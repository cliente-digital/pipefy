<?php
namespace Clientedigital\Pipefy\Schema\Data\Type;
use Clientedigital\Pipefy\Pipe;


uses()->beforeEach(function () {
    $this->setLocal('PIPEID', 304547300);
});

test('TryCreateInstanceofDateWithSuccess', function () {

    $pipe  = new Pipe($this->getLocal('PIPEID'));
    $field = $pipe->field('data');
    $fieldDef =  \Clientedigital\Pipefy\Schema::field( $this->getLocal('PIPEID'), 'data');
    expect($field)->toEqual($fieldDef);
    expect($field)->toBeInstanceOf(\Clientedigital\Pipefy\Schema\Data\Type\Date::class);
    expect($field->value())->toBeNull();
});

test('TrySetValidDateValueAndFail', function () {
    $field =  \Clientedigital\Pipefy\Schema::field( $this->getLocal('PIPEID'), 'data');
    $datetime = new \DateTime();
    $field->value($datetime);
    expect($field->value())->toBeInstanceOf(\DateTime::class);
    expect($field->value())->toEqual($datetime);
});



test('TryCreateInstanceofDateTimeWithSuccess', function () {

    $pipe  = new Pipe($this->getLocal('PIPEID'));
    $field = $pipe->field('date_e_hora');
    $fieldDef =  \Clientedigital\Pipefy\Schema::field( $this->getLocal('PIPEID'), 'date_e_hora');
    expect($field)->toEqual($fieldDef);
    expect($field)->toBeInstanceOf(\Clientedigital\Pipefy\Schema\Data\Type\DateTime::class);
    expect($field->value())->toBeNull();
});

test('TrySetValidTimeValueAndFail', function () {
    $field =  \Clientedigital\Pipefy\Schema::field( $this->getLocal('PIPEID'), 'tempo');
    $time = "23:59";
    $field->value($time);
    expect($field->value())->toBeString();
    expect($field->value())->toEqual($time);
});

test('TryCreateInstanceofTimeWithSuccess', function () {

    $pipe  = new Pipe($this->getLocal('PIPEID'));
    $field = $pipe->field('tempo');
    $fieldDef =  \Clientedigital\Pipefy\Schema::field( $this->getLocal('PIPEID'), 'tempo');
    expect($field)->toEqual($fieldDef);
    expect($field)->toBeInstanceOf(\Clientedigital\Pipefy\Schema\Data\Type\Time::class);
    expect($field->value())->toBeNull();
});

test('TrySetInvalidTimeValueAndFail', function () {
    $field =  \Clientedigital\Pipefy\Schema::field( $this->getLocal('PIPEID'), 'tempo');
    $time = "24:99";
    $field->value($time);
})->throws(\Exception::class, "Time tempo only accept 24h time format 00:00-23:59. Found 24:99.");






