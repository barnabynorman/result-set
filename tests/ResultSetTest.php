<?php
use PHPUnit\Framework\TestCase;

require_once '../result-set.php';
require_once '_testData.php';

class ResultSetTest extends TestCase {

  public function testGetInstanceFromArray()
  {
    $data = ['one', 'two', 'three'];
    $rs = ResultSet::getInstance($data);
    $this->assertTrue(is_subclass_of($rs, 'ArrayObject'));
  }

  /**
   * @depends testGetInstanceFromArray
   */
  public function testGetInstanceFromExistingResultSet()
  {
    $data = ['one', 'two', 'three'];
    $rs = ResultSet::getInstance($data);

    $comment = 'getInstance: From existing ResultSet';
    $rz = ResultSet::getInstance($rs);
    $this->assertTrue(is_subclass_of($rz, 'ArrayObject'));
  }

  public function testGetInstanceFromNonResultSetInstance()
  {
    $items = TestData::getItems();
    $orange = $items[0];
    $orangeRs = ResultSet::getInstance($orange);
    $this->assertTrue(is_subclass_of($orangeRs, 'ArrayObject'));
  }

  public function testFirstReturnsFirstItem()
  {
    $data = ['one', 'two', 'three'];
    $rs = new ResultSet($data);

    $this->assertEquals($rs->first(), 'one');
  }

  public function testWhereReturnsResultSetWithSingleItem()
  {
    $items = TestData::getItems();
    $itemsRs = new ResultSet($items);

    $result = $itemsRs->where(['id' => 3]);
    $this->assertTrue(is_subclass_of($result, 'ArrayObject'));
    $this->assertEquals(count($result), 1);
    $this->assertEquals($result[0]->name, 'Pear');

    $result = $itemsRs->where(['name' => 'Apple']);
    $this->assertTrue(is_subclass_of($result, 'ArrayObject'));
    $this->assertEquals(count($result), 1);
    $this->assertEquals($result[0]->id, 2);
  }

  public function testWhereReturnsResultSetWithThreeItems()
  {
    $items = TestData::getItems();
    $itemsRs = new ResultSet($items);

    $result = $itemsRs->where(['typeId' => 2]);
    $this->assertTrue(is_subclass_of($result, 'ArrayObject'));
    $this->assertEquals(count($result), 3);
  }

  public function testWhereReturnsEmptyResultSet()
  {
    $items = TestData::getItems();
    $itemsRs = new ResultSet($items);

    $result = $itemsRs->where(['typeId' => 7]);
    $this->assertTrue(is_subclass_of($result, 'ArrayObject'));
    $this->assertEquals(count($result), 0);
  }

  public function testWhereInReturnsResultSetWithThreeItems()
  {
    $items = TestData::getItems();
    $itemsRs = new ResultSet($items);

    $result = $itemsRs->whereIn('id', '1,3,5');
    $this->assertTrue(is_subclass_of($result, 'ArrayObject'));
    $this->assertEquals(count($result), 3);
    $this->assertEquals($result[0]->name, 'Orange');
    $this->assertEquals($result[1]->name, 'Pear');
    $this->assertEquals($result[2]->name, 'Pepper');
  }

  public function testWhereChildReturnsResultSetWithThreeItemChildItems()
  {
    $gList = TestData::getGroceryList();
    $gListRs = new ResultSet($gList);
    $result = $gListRs->whereChild('items', ['name' => 'Celery']);

    $this->assertTrue(is_subclass_of($result, 'ArrayObject'));
    $this->assertEquals(count($result), 1);
    $this->assertEquals(count($result[0]->items), 3);
    $this->assertEquals($result[0]->items[2]->name, 'Celery');
  }

  public function testLikeReturnsResultSetWithTwoResultsForAto()
  {
    $items = TestData::getItems();
    $itemsRs = new ResultSet($items);
    $result = $itemsRs->like(['name' => 'ato']);

    $this->assertTrue(is_subclass_of($result, 'ArrayObject'));
    $this->assertEquals(count($result), 2);
    $this->assertEquals($result[0]->name, 'Potato');
    $this->assertEquals($result[1]->name, 'Tomato');
  }

