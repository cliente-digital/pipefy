<?php
namespace Clientedigital\Pipefy;


class Pipefy
{

    private static array $config=[];
    private static bool $useBulk = false;
    private static bool $useCache= false;

    public function __construct()
    {
        self::getConfig('PIPEFY_APIKEY');
    }

    public static function getConfig($name=null)
    {
        $configFile = getenv('CLIENTEDIGITAL_PIPEFY_CONFIG_FILE');
        if( self::$config == [] and $configFile===false)
            throw new \Exception("Cant find CLIENTEDIGITAL_PIPEFY_CONFIG_FILE ENV variable.");

        if(self::$config == []) {

            $configContent = parse_ini_file($configFile, true);

            if(!isset($configContent['CLIENTEDIGITAL'])) {
                throw new \Exception("Cant Find CLIENTEDIGITAL section into config File");
            }
            self::$config = $configContent['CLIENTEDIGITAL'];
        }


        if(is_null($name))
            return self::$config;

        if(!isset(self::$config[$name]))
            return null;

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

    public static function useCache(?bool $use=null): bool
    {
        if(!is_null($use))
            self::$useCache = $use;
        return self::$useCache;
    }

}
