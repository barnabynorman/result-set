<?php

namespace Tests\ResultSet;

use ResultSet\ResultSet;
use Tests\AbstractTestCase;


class FieldsAsTest extends AbstractTestCase {

  public function testNoFields()
  {
    $groceryList = TestData::getItemsWithTypeLabel();
    $groceryListRs = new ResultSet($groceryList);

    $result = $groceryListRs->fieldsAs([]);

    $this->assertInstanceOfResultSet($result);
    $this->assertEquals(count($result), 11);
    $this->assertEquals(count($result[0]), 0);
  }

  public function testTwoFields()
  {
    $groceryList = TestData::getItemsWithTypeLabel();
    $groceryListRs = new ResultSet($groceryList);

    $result = $groceryListRs->fieldsAs([['name' => 'genus'], ['type' => 'species']]);

    $this->assertInstanceOfResultSet($result);
    $this->assertEquals(count($result), 11);
    $this->assertEquals($result[0]['genus'], 'Orange');
    $this->assertEquals($result[0]['species'], 'Fruit');
  }

}