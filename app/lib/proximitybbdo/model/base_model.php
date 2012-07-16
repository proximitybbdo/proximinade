<?php

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

  protected static function _get_db() {
    $d = new BaseModel();

    return $d->get_db();
  }
}
