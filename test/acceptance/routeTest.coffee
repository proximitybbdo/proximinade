casper = require('casper').create()

<<<<<<< HEAD
casper.start "http://localhost:3000/home/", ->
=======
casper.start "http://0.0.0.0:7000/proximinade/home/", ->
>>>>>>> fbb66617a7073d8bf9145384474fb5c74b1af270
  @test.comment 'Starting Proximinade testing sequence'

casper.then ->
  @test.assertTextExists 'another_page'

<<<<<<< HEAD
casper.thenOpen "http://localhost:3000/home/another_page#page", ->
=======
casper.thenOpen "http://0.0.0.0:7000/proximinade/home/another_page#page", ->
>>>>>>> fbb66617a7073d8bf9145384474fb5c74b1af270
  @test.assertTextExists 'another_page'

casper.run ->
  @test.renderResults true
