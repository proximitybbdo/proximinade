<?php
# ============================================================================ #
/**
 * Proximity Framwork Helpers 
 * 
 * v0.01
 * @package proximitybbdo
 *
 * These functions are generic helpers that can be used throughout the framework
 * They can be called from everywhere since they are loaded from the moment
 * the app starts.
 */
# ============================================================================ #

/**
 * Helper _c function defined outside of the apploader class for easy of use.
 * Parses the options found in the config.yml
 */
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

/**
 * Logs input to the console (if available, won't crash on IE)
 *
 * @param $msg  the input for the log, can be anything from a string to an object
 *              try me :)
 * 
 * The output will not be shown if you have 'verbose' in you config.yaml
 */
function _log($msg) {
  $out = "<script>//<![CDATA[\n";
  $out .= 'if(this.console) {';
  $out .= 'console.log(' . json_encode($msg) . '); }';
  $out .= "\n//]]></script>";

  if(_c('verbose')) {
    echo($out);
  }
}

// Splits the url into parts.
function _url_parts() {
  $parts = explode("/", request_uri());
  
  array_shift($parts); // remove first empty element (blame the explode)
  return $parts;
}

// Returns the name (based on the URL) of the part you request (based on the ``$id``).
function _page($id = 0) {
  $parts = _url_parts();

  // if first part is a lang (we match it with the lang array from MultiLang)
  if(count($parts) > 0 && preg_match(Multilang::get_instance()->langs_as_regexp(), $parts[0]))
    array_shift($parts);

  // if the given index is found in the url
  if(count($parts) > 0 && $id < count($parts))
    return $parts[$id];

  return '';
}

// Returns **active** when the ``$page_name`` argument combined with the given ``$id`` resembles the page.
function _get_active($page_name, $id = 0) {
  if(_page($id) == $page_name)
    return 'active';
  
  return '';
}

function _asset($path) {
  $path = preg_replace("/^\//", "", $path);
  $path = strlen($path) === 0 ? '' : '/' . $path;
  $path = (BASE_PATH == '/' ? '' : BASE_PATH) . $path;
  $path = preg_replace("/\/\//", "/", $path);

  return $path;
}

function _url($value, $lang = '') {
  $lang = strlen($lang) == 0 ? Multilang::get_instance()->get_lang() : $lang;

  return url_for($lang . '/' . $value);
}

function _h_option_select($value1, $value2) {
  echo ($value1 == $value2) ? 'selected="selected"' : '';
}

function get_db() {
  return Database::get_instance()->get_db();
}

function _protect_post($pass = true) {
  CSRF::verify_request($pass);
}
