<?php

include_once(dirname(__FILE__) . '/limonade/helpers.php');

class BaseModel {
  public $db = NULL;

  public function construct($pdata, $prefix = NULL) {
    foreach($pdata as $fieldname => $value) {
      if(!is_null($prefix)) {
        $split = explode($prefix . '_', $fieldname);

        if(count($split) > 1 && property_exists($this, $split[1]))
          $this->{$split[1]} = $value;
      } else if(property_exists($this, $fieldname))
        $this->{$fieldname} = $value;
    }
  }

  public function get_db() {
    if(is_null($this->db))
      $this->db = db_connection();

    if(is_null($this->db))
      $this->add_error('Could not connect to database.');
    
    return is_null($this->db) ? FALSE : $this->db;
  }

  public function add_error() {
    throw new Exception('Not yet implemented: BaseModel::add_error');
  }

  public static function _get_db() {
    $d = new BaseModel();

    return $d->get_db();
  }

  public static function _add_error() {
    $d = new BaseModel();

    return $d->add_error();
  }
}
