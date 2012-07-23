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
include_once('proximitybbdo/base_model.php');

require_once('Zend/Loader.php');
Zend_Loader::loadClass('Zend_Db');

class BaseModelEx extends BaseModel {
  public $prop1;
  public $prop2;
}

class BaseModelTest extends PHPUnit_Framework_TestCase {

  public static function setUpBeforeClass() {
    $config_directory = dirname(__FILE__) . '/fixtures/';
    ProximityApp::init($config_directory);
  }

  public function testConstructParameterParsing() {
    $params = array('prop1' => 'val1', 'prop2' => 'val2');
    $base = new BaseModelEx();
    $base->construct($params);

    $this->assertEquals('val1', $base->prop1);
    $this->assertEquals('val2', $base->prop2);
  }

  public function testDBReturnsObjectFromStaticCall() {
    $this->assertNotEquals(null, BaseModel::_get_db());
  }

  public function testDBReturnsObjectFromStaticCallOnExtendedObject() {
    $this->assertNotEquals(null, BaseModelEx::_get_db());
  }

  public function testDBReturnsObjectFromObjectCall() {
    $base = new BaseModel();
    $this->assertNotEquals(null, $base->get_db());
  }
}
