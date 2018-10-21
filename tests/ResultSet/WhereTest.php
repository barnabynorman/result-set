<?php

namespace Tests\ResultSet;

use ResultSet\ResultSet;
use Tests\AbstractTestCase;


class WhereTest extends AbstractTestCase {

  public function testWhenNonArrayPassedAsClause()
  {
    $items = TestData::getItems();
    $itemsRs = new ResultSet($items);

    $result = $itemsRs->where('passed string');

    $this->assertInstanceOfResultSet($result);
    $this->assertEquals(count($result), 0);
  }

  public function testWhenEmptyArrayPassedAsClause()
  {
    $items = TestData::getItems();
    $itemsRs = new ResultSet($items);

    $result = $itemsRs->where([]);

    $this->assertInstanceOfResultSet($result);
    $this->assertEquals(count($result), 0);
  }

  public function testWhereReturnsResultSetWithSingleItem()
  {
    $items = TestData::getItems();
    $itemsRs = new ResultSet($items);

    $result = $itemsRs->where(['id' => 3]);
    $this->assertInstanceOfResultSet($result);
    $this->assertEquals(count($result), 1);
    $this->assertEquals($result[0]->name, 'Pear');

    $result = $itemsRs->where(['name' => 'Apple']);
    $this->assertInstanceOfResultSet($result);
    $this->assertEquals(count($result), 1);
    $this->assertEquals($result[0]->id, 2);
  }

  public function testWhereReturnsResultSetWithThreeItems()
  {
    $items = TestData::getItems();
    $itemsRs = new ResultSet($items);

    $result = $itemsRs->where(['typeId' => 2]);
    $this->assertInstanceOfResultSet($result);
    $this->assertEquals(count($result), 3);
  }

  public function testWhereReturnsEmptyResultSet()
  {
    $items = TestData::getItems();
    $itemsRs = new ResultSet($items);

    $result = $itemsRs->where(['typeId' => 7]);
    $this->assertInstanceOfResultSet($result);
    $this->assertEquals(count($result), 0);
  }

  public function testMultipleClauses()
  {
    $items = TestData::getItems();
    $itemsRs = new ResultSet($items);

    $result = $itemsRs->where([
      'typeId' => 1,
      'colour' => 'green',
    ]);

    $this->assertInstanceOfResultSet($result);
    $this->assertEquals(count($result), 2);
  }

}