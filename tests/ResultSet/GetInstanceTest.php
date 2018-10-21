<?php

namespace Tests\ResultSet;

use ResultSet\ResultSet;
use Tests\AbstractTestCase;

class GetInstanceTest extends AbstractTestCase {

  public function testGetInstanceFromArray()
  {
    $data = ['one', 'two', 'three'];
    $rs = ResultSet::getInstance($data);
    $this->assertTrue(is_subclass_of($rs, 'ArrayObject'));
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
    $this->assertTrue(is_subclass_of($rz, 'ArrayObject'));
  }

  public function testGetInstanceFromNonResultSetInstance()
  {
    $items = TestData::getItems();
    $orange = $items[0];
    $orangeRs = ResultSet::getInstance($orange);
    $this->assertTrue(is_subclass_of($orangeRs, 'ArrayObject'));
  }

}