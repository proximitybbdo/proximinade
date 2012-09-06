<?php

include_once('helpers.php');

class HelpersTest extends PHPUnit_Framework_TestCase {

  public static function setUpBeforeClass() {
    // include the apploader for framework setup
    include_once('limonade.php');
    include_once('proximitybbdo/apploader.php');
    include_once('proximitybbdo/db.php');
  }

  public function setUp() {
    $this->config_dir = dirname(__FILE__) . '/fixtures/';
    ProximityApp::init($this->config_dir);
  }

  public function testGlobalCReturnsCorrectValueForKey() {
    $this->assertEquals('nananananananana', _c('batman'));
  }

  public function testAssetProducesCorrectUrl() {
    define('BASE_PATH', str_replace('\\', '', dirname(__FILE__)));
    $this->assertEquals(dirname(__FILE__) . '/assets/img/some_image.jpg', _asset('assets/img/some_image.jpg'));
  }

  public function testUrlReturnsOtherLangInUrl() {
    $this->assertEquals('/fr-BE/some-page', _url('some-page', 'fr-BE'));
  }

  public function testUrlReturnsDefaultLang() {
    $this->assertEquals('/nl-BE/some-page', _url('some-page'));
  }

  public function testGetDB() {
    $this->assertNotNull(get_db());
  }

  public function testUrlParts() {
    $this->markTestIncomplete('This test has not been implemented yet.');
  }

  public function testPage() {
    $this->markTestIncomplete('This test has not been implemented yet.');
  }

}
