<?php
require __DIR__ . "/../vendor/autoload.php";

function update(){
$labelEntity = new Clientedigital\Pipefy\Entity\Label();
$labelEntity->name('Label Teste Add');
$labelEntity->color('#ffffff');
$labelEntity->pipeId(302358339);


var_dump($labelEntity);

$label = new Clientedigital\Pipefy\Label();
$label->create($labelEntity);

}
//update

$pipe = new Clientedigital\Pipefy\Pipe(304530916);
$labelFilter = new Clientedigital\Pipefy\Filter\Label();
$labelFilter->by('name', '=', 'Média');
//$pipedata = $pipe->get();
$labels= $pipe->labels($labelFilter);
var_dump($labels);




