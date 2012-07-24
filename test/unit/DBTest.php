<?php

// require_once('proximitybbdo/bootstrap.php');
// Set include path to include various dirs
global $config_directory, $root_directory, $app_directory, $lib_directory, $proximity_lib_directory, $spec_directory;

$root_directory = dirname(__FILE__) . '/../../';
$app_directory = $root_directory . 'app/';
$lib_directory = $app_directory . 'lib/';

set_include_path(get_include_path() . PATH_SEPARATOR . $lib_directory);

// include the apploader for framework setup
include_once('limonade.php');
include_once('proximitybbdo/apploader.php');
include_once('proximitybbdo/db.php');

class DBTest extends PHPUnit_Framework_TestCase {

  public function testGetInstanceShouldReturnDatabaseInstance() {
    $this->assertEquals('Database', get_class(Database::get_instance()));
  }

}
