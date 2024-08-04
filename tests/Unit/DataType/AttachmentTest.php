<?php
namespace Clientedigital\Pipefy\Schema\Data\Type;

use Clientedigital\Pipefy\Pipe;
use Clientedigital\Pipefy\Card;




uses()->beforeEach(function () {
    $this->setLocal('PIPEID', 304547300);
    $CLIENTEDIGITAL_PIPEFY_CONFIG_FILE_PATH = __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "cd.pipefy.ini";
    $this->setConfig('CLIENTEDIGITAL_PIPEFY_CONFIG_FILE', $CLIENTEDIGITAL_PIPEFY_CONFIG_FILE_PATH );
});

test('TryGetDataTypeAtachmentFieldWithSuccess', function () {
    $pipe  = new Pipe($this->getLocal('PIPEID'));
    $field = $pipe->field('campo_anexo');
    expect($field)->toBeInstanceOf(\Clientedigital\Pipefy\Schema\Data\Type\Attachment::class);
});

test('TrySetDataTypeAtachmentFieldWithSuccess', function () {
    $pipe  = new Pipe($this->getLocal('PIPEID'));
    $field = $pipe->field('campo_anexo');
    $cards = $pipe->cards()->get();
    $card= $cards->current();
    var_dump($card->id);

    $orgid = $card->pipe->organization->id; 
    $field->value(['orgid'=>$orgid, 'path'=>__DIR__."/fixtures/README.md"]);
    $card->setField('campo_anexo',['orgid'=>$orgid, 'path'=>__DIR__."/fixtures/report.md"]);
    (new Card($card->id))->update($card);
});







