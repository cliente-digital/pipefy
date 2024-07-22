<?php

require __DIR__ . DIRECTORY_SEPARATOR . "header.php";

if($argc == 1){
    show();
}
else if($argc ==3) {
    write($argv[1], $argv[2]);
}

function get(): array{
    $hasConfigFile = is_file(CLIENTEDIGITAL_PIPEFY_CONFIG_PATH);
    if(!$hasConfigFile)
    {
        create();
    }
    return parse_ini_file(CLIENTEDIGITAL_PIPEFY_CONFIG_PATH);
}

function create(array $params = [])
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

function write(string $key, string $value) {
    $config = get();
    if(!in_array($key, array_keys(CLIENTEDIGITAL_PIPEFY_CONFIG_PARAMS)))
    {
        echo PHP_EOL. "{$key} is not a valid pipefy config.".PHP_EOL;
        show();
        exit(0);
    }
    if($key == 'APIKEY' && get()['APIKEY']!=""){
        $canclearCache = readline(PHP_EOL . "Trocar a chave remove todo o cache de dados. Continuar? [Y/n]");
        if($canclearCache =='n'){
            echo PHP_EOL . "ApiKey não foi trocada." . PHP_EOL
                . "O Cache não foi removido." . PHP_EOL;
            exit(0);
        }
        $config[$key] = $value;
        create($config);
        echo "\nyour {$key} was set.".PHP_EOL;
        (new Clientedigital\Pipefy\Cache())->clearCache(Clientedigital\Pipefy\Cache::CACHE_ALL);
 
     
    }
    $config[$key] = $value;
    create($config);
    echo "\nyour {$key} was set.".PHP_EOL;
    show();
}
function show(): void
{
    $config = get();
    echo "# PIPEFY Config values #".PHP_EOL;
    foreach($config as $key => $value){
        echo "    {$key}\t = {$value}".PHP_EOL;
    }
}

