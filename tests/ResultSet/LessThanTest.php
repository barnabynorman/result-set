<?php

namespace Tests\ResultSet;

use ResultSet\ResultSet;
use Tests\AbstractTestCase;


class LessThanTest extends AbstractTestCase {

  public function testLessThanReturnsAllItemsLessThanPassed()
  {
    $items = TestData::getItems();
    $itemsRs = new ResultSet($items);

    $result = $itemsRs->lessThan(['typeId' => 2]);

    $this->assertTrue(is_subclass_of($result, 'ArrayObject'));
    $this->assertEquals(count($result), 4);
    $this->assertEquals($result[2]->name, 'Pear');
  }

}