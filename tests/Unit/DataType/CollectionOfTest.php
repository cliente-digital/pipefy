<?php
namespace Clientedigital\Pipefy\Schema\Data;

use Clientedigital\Pipefy\Schema\Data\Type;
use Clientedigital\Pipefy\Pipe;
use Clientedigital\Pipefy\Card;









uses()->beforeEach(function () {
    $this->setLocal('PIPEID', 304547300);
    $CLIENTEDIGITAL_PIPEFY_CONFIG_FILE_PATH = __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "cd.pipefy.ini";
    $this->setConfig('CLIENTEDIGITAL_PIPEFY_CONFIG_FILE', $CLIENTEDIGITAL_PIPEFY_CONFIG_FILE_PATH );
});

test('TryCollectInttWithSuccess', function () {
    $collection = new CollectionOf(Type\ShortText::class);
    $fieldDef =  \Clientedigital\Pipefy\Schema::field( $this->getLocal('PIPEID'), 'campo_1');

    $collection->add($fieldDef);
    $collection->add($fieldDef);
    $collection->add($fieldDef);
    $collection->add($fieldDef);
    expect($collection->count())->toBeInt()->toEqual(4);
});

test('TryCollectAnyTypeWithSuccess', function () {
    $collection = new CollectionOf(Type\AbstractType::class);
    $fieldDef =  \Clientedigital\Pipefy\Schema::field( $this->getLocal('PIPEID'), 'campo_1');

    $collection->add($fieldDef);
    $collection->add($fieldDef);
    $collection->add($fieldDef);
    $collection->add($fieldDef);
    expect($collection->count())->toBeInt()->toEqual(4);
});

test('TryCollectShortTextAndAddLorgTextAndFail', function () {
    $collection = new CollectionOf(Type\ShortText::class);
    $longtextDefinition =  json_decode('{
     "id": "detalhes",
     "label": "Detalhes",
     "type": "long_text",
     "options": [],
     "editable": true,
     "deleted": false,
     "required": false
 }');
   $longText =  new Type\LongText($longtextDefinition);
   $collection->add($longText);

})->throws(\Exception::class, 
    'Error: Collection of Clientedigital\Pipefy\Schema\Data\Type\ShortText.' .
    'Found Clientedigital\Pipefy\Schema\Data\Type\LongText'
    );


test('TryCollectShortTextandGetScriptWithSuccess', function () {
    $collection = new CollectionOf(Type\ShortText::class);
    $field=  \Clientedigital\Pipefy\Schema::field( $this->getLocal('PIPEID'), 'campo_1');
    $field->value("Novo Valor do Campo 1");
    $collection->add($field);
    $collection->add($field);
    $collection->add($field);
    $collection->add($field);
    expect($collection->count())->toBeInt()->toEqual(4);
    expect($collection->script())->toBeString()->toContain("campo_1")->toContain("Novo Valor");
});

test('TryCollectShortTextWithaoutAddAnyAndGetScriptWithSuccess', function () {
    $collection = new CollectionOf(Type\ShortText::class);
    expect($collection->count())->toBeInt()->toEqual(0);
    expect($collection->script())->toBeString()->toEqual("");
});

test('TryUpdateEntityShortTextFieldwithSuccess', function () {
    $pipe  = new Pipe($this->getLocal('PIPEID'));
    $cards = $pipe->cards()->get();
    $card= $cards->current();
    $card->setField('campo_1', "texto simples");
    (new Card($card->id))->update($card);
    $cards = $pipe->cards()->get();
    $card= $cards->current();
    expect($card->campo_1)->toBeString()->toEqual("texto simples");
 
});
