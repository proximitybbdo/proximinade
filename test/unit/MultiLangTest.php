<?php

$root_directory = dirname(__FILE__) . '/../../';
$lib_directory = $root_directory . 'app/lib/';
$config_directory = $root_directory . 'config/';

set_include_path(get_include_path() . PATH_SEPARATOR . $lib_directory);

include_once('proximitybbdo/multilang.php');

class MultiLangTest extends PHPUnit_Framework_TestCase {

  protected function setUp() {
    $this->langDir = dirname(__FILE__) . '/fixtures/locales';
    MultiLang::getInstance()->init($this->langDir);
  }

  protected function tearDown() {
    Multilang::getInstance()->destroy();
  }

  public function testShouldReturnMultilangInstance() {
    $this->assertEquals('Multilang', get_class(MultiLang::getInstance()));
  }

  public function testInitWithNoDefaultLangSetsDefaultLangToNLBE() {
    $this->assertEquals('nl-BE', MultiLang::getInstance()->getLang());
  }

  public function testInitWithDefaultLangSetsLangToFRBE() {
    MultiLang::getInstance()->init($this->langDir, 'fr-BE');
    $this->assertEquals('fr-BE', MultiLang::getInstance()->getLang());
  }

  public function testInitIncreasesLangs() {
    Multilang::getInstance()->destroy();
    $this->assertCount(0, Multilang::getInstance()->langs);
    MultiLang::getInstance()->init($this->langDir);
    $this->assertCount(2, Multilang::getInstance()->langs);
  }

  public function testLangSwitchOutputsCorrectLbels() {
    Multilang::getInstance()->setLang('nl-BE');
    $this->assertEquals(_t('tmnt'), 'Heroes in a half shell, Turtle power!');

    Multilang::getInstance()->setLang('fr-BE');
    $this->assertEquals(_t('tmnt'), "Le chanson en FR, n'existe pas! Turle power!");

    Multilang::getInstance()->setLang('nl-BE');
    $this->assertEquals(_t('tmnt'), 'Heroes in a half shell, Turtle power!');
  }

  public function testResetDefaultLanguage() {
    Multilang::getInstance()->setLang('fr-BE');
    $this->assertEquals(_t('tmnt'), "Le chanson en FR, n'existe pas! Turle power!");

    Multilang::getInstance()->setDefaultLang();
    $this->assertEquals(_t('tmnt'), 'Heroes in a half shell, Turtle power!');
  }

  // gloabalT stands for the global _t() helper function
  public function testGlobalTWithoutLang() {
    $this->assertEquals(_t('tmnt'), 'Heroes in a half shell, Turtle power!');
  }

  public function testGlobalTWithLang() {
    $this->assertEquals(_t('tmnt', 'fr-BE'), "Le chanson en FR, n'existe pas! Turle power!");
  }

  public function testGlobalTChaining() {
    $this->assertEquals(_t('chain')->t('hangs'), 'low');
  }

   

}
?>
