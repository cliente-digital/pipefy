<?php
namespace Clientedigital\Pipefy;


uses()->beforeEach(function () {
});


//define('CLIENTE_DIGITAL_BULK_PAGE_SIZE', 30);
test('TryGetConfigFromPipefyWithSuccessAfterConfigureParameter', function () {
    $apikey = Pipefy::getConfig('PIPEFY_APIKEY');
    expect($apikey)->toBeString("Should be a value into the key");
});

test('TrySetBulkModeWithSuccess', function () {
    expect(Pipefy::useBulk())->toBeFalse("Bulk Mode Should init as false.");
    expect(Pipefy::useBulk(true))->toBeTrue("Should enter the Bulk Mode  and return true.");
    expect(Pipefy::useBulk(false))->toBeFalse("Should exit Bulk Mode and return false.");
});

test('testUseCacheStates', function () {
    expect(Pipefy::useCache())->toBeBool()->toBeFalse();
    expect(Pipefy::useCache(true))->toBeBool()->toBeTrue();
    expect(Pipefy::useCache())->toBeBool()->toBeTrue();
    expect(Pipefy::useCache(False))->toBeBool()->toBeFalse();
    expect(Pipefy::useCache())->toBeBool()->toBeFalse();
});

test('testUseBulStates', function () {
    expect(Pipefy::useBulk())->toBeBool()->toBeFalse();
    expect(Pipefy::useBulk(true))->toBeBool()->toBeTrue();
    expect(Pipefy::useBulk())->toBeBool()->toBeTrue();
    expect(Pipefy::useBulk(False))->toBeBool()->toBeFalse();
    expect(Pipefy::useBulk())->toBeBool()->toBeFalse();
});





