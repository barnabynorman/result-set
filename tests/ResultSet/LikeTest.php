<?php

namespace Tests\ResultSet;

use ResultSet\ResultSet;
use Tests\AbstractTestCase;


class LikeTest extends AbstractTestCase {

  public function testMatchesCharactersInTomatoPotato()
  {
    $items = TestData::getItems();
    $itemsRs = new ResultSet($items);
    $result = $itemsRs->like(['name' => 'ato']);

    $this->assertInstanceOfResultSet($result);
    $this->assertEquals(count($result), 2);
    $this->assertEquals($result[0]->name, 'Potato');
    $this->assertEquals($result[1]->name, 'Tomato');
  }

  public function testTwoConditionsWithNoDuplicates()
  {
    $items = TestData::getItemsWithTypeField();
    $itemsRs = new ResultSet($items);
    $result = $itemsRs->like(['name' => 'ato', 'type' => 'Fruit']);

    $tomCount = 0;
    foreach ($result as $item) {
      if ($item->name == 'Tomato') {
        $tomCount++;
      }
    }

    $this->assertInstanceOfResultSet($result);
    $this->assertEquals(count($result), 5);
    $this->assertEquals($result[2]->type, 'Fruit');
    $this->assertEquals($tomCount, 1);
  }

  public function testWhenPassedEmptyTestValue()
  {
    $items = TestData::getItems();
    $itemsRs = new ResultSet($items);
    $result = $itemsRs->like(['name' => '']);

    $this->assertInstanceOfResultSet($result);
    $this->assertEquals(count($result), 0);
  }

  public function testFindingNonStringValues()
  {
    $items = TestData::getItems();
    $itemsRs = new ResultSet($items);
    $result = $itemsRs->like(['typeId' => 6]);

    $this->assertInstanceOfResultSet($result);
    $this->assertEquals(count($result), 1);
    $this->assertEquals($result[0]->name, 'Beer');
  }

}