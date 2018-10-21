<?php

namespace Tests\ResultSet;

use ResultSet\ResultSet;
use Tests\AbstractTestCase;


class SearchTest extends AbstractTestCase {

  public function testSearchReturnsValuesFromAShallowSearch()
  {
    $groceryList = TestData::getItemsWithTypeFieldJoined();
    $groceryListRs = new ResultSet($groceryList);

    $result = $groceryListRs->search('Beer');

    $this->assertTrue(is_subclass_of($result, 'ArrayObject'));
    $this->assertEquals(count($result), 1);
    $this->assertEquals($result[0]->name, 'Beer');
  }

  public function testSearchReturnsValuesFromADeepSearch()
  {
    $groceryList = TestData::getItemsWithTypeFieldJoined();
    $groceryListRs = new ResultSet($groceryList);

    $result = $groceryListRs->search('Tinned');

    $this->assertTrue(is_subclass_of($result, 'ArrayObject'));
    $this->assertEquals(count($result), 1);
    $this->assertEquals($result[0]->name, 'Baked beans');
  }

  public function testSearchReturnsValuesFromACaseInsensitiveSearch()
  {
    $groceryList = TestData::getItemsWithTypeFieldJoined();
    $groceryListRs = new ResultSet($groceryList);

    $result = $groceryListRs->search('beer');

    $this->assertTrue(is_subclass_of($result, 'ArrayObject'));
    $this->assertEquals(count($result), 1);
    $this->assertEquals($result[0]->name, 'Beer');
  }

}