<?php

namespace Tests\ResultSet;

use ResultSet\ResultSet;
use Tests\AbstractTestCase;


class LeftOuterJoinFirstTest extends AbstractTestCase {

  public function testJoinsWithArray()
  {
    $groceryItems = TestData::getItems();
    $groceryItemsRs = new ResultSet($groceryItems);

    $groceryTypes = TestData::getGroceryTypes();

    $result = $groceryItemsRs->leftOuterJoinFirst($groceryTypes, 'type', ['typeId' => 'id']);

    $this->assertInstanceOfResultSet($result);
    $this->assertEquals(count($result), 11);
    $this->assertEquals($result[0]->type->name, 'Fruit');
  }

  public function testJoinsWithEmptyArray()
  {
    $groceryItems = TestData::getItems();
    $groceryItemsRs = new ResultSet($groceryItems);

    $groceryTypes = [];

    $result = $groceryItemsRs->leftOuterJoinFirst($groceryTypes, 'type', ['typeId' => 'id']);

    $this->assertInstanceOfResultSet($result);
    $this->assertEquals(count($result), 11);
  }

}
