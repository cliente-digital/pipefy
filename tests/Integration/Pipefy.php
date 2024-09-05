<?php
namespace Clientedigital\Pipefy;

uses()->beforeEach(function () {
});


test('TryGetOrgsWithSuccess', function () {
    $pipefy = new Pipefy();
    $orgs = $pipefy->orgs();
    expect($orgs)->toBeArray()->toHaveCount(1);
    expect($orgs[0])->toBeInstanceOf(Org::class);
    expect($orgs[0]->id())->toBeInt();
});

test('TryOrgInstanceWithSuccess', function(){
    $orgid = (new Pipefy())->orgs()[0]->id();
    $org = new Org($orgid);
    expect($org)->toBeInstanceOf(Org::class);
    expect($org->id())->toEqual($orgid)->toBeInt();
    expect($org->pipes())->toBeArray()->toHaveCount(5);
    expect($org->pipe($org->pipes()[0]->id()))->toBeInstanceOf(Pipe::class);
});

test('TryOrgInstanceAndFail', function(){
    $orgid = (new Pipefy())->orgs()[0]->id();
    $org = new Org($orgid);
    expect($org)->toBeInstanceOf(Org::class);
    expect($org->id())->toEqual($orgid)->toBeInt();
    expect($org->pipes())->toBeArray()->toHaveCount(5);
    expect($org->pipe($org->pipes()[0]->id()))->toBeInstanceOf(Pipe::class);
});


test('TryOrgInstanceEntityWithSuccess', function(){
    $orgid = (new Pipefy())->orgs()[0]->id();
    $org = new Org($orgid);
    $entity = $org->entity();
    expect($entity)->toBeInstanceOf(Entity\Org::class);
    expect($entity->name)->toEqual('pessoal');
    expect($entity->freemium)->toBeTrue();
    expect($entity->membersCount)->toEqual(2);
    expect($entity->pipes)->toBeArray()->toHaveCount(5);
});


/*
$pipe = Pipefy->org(id)->pipes()->get(id) // Entity\Pipe;

$labels = $pipe->labels(); [] of Entity\labels.
$label_QUENTE = $pipe->labels()->labelByName('Quente');
$label_QUENTE->color = "#000000";
$pipe->update($label_QUENTE);

    // verifica se o label pertence ao pipe usando o owner_id.
    // se nao pertence lance exception.
    

// como labels conehce seu owner_id, consegue adicionar o label nele.
// utiliza gql label.new.gql

$new_label = new Entity\label();
$new_label->SetNome('tste')->SetColor('#5a5a5a');
$labels->add($new_label);

// quando roda uma atualizacao
    procura pela arvore de objects do owner e manda sinal para atualizar o objeto correspondete 
    // se ele tiver uma instancia.

*/
