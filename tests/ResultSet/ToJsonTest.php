<?php

namespace Tests\ResultSet;

use ResultSet\ResultSet;
use Tests\AbstractTestCase;


class ToJsonTest extends AbstractTestCase {

  public function testToJsonReturnsValidJsonString()
  {
    $groceryItems = TestData::getItems();
    $groceryItemsRs = new ResultSet($groceryItems);

    $resultJson = $groceryItemsRs->toJson();
    $result = json_decode($resultJson, true);

    $this->assertTrue(is_array($result));
    $this->assertEquals(count($result), 11);
    $this->assertEquals($result[2]['name'], 'Pear');
  }

}