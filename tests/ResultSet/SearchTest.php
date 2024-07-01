<?php

namespace Tests\ResultSet;

use ResultSet\ResultSet;
use Tests\AbstractTestCase;


class SearchTest extends AbstractTestCase {

  public function testShallowSearch()
  {
    $groceryList = TestData::getItemsWithTypeFieldJoined();
    $groceryListRs = new ResultSet($groceryList);

    $result = $groceryListRs->search('Beer');

    $this->assertInstanceOfResultSet($result);
    $this->assertEquals(count($result), 1);
    $this->assertEquals($result[0]->name, 'Beer');
  }

  public function testDeepSearch()
  {
    $groceryList = TestData::getItemsWithTypeFieldJoined();
    $groceryListRs = new ResultSet($groceryList);

    $result = $groceryListRs->search('Tinned');

    $this->assertInstanceOfResultSet($result);
    $this->assertEquals(count($result), 1);
    $this->assertEquals($result[0]->name, 'Baked beans');
  }

  public function testCaseInsensitiveSearch()
  {
    $groceryList = TestData::getItemsWithTypeFieldJoined();
    $groceryListRs = new ResultSet($groceryList);

    $result = $groceryListRs->search('beer');

    $this->assertInstanceOfResultSet($result);
    $this->assertEquals(count($result), 1);
    $this->assertEquals($result[0]->name, 'Beer');
  }

  public function testCaseSensitiveSearch()
  {
    $groceryList = TestData::getItemsWithTypeFieldJoined();
    $groceryListRs = new ResultSet($groceryList);

    $caseSentitive = true;
    $result = $groceryListRs->search('beer', $caseSentitive);

    $this->assertInstanceOfResultSet($result);
    $this->assertEquals(count($result), 0);
  }

}