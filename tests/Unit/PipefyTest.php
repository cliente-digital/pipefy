<?php
namespace Clientedigital\Pipefy;


uses()->beforeEach(function () {
});


//define('CLIENTE_DIGITAL_BULK_PAGE_SIZE', 30);
test('TryGetConfigFromPipefyWithSuccessAfterConfigureParameter', function () {
    $this->setConfig('CLIENTEDIGITAL_PIPEFY_CONFIG_FILE', __DIR__ . DIRECTORY_SEPARATOR . "cd.pipefy.ini" );
    $apikey = Pipefy::getConfig('PIPEFY_APIKEY');
    expect($apikey)->toBeString("Should be a value into the key");
});

test('TryGetOrgsWithSuccess', function () {
    $pipefy = new Pipefy();
    $orgs = $pipefy->orgs();
    expect($orgs)->toBeInstanceOf(Orgs::class);
    expect($orgs->all())->toBeArray()->toHaveCount(1);
});

test('TrySetBulkModeWithSuccess', function () {
    expect(Pipefy::useBulk())->toBeFalse("Bulk Mode Should init as false.");
    expect(Pipefy::useBulk(true))->toBeTrue("Should enter the Bulk Mode  and return true.");
    expect(Pipefy::useBulk(false))->toBeFalse("Should exit Bulk Mode and return false.");
});







