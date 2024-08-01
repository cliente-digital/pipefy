<?php
namespace Clientedigital\Pipefy;
use Clientedigital\Pipefy\Entity;

uses()->beforeEach(function () {
});


test('TryCreateCardWithSuccess', function () {
    $this->setConfig('CLIENTEDIGITAL_PIPEFY_CONFIG_FILE', __DIR__ . DIRECTORY_SEPARATOR . "cd.pipefy.ini" );
    $pipeid = 304547300;
    $pipe = new Pipe($pipeid);
    $newCard = new Entity\Card(); 
    $newCard->title("teste de criacao de card");
    $newCard->setField("campo_1", "texto geral");
    $newCard->setField("data_de_cricao", (new \DateTime())->format(DATE_ATOM));
    $result = $pipe->createCard($newCard);
    var_dump($result);
});




