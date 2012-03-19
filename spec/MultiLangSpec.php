<?php

include(dirname(__FILE__) . "/spec_helper.php");

require('Multilang.php');

class DescribeMultiLang  extends \PHPSpec\Context {

  // fixtures, see fixtures/config/config.yml
  // output matched with fixtures, see fixtures/locales/nl-BE.yml
  public function before() {
    global $config_directory;
    
    ProximityApp::$settings['multilang']['dir'] = "../spec/fixtures/locales/";
    ProximityApp::init($config_directory);

    ob_start();
  }

  public function itShouldReturnAnInstanceAndNotNull() {
    $multilang = Multilang::getInstance();
    $this->spec($multilang)->shouldNot->be(null);
  }
  
  public function itShouldReturnDefaultLang() {
    $multilang = Multilang::getInstance();
    $this->spec($multilang->getLang())->should->be("nl-BE"); 
  }

  public function itShouldReturnAValueForTheTitleKey() {
    $this->spec(_t('titel'))->should->beEqual('titel');
  }

  public function itShouldReplaceSnickersIntoMarsForADynamicLabel() {
    $this->spec(_d('candy_shop', '/snickers/', 'mars'))->should->beEqual('Take me to the mars shop!');
  }

}
