<?php

include_once(dirname(__FILE__) . '/../../app/lib/proximitybbdo/base_model.php');

class BaseModelEx extends BaseModel {
  public $prop1;
  public $prop2;
}

class BaseModelTest extends PHPUnit_Framework_TestCase {

  public function testConstructParameterParsing() {
    $params = array('prop1' => 'val1', 'prop2' => 'val2');
    $base = new BaseModelEx();
    $base->construct($params);

    $this->assertEquals('val1', $base->prop1);
    $this->assertEquals('val2', $base->prop2);
  }
}
