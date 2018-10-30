<?php

namespace Tests\ResultSet;

use ResultSet\ResultSet;
use Tests\AbstractTestCase;


class WhereSubFieldTest extends AbstractTestCase {

  public function testWithEmptyArrayParameter()
  {
    $items = TestData::getGroceryList();
    $itemsRs = new ResultSet($items);

    $result = $itemsRs->whereSubField('items', []);
    $this->assertInstanceOfResultSet($result);
    $this->assertEquals(count($result), 0);
  }

  public function testWithEmptyStringParameter()
  {
    $items = TestData::getGroceryList();
    $itemsRs = new ResultSet($items);

    $result = $itemsRs->whereSubField('items', '');
    $this->assertInstanceOfResultSet($result);
    $this->assertEquals(count($result), 0);
  }

  public function testForThreeChildItems()
  {
    $items = TestData::getItemsWithTypeFieldJoined();
    $itemsRs = new ResultSet($items);
    $result = $itemsRs->whereSubField('type', ['name' => 'Drinks']);

    $this->assertInstanceOfResultSet($result);
    $this->assertEquals(count($result), 1);
    $this->assertEquals($result[0]->name, 'Beer');
  }

}