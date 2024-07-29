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
        self::getConfig('PIPEFY_APIKEY');
    }

    public static function getConfig($name=null)
    {
        $configFile = getenv('CLIENTEDIGITAL_PIPEFY_CONFIG_FILE');
        if( self::$config == [] and $configFile===false)
            throw new \Exception(
                "Cant find CLIENTEDIGITAL_PIPEFY_CONFIG_FILE ENV variable.".PHP_EOL.
                "please set CLIENTEDIGITAL_PIPEFY_CONFIG_FILE with the ".PHP_EOL.
                "path of the ini file tha contain the [CLIENTEDIGITAL] section.".PHP_EOL.
                "and check the documentation for more information.".PHP_EOL .
                "https://github.com/cliente-digital/pipefy/blob/main/doc/configuration.md"
            );

        if(self::$config == []) {

            $configContent = parse_ini_file($configFile, true);

            if(!isset($configContent['CLIENTEDIGITAL'])) {
                throw new \Exception("Cant Find CLIENTEDIGITAL section into config File");
            }
            self::$config = $configContent['CLIENTEDIGITAL'];
        }


        if(is_null($name))
            return self::$config;
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
