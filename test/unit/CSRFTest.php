<?php

include_once('helpers.php');

class CSFRFTest extends PHPUnit_Framework_TestCase {
  
  public static function setUpBeforeClass() {
    include_once('proximitybbdo/csrf.php');
  }

  public function testTokenGeneration() {
    $this->assertNotEmpty(CSRF::get_token());
  }

  public function testTokenAndSessions() {
    CSRF::setup();

    $this->assertEquals($_SESSION['_csrf'], CSRF::get_token());
  }

  public function testVerificationGET() {
    $_SERVER['REQUEST_METHOD'] = 'GET';

    $this->assertEquals(true, CSRF::verify_request());
  }

  public function testVerificationPOST() {
    $_SERVER['REQUEST_METHOD'] = 'POST';

    $this->assertEquals(false, CSRF::verify_request());
  }
}
