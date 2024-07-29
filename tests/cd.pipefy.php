#!/usr/bin/env php
<?php
$GLOBALS['_composer_bin_dir'] = __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR;
$GLOBALS['_composer_autoload_path'] =  $GLOBALS['_composer_bin_dir'] . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
require $GLOBALS['_composer_bin_dir']. 'bin' . DIRECTORY_SEPARATOR  . 'cd.pipefy';

