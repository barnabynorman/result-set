<?php

namespace Tests\ResultSet;

use ResultSet\ResultSet;
use Tests\AbstractTestCase;


class SetKeysFromFieldTest extends AbstractTestCase {

  public function testKeyOrderReturned()
  {
    $items = [];
    $items[] = new GroceryItem([ "id" => "1", "name" => "Orange" ]);
    $items[] = new GroceryItem([ "id" => "2", "name" => "Apple" ]);
    $items[] = new GroceryItem([ "id" => "3", "name" => "Pear" ]);
    $items[] = new GroceryItem([ "id" => "4", "name" => "Potato" ]);
    $items[] = new GroceryItem([ "id" => "5", "name" => "Pepper" ]);
    $items[] = new GroceryItem([ "id" => "6", "name" => "Tomato" ]);
    $items[] = new GroceryItem([ "id" => "7", "name" => "Celery" ]);
    $items[] = new GroceryItem([ "id" => "8", "name" => "Kipper" ]);
    $items[] = new GroceryItem([ "id" => "9", "name" => "Baked beans" ]);
    $items[] = new GroceryItem([ "id" => "10", "name" => "Ketchup" ]);
    $items[] = new GroceryItem([ "id" => "11", "name" => "Beer" ]);

    $itemsRs = ResultSet::getInstance($items);

    $result = $itemsRs->setKeysFromField('name');

    $this->assertInstanceOfResultSet($result);

    $firstItem = reset($result);
    $key = key($result);
    $this->assertEquals($key, 'orange');

    $lastItem = end($result);
    $key = key($result);
    $this->assertEquals($key, 'beer');
  }

  public function testWithSpaceInValue()
  {
    $items = [];
    $items[] = new GroceryItem([ "id" => "9", "name" => "Baked beans" ]);
    $items[] = new GroceryItem([ "id" => "10", "name" => "Ketchup" ]);
    $items[] = new GroceryItem([ "id" => "11", "name" => "Beer" ]);

    $itemsRs = ResultSet::getInstance($items);

    $result = $itemsRs->setKeysFromField('name');

    $firstItem = reset($result);
    $key = key($result);
    $this->assertEquals($key, 'baked_beans');
  }

}