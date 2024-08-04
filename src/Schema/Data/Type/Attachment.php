<?php
namespace Clientedigital\Pipefy\Schema\Data\Type;

use \stdclass;
use Clientedigital\Pipefy\Graphql\File\One;
use GuzzleHttp\Psr7\Utils;
use GuzzleHttp\Client;

class Attachment extends AbstractType implements TypeInterface 
{
    private ?array $value = null;
    private int $orgid;
    private string $path;
    private ?string $alias = null;
    private bool $uploaded = false;
    private string $url = "";
    public function value($value = null)
    {
        if(!is_null($value)){
            $this->validate($value);
            $this->value = $value;
        }

        if($this->required() && is_null($this->value))
            throw new \Exception("{$this->id()} is required and cannot be null");
        

        $pathinfo = pathinfo($this->value['path']);
        $this->orgid = $value['orgid'];
        $this->path = $value['path'];
        $this->alias = isset($value['alias'])?$value['alias']:$pathinfo['basename'];
        return $this->value;
    }

    private function validate($value)
    {
        if(!is_array($value) || !array_key_exists('orgid',$value) || !array_key_exists('path',$value))
             throw new \Exception("Attachment {$this->id()} value need be array ['orgid'=>{ORGID}, 'path'=>{LOCALFILEPATH}, 'alias'=>?{FILEALIAS}].");
    

        // todo need protect file exposition by only accept absolute path from PIPE_STORAGE_PATH.
        if(!is_file($value['path'])){
            throw new \Exception("Attachment {$this->id()} need a valid local file Path. Invalid: {$value['localfilepath']}.");
        }
    }
    public function script(): string
    {
        $fileurl = $this->upload();
        return "{fieldId:\"{$this->id()}\", value: \"{$fileurl}\"}";
    }

    private function upload(): string{
        if($this->uploaded)
            return $this->url;
        $uploadLink = (new One())->createUploadLink($this->orgid, $this->alias);
        $file= Utils::tryFopen($this->path, 'r');
        $response = (new Client())->request('PUT', $uploadLink->url, ['body' => $file]);

        if($response->getStatusCode() == 200){
            $url = $this->getUrlValueToField($uploadLink->url);
            $this->uploaded = true;
            $this->url= $url;
            return $url;
        }
        throw new \Exception("Fail to Create Attachment for file {$this->alias}.");
    }
    
    /**
    * the url you need to send is part of uploadLink->url as [org/...filename]?
    **/
    private function getUrlValueToField($url): string{
        $re = '/amazonaws.com\/([\s\S]*?)\?/m';
        preg_match_all($re, $url, $matches, PREG_SET_ORDER, 0);
        return $matches[0][1];
    }

}
