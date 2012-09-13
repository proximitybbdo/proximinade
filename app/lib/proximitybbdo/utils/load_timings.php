<?php

class LoadTimings {

  private static $instance = null;

  private function __construct() {}

  public function __clone() {
    trigger_error( "Cannot clone instance of Singleton pattern ...", E_USER_ERROR );
  }
  public function __wakeup() {
    trigger_error('Cannot deserialize instance of Singleton pattern ...', E_USER_ERROR );
  }

  /**
   * Returns an instance of LoadTimings
   */
  public static function get_instance() {
    if( self::$instance == null )
      self::$instance = new LoadTimings();

    return self::$instance;
  }

  public static $page_start;
  public static $page_end;
  public static $page_total;

  public static function get_time() {
    $load_time = explode(' ', microtime());

    return ($load_time[1] + $load_time[0]);
  }

  public static function start() {
    self::$page_start = self::get_time();

    if(isset($_GET['reset_timings'])) {
      self::reset_average();
    }
  }

  public static function end() {
    self::$page_end = self::get_time();

    self::$page_total = number_format((self::$page_end - self::$page_start), 4, '.', '');

    $_SESSION['LoadTimings::timings'] .= self::$page_total . ',';
  }

  public static function print_result() {
    echo('Page generated in ' . self::$page_total . ' seconds.<br />');
  }

  public static function reset_average() {
    $_SESSION['LoadTimings::timings'] = '';
  }

  public static function print_average() {
    $avg = explode(",", $_SESSION['LoadTimings::timings']);
    $count = count($avg) - 1;

    echo('Average of ' . (array_sum($avg) / $count));
    echo(' on ' . $count . ' tests. ');
  }
}
