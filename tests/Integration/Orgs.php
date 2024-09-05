<?php
namespace Clientedigital\Pipefy;

uses()->beforeEach(function () {
});


test('TryGetOrgsWithSuccess', function () {
    $pipefy = new Pipefy();
    $orgs = $pipefy->orgs();
 
$orgs = new Clientedigital\Pipefy\Orgs();

$orgs = $orgs->All();

$org = $orgs[0];
$data = $org->get();
