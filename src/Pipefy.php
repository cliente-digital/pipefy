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
        $this->config = parse_ini_file(PIPEFY_CONFIG_PATH);
        $this->http   = new Client();
    }

    public function request(string $gql): Object
    {
        $normalizedgql = str_replace(["\t", "\n"], " " , $gql);
        $normalizedgql = str_replace(['"'], '\"' , $normalizedgql);

        $response = $this->http->request('POST', PIPEFY_API_URI, [
          'body' => "{\"query\":\"{$normalizedgql}\"}",
          'headers' => [
            'accept' => 'application/json',
            'authorization' => "Bearer {$this->config['APIKEY']}",
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

    public function getConfig($name): string
    {
        if (!in_array($name, array_keys($this->config)))
            throw new \Exception("Invalid Config Key {$name}");
    }

    private static function RequestLimitCoordination()
    {
        // todo
        // rate limit = 500 request / 30 segundos.
        $now = new \DateTime();

        if (self::$lastrequestTimestamp == 0) {
            self::$lastrequestTimestamp == $now->getTimestamp();
            return;
        }
        
    }
}
