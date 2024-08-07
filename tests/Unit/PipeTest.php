<?php
namespace Clientedigital\Pipefy;
use Clientedigital\Pipefy\Entity;

uses()->beforeEach(function () {
});


test('TryCreateCardWithSuccess', function () {
    $pipeid = 304547300;
    $pipe = new Pipe($pipeid);
    $newCard = new Entity\Card(); 
    $newCard->pipeId($pipeid);
    $newCard->title("teste de criacao de card");
    $newCard->setField("campo_1", "texto geral");
    $newCard->setField("data", new \DateTime());
    $result = $pipe->createCard($newCard);
    expect($result)->toBeInt();
});




