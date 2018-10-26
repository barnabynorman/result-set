<?php

namespace Tests\ResultSet;

use ResultSet\ResultSet;
use Tests\AbstractTestCase;


class WhereOrTest extends AbstractTestCase {

  public function testWithEmptyResultSet()
  {
    $empty = new ResultSet([]);

    $result = $empty->whereOr(['a' => 5]);

    $this->assertEquals(count($result), 0);
  }

  public function testWithNoClauses()
  {
    $items = TestData::getItems();
    $itemsRs = new ResultSet($items);

    $result = $itemsRs->whereOr([]);

    $this->assertEquals(count($result), 0);
  }

  public function testWithSingleClause()
  {
    $items = TestData::getItems();
    $itemsRs = new ResultSet($items);

    $result = $itemsRs->whereOr(['colour' => 'red']);

    $this->assertEquals(count($result), 3);
  }

  public function testWithTwoClauses()
  {
    $items = TestData::getItems();
    $itemsRs = new ResultSet($items);

    $result = $itemsRs->whereOr([
      'typeId' => 6,
      'colour' => 'green'
    ]);

    $this->assertEquals(count($result), 4);
    $this->assertEquals($result[3]->colour, 'brown');
  }

}