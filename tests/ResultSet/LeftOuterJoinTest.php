<?php

namespace Tests\ResultSet;

use ResultSet\ResultSet;
use Tests\AbstractTestCase;


class LeftOuterJoinTest extends AbstractTestCase {

  public function testJoinsArrayToResultSetReturningAllFromResultSetAndJoinsInNewField()
  {
    $groceryTypes = TestData::getGroceryTypes();
    $groceryTypes[] = new GroceryType(['type_id' => 7, 'name' => 'Pet food']);
    $groceryTypesRs = new ResultSet($groceryTypes);

    $groceryItems = TestData::getItems();
    $groceryItems[] = new GroceryItem(['id' => 11, 'name' => 'Cheese', 'type_id' => 8]);

    $result = $groceryTypesRs->leftOuterJoin($groceryItems, 'items', ['id' => 'typeId']);

    $this->assertInstanceOfResultSet($result);
    $this->assertEquals(count($result), 7);
    $this->assertEquals(count($result[0]->items), 4);
    $this->assertEquals(count($result[6]->items), 0);
  }

  public function testJoinWithExtraClause()
  {
    $groceryTypes = TestData::getGroceryTypesWithRedColour();
    $groceryTypesRs = new ResultSet($groceryTypes);

    $groceryItems = TestData::getItemsWithRedApple();

    $result = $groceryTypesRs->leftOuterJoin($groceryItems, 'items', [
      'id' => 'typeId',
      'colour' => 'colour'
    ]);

    $this->assertInstanceOfResultSet($result);
    $this->assertEquals(count($result), 6);
    $this->assertEquals(count($result[0]->items), 2);
    $this->assertEquals(count($result[1]->items), 1);
    $this->assertEquals(count($result[2]->items), 0);
  }

}