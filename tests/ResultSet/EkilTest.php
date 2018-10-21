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

    $this->assertTrue(is_subclass_of($result, 'ArrayObject'));
    $this->assertEquals(count($result), 2);
    $this->assertEquals($result[1]->name, 'Kipper');
  }

}