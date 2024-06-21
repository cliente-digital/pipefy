<?php
namespace Clientedigital\Pipefy;

use \GuzzleHttp\Client;

class Pipefy 
{
    use GraphQL;

    private array $config; 
    private Client $http; 


    public function __construct()
    {
        $this->config = parse_ini_file(PIPEFY_CONFIG_PATH);
        $this->http   = new Client();
    }

    public function exec(string $gql): Object
    {
        $normalizedgql = str_replace(["\t", "\n"], " " , $gql);
        echo $normalizedgql; 
        var_dump($this->config['APIKEY'], $normalizedgql);
        $response = $this->http->request('POST', PIPEFY_API_URI, [
          'body' => "{\"query\":\"{$normalizedgql}\"}",
          'headers' => [
            'accept' => 'application/json',
            'authorization' => "Bearer {$this->config['APIKEY']}",
            'content-type' => 'application/json',
          ],
        ]);
        return json_decode($response->getBody());
    }

    public function getConfig($name): string
    {
        if (!in_array($name, array_keys($this->config)))
            throw new \Exception("Invalid Config Key {$name}");
    } 
}
