<?php

namespace Tests\ResultSet;

use ResultSet\ResultSet;
use Tests\AbstractTestCase;


class GroupByTest extends AbstractTestCase {

  public function testGroupByReturnsResultSetContainingSubSetsOfGroupedData()
  {
    $people = TestData::getPeople();
    $peopleRs = new ResultSet($people);

    $result = $peopleRs->groupBy('lastname');

    $this->assertTrue(is_subclass_of($result, 'ArrayObject'));
    $this->assertEquals(count($result['Smith']), 3);
    $this->assertEquals(count($result['Jones']), 2);
    $this->assertEquals(count($result['Clifton']), 1);
  }

  public function testGroupByChildFieldReturnsGroupedResultBasedOnChildField()
  {
    $groceryList = TestData::getItemsWithTypeFieldJoined();
    $groceryListRs = new ResultSet($groceryList);

    $result = $groceryListRs->groupByChildField('type', 'name');

    $this->assertTrue(is_subclass_of($result, 'ArrayObject'));
    $this->assertEquals(count($result), 6);
    $this->assertEquals(count($result['Veg']), 3);
  }

}