<?php
namespace Clientedigital\Pipefy;


class Pipefy 
{

    final public const CACHED= true;
    final public const UNCACHED= false;

    private static array $config=[]; 
    private static bool $useBulk = false;

    public function __construct()
    {
        //check if is configured
        self::getConfig('APIKEY');
    }

    public static function getConfig($name): string
    {
        if( self::$config == [] and !defined("CLIENTEDIGITAL_PIPEFY_CONFIG_PATH"))
            throw new \Exception("Pipefy need CLIENTEDIGITAL_PIPEFY_CONFIG_PATH to work.");

        self::$config = parse_ini_file(CLIENTEDIGITAL_PIPEFY_CONFIG_PATH);
 
        if (!in_array($name, array_keys(self::$config)))
            throw new \Exception("Invalid Config Key {$name}");

        return self::$config[$name];
    }

    public function Orgs(){
        return new Orgs();
    }

    public static function useBulk(?bool $use=null): bool
    {
        if(!is_null($use))
            self::$useBulk = $use;
        return self::$useBulk;
    }
}
