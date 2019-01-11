<?php

namespace Tests\ResultSet;

use ResultSet\ResultSet;
use Tests\AbstractTestCase;


class JoinFieldsTest extends AbstractTestCase {

  public function testExpectedDataReturned()
  {
    $people = TestData::getPeopleWithId();
    $peopleRs = new ResultSet($people);

    $profileData = TestData::getProfileData();

    $result = $peopleRs->joinFields($profileData, ['height' => 'height', 'eye_colour' => 'eye_colour', 'pb' => 'pb'], ['id' => 'person_id']);

    $this->assertInstanceOfResultSet($result);
    $this->assertEquals(count($result), 5);
  }

  public function testExpectedFields()
  {
    $people = TestData::getPeopleWithId();
    $peopleRs = new ResultSet($people);

    $profileData = TestData::getProfileData();

    $result = $peopleRs->joinFields($profileData, ['height' => 'height', 'eye_colour' => 'eye_colour', 'pb' => 'pb'], ['id' => 'person_id']);

    $item = $result[0];

    $this->assertTrue(isset($item->height));
    $this->assertTrue(isset($item->eye_colour));
    $this->assertTrue(isset($item->pb));
  }

}