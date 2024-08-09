<?php
namespace Clientedigital\Pipefy;
use Clientedigital\Pipefy\Entity;
use Clientedigital\Pipefy\Filter\Operator;

uses()->beforeEach(function () {
    $cache_dir = Pipefy::getConfig('PIPEFY_CACHE_DIR');
    $this->setLocal('carddata', json_decode(file_get_contents("{$cache_dir}card-one-731bd1c64a74dfee99cb6e24afda5bfe.json"))->data->card);
});


test('testOperatorContainWithSuccess', function () {
   $entity = new Entity\Card($this->getLocal('carddata'));

   $contain = new Operator\Contain();
   $notcontain = new Operator\NotContain();
   expect($contain->evaluate($entity, 'email', 'gmail.com'))->toBeTrue();
   expect($contain->evaluate($entity, 'email', 'hotmail.com'))->toBeFalse();
   expect($notcontain->evaluate($entity, 'email', 'gmail.com'))->toBeFalse();
   expect($notcontain->evaluate($entity, 'email', 'hotmail.com'))->toBeTrue();
   
});

test('testOperatorEqualWithSuccess', function () {
   $entity = new Entity\Card($this->getLocal('carddata'));

   $contain = new Operator\Equal();
   $notcontain = new Operator\NotEqual();
   expect($contain->evaluate($entity, 'email', 'ianns@gmail.com'))->toBeTrue();
   expect($contain->evaluate($entity, 'email', 'ianns@hotmail.com'))->toBeFalse();
   expect($notcontain->evaluate($entity, 'email', 'ianns@gmail.com'))->toBeFalse();
   expect($notcontain->evaluate($entity, 'email', 'ianns@hotmail.com'))->toBeTrue();
});

test('testOperatorGreaterWithSuccess', function () {
   $entity = new Entity\Card($this->getLocal('carddata'));

   $contain = new Operator\GreaterThan();
   $notcontain = new Operator\GreaterThanEqual();
   expect($contain->evaluate($entity, 'numero', 1235 ))->toBeTrue();
   expect($contain->evaluate($entity, 'numero', 1236))->toBeFalse();
   expect($notcontain->evaluate($entity, 'numero', 1236))->toBeFalse();
   expect($notcontain->evaluate($entity, 'numero', 1235.32))->toBeTrue();
});

test('testOperatorLessWithSuccess', function () {
   $entity = new Entity\Card($this->getLocal('carddata'));

   $contain = new Operator\LessThan();
   $notcontain = new Operator\LessThanEqual();
   expect($contain->evaluate($entity, 'numero', 1236 ))->toBeTrue();
   expect($contain->evaluate($entity, 'numero', 1232))->toBeFalse();
   expect($notcontain->evaluate($entity, 'numero', 1230))->toBeFalse();
   expect($notcontain->evaluate($entity, 'numero', 1235.32))->toBeTrue();
});
