<?php

namespace Tests\ResultSet;

use ResultSet\ResultSet;
use Tests\AbstractTestCase;


class LimitTest extends AbstractTestCase {

  public function testLimitReturnsALimitedNumberOfResults()
  {
    $people = TestData::getPeople();
    $peopleRs = new ResultSet($people);

    $result = $peopleRs->limit(3);

    $this->assertInstanceOfResultSet($result);
    $this->assertEquals(count($peopleRs), 17);
    $this->assertEquals(count($result), 3);
  }

}