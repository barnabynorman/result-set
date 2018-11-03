<?php

namespace Tests\ResultSet;

use ResultSet\ResultSet;
use Tests\AbstractTestCase;


class UniqueTest extends AbstractTestCase {

  public function testWithNumbers()
  {
    $numberObjects = TestData::getArrayOfNumberObjects();
    $numberObjectsRs = new ResultSet($numberObjects);

    $result = $numberObjectsRs->unique('number');

    $this->assertInstanceOfResultSet($result);
    $this->assertEquals(count($result), 3);
    $this->assertEquals($result[0]->number, 1);
    $this->assertEquals($result[1]->number, 2);
    $this->assertEquals($result[2]->number, 3);
  }

  public function testNonScalarField()
  {
    $numberObjects = TestData::getItemsWithTypeFieldJoined();
    $numberObjectsRs = new ResultSet($numberObjects);

    $result = $numberObjectsRs->unique('type');

    $this->assertInstanceOfResultSet($result);
    $this->assertEquals(count($result), 0);
  }

}