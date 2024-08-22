<?php
namespace Clientedigital\Pipefy;

uses()->beforeEach(function () {
});


test('TryGetTablesWithSuccess', function () {
    $pipefy = new Pipefy();
    $org = $pipefy->orgs()[0];
    $tables = $org->tables();
    expect($tables)->toBeArray()->toHaveCount(3);
    expect($tables[0]->id())->toBeInt();
    expect($tables[0])->toBeInstanceOf(Table::class);
    $table = new Table($tables[0]->id());
    $entity = $table->entity(); 
    expect($entity)->toBeInstanceOf(Entity\Table::class);
    expect($tables[0]->id())->toEqual($entity->internal_id);
    expect($entity->type)->toEqual("Table");
});

test('TryGetRecordWithSuccess', function () {
    $pipefy = new Pipefy();
    $org = $pipefy->orgs()[0];
    $table = $org->tables()[0];
    expect($table->entity())->toBeInstanceOf(Entity\Table::class);
    $records = $table->records();
    var_dump($records);
    foreach($records as $record){
        var_dump($record);
    }
}); 
