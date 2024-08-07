<?php
namespace Clientedigital\Pipefy\Schema\Data\Type;
use Clientedigital\Pipefy\Pipe;


uses()->beforeEach(function () {
    $this->setLocal('PIPEID', 304547300);
});

test('TryCreateInstanceofLongTextWithSuccess', function () {

    $pipe  = new Pipe($this->getLocal('PIPEID'));
    $field = $pipe->field('texto_longo');
    $fieldDef =  \Clientedigital\Pipefy\Schema::field( $this->getLocal('PIPEID'), 'texto_longo');
    expect($field)->toEqual($fieldDef);
});

test('TryGSetValueOfNotRequiredFieldWithoutSetWithSuccess', function () {

    $pipe  = new Pipe($this->getLocal('PIPEID'));
    $field = $pipe->field('texto_longo');
    expect($field->value())->toBeNull();
});

test('TrySetLongTextAsIntAndFail', function () {

    $pipe  = new Pipe($this->getLocal('PIPEID'));
    $field = $pipe->field('texto_longo');
    $field->value(1);
})->throws(\Exception::class, "LongText texto_longo only accept string. Found integer");

test('TrySetLongTextAsLongWithSuccess', function () {

    $pipe  = new Pipe($this->getLocal('PIPEID'));
    $longText = str_repeat('a', 300);
    $field = $pipe->field('texto_longo');
    $field->value($longText);
    expect($field->value())->toEqual($longText);
});






