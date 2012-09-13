<?php

# ============================================================================ #
/**
 * Proximity Apploader
 *
 * Class with helper functions for a basic application
 *
 * v0.01
 *
 * @package proximitybbdo
 *
 */
# ============================================================================ #

require_once(dirname(dirname(__FILE__)) . "/spyc/spyc.php");
require_once('multilang.php');
require_once('db.php');
require_once('limonade/helpers.php');

class ProximityApp {
  public static $settings = array();
  public static $settings_file = 'config.yml';

  // parse a yaml config file and save it in an array
  private static function load_settings($settings_file) {
    self::$settings = spyc_load_file($settings_file);
  }

  // inits the actual app, putting together a skeleton of
  // niceness to use in your app, like multilang
  public static function init($config_directory, $param_settings_file = '') {
    // Step one, parse settings
    self::load_settings($config_directory . (strlen($param_settings_file) > 0 ? $param_settings_file : self::$settings_file));

    // init Multilang
    $lang_dir_setting = array_key_exists('dir', ProximityApp::$settings['multilang']) ? ProximityApp::$settings['multilang']['dir'] : '';
    $lang_dir = strlen($lang_dir_setting) > 0 ? $lang_dir_setting : 'assets/locales/';
    $lang_dir = dirname(__FILE__) . '/../../../' . $lang_dir;

    Multilang::get_instance()->init($lang_dir);

    // init Database if needed
    $db_env = _c('db_' . option('env'));
  
    if(is_null($db_env)) {
      $db_env = _c('db');
    }

    if(!is_null($db_env)) {
      Database::get_instance()->init($db_env);
    }
  }
}
