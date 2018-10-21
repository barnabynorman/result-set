<?php

namespace Tests\ResultSet;
/**
 * Contains single instance of a grocery item
 */
class GroceryItem {

    public $id;
    public $name;
    public $typeId;

    public function __construct($data) {
      $this->id = $data['id'];
      $this->name = $data['name'];
      $this->typeId = $data['type_id'];
      $this->colour = $data['colour'];
  }
}

/**
 * Defines the type of grocery item
 */
class GroceryType {

    public $id;
    public $name;

    public function __construct($data) {
      $this->id = $data['type_id'];
      $this->name = $data['name'];
  }
}

/**
 * Defines a simple object that holds a number value
 */
class NumberObj {
  public $number;

  public function __construct($number) {
    $this->number = $number;
  }

  public function makeBigger()
  {
    $this->number += 10;
  }
}

/**
 * Collection of methods used in testing
 * Assembles data ready for testing based
 * on groceries etc
 */
class TestData {

  /**
   * @return Array of GroceryItem object instances
   */
  public static function getItems()
  {
    $items = [];
    $items[] = new GroceryItem([ 'id' => 1,  'name' => 'Orange',      'type_id' => 1, 'colour' => 'orange']);
    $items[] = new GroceryItem([ 'id' => 2,  'name' => 'Apple',       'type_id' => 1, 'colour' => 'green']);
    $items[] = new GroceryItem([ 'id' => 3,  'name' => 'Pear',        'type_id' => 1, 'colour' => 'green']);
    $items[] = new GroceryItem([ 'id' => 4,  'name' => 'Potato',      'type_id' => 2, 'colour' => 'brown']);
    $items[] = new GroceryItem([ 'id' => 5,  'name' => 'Pepper',      'type_id' => 2, 'colour' => 'red']);
    $items[] = new GroceryItem([ 'id' => 6,  'name' => 'Tomato',      'type_id' => 1, 'colour' => 'red']);
    $items[] = new GroceryItem([ 'id' => 7,  'name' => 'Celery',      'type_id' => 2, 'colour' => 'green']);
    $items[] = new GroceryItem([ 'id' => 8,  'name' => 'Kipper',      'type_id' => 3, 'colour' => 'yellow']);
    $items[] = new GroceryItem([ 'id' => 9,  'name' => 'Baked beans', 'type_id' => 4, 'colour' => 'orange']);
    $items[] = new GroceryItem([ 'id' => 10, 'name' => 'Ketchup',     'type_id' => 5, 'colour' => 'red']);
    $items[] = new GroceryItem([ 'id' => 11, 'name' => 'Beer',        'type_id' => 6, 'colour' => 'brown']);

    return $items;
  }

  /**
   * @return Array of GroceryType object instances
   */
  public static function getGroceryTypes()
  {
    $groceryTypes = [];
    $groceryTypes[] = new GroceryType(['type_id' => 1, 'name' => 'Fruit']);
    $groceryTypes[] = new GroceryType(['type_id' => 2, 'name' => 'Veg']);
    $groceryTypes[] = new GroceryType(['type_id' => 3, 'name' => 'Fish']);
    $groceryTypes[] = new GroceryType(['type_id' => 4, 'name' => 'Tinned Veg']);
    $groceryTypes[] = new GroceryType(['type_id' => 5, 'name' => 'Sauces']);
    $groceryTypes[] = new GroceryType(['type_id' => 6, 'name' => 'Drinks']);

    return $groceryTypes;
  }

  /**
   * @return Array of GroceryType object instances joined with GroceryItems
   */
  public static function getGroceryList()
  {

    $groceryTypes = TestData::getGroceryTypes();
    $items = TestData::getItems();

    foreach ($groceryTypes as $type) {
      $list = [];

      foreach ($items as $item) {
        if ($item->typeId == $type->id) {
          $list[] = $item;
        }
      }

      $type->items = $list;
    }

    return $groceryTypes;
  }

  public static function getItemsWithTypeField()
  {
    $items = TestData::getItems();
    $groceryTypes = TestData::getGroceryTypes();

    foreach ($items as $i) {
      foreach ($groceryTypes as $type) {
        if ($i->typeId == $type->id) {
          $i->type = $type->name;
        }
      }
    }

    return $items;
  }

  public static function getItemsWithTypeFieldJoined()
  {
    $items = TestData::getItems();
    $groceryTypes = TestData::getGroceryTypes();

    foreach ($items as $i) {
      foreach ($groceryTypes as $type) {
        if ($i->typeId == $type->id) {
          $i->type = $type;
        }
      }
    }

    return $items;
  }

  public static function getItemsWithTypeLabel()
  {
    $items = TestData::getItems();
    $groceryTypes = TestData::getGroceryTypes();

    foreach ($items as $i) {
      foreach ($groceryTypes as $type) {
        if ($i->typeId == $type->id) {
          $i->type = $type->name;
        }
      }
    }

    return $items;
  }

  public static function getPeople()
  {
    $people = [
      (object) ['firstname' => 'Bob', 'lastname' => 'Smith'],
      (object) ['firstname' => 'Joanne', 'lastname' => 'Hague'],
      (object) ['firstname' => 'Sophia', 'lastname' => 'Ovchinin'],
      (object) ['firstname' => 'Amelia', 'lastname' => 'Smith'],
      (object) ['firstname' => 'Lily', 'lastname' => 'Jones'],
      (object) ['firstname' => 'Emily', 'lastname' => 'Walsh'],
      (object) ['firstname' => 'Ava', 'lastname' => 'Humphries'],
      (object) ['firstname' => 'Isla', 'lastname' => 'Francis'],
      (object) ['firstname' => 'Muhammed', 'lastname' => 'Boyce'],
      (object) ['firstname' => 'Oliver', 'lastname' => 'Jones'],
      (object) ['firstname' => 'Noah', 'lastname' => 'Clifton'],
      (object) ['firstname' => 'George', 'lastname' => 'Shephard'],
      (object) ['firstname' => 'Harry', 'lastname' => 'Middleton'],
      (object) ['firstname' => 'Charlie', 'lastname' => 'Smith'],
      (object) ['firstname' => 'Jack', 'lastname' => 'Brooksbank'],
      (object) ['firstname' => 'Freddie', 'lastname' => 'Cabot'],
      (object) ['firstname' => 'Alfie', 'lastname' => 'Conner'],
    ];

    return $people;
  }

  public static function getArrayOfNumberObjects()
  {
    $numbers = [1,2,3,3];

    $data = [];

    foreach ($numbers as $num) {
      $data[] = new NumberObj($num);
    }

    return $data;
  }

  public static function getArrayDataColours()
  {
    $cssColours = [
      0 => [
        'hex' => '#EE82EE',
        'name' => 'violet',
        'rgb' => '238,130,238'
      ],
      1 => [
        'hex' => '#DA70D6',
        'name' => 'orchid',
        'rgb' => '218,112,214'
      ],
      2 => [
        'hex' => '#FF00FF',
        'name' => 'fuchsia',
        'rgb' => '255,0,255'
      ],
      3 => [
        'hex' => '#FF00FF',
        'name' => 'magenta',
        'rgb' => '255,0,255'
      ],
    ];

    return $cssColours;
  }

}
