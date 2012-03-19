<?php

//require 'paths.php';

// Create WebClient behavior
$world->client = new \Goutte\Client;
$world->response = null;
$world->form = array();

// Helpful closures
// Use later, first get to know the package
$world->visit = function($link) use($world) {
  $world->crawler = $world->client->request('GET', $link);
};
