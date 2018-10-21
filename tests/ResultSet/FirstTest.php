<?php

namespace Tests\ResultSet;

use ResultSet\ResultSet;
use Tests\AbstractTestCase;


class FirstTest extends AbstractTestCase {

  public function testFirstReturnsFirstItem()
  {
    $data = ['one', 'two', 'three'];
    $rs = new ResultSet($data);

    $this->assertEquals($rs->first(), 'one');
  }

}