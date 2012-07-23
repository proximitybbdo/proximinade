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

// Require spyc for YAML parsing.
require_once(dirname(dirname(__FILE__)) . "/spyc/spyc.php");

class ProximityApp {
  public static $settings = array();
  public static $settings_file = 'config.yml';

  // Parse a yaml config file and save it in an array
  private static function load_settings($settings_file) {
    self::$settings = spyc_load_file($settings_file);
  }

  // Inits the actual app, putting together a skeleton of
  // niceness to use in your app, like multilang
  public static function init($config_directory, $param_settings_file = '') {
    // Step one, parse settings
    self::load_settings($config_directory . (strlen($param_settings_file) > 0 ? $param_settings_file : self::$settings_file));

    // Init Multilang
    $lang_dir_setting = array_key_exists('dir', ProximityApp::$settings['multilang']) ? ProximityApp::$settings['multilang']['dir'] : '';
    $lang_dir = strlen($lang_dir_setting) > 0 ? $lang_dir_setting : 'assets/locales/';
    $lang_dir = dirname(__FILE__) . '/../../../' . $lang_dir;
    Multilang::getInstance()->init($lang_dir);
  }
}

// Helper _c function defined outside of the apploader class
// for easy of use
function _c() {
  $result = ProximityApp::$settings;

  for($i = 0; $i < func_num_args(); $i++) {
    if(isset($result[func_get_arg($i)]))
      $result = $result[func_get_arg($i)];
    else
      return NULL;
  }

  return $result;
}
