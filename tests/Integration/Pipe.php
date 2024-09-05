<?php
require __DIR__ . "/../autoload.php";

$orgid = 300768246;
$pipe = (new Clientedigital\Pipefy\Pipes($orgid));
//orgid = 300768246
$allPipes = $pipe->All();

$pipe = $allPipes[0];
$pipeData = $pipe->get();
$labels = $pipe->labels();

//var_dump($labels);

$labelUpdater = new Clientedigital\Pipefy\Label();
foreach($labels as $label){
echo $label->id.PHP_EOL;
echo $label->name.PHP_EOL;
echo $label->color.PHP_EOL;
echo $label->parentType.PHP_EOL;
echo $label->parentId.PHP_EOL;
echo PHP_EOL.PHP_EOL;
//$label->name(explode(" ", $label->name)[0]);
$label->color($label->color);
//$labelUpdater->update($label);
}

var_dump("table labels" , (new Clientedigital\Pipefy\Table(302358340))->labels());
