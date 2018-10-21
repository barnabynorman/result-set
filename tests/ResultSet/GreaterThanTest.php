<?php

namespace Tests\ResultSet;

use ResultSet\ResultSet;
use Tests\AbstractTestCase;


class GreaterThanTest extends AbstractTestCase {

  public function testGreaterThanReturnsAllItemsGreaterThanPassed()
  {
    $items = TestData::getItems();
    $itemsRs = new ResultSet($items);

    $result = $itemsRs->greaterThan(['typeId' => 2]);

    $this->assertTrue(is_subclass_of($result, 'ArrayObject'));
    $this->assertEquals(count($result), 4);
    $this->assertEquals($result[2]->name, 'Ketchup');
  }

}