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

  public function testWithSubFields()
  {
    $items = [
      '0' => [
        'id' => '1',
        'name' => 'Orange',
        'typeId' => '1',
        'colour' => 'orange',
        'type' => [
          'id' => '1',
          'name' => 'Fruit'
        ]
      ],
      '1' => [
        'id' => '2',
        'name' => 'Apple',
        'typeId' => '1',
        'colour' => 'green',
        'type' => [
          'id' => '1',
          'name' => 'Fruit'
        ]
      ],
      '2' => [
        'id' => '3',
        'name' => 'Pear',
        'typeId' => '1',
        'colour' => 'green',
        'type' => [
          'id' => '1',
          'name' => 'Fruit'
        ]
      ],
      '3' => [
        'id' => '4',
        'name' => 'Potato',
        'typeId' => '2',
        'colour' => 'brown',
        'type' => [
          'id' => '2',
          'name' => 'Veg'
        ]
      ],
      '4' => [
        'id' => '5',
        'name' => 'Pepper',
        'typeId' => '2',
        'colour' => 'red',
        'type' => [
          'id' => '2',
          'name' => 'Veg'
        ]
      ],
      '5' => [
        'id' => '6',
        'name' => 'Tomato',
        'typeId' => '1',
        'colour' => 'red',
        'type' => [
          'id' => '1',
          'name' => 'Fruit'
        ]
      ],
      '6' => [
        'id' => '7',
        'name' => 'Celery',
        'typeId' => '2',
        'colour' => 'green',
        'type' => [
          'id' => '2',
          'name' => 'Veg'
        ]
      ],
      '7' => [
        'id' => '8',
        'name' => 'Kipper',
        'typeId' => '3',
        'colour' => 'yellow',
        'type' => [
          'id' => '3',
          'name' => 'Fish'
        ]
      ],
      '8' => [
        'id' => '9',
        'name' => 'Baked beans',
        'typeId' => '4',
        'colour' => 'orange',
        'type' => [
          'id' => '4',
          'name' => 'Tinned Veg'
        ]
      ],
      '9' => [
        'id' => '10',
        'name' => 'Ketchup',
        'typeId' => '5',
        'colour' => 'red',
        'type' => [
          'id' => '5',
          'name' => 'Sauces'
        ]
      ],
      '10' => [
        'id' => '11',
        'name' => 'Beer',
        'typeId' => '6',
        'colour' => 'brown',
        'type' => [
          'id' => '6',
          'name' => 'Drinks'
        ]
      ]
    ];

    $itemsRs = ResultSet::getInstance($items);

    $result = $itemsRs->fields(['name', ['type' => ['type' => 'name']]]);

    $this->assertInstanceOfResultSet($result);
    $this->assertEquals(count($result), 11);
    $this->assertEquals(count($result[0]), 2);
    $this->assertEquals($result[0]['type'], 'Fruit');
  }

}