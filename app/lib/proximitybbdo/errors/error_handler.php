<?php

class ErrorHandler {
  // sets the correct error reporting
  // depending on the environment (DEV / STAGING /  PRODUCTION)
  public static function set_error_reporting() {
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

  public static function set_error_handling() {
    error(E_LIM_HTTP, 'ErrorHandler::default_error_handler');
  }

  public static function default_error_handler($errno, $errstr, $errfile, $errline) {
    global $app_directory, $lib_directory;

    status($errno);

    set('code', $errno);
    set('errors', http_response_status_code($errno));
    
    if(_c('errors', 'custom_page'))
      $html_file = (string) _c('errors', 'custom_page');
    else
      $html_file = '../lib/proximitybbdo/views/errors.html.php';

    ErrorHandler::_log_to_google_docs($errno, $errstr, $errfile, $errline);

    if((boolean) _c('errors', 'custom_layout'))
      return html($html_file);
    else
      return html($html_file, null);
  }

  protected static function _log_to_google_docs($errno, $errstr, $errfile, $errline) {
    Zend_Loader::loadClass('Zend_Http_Client');

    $client = new Zend_Http_Client('https://docs.google.com/a/proximity.bbdo.be/spreadsheet/formResponse?formkey=dG55ZHlRZzdaWFpkZnRsT3dXZjZmNkE6MQ&amp;ifq');

    // set some parameters
    $client->setParameterPost('entry.0.single', '');
    $client->setParameterPost('entry.1.single', $errno);
    $client->setParameterPost('entry.2.single', $errstr);
    $client->setParameterPost('entry.3.single', $errfile);
    $client->setParameterPost('entry.4.single', $errline);

    // POST request
    $response = $client->request(Zend_Http_Client::POST);
  }
}
