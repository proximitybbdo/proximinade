<?php

function index() {
  // halt(SERVER_ERROR, "Not good...");
  _protect_post();
  
  return html('index.html.php');
}

function pages() {
  return html(params('page') . '.html.php');
}

function index_catchall() {
  return html('index.html.php');
}
