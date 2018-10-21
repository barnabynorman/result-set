<?php

namespace Tests\ResultSet;

use ResultSet\ResultSet;
use Tests\AbstractTestCase;


class ToArrayTest extends AbstractTestCase {

  public function testToArrayReturnsAnArray()
  {
    $groceryItems = TestData::getItems();
    $groceryItemsRs = new ResultSet($groceryItems);

    $result = $groceryItemsRs->toArray();

    $this->assertFalse(is_subclass_of($result, 'ArrayObject'));
    $this->assertTrue(is_array($result));
  }

}