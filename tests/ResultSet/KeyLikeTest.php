<?php

namespace Tests\ResultSet;

use ResultSet\ResultSet;
use Tests\AbstractTestCase;


class KeyLikeTest extends AbstractTestCase {

  public function testKeyLikeMatchesKeyInArgument()
  {
    $groceryList = TestData::getGroceryList();
    $groceryListRs = new ResultSet($groceryList);

    $gList = [];
    foreach ($groceryListRs as $items) {
      $type = $items->name;
      $gList[$type] = $items;
    }
    $gListRs = new ResultSet($gList);

    $result = $gListRs->keyLike('Drinks');

    $this->assertInstanceOfResultSet($result);
    $this->assertEquals(count($result), 1);

    $result2 = $gListRs->keyLike('Bob');
    $this->assertInstanceOfResultSet($result2);
    $this->assertEquals(count($result2), 0);
  }

}