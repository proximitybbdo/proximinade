<?php

// Set include path to include **app/lib** directory
$root_directory = dirname(__FILE__) . '/../../../';
$app_directory = $root_directory . 'app/';
$lib_directory = $app_directory . 'lib/';
$config_directory = $root_directory . 'config/';

set_include_path(get_include_path() . PATH_SEPARATOR . $lib_directory);
set_include_path(get_include_path() . PATH_SEPARATOR . $config_directory);

// [Limonade PHP](https://github.com/sofadesign/limonade/): the basis of this framework.
require_once('limonade.php');

// Default timezone.
date_default_timezone_set('Europe/Brussels');

// Load all Proximity BBDO libraries.
foreach (glob($lib_directory . 'proximitybbdo/*.php', GLOB_NOSORT) as $filename)
  require_once($filename);

// Load all sub lib files.
foreach (glob($lib_directory . 'proximitybbdo/[!(vi)]*/*.php', GLOB_NOSORT) as $filename)
  require_once($filename);

/**
 * Include Zend Loader class.
 * Load libraries like this: ``Zend_Loader::loadClass('Zend_Db');``
 */
require_once('Zend/Loader.php');

/**
 * basic config files needed to boot the application.
 */
require_once('bootstrap.php');
require_once('helpers.php');
require_once('routes.php');

/**
 * Load all models
 */
foreach (glob($app_directory . 'models/*.php', GLOB_NOSORT) as $filename)
  require_once($filename);

/**
 * Get environment settings based on root files.
 */
function get_env() {
  global $root_directory;
  
  $env = 'DEVELOPMENT'; // default
  $files = array();
  $envs = array('PRODUCTION', 'STAGING', 'DEVELOPMENT'); // priority order

  foreach(glob($root_directory . '*', GLOB_NOSORT) as $file)
    array_push($files, basename($file));

  foreach($envs as $state) {
    if(in_array($state, $files))
      return $state;
  }

  return $env;
}

// Default configuration. You probably won't need to change any of this.
function configure() {
  global $app_directory, $config_directory;

  // Define the base path based on the index.php file (and its location)
  $script_dir = dirname(dirname($_SERVER['SCRIPT_NAME']) . '/.');

  define('BASE_PATH', str_replace('\\', '', $script_dir . ($script_dir === '/' ? '' : '/' )));

  if(function_exists('config'))
    config();

  option('env', get_env());
  option('base_uri', BASE_PATH);

  // Init our skeleton app.
  ProximityApp::init($config_directory);

  // Environment variable. You could use this to take different actions when on production or development environment.
  if(array_key_exists('env', ProximityApp::$settings)) {
    foreach(ProximityApp::$settings['env'] as $state)
      option('ENV_' . $state, $state);
  }

  option('views_dir', $app_directory . 'views');
  option('controllers_dir', $app_directory . 'controllers');

  // default layout for rendering
  layout('layout.html.php');

  // set correct error reporting
  ErrorHandler::set_error_reporting();
  ErrorHandler::set_error_handling();

  // Init CSRF
  CSRF::setup();

  if(function_exists('config_post'))
    config_post();
}

// Start session
session_start();

// LoadTimings::start();

run();

// LoadTimings::end();
// LoadTimings::print_result();
// LoadTimings::print_average();
