<?php

/**
 * Contains single instance of a grocery item
 */
class GroceryItem {

    public $id;
    public $name;
    public $typeId;

    public function __construct($id, $name, $typeId) {
        $this->id = $id;
        $this->name = $name;
        $this->typeId = $typeId;
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
    $items[] = new GroceryItem(1, 'Orange', 1);
    $items[] = new GroceryItem(2, 'Apple', 1);
    $items[] = new GroceryItem(3, 'Pear', 1);
    $items[] = new GroceryItem(4, 'Potato', 2);
    $items[] = new GroceryItem(5, 'Pepper', 2);
    $items[] = new GroceryItem(6, 'Tomato', 1);
    $items[] = new GroceryItem(7, 'Celery', 2);
    $items[] = new GroceryItem(8, 'Kipper', 3);
    $items[] = new GroceryItem(9, 'Baked beans', 4);
    $items[] = new GroceryItem(10, 'Ketchup', 5);
    $items[] = new GroceryItem(11, 'Beer', 6);

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

}
