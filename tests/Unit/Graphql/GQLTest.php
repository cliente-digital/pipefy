<?php
namespace Clientedigital\Pipefy\Graphql;
use Clientedigital\Pipefy\Pipefy;
// refactoring consts to var_dump($GLOBALS);

test('gqlDontExistNeedThrowException', function () {
    new GQL("nonexist");
})->throws(\Exception::class, "GQL script: nonexist not found");

test('trySetaPropertyThatDontExistThrowException', function () {
    $gql = new GQL("without_required_fields");
    $gql->set("PIPEID", 123);
})->throws(\Exception::class, "Property PIPEID dont exist in gql without_required_fields");

test('gqlUnsetUnrequiredVariableDontAppearOnScript', function () {
    $gql = new GQL("without_required_fields");

    $rawScript = trim(file_get_contents(Pipefy::getConfig('PIPEFY_GRAPHQL_DIR')."without_required_fields.gql"));
    expect($rawScript)->toEqual($gql->rawScript(), "Raw Script esta diferente do esperado");


    $expectedScript= "{         title     } }";
    expect($gql->script())->toEqual($expectedScript, "GQL Script esta diferente do esperado.");

    $expectedScript = "{  card (id : 123){         title     } }";
    $gql->set("CARDID", 123);
    expect($gql->script())->toEqual($expectedScript, "GQL Script esta diferente do esperado.");
});

test('gqlPropertyInfo', function () {
    $gql = new GQL("with_required_fields");
    $field = $gql->property('CARDID');

    expect($field)->toHaveProperties(['exists', 'type', 'required', 'name']);
    expect($field->exists)->toBeTrue();      
    expect($field->type)->toEqual('int');      
    expect($field->required)->toBeTrue();      
    expect($field->name)->toEqual('CARDID');      

    $field = $gql->property('TITLE');

    expect($field)->toHaveProperties(['exists', 'type', 'required', 'name']);
    expect($field->exists)->toBeTrue();      
    expect($field->type)->toEqual('string');      
    expect($field->required)->toBeFalse();      
    expect($field->name)->toEqual('TITLE');      

});

test('gqlPropertiesWith3Properties', function () {
    $gql = new GQL("with_required_fields");

    $info= $gql->info();
    expect($info->name)->toEqual('with_required_fields');
    expect($info->kind)->toEqual('query');
    expect($info->fields)->toHaveCount(3);
    expect($info->script)->toEqual('{
 card (id : _R.CARDID_){
        title: "_TITLE_"
        pipeid : _PIPEID_
    }
}');

});

test('gqlPropertiesFromEmptyGql', function () {
    $gql = new GQL("empty");

    $info= $gql->info();
    expect($info->script)->toEqual("");
    expect($info->name)->toEqual("empty");
    expect($info->fields)->toHaveCount(0);
});

test('gqlPropertiesFromMutation', function () {
    $gql = new GQL("mutation");

    $info= $gql->info();
    expect($info->kind)->toEqual("mutation");
});

test('gqlRequestScriptBeforeSetRequiredField', function () {
    $gql = new GQL("with_required_fields");
    $gql->script();

})->throws(\Exception::class, "Required Field not set: CARDID");


