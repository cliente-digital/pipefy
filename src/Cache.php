<?php
namespace Clientedigital\Pipefy;

use \Datetime;
use \stdclass;

class Cache 
{

    public const ALL = 0;
    public const ALLWAYSVALIDCACHE = -1;

    public function get(string $name)
    {
        $info = $this->info($name);
        
        if($info->exists && !$info->valid && $info->ttl != self::ALLWAYSVALIDCACHE){
            $this->clear($name, $info->path);
            $info = $this->info($name);
        }
 
        if(!$info->exists)
            throw new \Exception("CACHE file {$name} not found");

        return json_decode(
            file_get_contents($info->path),
            null,
            512,
            JSON_THROW_ON_ERROR|JSON_UNESCAPED_UNICODE
        );
    }

    public function info($name, $path=null): StdClass
    {
        $path = is_null($path)?Pipefy::getConfig('PIPEFY_CACHE_DIR'):$path;
        $hashlength = 32 +1;
        $cachedName = substr($name, 0, $hashlength * -1);
        $defaultTtl = Pipefy::getConfig("PIPEFY_CACHE_TTL_DEFAULT");
        $ttl = Pipefy::getConfig("PIPEFY_CACHE_TTL.{$cachedName}");
        if(is_null($ttl) and is_null($defaultTtl))
            $ttl = 0;
        if(is_null($ttl) and !is_null($defaultTtl))
            $ttl = $defaultTtl; 

        $info = new stdClass();
        $info->name = $name;
        $info->isDir = is_dir($path.$name);

        $info->path = !$info->isDir
            ? $path."{$name}.json"
            : $path.  $name . DIRECTORY_SEPARATOR;


        $info->exists = !$info->isDir ? is_file($info->path): true;
        $info->createdAt = null;
        $info->ttl       = $ttl;
        $info->valid = true || $info->exists; 

        if($info->exists) {
            $filecTime = filectime($info->path);
            $info->createdAt = (new Datetime())->setTimestamp($filecTime);

            $lifespan = (new DateTime())->setTimestamp($filecTime)->add(
                \DateInterval::createFromDateString("{$info->ttl} sec")
            );

            if($lifespan < (new DateTime()) && $info->ttl > self::ALLWAYSVALIDCACHE){
                $info->valid = false;
            } 
        }

        return $info;
    }

    public function clear($name, $path = null, bool $allhashednames = false): bool 
    {
        $deleted = false;
        $filesToClear = [$name];
        $path = is_null($path)? Pipefy::getConfig('PIPEFY_CACHE_DIR'): $path;
        if ($name == self::ALL) {
            $filesToClear = scandir($path);
        }
        if ($allhashednames) {
            $filesToClear = [];
            $filesStagedToClear = scandir($path);
            foreach($filesStagedToClear  as $fStaged){
                if(strpos($fStaged, $name)!== false)
                    $filesToClear[] = str_replace(".json", "",$fStaged);
            }
        }
        foreach ($filesToClear as $file) {     
            if(in_array($file, [".", ".."]))
                continue;
            $info = $this->info($file);
            if ($info->isDir && $info->path != Pipefy::getConfig('PIPEFY_CACHE_DIR')) {
                $this->clear(self::ALL, $info->path); 
                continue;
            }
           if ($info->exists && !$info->isDir) {
                unlink($info->path);
                $deleted = true;
            }
        }
        return $deleted;
    }

    public function set(string $name, $content): bool 
    {
        $info = $this->info($name);
        return  (bool) file_put_contents(
            $info->path, 
            json_encode(
                $content, 
                JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT
            )
        );
    }
} 
