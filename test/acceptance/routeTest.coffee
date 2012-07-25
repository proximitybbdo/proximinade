casper = require('casper').create()

casper.start "http://dev.local/proximinade/home/", ->
  @test.comment 'Starting Proximinade testing sequence'

casper.then ->
  @test.assertTextExists 'another_page'

casper.thenOpen "http://dev.local/proximinade/home/another_page#page", ->
  @test.assertTextExists 'another_page'

casper.run ->
  @test.renderResults true
