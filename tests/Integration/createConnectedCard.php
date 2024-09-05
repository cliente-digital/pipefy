<?php

namespace Clientedigital\Pipefy;
require __DIR__ . "/../../vendor/autoload.php";


$org = (new Pipefy)->org(301345588);

$pipeOrigem = $org->pipe(304662792);
$pipeDestino= $org->pipe(304662803);

$cardOrigem = $pipeOrigem->card(985655673);
$e1 = $cardOrigem->entity();

var_dump($e1->id, $e1->nome);
$newCard = new Entity\Card(); 
$newCard->pipeId($pipeDestino->id());
$newCard->setField('origem', $e1->id);
$newCard->title($e1->nome);
$newCard->dueDate(\DateTime::createFromFormat("d/m/Y", "30/06/2023"));
$pipeDestino->createCard($newCard);



