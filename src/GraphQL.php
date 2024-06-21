<?php
namespace Clientedigital\Pipefy;

Trait GraphQL{

    function getGQL($name): string
    {
        $file = PIPEFY_GRAPHQL_DIR."{$name}.gql";
        if(!is_file($file))
            throw new \Exception("GQL file {$name} not found");
        return file_get_contents($file);  
    }

    function getCache($name): Object 
    {
        $file = PIPEFY_CACHE_DIR."{$name}.json";
        if(!is_file($file))
            throw new \Exception("CACHE file {$name} not found");
        return json_decode(
            file_get_contents($file),
            null,
            512,
            JSON_THROW_ON_ERROR|JSON_UNESCAPED_UNICODE
        );
    }
    function setCache(string $name, $content): bool 
    {
        $file = PIPEFY_CACHE_DIR."{$name}.json";
    
        return  (bool) file_put_contents(
            $file, 
            json_encode(
                $content, 
                JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT
            )
        );
    }


}
