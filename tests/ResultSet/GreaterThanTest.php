<?php

namespace Tests\ResultSet;

use ResultSet\ResultSet;
use Tests\AbstractTestCase;


class GreaterThanTest extends AbstractTestCase {

  public function testReturnsItemsGreaterThan2()
  {
    $items = TestData::getItems();
    $itemsRs = new ResultSet($items);

    $result = $itemsRs->greaterThan(['typeId' => 2]);

    $this->assertInstanceOfResultSet($result);
    $this->assertEquals(count($result), 4);
    $this->assertEquals($result[2]->name, 'Ketchup');
  }

  public function testBeyondValues()
  {
    $items = TestData::getItems();
    $itemsRs = new ResultSet($items);

    $result = $itemsRs->greaterThan(['typeId' => 10]);

    $this->assertInstanceOfResultSet($result);
    $this->assertEquals(count($result), 0);
  }

}