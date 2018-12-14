<?php

namespace Tests\ResultSet;

use ResultSet\ResultSet;
use Tests\AbstractTestCase;


class WhereNotTest extends AbstractTestCase {

  public function testExcludesResultsCorrectly()
  {
    $items = TestData::getPeople();
    $itemsRs = new ResultSet($items);

    $result = $itemsRs->whereNot(['lastname' => 'Smith']);

    $this->assertInstanceOfResultSet($result);
    $this->assertEquals(count($result), 14);
  }

  public function testWhenEmptyArrayPassedAsClause()
  {
    $items = TestData::getPeople();
    $itemsRs = new ResultSet($items);

    $itemCount = count($itemsRs);

    $result = $itemsRs->whereNot([]);

    $this->assertEquals(count($result), $itemCount);
  }

  public function testMultipleClauses()
  {
    $items = TestData::getPeople();
    $itemsRs = new ResultSet($items);

    $itemCount = count($itemsRs);

    $result = $itemsRs->whereNot([
      'firstname' => 'Sophia',
      'lastname' => 'Ovchinin',
    ]);

    $this->assertEquals(count($result), $itemCount -1);
  }

  public function testWithArrayItems()
  {
    $cssColours = TestData::getArrayDataColours();
    $cssColoursRs = ResultSet::getInstance($cssColours);

    $result = $cssColoursRs->whereNot(['name' => 'orchid']);

    $this->assertEquals(count($result), 3);
  }

}