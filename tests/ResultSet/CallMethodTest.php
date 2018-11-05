<?php

namespace Tests\ResultSet;

use ResultSet\ResultSet;
use Tests\AbstractTestCase;


class CallMethodTest extends AbstractTestCase {

  public function testNumbersMakeSmallerMethod()
  {
    $numbers = array_map(function($num){
      return new NumberObj($num);
    }, [13, 15, 16]);
    $numbersRs = new ResultSet($numbers);

    $numbersRs->callMethod('makeSmaller');

    $this->assertInstanceOfResultSet($numbersRs);
    $this->assertEquals($numbersRs[0]->number, 3);
    $this->assertEquals($numbersRs[1]->number, 5);
    $this->assertEquals($numbersRs[2]->number, 6);
  }

  public function testWhenMethodIsNotAvailable()
  {
    $numbers = array_map(function($num){
      return new NumberObj($num);
    }, [13, 15, 16]);
    $numbersRs = new ResultSet($numbers);

    $numbersRs->callMethod('makeSqueaky');

    $this->assertInstanceOfResultSet($numbersRs);
    $this->assertEquals($numbersRs[0]->number, 13);
    $this->assertEquals($numbersRs[1]->number, 15);
    $this->assertEquals($numbersRs[2]->number, 16);
  }

}