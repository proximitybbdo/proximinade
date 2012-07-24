<?php

require_once('Zend/Loader.php');
Zend_Loader::loadClass('Zend_Db');

class Database {

  private static $instance = null;

  private $db = null;

  private function __construct() {
  }

  public function __clone() {
    trigger_error( "Cannot clone instance of Singleton pattern ...", E_USER_ERROR );
  }
  public function __wakeup() {
    trigger_error('Cannot deserialize instance of Singleton pattern ...', E_USER_ERROR );
  }

  /**
   * Returns an instance of Database
   */
  public static function get_instance() {
    if( self::$instance == null )
      self::$instance = new Database();

    return self::$instance;
  }

  /**
   * Init for the db class
   *
   * @param array $settings various db settings, including
   *   ['host']
   *   ['user']
   *   ['password']
   *   ['db']
   */
  public function init($settings) {
    $setup = array( 'host'      => $settings['host'], 
      'username'  => $settings['user'],  
      'password'  => $settings['password'],  
      'dbname'    => $settings['db']
    );

    $db = Zend_Db::factory($settings['adapter'], $setup); 

    try {
      $db->getConnection();
      $db->query('SET CHARACTER SET \'UTF8\'');

      $this->db = $db;
    } catch (Zend_Db_Adapter_Exception $e) {
      trigger_error("Error initializing DB", E_USER_ERROR);
    }
  }

  /**
   * Returns a Zend db connection object
   */
  public function get_connection() {
    return $db;
  }
}
