<?php
namespace Clientedigital\Pipefy\Schema\Data\Type;

use Clientedigital\Pipefy\Pipefy;
use Clientedigital\Pipefy\Pipe;
use Clientedigital\Pipefy\Card;



uses()->beforeEach(function () {
    $this->setLocal('PIPEID', 304547300);
    $cache_dir = Pipefy::getConfig('PIPEFY_CACHE_DIR');
    $this->setLocal('carddata', json_decode(file_get_contents("{$cache_dir}card-one-731bd1c64a74dfee99cb6e24afda5bfe.json"))->data->card);
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
    $orgid = $card->pipe->organization->id; 
    $field->value(['orgid'=>$orgid, 'path'=>__DIR__."/fixtures/README.md"]);
    $card->setField('campo_anexo',['orgid'=>$orgid, 'path'=>__DIR__."/fixtures/report.md"]);
    (new Card($card->id))->update($card);
});







