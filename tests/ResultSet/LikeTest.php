<?php

namespace Tests\ResultSet;

use ResultSet\ResultSet;
use Tests\AbstractTestCase;


class LikeTest extends AbstractTestCase {

  public function testLikeReturnsResultSetWithTwoResultsForAto()
  {
    $items = TestData::getItems();
    $itemsRs = new ResultSet($items);
    $result = $itemsRs->like(['name' => 'ato']);

    $this->assertInstanceOfResultSet($result);
    $this->assertEquals(count($result), 2);
    $this->assertEquals($result[0]->name, 'Potato');
    $this->assertEquals($result[1]->name, 'Tomato');
  }

  public function testLikeReturnsResultSetWithExpectedNoOfResultsForTwoConditionsWithNoDuplicates()
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

  public function testLikeReturnsEmptyResultSetWhenPassedEmptyTestValue()
  {
    $items = TestData::getItems();
    $itemsRs = new ResultSet($items);
    $result = $itemsRs->like(['name' => '']);

    $this->assertInstanceOfResultSet($result);
    $this->assertEquals(count($result), 0);
  }

}