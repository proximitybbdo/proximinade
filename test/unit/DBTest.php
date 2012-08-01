<?php

// require_once('proximitybbdo/bootstrap.php');
// Set include path to include various dirs
global $config_directory, $root_directory, $app_directory, $lib_directory, $proximity_lib_directory, $spec_directory;

$root_directory = dirname(__FILE__) . '/../../';
$app_directory = $root_directory . 'app/';
$lib_directory = $app_directory . 'lib/';

set_include_path(get_include_path() . PATH_SEPARATOR . $lib_directory);

// include the apploader for framework setup
include_once('limonade.php');
include_once('proximitybbdo/apploader.php');
include_once('proximitybbdo/db.php');

class DBTest extends PHPUnit_Framework_TestCase {

  protected function setUp() {
    Database::get_instance()->init(array(
      'adapter'  => 'pdo_sqlite',
      'dbname'   => dirname(__FILE__) . '/fixtures/db.sqlite'
    ));

    $this->db = Database::get_instance()->get_db();
  }

  public function testGetInstanceShouldReturnDatabaseInstance() {
    $this->assertEquals('Database', get_class(Database::get_instance()));
  }

  public function testGetDbReturnsDbObject() {
    $this->assertNotNull(Database::get_instance()->get_db());
  }

  public function testDbRetrievesOneRecord() {
    $sql = $this->db->select()->from('users');
    $res = $this->db->fetchAll($sql);

    $this->assertCount(1, $res);
  }

  public function testDbRetrievesAUserRecord() {
    $sql = $this->db->select()->from('users');
    $res = $this->db->fetchAll($sql);

    $this->assertEquals("jeroen.bourgois@proximity.bbdo.be", $res[0]['email']);
  }

}
