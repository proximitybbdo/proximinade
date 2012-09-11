<?php

$root_directory = dirname(__FILE__) . '/../../';
$lib_directory = $root_directory . 'app/lib/';
$config_directory = $root_directory . 'config/';

set_include_path(get_include_path() . PATH_SEPARATOR . $lib_directory);

