<?php

include_once('helpers.php');

class DBTest extends PHPUnit_Framework_TestCase {

  public static function setUpBeforeClass() {
    // include the apploader for framework setup
    include_once('limonade.php');
    include_once('proximitybbdo/apploader.php');
    include_once('proximitybbdo/db.php');
  }

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
