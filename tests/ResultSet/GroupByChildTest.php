<?php

namespace Tests\ResultSet;

use ResultSet\ResultSet;
use Tests\AbstractTestCase;


class GroupByChildTest extends AbstractTestCase {

  public function testGroupByChildFieldReturnsGroupedResultBasedOnChildField()
  {
    $groceryList = TestData::getItemsWithTypeFieldJoined();
    $groceryListRs = new ResultSet($groceryList);

    $result = $groceryListRs->groupByChildField('type', 'name');

    $this->assertInstanceOfResultSet($result);
    $this->assertEquals(count($result), 6);
    $this->assertEquals(count($result['Veg']), 3);
  }

}