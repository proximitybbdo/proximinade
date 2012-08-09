<?php

include_once('helpers.php');

class BaseModelTest extends PHPUnit_Framework_TestCase {

  public static function setUpBeforeClass() {
    include_once(dirname(__FILE__) . '/../../app/lib/proximitybbdo/model/base_model.php');
  }

  public function testConstructParameterParsing() {
    $params = array('prop1' => 'val1', 'prop2' => 'val2');
    $base = new BaseModel();
    $base->prop1 = null;
    $base->prop2 = null;
    $base->construct($params);

    $this->assertEquals('val1', $base->prop1);
    $this->assertEquals('val2', $base->prop2);
  }
}
