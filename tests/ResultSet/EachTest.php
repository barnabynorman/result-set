<?php

namespace Tests\ResultSet;

use ResultSet\ResultSet;
use Tests\AbstractTestCase;


class EachTest extends AbstractTestCase {

  public function testEachIteratesValuesInResultSet()
  {
    $numbers = TestData::getArrayOfNumberObjects();
    $numbersRs = new ResultSet($numbers);

    $results = [];

    $numbersRs->each('n', function($n) use (&$results) {
      $results[] = $n;
    });

    $this->assertEquals(count($results), count($numbersRs));
    $this->assertEquals($results[0], $numbersRs[0]);
    $this->assertEquals($results[1], $numbersRs[1]);
    $this->assertEquals($results[2], $numbersRs[2]);
    $this->assertEquals($results[3], $numbersRs[3]);
  }

  public function testReturnsResultSet()
  {
    $numbers = TestData::getArrayOfNumberObjects();
    $numbersRs = new ResultSet($numbers);

    $results = [];

    $result = $numbersRs->each('n', function($n) use (&$results) {
      $results[] = $n;
    });

    $this->assertInstanceOfResultSet($result);
  }

}