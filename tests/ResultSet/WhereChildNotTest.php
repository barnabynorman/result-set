<?php

namespace Tests\ResultSet;

use ResultSet\ResultSet;
use Tests\AbstractTestCase;


class WhereChildNotTest extends AbstractTestCase {

  public function testWithEmptyArrayParameter()
  {
    $itemIds[] = [1,2,3,5,6,8];
    $itemIds[] = [2,5,8,10];
    $itemIds[] = [1,11];
    $itemIds[] = [2,4,5,6,7,9];
    $itemIds[] = [1,6,7,9,10,11];
    $itemIds[] = [2,4,5,8,9];
    $itemIds[] = [1,2,3,5,8];
    $itemIds[] = [7];
    $itemIds[] = [1,7,8];
    $itemIds[] = [3,5,8,10];
    $itemIds[] = [3,5,8,9,10,11];
    $itemIds[] = [1,7,8];
    $itemIds[] = [1];
    $itemIds[] = [3,5,7];
    $itemIds[] = [10];
    $itemIds[] = [1,3,6,7,9];
    $itemIds[] = [1,2,3,8,9];

    $items = TestData::getItems();
    $itemsRs = new ResultSet($items);

    $people = TestData::getPeople();
    $peeps = [];
    $counter = 0;
    foreach ($people as $person) {

      $personItems = [];

      foreach ($itemIds[$counter] as $id) {
        $personItems[] = $itemsRs->where(['id' => $id])->first();
      }

      $person->items = $personItems;
      $peeps[] = $person;

      $counter++;
    }

    $peopleRs = new ResultSet($peeps);

    $result = $peopleRs->whereChildNot('items', ['name' => 'Kipper']);

    $this->assertInstanceOfResultSet($result);
    $this->assertEquals(count($result), 8);
  }

  public function testWithEmptyStringParameter()
  {
    $itemIds[] = [1,2,3,5,6,8];
    $itemIds[] = [2,5,8,10];
    $itemIds[] = [1,11];
    $itemIds[] = [2,4,5,6,7,9];
    $itemIds[] = [1,6,7,9,10,11];
    $itemIds[] = [2,4,5,8,9];
    $itemIds[] = [1,2,3,5,8];
    $itemIds[] = [7];
    $itemIds[] = [1,7,8];
    $itemIds[] = [3,5,8,10];
    $itemIds[] = [3,5,8,9,10,11];
    $itemIds[] = [1,7,8];
    $itemIds[] = [1];
    $itemIds[] = [3,5,7];
    $itemIds[] = [10];
    $itemIds[] = [1,3,6,7,9];
    $itemIds[] = [1,2,3,8,9];

    $items = TestData::getItems();
    $itemsRs = new ResultSet($items);

    $people = TestData::getPeople();
    $peeps = [];
    $counter = 0;
    foreach ($people as $person) {

      $personItems = [];

      foreach ($itemIds[$counter] as $id) {
        $personItems[] = $itemsRs->where(['id' => $id])->first();
      }

      $person->items = $personItems;
      $peeps[] = $person;

      $counter++;
    }

    $peopleRs = new ResultSet($peeps);
    $peopleCount = count($peopleRs);

    $result = $peopleRs->whereChildNot('items', '');

    $this->assertInstanceOfResultSet($result);
    $this->assertEquals(count($result), $peopleCount);
  }

  public function testForThreeChildItems()
  {
    $itemIds[] = [1,2,3,5,6,8];
    $itemIds[] = [2,5,8,10];
    $itemIds[] = [1,11];
    $itemIds[] = [2,4,5,6,7,9];
    $itemIds[] = [1,6,7,9,10,11];
    $itemIds[] = [2,4,5,8,9];
    $itemIds[] = [1,2,3,5,8];
    $itemIds[] = [7];
    $itemIds[] = [1,7,8];
    $itemIds[] = [3,5,8,10];
    $itemIds[] = [3,5,8,9,10,11];
    $itemIds[] = [1,7,8];
    $itemIds[] = [1];
    $itemIds[] = [3,5,7];
    $itemIds[] = [10];
    $itemIds[] = [1,3,6,7,9];
    $itemIds[] = [1,2,3,8,9];

    $items = TestData::getItems();
    $itemsRs = new ResultSet($items);

    $people = TestData::getPeople();
    $peeps = [];
    $counter = 0;
    foreach ($people as $person) {

      $personItems = [];

      foreach ($itemIds[$counter] as $id) {
        $personItems[] = $itemsRs->where(['id' => $id])->first();
      }

      $person->items = $personItems;
      $peeps[] = $person;

      $counter++;
    }

    $peopleRs = new ResultSet($peeps);

    $result = $peopleRs->whereChildNot('items', [
      'name' => 'Orange',
      'name' => 'Pear',
    ]);

    $this->assertInstanceOfResultSet($result);
    $this->assertEquals(count($result), 10);
  }

}