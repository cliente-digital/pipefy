<?php
namespace Clientedigital\Pipefy;
use Clientedigital\Pipefy\Entity;


uses()->beforeEach(function () {
    $this->setConfig('CLIENTEDIGITAL_PIPEFY_CONFIG_FILE', __DIR__ ."/../../cd.pipefy.test.ini" );
    $cache_dir = Pipefy::getConfig('PIPEFY_CACHE_DIR');
    $this->setLocal('carddata', json_decode(file_get_contents("{$cache_dir}card-one-731bd1c64a74dfee99cb6e24afda5bfe.json"))->data->card);
});


test('testFilterCheckingACardEqualValueAndReturnFalseWithSuccess', function () {
   $card= new Entity\Card($this->getLocal('carddata'));
    $filter = new Filter\Cards();
    expect($filter->check($card))->tobeTrue("No filter parameter are set. Any card need be check true");
    $filter->by('campo_1', '=', 'Joao');
    expect($filter->check($card))->tobeFalse("campo_1 need be equal 'Joao'. Card has it value as John Doe");
});

test('testFilterCheckingACardEqualValueOfAPropertyThatNotExistAndReturnFalseWithSuccess', function () {
    $card= new Entity\Card($this->getLocal('carddata'));
    $filter = new Filter\Cards();
    $filter->by('campo_X', '=', 'Joao');
    expect($filter->check($card))->tobeFalse("campo_X Dont Exist And Equal Operator need return false");
});

test('testFilterCheckingACardContainValueOfAPropertyWithSuccess', function () {
    $card= new Entity\Card($this->getLocal('carddata'));
    $filter = new Filter\Cards();
    $filter->by('campo_1', '<-', 'John');
    expect($filter->check($card))->tobeTrue("campo_X Dont Exist And Equal Operator need return false");
});

test('testFilterCheckingACardvPropertyThatNotExistIsEqualNullOfAPropertyWithSuccess', function () {
    $card= new Entity\Card($this->getLocal('carddata'));
    $filter = new Filter\Cards();
    $filter->by('campo_x', '=', null);
    expect($filter->check($card))->tobeTrue("campo_X Dont Exist and Is Equal null");
});

test('testFilterCheckingACardContainPropertyThatNotExistWithSuccess', function () {
    $card= new Entity\Card($this->getLocal('carddata'));
    $filter = new Filter\Cards();
    $filter->by('campo_X', '<-', null);
    expect($filter->check($card))->tobeTrue("campo_X Dont Exist and Is Equal null");
});







