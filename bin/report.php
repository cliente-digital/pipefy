<?php
require  __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR 
    . DIRECTORY_SEPARATOR . "autoload.php";



if(count($argv)<2)
{
    help();
    exit(0);
}

array_shift($argv);

if(count($argv) == 0)
    help();

$cmd = array_shift($argv);

$params = $argv; 

// execute the function 
$cmd(...$params);

function help()
{
    echo 
"pipefy:report help
    pipefy:report schema 
        gera um relatorio do schema dos dados de sua organização.
\n";
}

function schema()
{
    $schema = new Clientedigital\Pipefy\Report\Schema();
    echo $schema->report() . PHP_EOL;
}
