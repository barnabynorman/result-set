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

    $this->assertInstanceOfResultSet($result);
    $this->assertEquals(count($result['Smith']), 3);
    $this->assertEquals(count($result['Jones']), 2);
    $this->assertEquals(count($result['Clifton']), 1);
  }

}