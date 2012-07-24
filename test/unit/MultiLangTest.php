<?php

$root_directory = dirname(__FILE__) . '/../../';
$lib_directory = $root_directory . 'app/lib/';
$config_directory = $root_directory . 'config/';

set_include_path(get_include_path() . PATH_SEPARATOR . $lib_directory);

include_once('proximitybbdo/multilang.php');

class MultiLangTest extends PHPUnit_Framework_TestCase {

  protected function setUp() {
    $this->langDir = dirname(__FILE__) . '/fixtures/locales';
    MultiLang::get_instance()->init($this->langDir);
  }

  protected function tearDown() {
    MultiLang::get_instance()->destroy();
  }

  public function testGetInstanceShouldReturnMultiLangInstance() {
    $this->assertEquals('MultiLang', get_class(MultiLang::get_instance()));
  }

  public function testInitWithNoDefaultLangSetsDefaultLangToNLBE() {
    $this->assertEquals('nl-BE', MultiLang::get_instance()->get_lang());
  }

  public function testInitWithDefaultLangSetsLangToFRBE() {
    MultiLang::get_instance()->init($this->langDir, 'fr-BE');
    $this->assertEquals('fr-BE', MultiLang::get_instance()->get_lang());
  }

  public function testInitIncreasesLangs() {
    MultiLang::get_instance()->destroy();
    $this->assertCount(0, MultiLang::get_instance()->langs);
    MultiLang::get_instance()->init($this->langDir);
    $this->assertCount(2, MultiLang::get_instance()->langs);
  }

  public function testLangSwitchOutputsCorrectLabels() {
    MultiLang::get_instance()->set_lang('nl-BE');
    $this->assertEquals(_t('tmnt'), 'Heroes in a half shell, Turtle power!');

    MultiLang::get_instance()->set_lang('fr-BE');
    $this->assertEquals(_t('tmnt'), "Le chanson en FR, n'existe pas! Turle power!");

    MultiLang::get_instance()->set_lang('nl-BE');
    $this->assertEquals(_t('tmnt'), 'Heroes in a half shell, Turtle power!');
  }

  public function testResetDefaultLanguage() {
    MultiLang::get_instance()->set_lang('fr-BE');
    $this->assertEquals(_t('tmnt'), "Le chanson en FR, n'existe pas! Turle power!");

    MultiLang::get_instance()->set_default_lang();
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
    $this->assertEquals('low', (string) _t('chain')->t('hangs'));
  }

  public function testGlobalD() {
    $this->assertEquals('all your base belongs to jeroen bourgois', (string) _d('dynamic', '/US/', 'jeroen bourgois'));
  }

  public function testGlobalDChaining() {
    $this->assertEquals('all your base belongs to jeroen bourgois', (string) _t('dynamic_chain')->t('hangs')->d('low', '/US/', 'jeroen bourgois'));
  } 

  public function testGlobalDLanguageParam() {
    $this->assertEquals('all your base belongs to France', (string) _d('dynamic', '/FRANCE/', 'France', 'fr'));
  }

}
