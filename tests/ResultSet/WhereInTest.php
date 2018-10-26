<?php

namespace Tests\ResultSet;

use ResultSet\ResultSet;
use Tests\AbstractTestCase;


class WhereInTest extends AbstractTestCase {

  public function testWithEmptyArrayParameter()
  {
    $items = TestData::getItems();
    $itemsRs = new ResultSet($items);

    $result = $itemsRs->whereIn('name', []);
    $this->assertInstanceOfResultSet($result);
    $this->assertEquals(count($result), 0);
  }

  public function testWithEmptyStringParameter()
  {
    $items = TestData::getItems();
    $itemsRs = new ResultSet($items);

    $result = $itemsRs->whereIn('name', '');
    $this->assertInstanceOfResultSet($result);
    $this->assertEquals(count($result), 0);
  }

  public function testWithArrayParameter()
  {
    $items = TestData::getItems();
    $itemsRs = new ResultSet($items);

    $result = $itemsRs->whereIn('name', ['Pear', 'Potato', 'Pepper']);
    $this->assertInstanceOfResultSet($result);
    $this->assertEquals(count($result), 3);
    $this->assertEquals($result[0]->name, 'Pear');
    $this->assertEquals($result[1]->name, 'Potato');
    $this->assertEquals($result[2]->name, 'Pepper');
  }

  public function testWithStringParameter()
  {
    $items = TestData::getItems();
    $itemsRs = new ResultSet($items);

    $result = $itemsRs->whereIn('id', '1,3,5');
    $this->assertInstanceOfResultSet($result);
    $this->assertEquals(count($result), 3);
    $this->assertEquals($result[0]->name, 'Orange');
    $this->assertEquals($result[1]->name, 'Pear');
    $this->assertEquals($result[2]->name, 'Pepper');
  }

}