<?php

namespace Tests\ResultSet;

use ResultSet\ResultSet;
use Tests\AbstractTestCase;

class SetKeysFromFieldTest extends AbstractTestCase {

  public function testKeyOrderReturned()
  {
    $items = [];
    $items[] = new GroceryItem([ "type_id" => "", "colour" => "", "id" => "1", "name" => "Orange" ]);
    $items[] = new GroceryItem([ "type_id" => "", "colour" => "", "id" => "2", "name" => "Apple" ]);
    $items[] = new GroceryItem([ "type_id" => "", "colour" => "", "id" => "3", "name" => "Pear" ]);
    $items[] = new GroceryItem([ "type_id" => "", "colour" => "", "id" => "4", "name" => "Potato" ]);
    $items[] = new GroceryItem([ "type_id" => "", "colour" => "", "id" => "5", "name" => "Pepper" ]);
    $items[] = new GroceryItem([ "type_id" => "", "colour" => "", "id" => "6", "name" => "Tomato" ]);

    $itemsRs = ResultSet::getInstance($items);

    $result = $itemsRs->setKeysFromField('name');
    $this->assertInstanceOfResultSet($result);

    $resultAsArray = $result->toArray();
    $this->assertTrue(is_array($resultAsArray));

    $keys = ['orange', 'apple', 'pear', 'potato', 'pepper', 'tomato'];
    $this->assertEquals(array_keys($resultAsArray),$keys);
  }

  public function testWithSpaceInValue()
  {
    $items = [];
    $items[] = new GroceryItem([ "type_id" => "", "colour" => "", "id" => "9", "name" => "Baked beans" ]);
    $items[] = new GroceryItem([ "type_id" => "", "colour" => "", "id" => "10", "name" => "Ketchup" ]);
    $items[] = new GroceryItem([ "type_id" => "", "colour" => "", "id" => "11", "name" => "Beer" ]);

    $itemsRs = ResultSet::getInstance($items);

    $result = $itemsRs->setKeysFromField('name');
    $this->assertInstanceOfResultSet($result);

    $resultAsArray = $result->toArray();
    $this->assertTrue(is_array($resultAsArray));

    $keys = ['baked_beans', 'ketchup', 'beer'];
    $this->assertEquals(array_keys($resultAsArray),$keys);
  }

}
