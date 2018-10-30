<?php

namespace Tests\ResultSet;

use ResultSet\ResultSet;
use Tests\AbstractTestCase;


class WhereChildTest extends AbstractTestCase {

  public function testWithEmptyArrayParameter()
  {
    $items = TestData::getGroceryList();
    $itemsRs = new ResultSet($items);

    $result = $itemsRs->whereChild('items', []);
    $this->assertInstanceOfResultSet($result);
    $this->assertEquals(count($result), 0);
  }

  public function testWithEmptyStringParameter()
  {
    $items = TestData::getGroceryList();
    $itemsRs = new ResultSet($items);

    $result = $itemsRs->whereChild('items', '');
    $this->assertInstanceOfResultSet($result);
    $this->assertEquals(count($result), 0);
  }

  public function testForThreeChildItems()
  {
    $gList = TestData::getGroceryList();
    $gListRs = new ResultSet($gList);
    $result = $gListRs->whereChild('items', ['name' => 'Celery']);

    $this->assertInstanceOfResultSet($result);
    $this->assertEquals(count($result), 1);
    $this->assertEquals(count($result[0]->items), 3);
    $this->assertEquals($result[0]->items[2]->name, 'Celery');
  }

}