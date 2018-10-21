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

  /**
   * @depends testEachIteratesValuesInResultSet
   */
  public function testCallMethodCallsMethodInsideInstance()
  {
    $numbers = TestData::getArrayOfNumberObjects();
    $numbersRs = new ResultSet($numbers);

    $numbersRs->callMethod('makeBigger');

    $results = [];

    $numbersRs->each('n', function($n) use (&$results) {
      $results[] = $n;
    });

    $this->assertTrue(is_subclass_of($numbersRs, 'ArrayObject'));
    $this->assertEquals(count($results), count($numbersRs));
    $this->assertEquals($results[0]->number, 11);
    $this->assertEquals($results[1]->number, 12);
    $this->assertEquals($results[2]->number, 13);
    $this->assertEquals($results[3]->number, 13);
  }

  /**
   * @depends testEachIteratesValuesInResultSet
   */
  public function testCallMethodHandlesWhenMethodIsNotAvailable()
  {
    $numbers = TestData::getArrayOfNumberObjects();
    $numbersRs = new ResultSet($numbers);

    $numbersRs->callMethod('makeSmaller');

    $results = [];

    $numbersRs->each('n', function($n) use (&$results) {
      $results[] = $n;
    });

    $this->assertEquals(count($results), count($numbersRs));
    $this->assertEquals($results[0]->number, 1);
    $this->assertEquals($results[1]->number, 2);
    $this->assertEquals($results[2]->number, 3);
    $this->assertEquals($results[3]->number, 3);
  }

}