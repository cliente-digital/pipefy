<?php
namespace Clientedigital\Pipefy\Graphql;

use Clientedigital\Pipefy\Pipefy;
use Clientedigital\Pipefy\Cache;
use \GuzzleHttp\Client;
use StdClass;

Trait GraphQL{

    final public const CACHE_ALL = "_clearall_";

    private ?Client $http=null; 

    function getGQL($name): GQL 
    {
        return new GQL($name);
    }


    public function request(GQL $gql): Object
    {
        $gqlInfo = $gql->info();

        $isQuery = $gqlInfo->kind;
        $cachemode = Pipefy::useCache();

        $canCache = $isQuery && $cachemode;

        if($canCache) {
            try{
                return $this->getCache($gqlInfo->cacheId);    
            }catch( \Exception $cacheException ){

            }
        }

        $gqlscript = $gql->script();
        if(is_null($this->http))
            $this->http= new Client();

        $apiKey = Pipefy::getConfig('PIPEFY_APIKEY');
        $uri = Pipefy::getConfig('PIPEFY_API_URI');

        $response = $this->http->request('POST', $uri, [
          'body' => "{\"query\":\"{$gqlscript}\"}",
          'headers' => [
            'accept' => 'application/json',
            'authorization' => "Bearer {$apiKey}",
            'content-type' => 'application/json',
          ],
        ]);

        $responseObject = json_decode(
            $response->getBody(),
            null,
            512,
            JSON_UNESCAPED_UNICODE
        );
        if ($isQuery)
            $this->setCache($gqlInfo->cacheId, $responseObject);

        return $responseObject;
    }

    private function setCache($cacheId, $response){
            $cache =  new Cache();
            $info = $cache->info($cacheId);
            if($info->ttl > 0 || $info->ttl == Cache::ALLWAYSVALIDCACHE)
                return $cache->set($cacheId, $response);
    }

    private function getCache(string $cacheId){
            $cache =  new Cache();
            return $cache->get($cacheId); 
    }

}
