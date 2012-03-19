<?php

$steps->Given('/^I am on the devphp website "([^"]*)"$/', function($world, $url) {
  $world->url = $url;
});

$steps->When('/^I browse to the homepage \/$/', function($world) {
  $world->client->request('GET', $world->url);
});

$steps->Then('/^the title should be "([^"]*)"$/', function($world, $title) {
  $crawler = $world->client->getCrawler();
  assertEquals($title, $world->client->getCrawler()->filter('title')->text());
});
