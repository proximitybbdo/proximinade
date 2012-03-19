<?php

/**
 * Place all custom helper methods here.
 */

function db_connection() {
  $db_env = _c('db_' . option('env'));
  
  if(is_null($db_env))
    $db_env = _c('db');

  $db_settings = array( 'host'      => $db_env['host'], 
                        'username'  => $db_env['user'],  
                        'password'  => $db_env['password'],  
                        'dbname'    => $db_env['db']
  );

  $db = Zend_Db::factory($db_env['adapter'], $db_settings); 

  try {
    $db->getConnection();

    return $db;
  } catch (Zend_Db_Adapter_Exception $e) {
    return NULL;
  }
}
