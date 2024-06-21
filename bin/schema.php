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
"pipefy:schema help
    pipefy:schema build 
        extrai o schema dos das de sua organização.
    
    pipefy:schema report
        gera um relatorio do schema da organização
        em Markdown. 
\n";
}

function build()
{
    $schema = new Clientedigital\Pipefy\Schema();
    $schema->build();
    echo "Organization Schema was build.\n";
}
