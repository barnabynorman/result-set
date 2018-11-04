<?php

namespace Tests\ResultSet;

use ResultSet\ResultSet;
use Tests\AbstractTestCase;


class InnerJoinTest extends AbstractTestCase {

  public function testMatchingItemsAndFilterNotMatching()
  {
    $groceryTypes = TestData::getGroceryTypes();
    $groceryTypes[] = new GroceryType(['type_id' => 7, 'name' => 'Pet food']);

    $groceryItems = TestData::getItems();
    $groceryItems[] = new GroceryItem(11, 'Cheese', 8);
    $groceryItemsRs = new ResultSet($groceryItems);

    $result = $groceryItemsRs->innerJoin($groceryTypes, 'type', ['typeId' => 'id']);

    $this->assertInstanceOfResultSet($result);
    $this->assertEquals(count($result), 11);
    $this->assertNotEquals(count($result->groceryItems), count($result));
  }

}