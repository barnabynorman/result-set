<?php

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

class GroceryType {

    public $id;
    public $name;

    public function __construct($id, $name) {
        $this->id = $id;
        $this->name = $name;
    }
}

class TestData {

  public static function getItems()
  {
    $items = [];
    $items[] = new GroceryItem(1, 'Orange', 1);
    $items[] = new GroceryItem(2, 'Apple', 1);
    $items[] = new GroceryItem(3, 'Pair', 1);
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
}
$groceryTypes = [];
$types = [1 => 'Fruit', 2 => 'Veg', 3 => 'Fish', 4 => 'Tinned Veg', 5 => 'Sauces', 6 => 'Drinks'];
foreach ($types as $id => $name) {
    $type = new GroceryType($id, $name);
    $groceryTypes[] = $type;
}

$groceryTypes = new ResultSet($groceryTypes);
