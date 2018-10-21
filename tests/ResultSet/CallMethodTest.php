<?php

namespace Tests\ResultSet;

use ResultSet\ResultSet;
use Tests\AbstractTestCase;


class CallMethodTest extends AbstractTestCase {

  public function testCallMethodHandlesWhenNonObjectsPassed()
  {
    $numbers = [3, 5, 6];
    $numbersRs = new ResultSet($numbers);

    $numbersRs->callMethod('makeSmaller');

    $this->assertInstanceOfResultSet($numbersRs);
    $this->assertEquals($numbersRs[0], 3);
    $this->assertEquals($numbersRs[1], 5);
    $this->assertEquals($numbersRs[2], 6);
  }

}