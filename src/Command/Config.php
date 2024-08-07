<?php
namespace Clientedigital\Pipefy\Command;

use Clientedigital\Pipefy\Pipefy;


class Config{

    public function exec(array $args)
    {
        $argc = count($args);
        if($argc == 1){
            return $this->help();
        }
        else if($args[1] =='build-schema')
            return $this->buildSchema();
        else if($argc ==3) {
            return $this->write($args[1], $args[2]);
        }
        $this->help();
        return 1;
    }

    public function help()
    {
        $config = Pipefy::getConfig();
        echo "Command options:".PHP_EOL;
        echo "1. build-schema:  extract schema acessible by APIKEY.".PHP_EOL;
        echo "2. [CONFIGNAME]  [CONFIGVALUE]:  set a configuration value.".PHP_EOL.PHP_EOL;
        echo "# LIST OF PIPEFY Config values #".PHP_EOL;
        foreach($config as $key => $value){
            echo "    {$key}\t = {$value}".PHP_EOL;
        }

    }

    private function create(array $config)
    {
        $fileContent = [];
        foreach($config  as $key => $value) {
            $fileContent [] = "{$key}={$value}";
        }
        file_put_contents(
            getenv('CLIENTEDIGITAL_PIPEFY_CONFIG_FILE'), 
            "[CLIENTEDIGITAL]".PHP_EOL . implode( PHP_EOL, $fileContent).PHP_EOL
        );
    }

    private function write(string $key, string $value) {
        $config = Pipefy::getConfig();

        if($key == 'PIPEFY_APIKEY' && Pipefy::getConfig('PIPEFY_APIKEY')!=""){
            $canclearCache = readline(PHP_EOL . "Trocar a chave remove todo o cache de dados. Continuar? [Y/n]");
            if($canclearCache =='n'){
                echo PHP_EOL . "ApiKey não foi trocada." . PHP_EOL
                    . "O Cache não foi removido." . PHP_EOL;
                return 0;
            }

            $config[$key] = $value;
            $this->create($config);
            echo "\nyour {$key} was set.".PHP_EOL;
            (new \Clientedigital\Pipefy\Cache())->clearCache(\Clientedigital\Pipefy\Cache::CACHE_ALL);
            return 0; 
        }

        $config[$key] = $value;
        $this->create($config);
        echo "\nyour {$key} was set.".PHP_EOL;
        $this->help();
        return 0;
    }

    private function buildSchema()
    {
        $schema = new \Clientedigital\Pipefy\Schema();
        $schema->build();
        echo "Organization Schema was build.\n";
        return 0;
    }

}


