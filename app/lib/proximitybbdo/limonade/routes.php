<?php

/**
 * This default helper sets some interesting default values.
 * ``base_path`` can be used to generate a url that points to the root of the site.
 * ``lang`` will give your the language based on an optional language url (eg. /nl-BE/...)
 */
function before($route) {
  set('base_path', BASE_PATH);

  // Set lang if first controller is a language
  $url_parts = _url_parts();
  
  if(preg_match(Multilang::get_instance()->langs_as_regexp(), $url_parts[0]))
    Multilang::get_instance()->set_lang($url_parts[0]);

  set('lang', Multilang::get_instance()->get_lang());

  if(function_exists('before_route'))
    before_route($route);  
}

function after($output) {
  global $root_directory;

  if(array_key_exists('xporter', ProximityApp::$settings) && ProximityApp::$settings['xporter']['active']) {
    $xporter = new Exporter($root_directory);
    $xporter->export($output);
  }

  if(function_exists('after_route'))
    return after_route($output);  
  else
    return $output;
}

function before_render($content_or_func, $layout, $locals, $view_path) {
  if(_c('compile_templates') !== false) {
    $c = new Compiler();

    $view_path = $c->template($view_path);
  }

  return array($content_or_func, $layout, $locals, $view_path);
}
