<?php

namespace Tests\ResultSet;

use ResultSet\ResultSet;
use Tests\AbstractTestCase;


class UniqueTest extends AbstractTestCase {

  public function testUniqueReturnsResultSetContainingUniqueSet()
  {
    $numberObjects = TestData::getArrayOfNumberObjects();
    $numberObjectsRs = new ResultSet($numberObjects);

    $result = $numberObjectsRs->unique('number');

    $this->assertTrue(is_subclass_of($result, 'ArrayObject'));
    $this->assertEquals(count($result), 3);
    $this->assertEquals($result[0], 1);
    $this->assertEquals($result[1], 2);
    $this->assertEquals($result[2], 3);
  }

}