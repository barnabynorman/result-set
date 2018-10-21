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

    $this->assertTrue(is_subclass_of($result, 'ArrayObject'));
    $this->assertEquals(count($result), 4);
  }

}