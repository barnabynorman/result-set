<?php

namespace Tests\ResultSet;

use ResultSet\ResultSet;
use Tests\AbstractTestCase;


class UniqueFieldsTest extends AbstractTestCase {

  public function testWithNumbers()
  {
    $numberObjects = TestData::getArrayOfNumberObjects();
    $numberObjectsRs = new ResultSet($numberObjects);

    $result = $numberObjectsRs->uniqueFields('number');

    $this->assertInstanceOfResultSet($result);
    $this->assertEquals(count($result), 3);
    $this->assertEquals($result[0]->number, 1);
    $this->assertEquals($result[1]->number, 2);
    $this->assertEquals($result[2]->number, 3);
  }

  public function testNonScalarField()
  {
    $numberObjects = TestData::getItemsWithTypeFieldJoined();
    $numberObjectsRs = new ResultSet($numberObjects);

    $result = $numberObjectsRs->uniqueFields('type');

    $this->assertInstanceOfResultSet($result);
    $this->assertEquals(count($result), 0);
  }

  public function testTwoFields()
  {
    $items = [];
    $items[] = [ "firstname" => "Bob", "lastname" => "Smith" ];
    $items[] = [ "firstname" => "Joanne", "lastname" => "Hague" ];
    $items[] = [ "firstname" => "Sophia", "lastname" => "Ovchinin" ];
    $items[] = [ "firstname" => "Amelia", "lastname" => "Smith" ];
    $items[] = [ "firstname" => "Lily", "lastname" => "Jones" ];
    $items[] = [ "firstname" => "Emily", "lastname" => "Walsh" ];
    $items[] = [ "firstname" => "Ava", "lastname" => "Humphries" ];
    $items[] = [ "firstname" => "Isla", "lastname" => "Francis" ];
    $items[] = [ "firstname" => "Muhammed", "lastname" => "Boyce" ];
    $items[] = [ "firstname" => "Oliver", "lastname" => "Jones" ];
    $items[] = [ "firstname" => "Noah", "lastname" => "Clifton" ];
    $items[] = [ "firstname" => "George", "lastname" => "Shephard" ];
    $items[] = [ "firstname" => "Harry", "lastname" => "Middleton" ];
    $items[] = [ "firstname" => "Charlie", "lastname" => "Smith" ];
    $items[] = [ "firstname" => "Jack", "lastname" => "Brooksbank" ];
    $items[] = [ "firstname" => "Freddie", "lastname" => "Cabot" ];
    $items[] = [ "firstname" => "Alfie", "lastname" => "Conner" ];
    $items[] = [ "firstname" => "Alfie", "lastname" => "Conner" ];

    $itemsRs = new ResultSet($items);

    $this->assertEquals(count($itemsRs), 18);

    $unique = $itemsRs->uniqueFields(['firstname', 'lastname']);

    $this->assertInstanceOfResultSet($unique);
    $this->assertEquals(count($unique), 15);
  }

}