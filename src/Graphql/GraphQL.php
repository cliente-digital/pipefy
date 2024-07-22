<?php
namespace Clientedigital\Pipefy\Graphql;

use StdClass;

Trait GraphQL{
    final public const CACHE_ALL = "_clearall_";
    function getGQL($name): GQL 
    {
        return new GQL($name);
    }

    function getCache($name)
    {
        $file = CLIENTEDIGITAL_PIPEFY_CACHE_DIR."{$name}.json";
        $info = $this->infoCache($name);
        if(!$info->exists)
            throw new \Exception("CACHE file {$name} not found");
        return json_decode(
            file_get_contents($info->path),
            null,
            512,
            JSON_THROW_ON_ERROR|JSON_UNESCAPED_UNICODE
        );
    }

    function infoCache($name, $path=null): StdClass
    {
        $path = is_null($path)?CLIENTEDIGITAL_PIPEFY_CACHE_DIR:$path;

        $info = new stdClass();
        $info->name = $name;
        $info->isDir = is_dir($path.$name);

        $info->path = !$info->isDir
            ? $path."{$name}.json"
            : $path.  $name . DIRECTORY_SEPARATOR;

        $info->exists = !$info->isDir ? is_file($info->path): true;

        return $info;
    }

    function clearCache($name, $path = null): void
    {
        $filesToClear = [$name];
        $path = is_null($path)? CLIENTEDIGITAL_PIPEFY_CACHE_DIR : $path;

        if ($name == self::CACHE_ALL) {
            $filesToClear = scandir($path);
        }

        foreach ($filesToClear as $file) {     
            if(in_array($file, [".", ".."]))
                continue;

            $info = $this->infoCache(str_replace(".json", "", $file), $path);

            if ($info->isDir && $info->path != CLIENTEDIGITAL_PIPEFY_CACHE_DIR) {
                $this->clearCache(self::CACHE_ALL, $info->path); 
                continue;
            }

           if ($info->exists && !$info->isDir) {
                unlink($info->path);
            }
        }
    }

    function setCache(string $name, $content): bool 
    {
        $info = $this->infoCache($name);
        return  (bool) file_put_contents(
            $info->path, 
            json_encode(
                $content, 
                JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT
            )
        );
    }


}
