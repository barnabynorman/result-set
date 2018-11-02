<?php

namespace Tests\ResultSet;

use ResultSet\ResultSet;
use Tests\AbstractTestCase;


class FieldTest extends AbstractTestCase {

  public function testFieldReturnsOnlySingleFieldsFromResultSet()
  {
    $people = TestData::getPeople();
    $peopleRs = new ResultSet($people);

    $result = $peopleRs->field('lastname');

    $this->assertInstanceOfResultSet($result);
    $this->assertEquals(count($result), 17);
  }

}