<?php

class BaseModel {
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
}
