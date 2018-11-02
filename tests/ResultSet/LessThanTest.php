<?php

namespace Tests\ResultSet;

use ResultSet\ResultSet;
use Tests\AbstractTestCase;


class LessThanTest extends AbstractTestCase {

  public function testAllItemsLessThan2()
  {
    $items = TestData::getItems();
    $itemsRs = new ResultSet($items);

    $result = $itemsRs->lessThan(['typeId' => 2]);

    $this->assertInstanceOfResultSet($result);
    $this->assertEquals(count($result), 4);
    $this->assertEquals($result[2]->name, 'Pear');
  }

  public function testBelowTheValues()
  {
    $items = TestData::getItems();
    $itemsRs = new ResultSet($items);

    $result = $itemsRs->lessThan(['typeId' => 1]);

    $this->assertInstanceOfResultSet($result);
    $this->assertEquals(count($result), 0);
  }

}