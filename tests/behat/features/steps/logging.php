<?php

$steps->Given('/^I visit any page/', function($world) {
  $world->client->request('GET', 'http://devphp.local/');
});

$steps->When('/^I _log "([^"]*)"$/', function($world, $log) {
  ob_start();
  _log($log);
  $world->log = ob_get_contents();
  ob_end_clean();
});

$steps->Then('/^the console should contain "([^"]*)"$/', function($world, $log) {
  assertContains($log, $world->log); 
});
