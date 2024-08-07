<?php
namespace Clientedigital\Pipefy\Schema\Data\Type;

use Clientedigital\Pipefy\Pipe;
use Clientedigital\Pipefy\Card;




uses()->beforeEach(function () {
    $this->setLocal('PIPEID', 304547300);
    $CLIENTEDIGITAL_PIPEFY_CONFIG_FILE_PATH = __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "cd.pipefy.ini";
    $this->setConfig('CLIENTEDIGITAL_PIPEFY_CONFIG_FILE', $CLIENTEDIGITAL_PIPEFY_CONFIG_FILE_PATH );
});

test('TryCreateInstanceofShortTextWithSuccess', function () {

    $pipe  = new Pipe($this->getLocal('PIPEID'));
    $field = $pipe->field('campo_1');
    $fieldDef =  \Clientedigital\Pipefy\Schema::field( $this->getLocal('PIPEID'), 'campo_1');
    expect($field)->toEqual($fieldDef);
});

test('TryGetFieldFromPipeThatNotExistAndFail', function () {
    $pipe  = new Pipe(10101);
    $field = $pipe->field('campo_1');
})->throws(\Exception::class, "Pipe 10101 don't exist at the schema.");


test('TryGSetValueOfFieldThatNotExistAndFail', function () {
    $pipe  = new Pipe($this->getLocal('PIPEID'));
    $field = $pipe->field('campo_inexistente');
})->throws(\Exception::class, "Field campo_inexistente don't exist at the schema.");


test('TryGSetValueOfNotRequiredFieldWithoutSetWithSuccess', function () {
    $pipe  = new Pipe($this->getLocal('PIPEID'));
    $field = $pipe->field('campo_1');
    expect($field->value())->toBeNull();
});

test('TrySetShortTextAsIntAndFail', function () {
    $pipe  = new Pipe($this->getLocal('PIPEID'));
    $field = $pipe->field('campo_1');
    $field->value(1);
})->throws(\Exception::class, "ShortText campo_1 only accept string. Found integer");

test('TrySetShortTextAsLongAndFail', function () {
    $pipe  = new Pipe($this->getLocal('PIPEID'));
    $longText = str_repeat('a', 300);
    $field = $pipe->field('campo_1');
    $field->value($longText);
})->throws(\Exception::class, "Value can't be longer than 255. Found 300.");

test('TrySetShortTextWithSuccess', function () {
    $pipe  = new Pipe($this->getLocal('PIPEID'));
    $shortText = str_repeat('a', 10);
    $field = $pipe->field('campo_1');
    $field->value($shortText);
    expect($field->value())->toBeString()->toEqual($shortText);
});


test('TryUpdateEntityShortTextFieldwithSuccess', function () {
    $pipe  = new Pipe($this->getLocal('PIPEID'));
    $cards = $pipe->cards()->get();
    $card= $cards->current();
    $card->setField('campo_1', "texto simples");
    (new Card($card->id))->update($card);
    $newCard = (new Card($card->id))->get();
    expect($newCard->campo_1)->toBeString()->toEqual("texto simples"); 
});

test('TryUpdateEntityLongTextFieldwithSuccess', function () {
    $pipe  = new Pipe($this->getLocal('PIPEID'));
    $cards = $pipe->cards()->get();
    $card= $cards->current();
    $textolongo = str_repeat("texto Longo. ", 100);
    $card->setField('texto_longo', $textolongo);
    (new Card($card->id))->update($card);
    $newCard = (new Card($card->id))->get();
    var_dump($newCard->pipe);
    expect($newCard->texto_longo)->toBeString()->toEqual($textolongo); 
});







