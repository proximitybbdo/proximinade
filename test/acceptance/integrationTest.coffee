casper = require('casper').create()

casper.start "http://localhost:3000/", ->
  @test.comment 'Starting Proximinade integration test'
  @test.assertHttpStatus 200, 'Site is up'
  @test.assertTitle 'Proximinade Integration Test', 'Title is correct'

casper.then ->
  @test.comment 'Testing langswitch'
  @test.assertExists 'body#nl-BE', 'Default lang is nl-BE'
  @click '#langswitch #fr'
  @test.assertExists 'body#fr-BE', 'Lang switched to fr-BE'
  @test.assertTitle 'Proximinade Test d\'Integration', 'Title is correct'

# casper.thenOpen "http://localhost:3000/home/another_page#page", ->
#   @test.assertTextExists 'another_page'

casper.run ->
  @test.renderResults true
