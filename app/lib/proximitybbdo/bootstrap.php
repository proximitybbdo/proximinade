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
foreach (glob($lib_directory . 'proximitybbdo/*.php') as $filename)
  require_once($filename);

// Load all Limonade startip files.
foreach (glob($lib_directory . 'proximitybbdo/limonade/*.php') as $filename)
  require_once($filename);

// Include Zend Loader class.
// Load librarues like this: ``Zend_Loader::loadClass('Zend_Db');``
require_once('Zend/Loader.php');

// Basic config files needed to boot the application.
require_once('bootstrap.php');
require_once('helpers.php');
require_once('routes.php');

// Models if exists
if(file_exists($app_directory . 'models/')) {
  foreach (glob($app_directory . 'models/*.php') as $filename)
    require_once($filename);
}

function get_env() {
  global $root_directory;
  
  $env = 'DEVELOPMENT'; // default
  $files = array();
  $envs = array('PRODUCTION', 'STAGING', 'DEVELOPMENT'); // priority order

  foreach(glob($root_directory . '*') as $file)
    array_push($files, basename($file));

  foreach($envs as $state) {
    if(in_array($state, $files))
      return $state;
  }

  return $env;
}

// sets the correct error reporting
// depending on the environment (DEV / STAGING /  PRODUCTION)
function set_error_reporting() {
  if(get_env() === 'DEVELOPMENT') {
    // Error reporting: report everything
    error_reporting(E_ALL);
  } else {
    // Error reporting: report nothing, only fatal errors.
    error_reporting(E_ALL & ~E_STRICT & ~E_WARNING & ~E_NOTICE & ~E_DEPRECATED);
  }

  // Display the errors when they occur.
  ini_set('display_errors', 1);
}

// Default configuration. You probably won't need to change any of this.
function configure() {
  global $app_directory, $config_directory;

  // Define the base path based on the index.php file (and its location)
  $script_dir = dirname(dirname($_SERVER['SCRIPT_NAME']) . '/.');

  define('BASE_PATH', str_replace('\\', '', $script_dir . ($script_dir === '/' ? '' : '/' )));

  if(function_exists('config'))
    config();

  // Init our skeleton app.
  ProximityApp::init($config_directory);

  // Environment variable. You could use this to take different actions when on production or development environment.
  if(array_key_exists('env', ProximityApp::$settings)) {
    foreach(ProximityApp::$settings['env'] as $state)
      option('ENV_' . $state, $state);
  }

  option('env', get_env());
  option('base_uri', BASE_PATH);

  option('views_dir', $app_directory . 'views');
  option('controllers_dir', $app_directory . 'controllers');

  foreach (glob($app_directory . 'models/*.php') as $filename)
    require_once($filename);

  // default layout for rendering
  layout('layout.html.php');

  // set correct error reporting
  set_error_reporting();

  if(function_exists('config_post'))
    config_post();
}

// Start session
session_start();

run();
