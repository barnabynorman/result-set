<?php

namespace Tests\ResultSet;

use ResultSet\ResultSet;
use Tests\AbstractTestCase;


class RandTest extends AbstractTestCase {

  public function testReturnsResultSet()
  {
    $items = TestData::getItems();
    $itemsRs = new ResultSet($items);
    $result = $itemsRs->rand();

    $this->assertInstanceOfResultSet($result);
  }

  public function testDefaultReturnsSingleItem()
  {
    $items = TestData::getItems();
    $itemsRs = new ResultSet($items);
    $result = $itemsRs->rand();

    $this->assertEquals(count($result), 1);
  }

  public function testThreeItems()
  {
    $items = TestData::getItems();
    $itemsRs = new ResultSet($items);
    $result = $itemsRs->rand(3);

    $this->assertEquals(count($result), 3);
  }

  public function testMoreThanResultSetCountItems()
  {
    $items = TestData::getItems();
    $itemsRs = new ResultSet($items);

    $count = count($itemsRs);

    $result = $itemsRs->rand($count + 1);

    $this->assertEquals(count($result), $count);
  }

}