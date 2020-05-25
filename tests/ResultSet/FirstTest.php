<?php

namespace Tests\ResultSet;

use ResultSet\ResultSet;
use Tests\AbstractTestCase;


class FirstTest extends AbstractTestCase {

  public function testFirstReturnsFirstItem()
  {
    $data = ['one', 'two', 'three'];
    $rs = new ResultSet($data);

    $result = $rs->first();
    $this->assertEquals($result, 'one');
    $this->assertNotInstanceOfResultSet($result);
  }

  public function testFirstWithNoData()
  {
    $data = [];
    $rs = new ResultSet($data);

    $result = $rs->first();
    $this->assertEquals($result, FALSE);
  }

  public function testFirstWithNonZeroFirstEntryKey()
  {
    $data = ['one', 'two', 'three'];
    unset($data[0]);
    $rs = new ResultSet($data);

    $result = $rs->first();
    $this->assertEquals($result, 'two');
  }

}