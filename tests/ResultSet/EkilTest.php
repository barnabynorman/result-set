<?php

namespace Tests\ResultSet;

use ResultSet\ResultSet;
use Tests\AbstractTestCase;


class EkilTest extends AbstractTestCase {

  public function testEkilReturnsExpectedNoResultsInPassedArgument()
  {
    $items = TestData::getItems();
    $itemsRs = new ResultSet($items);

    $para = 'Some days I like to go down to the shop and get myself a lovely kipper, that I cover in tomato sauce';
    $result = $itemsRs->ekil(['name' => $para]);

    $this->assertInstanceOfResultSet($result);
    $this->assertEquals(count($result), 2);
    $this->assertEquals($result[1]->name, 'Kipper');
  }

  public function testItWorksWithNumbers()
  {
    $nums = [1, 2, 3, 4, 5, 6, 7, 8, 9];
    $numbers = [];

    foreach ($nums as $number) {
      $numbers[] = ['number' => $number];
    }

    $numbersRs = new ResultSet($numbers);

    $para = '76553284767982674656';
    $result = $numbersRs->ekil(['number' => $para]);

    $this->assertInstanceOfResultSet($result);
    $this->assertEquals(count($result), 8);
  }

}