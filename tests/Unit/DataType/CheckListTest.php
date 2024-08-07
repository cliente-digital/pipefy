<?php
namespace Clientedigital\Pipefy\Schema\Data\Type;

use Clientedigital\Pipefy\Pipe;
use Clientedigital\Pipefy\Card;



uses()->beforeEach(function () {
    $this->setLocal('PIPEID', 304547300);
});

test('TryCreateInstanceofShortTextWithSuccess', function () {

    $pipe  = new Pipe($this->getLocal('PIPEID'));
    $field = $pipe->field('checklist');
    $fieldDef =  \Clientedigital\Pipefy\Schema::field( $this->getLocal('PIPEID'), 'checklist');
    expect($field)->toEqual($fieldDef);
});

test('TrySetSelectAsIntAndFail', function () {
    $pipe  = new Pipe($this->getLocal('PIPEID'));
    $field = $pipe->field('checklist');
    $field->value(1);
})->throws(\Exception::class, "checkList checklist only accept Array . Found integer.");


test('TrySetSelecttWithAItemNotInOptionsWithSuccess', function () {
    $pipe  = new Pipe($this->getLocal('PIPEID'));
    $field = $pipe->field('checklist');
    $field->value(["nao esta na lista"]);
})->throws(\Exception::class, "CheckList checklist only accept [um, 2, 3]. Found 'nao esta na lista'.");


test('TrySetSelecttWithAItemInOptionsWithSuccess', function () {
    $pipe  = new Pipe($this->getLocal('PIPEID'));
    $field = $pipe->field('checklist');
    $field->value(["um"]);
    expect($field->value())->toBeArray()->ToEqual(["um"]);
});

