<?php

function index() {
  // halt(SERVER_ERROR, "Not good...");
  
  return html('index.html.php');
}

function pages() {
  return html(params('page') . '.html.php');
}

function index_catchall() {
  return html('index.html.php');
}
