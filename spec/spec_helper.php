<?php

// Set include path to include various dirs
global $config_directory, $root_directory, $app_directory, $lib_directory, $proximity_lib_directory, $spec_directory;

$root_directory = dirname(__FILE__) . '/../';
$app_directory = $root_directory . 'bin/app/';
$lib_directory = $app_directory . 'lib/';
$proximity_lib_directory = $app_directory . 'lib/proximitybbdo/';
$config_directory = dirname(__FILE__) . '/fixtures/config/';
$spec_directory = dirname(__FILE__);

set_include_path(get_include_path() . PATH_SEPARATOR . $lib_directory);
set_include_path(get_include_path() . PATH_SEPARATOR . $proximity_lib_directory);
set_include_path(get_include_path() . PATH_SEPARATOR . $config_directory);
set_include_path(get_include_path() . PATH_SEPARATOR . $spec_directory);

// include the apploader for framework setup
require('apploader.php');

// no echo output during tests
ob_start();
