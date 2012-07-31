<?php

/**
 * Standard routes. Change to what you really need.
 */
dispatch('/:lang', 'index');

dispatch_post('index_post', 'index_post');

dispatch(':lang/very/deep/link', 'very_deep_link');

dispatch(':lang/:page', 'pages'); // dispatch all other pages to pages controller. Easy for templating.

/**
 * Function is called before every route is sent to his handler.
 */
function before_route($route) {
   
}

/**
 * Function is called before output is sent to browser.
 */
function after_route($output) {
  return $output;
}
