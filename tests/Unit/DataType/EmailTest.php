<?php
namespace Clientedigital\Pipefy\Schema\Data\Type;

use Clientedigital\Pipefy\Pipe;
use Clientedigital\Pipefy\Card;




uses()->beforeEach(function () {
    $this->setLocal('PIPEID', 304547300);
});

test('TryCreateInstanceofShortTextWithSuccess', function () {

    $pipe  = new Pipe($this->getLocal('PIPEID'));
    $field = $pipe->field('email');
    $fieldDef =  \Clientedigital\Pipefy\Schema::field( $this->getLocal('PIPEID'), 'email');
    expect($field)->toEqual($fieldDef);
});


test('TrySetEmailAsIntAndFail', function () {
    $pipe  = new Pipe($this->getLocal('PIPEID'));
    $field = $pipe->field('email');
    $field->value(1);
})->throws(\Exception::class, "Email email only accept string. Found integer.");

test('TrySetEmailWithSuccess', function () {
    $pipe  = new Pipe($this->getLocal('PIPEID'));
    $field = $pipe->field('email');
    $field->value("email@gmail.com");
    expect($field->value())->toBeString()->toEqual("email@gmail.com");
});

