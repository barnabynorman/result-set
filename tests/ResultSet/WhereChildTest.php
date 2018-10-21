<?php

namespace Tests\ResultSet;

use ResultSet\ResultSet;
use Tests\AbstractTestCase;


class WhereChildTest extends AbstractTestCase {

  public function testWhereChildReturnsResultSetWithThreeItemChildItems()
  {
    $gList = TestData::getGroceryList();
    $gListRs = new ResultSet($gList);
    $result = $gListRs->whereChild('items', ['name' => 'Celery']);

    $this->assertTrue(is_subclass_of($result, 'ArrayObject'));
    $this->assertEquals(count($result), 1);
    $this->assertEquals(count($result[0]->items), 3);
    $this->assertEquals($result[0]->items[2]->name, 'Celery');
  }

}