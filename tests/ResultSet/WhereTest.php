<?php

namespace Tests\ResultSet;

use ResultSet\ResultSet;
use Tests\AbstractTestCase;


class WhereTest extends AbstractTestCase {

  public function testWhereReturnsResultSetWithSingleItem()
  {
    $items = TestData::getItems();
    $itemsRs = new ResultSet($items);

    $result = $itemsRs->where(['id' => 3]);
    $this->assertTrue(is_subclass_of($result, 'ArrayObject'));
    $this->assertEquals(count($result), 1);
    $this->assertEquals($result[0]->name, 'Pear');

    $result = $itemsRs->where(['name' => 'Apple']);
    $this->assertTrue(is_subclass_of($result, 'ArrayObject'));
    $this->assertEquals(count($result), 1);
    $this->assertEquals($result[0]->id, 2);
  }

  public function testWhereReturnsResultSetWithThreeItems()
  {
    $items = TestData::getItems();
    $itemsRs = new ResultSet($items);

    $result = $itemsRs->where(['typeId' => 2]);
    $this->assertTrue(is_subclass_of($result, 'ArrayObject'));
    $this->assertEquals(count($result), 3);
  }

  public function testWhereReturnsEmptyResultSet()
  {
    $items = TestData::getItems();
    $itemsRs = new ResultSet($items);

    $result = $itemsRs->where(['typeId' => 7]);
    $this->assertTrue(is_subclass_of($result, 'ArrayObject'));
    $this->assertEquals(count($result), 0);
  }

}