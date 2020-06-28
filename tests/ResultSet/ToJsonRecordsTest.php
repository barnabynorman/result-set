<?php

namespace Tests\ResultSet;

use ResultSet\ResultSet;
use Tests\AbstractTestCase;


class ToJsonRecordsTest extends AbstractTestCase {

  public function testToJsonRecordsReturnsValidJsonString()
  {
    $groceryItems = TestData::getItems();
    $groceryItemsRs = new ResultSet($groceryItems);

    $resultJson = $groceryItemsRs->toJsonRecords();
    $this->assertNotInstanceOfResultSet($resultJson);

    $result = json_decode($resultJson, true);

    $this->assertTrue(is_array($result));
    $this->assertEquals(count($result), 11);
    $this->assertEquals($result['2']['name'], 'Apple');
  }

}