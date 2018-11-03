<?php

namespace Tests\ResultSet;

use ResultSet\ResultSet;
use Tests\AbstractTestCase;


class FieldsTest extends AbstractTestCase {

  public function testTwoFields()
  {
    $groceryList = TestData::getItemsWithTypeLabel();
    $groceryListRs = new ResultSet($groceryList);

    $result = $groceryListRs->fields(['name', 'type']);

    $this->assertInstanceOfResultSet($result);
    $this->assertEquals(count($result), 11);
    $this->assertEquals($result[0]['name'], 'Orange');
    $this->assertEquals($result[0]['type'], 'Fruit');
  }

  public function testNoFields()
  {
    $groceryList = TestData::getItemsWithTypeLabel();
    $groceryListRs = new ResultSet($groceryList);

    $result = $groceryListRs->fields([]);

    $this->assertInstanceOfResultSet($result);
    $this->assertEquals(count($result), 11);
    $this->assertEquals(count($result[0]), 0);
  }

}