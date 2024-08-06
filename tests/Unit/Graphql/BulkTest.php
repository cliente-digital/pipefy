<?php
namespace Clientedigital\Pipefy\Graphql;

define('BULK_TEST_PAGE_SIZE', 30);
uses()->beforeEach(function () {
    Bulk::destroy();
});

test('tryInitBulkWithPageSizeEqualsZeroAndFails', function () {
    Bulk::init(0);
})->throws(\Exception::class, "Pagesize cannot be less than 1.");

test('tryToAddAGqlToABulkWithoutInitializeItAndFail', function () {
    Bulk::destroy();
    $gql = new GQL("mutation");
    Bulk::add($gql);
})->throws(\Exception::class, "Bulk need be initialized.");

test('tryInitBulkWithDefaultPageSizeWithSuccess', function () {
    Bulk::init();
    expect(Bulk::pageSize())->toBeInt()->toBe(BULK_TEST_PAGE_SIZE);
});


test('tryToAddAQueryGqlAndFail', function () {
    Bulk::init(5);
    $gql = new GQL("without_required_fields");
    $id = Bulk::add($gql);
})->throws(\Exception::class, "Only mutations can be paginate.");

test('tryToAddAMutationGqlWithSuccess', function () {
    Bulk::init(5);
    $gql = new GQL("mutation");
    $id = Bulk::add($gql);
    expect($id)->TobeInt()->toBe(0);
});

test('tryToAddAMutationWithUnsetRequiredFieldAndFail', function () {
    Bulk::init(5);
    $gql = new GQL("mutation_with_required");
    $id = Bulk::add($gql);
    expect($id)->TobeInt()->toBe(0);
})->throws(\Exception::class, "Required Field not set: CARDID");

test('tryAdd30GQLandCheckBulkWithSuccess', function () {
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


