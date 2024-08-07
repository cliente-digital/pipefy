<?php
namespace Clientedigital\Pipefy\Schema\Data\Type;
use Clientedigital\Pipefy\Pipe;


uses()->beforeEach(function () {
    $this->setLocal('PIPEID', 304547300);
});

test('TryCreateInstanceofLongTextWithSuccess', function () {

    $pipe  = new Pipe($this->getLocal('PIPEID'));
    $field = $pipe->field('document_cpf');
    $fieldDef =  \Clientedigital\Pipefy\Schema::field( $this->getLocal('PIPEID'), 'document_cpf');
    expect($field)->toEqual($fieldDef);
});

test('TrySetValidCpfValue', function () {
    $field =  \Clientedigital\Pipefy\Schema::field( $this->getLocal('PIPEID'), 'document_cpf');
    $cpf = "507.572.060-93";
    $field->value($cpf);
    expect($field->value())->toBeString()->toEqual($cpf);
});

test('TrySetInvalidIntegerCPAndFail', function () {
    $field =  \Clientedigital\Pipefy\Schema::field( $this->getLocal('PIPEID'), 'document_cpf');
    $cpf = 50757206093;
    $field->value($cpf);

})->throws(\Exception::class, "CPF document_cpf only accept string. Found integer.");

test('TrySetInvalidShortStringCPAndFail', function () {
    $field =  \Clientedigital\Pipefy\Schema::field( $this->getLocal('PIPEID'), 'document_cpf');
    $cpf = "5075";
    $field->value($cpf);

})->throws(\Exception::class, "CPF Value can't have exatly 11 digits. Found 4.");

test('TrySetInvalidSCPFAndFail', function () {
    $field =  \Clientedigital\Pipefy\Schema::field( $this->getLocal('PIPEID'), 'document_cpf');
    $cpf = "111.111.111-11";
    $field->value($cpf);

})->throws(\Exception::class, "111.111.111-11 is not a valid CPF.");

test('TrySetInvalidRandomNumberCPFAndFail', function () {
    $field =  \Clientedigital\Pipefy\Schema::field( $this->getLocal('PIPEID'), 'document_cpf');
    $cpf = "123.456.789-01";
    $field->value($cpf);

})->throws(\Exception::class, "123.456.789-01 is not a valid CPF.");

test('TryReadValueAsNumWithSuccess', function () {
    $field =  \Clientedigital\Pipefy\Schema::field( $this->getLocal('PIPEID'), 'document_cpf');
    expect($field->value())->toBeNull();
});

test('TryReplaceSetCPFAWithSuccess', function () {
    $field =  \Clientedigital\Pipefy\Schema::field( $this->getLocal('PIPEID'), 'document_cpf');
    $cpf = "507.572.060-93";
    $field->value($cpf);
    expect($field->value())->toBeString()->toEqual($cpf);
    $cpf = "805.451.910-92";
    $field->value($cpf);
    expect($field->value())->toBeString()->toEqual($cpf);
});






