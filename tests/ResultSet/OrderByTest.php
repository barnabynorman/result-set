<?php

namespace Tests\ResultSet;

use ResultSet\ResultSet;
use Tests\AbstractTestCase;


class OrderByTest extends AbstractTestCase {

  public function testOrderByReturnsResultSetWithSeventeenItems(){
    $people = TestData::getPeople();
    $peopleRs = new ResultSet($people);

    $result = $peopleRs->orderBy('firstname');

    $this->assertTrue(is_subclass_of($result, 'ArrayObject'));
    $this->assertEquals(count($result), 17);
  }

  public function testOrderByFirstname(){
    $people = TestData::getPeople();
    $peopleRs = new ResultSet($people);

    $result = $peopleRs->orderBy('firstname');

    $this->assertEquals($result[0]->firstname, 'Alfie');
    $this->assertEquals($result[16]->firstname, 'Sophia');
  }

  public function testOrderByLaststname(){
    $people = TestData::getPeople();
    $peopleRs = new ResultSet($people);

    $result = $peopleRs->orderBy('lastname');

    $this->assertEquals($result[0]->firstname, 'Muhammed');
    $this->assertEquals($result[16]->firstname, 'Emily');
  }

  public function testOrderByLaststnameFirstname(){
    $people = TestData::getPeople();
    $peopleRs = new ResultSet($people);

    $result = $peopleRs->orderBy('lastname', 'firstname');

    $this->assertEquals($result[0]->firstname, 'Muhammed');

    $this->assertEquals($result[13]->firstname, 'Amelia');
    $this->assertEquals($result[14]->firstname, 'Bob');
    $this->assertEquals($result[15]->firstname, 'Charlie');

    $this->assertEquals($result[16]->firstname, 'Emily');
  }

}