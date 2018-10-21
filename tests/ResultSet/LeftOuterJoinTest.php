<?php

namespace Tests\ResultSet;

use ResultSet\ResultSet;
use Tests\AbstractTestCase;


class LeftOuterJoinTest extends AbstractTestCase {

  public function testLeftOuterJoinJoinsArrayToResultSetReturningAllFromResultSetAndJoinsInNewField()
  {
    $groceryTypes = TestData::getGroceryTypes();
    $groceryTypes[] = new GroceryType(['type_id' => 7, 'name' => 'Pet food']);
    $groceryTypesRs = new ResultSet($groceryTypes);

    $groceryItems = TestData::getItems();
    $groceryItems[] = new GroceryItem(['id' => 11, 'name' => 'Cheese', 'type_id' => 8]);

    $result = $groceryTypesRs->leftOuterJoin($groceryItems, 'items', 'id', 'typeId');

    $this->assertInstanceOfResultSet($result);
    $this->assertEquals(count($result), 7);
    $this->assertEquals(count($result[0]->items), 4);
    $this->assertEquals(count($result[6]->items), 0);
  }

}