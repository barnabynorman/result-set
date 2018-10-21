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
  }
}

/**
 * Defines the type of grocery item
 */
class GroceryType {

    public $id;
    public $name;

    public function __construct($id, $name) {
        $this->id = $id;
        $this->name = $name;
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
    $items[] = new GroceryItem([ 'id' => 1,  'name' => 'Orange',      'type_id' => 1]);
    $items[] = new GroceryItem([ 'id' => 2,  'name' => 'Apple',       'type_id' => 1]);
    $items[] = new GroceryItem([ 'id' => 3,  'name' => 'Pear',        'type_id' => 1]);
    $items[] = new GroceryItem([ 'id' => 4,  'name' => 'Potato',      'type_id' => 2]);
    $items[] = new GroceryItem([ 'id' => 5,  'name' => 'Pepper',      'type_id' => 2]);
    $items[] = new GroceryItem([ 'id' => 6,  'name' => 'Tomato',      'type_id' => 1]);
    $items[] = new GroceryItem([ 'id' => 7,  'name' => 'Celery',      'type_id' => 2]);
    $items[] = new GroceryItem([ 'id' => 8,  'name' => 'Kipper',      'type_id' => 3]);
    $items[] = new GroceryItem([ 'id' => 9,  'name' => 'Baked beans', 'type_id' => 4]);
    $items[] = new GroceryItem([ 'id' => 10, 'name' => 'Ketchup',     'type_id' => 5]);
    $items[] = new GroceryItem([ 'id' => 11, 'name' => 'Beer',        'type_id' => 6]);

    return $items;
  }

  /**
   * @return Array of GroceryType object instances
   */
  public static function getGroceryTypes()
  {
    $groceryTypes = [];
    $types = [1 => 'Fruit', 2 => 'Veg', 3 => 'Fish', 4 => 'Tinned Veg', 5 => 'Sauces', 6 => 'Drinks'];
    foreach ($types as $id => $name) {
        $type = new GroceryType($id, $name);
        $groceryTypes[] = $type;
    }

    $groceryTypes = $groceryTypes;

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

}
