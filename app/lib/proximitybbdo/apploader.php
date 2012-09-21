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
  public static $default_file = 'default.yml';

  // parse a yaml config file and save it in an array
  private static function load_settings($settings_file) {
    return spyc_load_file($settings_file);
  }

  private static function merge_arrays($arr1, $arr2) {
    foreach($arr2 as $key => $value) {
      if(array_key_exists($key, $arr1) && is_array($value)) {
        $arr1[$key] = self::merge_arrays($arr1[$key], $arr2[$key]);
      } else {
        $arr1[$key] = $value;
      }
    }

    return $arr1;
  }

  // inits the actual app, putting together a skeleton of
  // niceness to use in your app, like multilang
  public static function init($config_directory, $param_settings_file = '') {
    // Step one, parse settings
    $settings = self::load_settings($config_directory . (strlen($param_settings_file) > 0 ? $param_settings_file : self::$settings_file));
    $default = self::load_settings(dirname(__FILE__) . '/config/' . self::$default_file);

    self::$settings = self::merge_arrays($default, $settings);

    // init Multilang
    $lang_dir = dirname(__FILE__) . '/../../../' . ProximityApp::$settings['multilang']['dir'];

    $default_lang = array_key_exists('default', ProximityApp::$settings['multilang']) ? ProximityApp::$settings['multilang']['default'] : 'nl-BE';
    
    Multilang::get_instance()->init($lang_dir, $default_lang);

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
