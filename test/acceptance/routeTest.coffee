casper = require('casper').create()

casper.start "http://0.0.0.0:7000/proximinade/home/", ->
  @test.comment 'Starting Proximinade testing sequence'

casper.then ->
  @test.assertTextExists 'another_page'

casper.thenOpen "http://0.0.0.0:7000/proximinade/home/another_page#page", ->
  @test.assertTextExists 'another_page'

casper.run ->
  @test.renderResults true
