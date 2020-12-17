<?php

namespace Tests\ResultSet;

use ResultSet\ResultSet;
use Tests\AbstractTestCase;


class FilterTest extends AbstractTestCase {

  public function testReturnsAllValuesInResultSetWhenClosureReturnsTrue()
  {
    $numbers = TestData::getArrayOfNumberObjects();
    $numbersRs = new ResultSet($numbers);

    $results = $numbersRs->filter('n', function($n) {
      return TRUE;
    });

    $this->assertEquals(count($results), count($numbersRs));
  }

  public function testReturnsNoValuesInResultSetWhenClosureReturnsTrue()
  {
    $numbers = TestData::getArrayOfNumberObjects();
    $numbersRs = new ResultSet($numbers);

    $results = $numbersRs->filter('n', function($n) {
      return FALSE;
    });

    $this->assertEquals(count($results), 0);
  }

  public function testReturnsResultSet()
  {
    $numbers = TestData::getArrayOfNumberObjects();
    $numbersRs = new ResultSet($numbers);

    $results = $numbersRs->filter('n', function($n) {
      return TRUE;
    });

    $this->assertInstanceOfResultSet($results);
  }

}
