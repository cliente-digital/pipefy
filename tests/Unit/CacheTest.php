<?php
namespace Clientedigital\Pipefy;

//uses()->beforeEach(function () {
//});


test('TryClearCacheOfAllStagedFiles', function () {
    $cache = new Cache();
    $cache->clear('card-', null, true);
});




