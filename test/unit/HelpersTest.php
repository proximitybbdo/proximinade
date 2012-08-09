<?php

// Set include path to include various dirs
$lib_directory = dirname(__FILE__) . '/../../app/lib/';

set_include_path(get_include_path() . PATH_SEPARATOR . $lib_directory);

// include the apploader for framework setup
include_once('limonade.php');
include_once('proximitybbdo/apploader.php');
include_once('proximitybbdo/limonade/helpers.php');

class HelpersTest extends PHPUnit_Framework_TestCase {

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

  public function testDBConnection() {
    $this->assertNotNull(_db_connection());
  }

  public function testUrlParts() {
    $this->markTestIncomplete('This test has not been implemented yet.');
  }

  public function testPage() {
    $this->markTestIncomplete('This test has not been implemented yet.');
  }

}
