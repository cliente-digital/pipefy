<?php
namespace Clientedigital\Pipefy\Graphql;
define('FIXTURE_PATH', __DIR__. DIRECTORY_SEPARATOR. "fixtures". DIRECTORY_SEPARATOR);
define('CLIENTE_DIGITAL_BULK_PAGE_SIZE', 30);
// refactoring consts to var_dump($GLOBALS);

uses()->beforeEach(function () {
    Bulk::destroy();
});

test('tryInitBulkWithPageSizeEqualsZeroAndFails', function () {
    $this->setConfig("CLIENTEDIGITAL_PIPEFY_GRAPHQL_DIR", FIXTURE_PATH);
    Bulk::init(0);
})->throws(\Exception::class, "Pagesize cannot be less than 1.");

test('tryToAddAGqlToABulkWithoutInitializeItAndFail', function () {
    $this->setConfig("CLIENTEDIGITAL_PIPEFY_GRAPHQL_DIR", FIXTURE_PATH);
    $gql = new GQL("mutation");
    Bulk::add($gql);
})->throws(\Exception::class, "Bulk need be initialized.");

test('tryInitBulkWithDefaultPageSizeWithSuccess', function () {
    $this->setConfig("CLIENTEDIGITAL_PIPEFY_GRAPHQL_DIR", FIXTURE_PATH);
    Bulk::init();
    expect(Bulk::pageSize())->toBeInt()->toBe(CLIENTE_DIGITAL_BULK_PAGE_SIZE);
});


test('tryToAddAQueryGqlAndFail', function () {
    $this->setConfig("CLIENTEDIGITAL_PIPEFY_GRAPHQL_DIR", FIXTURE_PATH);
    Bulk::init(5);
    $gql = new GQL("without_required_fields");
    $id = Bulk::add($gql);
})->throws(\Exception::class, "Only mutations can be paginate.");

test('tryToAddAMutationGqlWithSuccess', function () {
    $this->setConfig("CLIENTEDIGITAL_PIPEFY_GRAPHQL_DIR", FIXTURE_PATH);
    Bulk::init(5);
    $gql = new GQL("mutation");
    $id = Bulk::add($gql);
    expect($id)->TobeInt()->toBe(0);
});

test('tryToAddAMutationWithUnsetRequiredFieldAndFail', function () {
    $this->setConfig("CLIENTEDIGITAL_PIPEFY_GRAPHQL_DIR", FIXTURE_PATH);
    Bulk::init(5);
    $gql = new GQL("mutation_with_required");
    $id = Bulk::add($gql);
    expect($id)->TobeInt()->toBe(0);
})->throws(\Exception::class, "Required Field not set: CARDID");

test('tryAdd30GQLandCheckBulkWithSuccess', function () {
    $this->setConfig("CLIENTEDIGITAL_PIPEFY_GRAPHQL_DIR", FIXTURE_PATH);
    Bulk::init(5);
    for($i=1; $i<=30; $i++){
        $gql = new GQL("mutation");
        $id = Bulk::add($gql);
    }
    $info = Bulk::info();
    expect($info->pageSize)->toBeInt()->toBe(5);
    expect($info->timeOfFirstGQL)->toBeInstanceOf(\DateTime::class);
    expect($info->pages)->toBeInt()->toBe(6);

    $pages = Bulk::paginate(); 
    foreach($pages as $idx => $page){
        expect($page)->toBeInstanceOf(Bulk\Page::class);
        expect($page->script())->toContain("pageitem"); 
        expect($page->rawScript())->toContain("_TITLE_"); 
        expect($page->size())->toBeInt()->toBe(5);
        expect($page->id())->toBeInt()->toBe($idx);
    }
});


