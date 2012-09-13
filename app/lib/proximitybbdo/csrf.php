<?php

class CSRF {
  private static $instance = null;

  private function __construct() { }

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
      self::$instance = new CSRF();

    return self::$instance;
  }

  public static function setup() {
    CSRF::get_token();
  }

  public static function get_token() {
    return $_SESSION['_csrf'] = !isset($_SESSION['_csrf']) ? sha1(microtime()) : $_SESSION['_csrf'];
  }

  public static function verify_request($pass = true) {
    // Ignore GETS
    if($_SERVER['REQUEST_METHOD'] === 'GET') {
      return true;
    }

    // Token must match
    if(isset($_POST['csrf_token']) && $_POST['csrf_token'] === $_SESSION['_csrf']) {
      return true;
    }

    // Else
    if(function_exists('halt') && $pass) {
      halt(SERVER_ERROR, 'Protecting from CSRF since 1947.');
    } else {
      return false;
    }
  }
}
