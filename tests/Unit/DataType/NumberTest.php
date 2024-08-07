<?php
namespace Clientedigital\Pipefy\Schema\Data\Type;
use Clientedigital\Pipefy\Pipe;


uses()->beforeEach(function () {
    $this->setLocal('PIPEID', 304547300);
});

test('TryCreateInstanceofCurrencyWithSuccess', function () {

    $pipe  = new Pipe($this->getLocal('PIPEID'));
    $field = $pipe->field('numero');
    $fieldDef =  \Clientedigital\Pipefy\Schema::field( $this->getLocal('PIPEID'), 'numero');
    expect($field)->toEqual($fieldDef);
    expect($field)->toBeInstanceOf(\Clientedigital\Pipefy\Schema\Data\Type\Number::class);
    expect($field->value())->toBeNull();
});

test('TrySetValidCurrencyValueAndFail', function () {
    $field =  \Clientedigital\Pipefy\Schema::field( $this->getLocal('PIPEID'), 'numero');
    $currency = 100;
    $field->value($currency);
    expect(is_numeric($field->value()))->toBeTrue();
    expect($field->value())->toEqual(100.00);
    expect((string)$field->value())->toEqual("100");
    $field->value(100.45);
    expect(is_numeric($field->value()))->toBeTrue();
    expect($field->value())->toEqual(100.45);
    $field->value(100.459);
    expect(is_numeric($field->value()))->toBeTrue();
    expect($field->value())->toEqual(100.459);
});



test('TryCreateInstanceofCurrencyWithStringAndFail', function () {
    $field =  \Clientedigital\Pipefy\Schema::field( $this->getLocal('PIPEID'), 'numero');
    $currency = "100";
    $field->value($currency);
})->throws(\Exception::class, "Number numero only accept Numeric([0-9].{0,2}). Found string.");


