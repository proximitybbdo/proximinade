casper = require('casper').create()

casper.start "http://localhost:3000/home/", ->
  @test.comment 'Starting Proximinade testing sequence'

casper.then ->
  @test.assertTextExists 'another_page'

casper.thenOpen "http://localhost:3000/home/another_page#page", ->
  @test.assertTextExists 'another_page'

casper.run ->
  @test.renderResults true
