<?php

require_once('raven-php/lib/Raven/Autoloader.php');

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

  public static function log_error($errstr, $errfile, $errno = 500) {
    ErrorHandler::_log_to_sentry($errno, $errstr, $errfile);
  }

  public static function set_error_handling() {
    error(E_LIM_HTTP, 'ErrorHandler::default_error_handler');
  }

  public static function set_shutdown_handling() {
    $error = error_get_last();

    if($error !== NULL) {
      ob_clean();

      ErrorHandler::_log_to_sentry($error['type'], $error['message'], $error['file'], $error['line']);
    }

    return ErrorHandler::_return_html($error['type']);
  }

  public static function default_error_handler($errno, $errstr, $errfile, $errline) {
    global $app_directory, $lib_directory;

    status($errno);

    ErrorHandler::_log_to_sentry($errno, $errstr, $errfile, $errline);

    return ErrorHandler::_return_html($errno);
  }

  protected static function _return_html($errno) {
    set('code', $errno);
    set('errors', http_response_status_code($errno));
    
    if(_c('errors', 'custom_page')) {
      $html_file = (string) _c('errors', 'custom_page');
    } else {
      $html_file = '../lib/proximitybbdo/views/errors.html.php';
    }

    if((boolean) _c('errors', 'custom_layout')) {
      return html($html_file);
    } else {
      return html($html_file, null);
    }
  }

  protected static function _log_to_sentry($errno, $errstr, $errfile, $errline = -1) {
    Raven_Autoloader::register();

    $trace = debug_backtrace();

    $client = new Raven_Client('https://562e874daec24a73abb6f2502142ebe3:048ac2157ebf4c788552b4ed9b0d4d32@app.getsentry.com/2251');
    $client->captureException(new ProxException($errstr, $errno, $errfile, $errline, $trace));
  }
}

class ProxException {
  protected $message = '';
  protected $code = -1;
  protected $line = 0;
  protected $trace = '';
  protected $file = '';

  public function __construct($message, $code, $file, $line, $trace) {
    $this->message = $message;
    $this->code = $code;
    $this->line = $line;
    $this->trace = $trace;
    $this->file = $file;
  }

  public function getTrace() {
    return $this->trace;
  }

  public function getFile() {
    return $this->file;
  }

  public function getLine() {
    return $this->line;
  }

  public function getCode() {
    return $this->code;
  }

  public function getMessage() {
    return $this->message;
  }
}
