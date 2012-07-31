casper = require('casper').create()

casper.start "http://localhost:3000/", ->
  @test.comment 'Starting Proximinade integration test'
  @test.assertHttpStatus 200, 'Site is up'
  @test.assertTitle 'Proximinade Integration Test', 'Title is correct'

casper.then ->
  @test.comment 'Default lang should be nl-BE'
  @test.assertExists 'body#nl-BE', 'Default lang is nl-BE'
  @click '#fr'

casper.then ->
  @test.comment 'Langswitch should change body ID to other lang'
  @test.assertExists 'body#fr-BE', 'Lang switched to fr-BE'
  @test.assertTitle 'Proximinade Test d\'Integration', 'Title is correct'

casper.then ->
  @test.comment 'Form post should redirect to `thanks`'
  @click 'form input[type=submit]'

casper.then ->
  @test.assertEquals @getCurrentUrl(), 'http://localhost:3000/fr-BE/thanks'

casper.then ->
  @test.comment 'Very deep link should return a page'

casper.thenOpen "http://localhost:3000/nl-BE/very/deep/link", ->
  @test.assertHttpStatus 200, 'Very deep link responds'
  @test.assertTextExists 'verydeeplink', '_page() + _page(1) + _(2) should match `verydeeplink`'

# casper.thenOpen "http://localhost:3000/home/another_page#page", ->
#   @test.assertTextExists 'another_page'

casper.run ->
  @test.renderResults true