  public function testLikeReturnsResultSetWithExpectedNoOfResultsForTwoConditionsWithNoDuplicates()
  {
    $items = TestData::getItemsWithTypeField();
    $itemsRs = new ResultSet($items);
    $result = $itemsRs->like(['name' => 'ato', 'type' => 'Fruit']);

    $tomCount = 0;
    foreach ($result as $item) {
      if ($item->name == 'Tomato') {
        $tomCount++;
      }
    }

    $this->assertTrue(is_subclass_of($result, 'ArrayObject'));
    $this->assertEquals(count($result), 5);
    $this->assertEquals($result[2]->type, 'Fruit');
    $this->assertEquals($tomCount, 1);
  }

  public function testLikeReturnsEmptyResultSetWhenPassedEmptyTestValue()
  {
    $items = TestData::getItems();
    $itemsRs = new ResultSet($items);
    $result = $itemsRs->like(['name' => '']);

    $this->assertTrue(is_subclass_of($result, 'ArrayObject'));
    $this->assertEquals(count($result), 0);
  }

  public function testEkilReturnsExpectedNoResultsInPassedArgument()
  {
    $items = TestData::getItems();
    $itemsRs = new ResultSet($items);

    $para = 'Some days I like to go down to the shop and get myself a lovely kipper, that I cover in tomato sauce';
    $result = $itemsRs->ekil(['name' => $para]);

    $this->assertTrue(is_subclass_of($result, 'ArrayObject'));
    $this->assertEquals(count($result), 2);
    $this->assertEquals($result[1]->name, 'Kipper');
  }

  public function testLikeChildReturnsItemsWithChildrenMatchingArgument()
  {
    $groceryList = TestData::getGroceryList();
    $groceryListRs = new ResultSet($groceryList);
    $result = $groceryListRs->likeChild('items', ['name' => 'pp']);

    $this->assertTrue(is_subclass_of($result, 'ArrayObject'));
    $this->assertEquals(count($result), 3);
    $this->assertEquals($result[1]->name, 'Veg');
  }

  public function testGreaterThanReturnsAllItemsGreaterThanPassed()
  {
    $items = TestData::getItems();
    $itemsRs = new ResultSet($items);

    $result = $itemsRs->greaterThan(['typeId' => 2]);

    $this->assertTrue(is_subclass_of($result, 'ArrayObject'));
    $this->assertEquals(count($result), 4);
    $this->assertEquals($result[2]->name, 'Ketchup');
  }

  public function testLessThanReturnsAllItemsLessThanPassed()
  {
    $items = TestData::getItems();
    $itemsRs = new ResultSet($items);

    $result = $itemsRs->lessThan(['typeId' => 2]);

    $this->assertTrue(is_subclass_of($result, 'ArrayObject'));
    $this->assertEquals(count($result), 4);
    $this->assertEquals($result[2]->name, 'Pear');
  }

  public function testKeyLikeMatchesKeyInArgument()
  {
    $groceryList = TestData::getGroceryList();
    $groceryListRs = new ResultSet($groceryList);

    $gList = [];
    foreach ($groceryListRs as $items) {
      $type = $items->name;
      $gList[$type] = $items;
    }
    $gListRs = new ResultSet($gList);

    $result = $gListRs->keyLike('Drinks');

    $this->assertTrue(is_subclass_of($result, 'ArrayObject'));
    $this->assertEquals(count($result), 1);

    $result2 = $gListRs->keyLike('Bob');
    $this->assertTrue(is_subclass_of($result2, 'ArrayObject'));
    $this->assertEquals(count($result2), 0);
  }

  public function testGroupByChildFieldReturnsGroupedResultBasedOnChildField()
  {
    $groceryList = TestData::getItemsWithTypeFieldJoined();
    $groceryListRs = new ResultSet($groceryList);

    $result = $groceryListRs->groupByChildField('type', 'name');

    $this->assertTrue(is_subclass_of($result, 'ArrayObject'));
    $this->assertEquals(count($result), 6);
    $this->assertEquals(count($result['Veg']), 3);
  }
}