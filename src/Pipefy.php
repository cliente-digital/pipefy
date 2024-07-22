<?php
namespace Clientedigital\Pipefy;

use \GuzzleHttp\Client;

class Pipefy 
{

    final public const CACHED= true;
    final public const UNCACHED= false;
    private static int $lastrequestTimestamp = 0;
    private array $config; 
    private Client $http; 

    public function __construct()
    {
        $this->config = parse_ini_file(CLIENTEDIGITAL_PIPEFY_CONFIG_PATH);
        $this->http   = new Client();
    }

    public function request(string $gql): Object
    {
        $normalizedgql = str_replace(["\t", "\n"], " " , $gql);
        $normalizedgql = str_replace(['"'], '\"' , $normalizedgql);

        $apiKey = $this->getConfig('APIKEY');

        $response = $this->http->request('POST', CLIENTEDIGITAL_PIPEFY_API_URI, [
          'body' => "{\"query\":\"{$normalizedgql}\"}",
          'headers' => [
            'accept' => 'application/json',
            'authorization' => "Bearer {$apiKey}",
            'content-type' => 'application/json',
          ],
        ]);

        return json_decode(
            $response->getBody(),
            null,
            512,
            JSON_UNESCAPED_UNICODE
        );
    }

    private function getConfig($name): string
    {
        if (!in_array($name, array_keys($this->config)))
            throw new \Exception("Invalid Config Key {$name}");
        return $this->config[$name];
    }
}
