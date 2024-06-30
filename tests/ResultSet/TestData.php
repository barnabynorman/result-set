<?php

namespace Tests\ResultSet;

/**
 * Contains single instance of a grocery item
 */
class GroceryItem {

    public $id;
    public $name;
    public $typeId;
    public $colour;
    public $items;
    public $type;

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
    public $colour;
    public $items;

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

  public function makeSmaller()
  {
    $this->number -= 10;
  }
}

/**
 * Person class
 */
class Person {
    public $id;
    public $firstname;
    public $lastname;
    public $height;
    public $eye_colour;
    public $pb;

  public function __construct($data) {
    $this->id = $data['id'];
    $this->firstname = $data['firstname'];
    $this->lastname = $data['lastname'];
  }
}

/**
 * Defines profile data to extend person
 */
class Profile {
  public $person_id;
  public $height;
  public $eye_colour;
  public $pb;

  public function __construct($data) {
    $this->person_id = $data['person_id'];
    $this->height = $data['height'];
    $this->eye_colour = $data['eye_colour'];
    $this->pb = $data['pb'];
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
   * @return Array of GroceryItem object instances
   */
  public static function getItemsWithRedApple()
  {
    $items = TestData::getItems();
    $items[] = new GroceryItem([ 'id' => 12, 'name' => 'Apple',       'type_id' => 1, 'colour' => 'red']);

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
   * @return Array of GroceryType object instances
   */
  public static function getGroceryTypesWithRedColour()
  {
    $redTypes = [];
    $groceryTypes = TestData::getGroceryTypes();

    foreach ($groceryTypes as $type) {
      $type->colour = 'red';
      $redTypes[] = $type;
    }

    return $redTypes;
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

  /**
   * Returns profile data for joining with people
   */
  public static function getProfileData()
  {
    $profile = [];
    $profile[] = new Profile([ "person_id" => "3", "height" => "175", "eye_colour" => "blue", "pb" => "23:59" ]);
    $profile[] = new Profile([ "person_id" => "5", "height" => "170", "eye_colour" => "green", "pb" => "22:05" ]);
    $profile[] = new Profile([ "person_id" => "6", "height" => "170", "eye_colour" => "brown", "pb" => "21:04" ]);
    $profile[] = new Profile([ "person_id" => "9", "height" => "191", "eye_colour" => "green", "pb" => "33:28" ]);
    $profile[] = new Profile([ "person_id" => "12", "height" => "180", "eye_colour" => "blue", "pb" => "31:03" ]);

    return $profile;
  }

  public static function getPeopleWithId()
  {
    $people = [];
    $people[] = new Person([ "id" => "1", "firstname" => "Bob", "lastname" => "Smith" ]);
    $people[] = new Person([ "id" => "2", "firstname" => "Joanne", "lastname" => "Hague" ]);
    $people[] = new Person([ "id" => "3", "firstname" => "Sophia", "lastname" => "Ovchinin" ]);
    $people[] = new Person([ "id" => "4", "firstname" => "Amelia", "lastname" => "Smith" ]);
    $people[] = new Person([ "id" => "5", "firstname" => "Lily", "lastname" => "Jones" ]);
    $people[] = new Person([ "id" => "6", "firstname" => "Emily", "lastname" => "Walsh" ]);
    $people[] = new Person([ "id" => "7", "firstname" => "Ava", "lastname" => "Humphries" ]);
    $people[] = new Person([ "id" => "8", "firstname" => "Isla", "lastname" => "Francis" ]);
    $people[] = new Person([ "id" => "9", "firstname" => "Muhammed", "lastname" => "Boyce" ]);
    $people[] = new Person([ "id" => "10", "firstname" => "Oliver", "lastname" => "Jones" ]);
    $people[] = new Person([ "id" => "11", "firstname" => "Noah", "lastname" => "Clifton" ]);
    $people[] = new Person([ "id" => "12", "firstname" => "George", "lastname" => "Shephard" ]);
    $people[] = new Person([ "id" => "13", "firstname" => "Harry", "lastname" => "Middleton" ]);
    $people[] = new Person([ "id" => "14", "firstname" => "Charlie", "lastname" => "Smith" ]);
    $people[] = new Person([ "id" => "15", "firstname" => "Jack", "lastname" => "Brooksbank" ]);
    $people[] = new Person([ "id" => "16", "firstname" => "Freddie", "lastname" => "Cabot" ]);
    $people[] = new Person([ "id" => "17", "firstname" => "Alfie", "lastname" => "Conner" ]);

    return $people;
  }

}
