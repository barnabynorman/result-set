<?php

namespace Tests\ResultSet;

use ResultSet\ResultSet;
use Tests\AbstractTestCase;

class GetInstanceTest extends AbstractTestCase {

  public function testGetInstanceFromArray()
  {
    $data = ['one', 'two', 'three'];
    $rs = ResultSet::getInstance($data);
    $this->assertInstanceOfResultSet($rs);
  }

  /**
   * @depends testGetInstanceFromArray
   */
  public function testGetInstanceFromExistingResultSet()
  {
    $data = ['one', 'two', 'three'];
    $rs = ResultSet::getInstance($data);

    $comment = 'getInstance: From existing ResultSet';
    $rz = ResultSet::getInstance($rs);
    $this->assertInstanceOfResultSet($rz);
  }

  public function testGetInstanceFromNonResultSetInstance()
  {
    $items = TestData::getItems();
    $orange = $items[0];
    $orangeRs = ResultSet::getInstance($orange);
    $this->assertInstanceOfResultSet($orangeRs);
  }

}