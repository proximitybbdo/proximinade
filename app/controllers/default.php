<?php

function index() {
  return html('index.html.php');
}

function pages() {
  return html(params('page') . '.html.php');
}

function very_deep_link() {
  return html('deep.html.php');
}

function index_post() {
  redirect(_url('thanks'));
}
