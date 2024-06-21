<?php

const ROOT_PATH =  __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR; 
const  PIPEFY_CONFIG_PATH = ROOT_PATH . ".pipefy";
const PIPEFY_CONFIG_PARAMS = ["APIKEY"=>null];

require  ROOT_PATH. "vendor" . DIRECTORY_SEPARATOR . "autoload.php";



if($argc == 1){
    show();
}
else if($argc ==3) {
    write($argv[1], $argv[2]);
}

function get(): array{
    $hasConfigFile = is_file(PIPEFY_CONFIG_PATH);
    if(!$hasConfigFile)
    {
        create();
    }
    return parse_ini_file(PIPEFY_CONFIG_PATH);
}

function create(array $params = [])
{
    $fileContent = [];
    $config = $params==[] ? PIPEFY_CONFIG_PARAMS : $params;
    foreach($config as $key => $value) {
        $fileContent [] = "{$key}={$value}";
    }
    file_put_contents(
        PIPEFY_CONFIG_PATH, 
        implode("\n", $fileContent) 
    );
}

function write(string $key, string $value) {

    if(!in_array($key, array_keys(PIPEFY_CONFIG_PARAMS)))
    {
        echo PHP_EOL. "{$key} is not a valid pipefy config.".PHP_EOL;
        show();
        exit(0);
    }
    $config = get();
    $config[$key] = $value;
    create($config);
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

