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

    $this->assertTrue(is_subclass_of($result, 'ArrayObject'));
    $this->assertEquals(count($result), 14);
  }

}