<?php
namespace Clientedigital\Pipefy\Command;

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
        $config = $this->get();
        echo "build-schema:  extract schema acessible by APIKEY.".PHP_EOL;
        echo "# PIPEFY Config values #".PHP_EOL;
        foreach($config as $key => $value){
            echo "    {$key}\t = {$value}".PHP_EOL;
        }

    }
    private function get(): array{
        $hasConfigFile = is_file(CLIENTEDIGITAL_PIPEFY_CONFIG_PATH);
        if(!$hasConfigFile)
        {
            $this->create();
        }
        return parse_ini_file(CLIENTEDIGITAL_PIPEFY_CONFIG_PATH);
    }

    private function create(array $params = [])
    {
        $fileContent = [];
        $config = $params==[] ? CLIENTEDIGITAL_PIPEFY_CONFIG_PARAMS : $params;
        foreach($config as $key => $value) {
            $fileContent [] = "{$key}={$value}";
        }
        file_put_contents(
            CLIENTEDIGITAL_PIPEFY_CONFIG_PATH, 
            implode("\n", $fileContent) 
        );
    }

    private function write(string $key, string $value) {
        $config = $this->get();
        if(!in_array($key, array_keys(CLIENTEDIGITAL_PIPEFY_CONFIG_PARAMS)))
        {
            echo PHP_EOL. "{$key} is not a valid pipefy config.".PHP_EOL;
            $this->help();
            return 0;
        }
        if($key == 'APIKEY' && $this->get()['APIKEY']!=""){
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


