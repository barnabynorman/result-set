<?php

namespace Tests\ResultSet;

use ResultSet\ResultSet;
use Tests\AbstractTestCase;


class LikeChildTest extends AbstractTestCase {

  public function testLikeChildReturnsItemsWithChildrenMatchingArgument()
  {
    $groceryList = TestData::getGroceryList();
    $groceryListRs = new ResultSet($groceryList);
    $result = $groceryListRs->likeChild('items', ['name' => 'pp']);

    $this->assertInstanceOfResultSet($result);
    $this->assertEquals(count($result), 3);
    $this->assertEquals($result[1]->name, 'Veg');
  }

}