<?php
namespace Clientedigital\Pipefy\Schema\Data\Type;

use Clientedigital\Pipefy\Pipe;
use Clientedigital\Pipefy\Card;



uses()->beforeEach(function () {
    $this->setLocal('PIPEID', 304547300);
});

test('TryCreateInstanceofShortTextWithSuccess', function () {

    $pipe  = new Pipe($this->getLocal('PIPEID'));
    $field = $pipe->field('selecao_de_lista');
    $fieldDef =  \Clientedigital\Pipefy\Schema::field( $this->getLocal('PIPEID'), 'selecao_de_lista');
    expect($field)->toEqual($fieldDef);
});

test('TrySetSelectAsIntAndFail', function () {
    $pipe  = new Pipe($this->getLocal('PIPEID'));
    $field = $pipe->field('selecao_de_lista');
    $field->value(1);
})->throws(\Exception::class, "Select selecao_de_lista only accept String. Found integer.");


test('TrySetSelecttWithAItemNotInOptionsWithSuccess', function () {
    $pipe  = new Pipe($this->getLocal('PIPEID'));
    $field = $pipe->field('selecao_de_lista');
    $field->value("nao esta na lista");
})->throws(\Exception::class, "Select selecao_de_lista only accept [um, 2, 3]. Found nao esta na lista.");


test('TrySetSelecttWithAItemInOptionsWithSuccess', function () {
    $pipe  = new Pipe($this->getLocal('PIPEID'));
    $field = $pipe->field('selecao_de_lista');
    $field->value("um");
    expect($field->value())->toBeString()->ToEqual("um");
});

