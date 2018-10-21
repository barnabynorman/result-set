<?php

namespace Tests\ResultSet;

use ResultSet\ResultSet;
use Tests\AbstractTestCase;


class BetweenTest extends AbstractTestCase {

  public function testBetweenReturnsExpectedItemsInOrderInResultSet()
  {
    $people = TestData::getPeople();
    $peopleRs = new ResultSet($people);

    $result = $peopleRs->between(2, 6);

    $this->assertInstanceOfResultSet($result);
    $this->assertEquals(count($result), 4);
  }

}