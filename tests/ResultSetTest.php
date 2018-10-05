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
    $this->assertEquals($result[0]->name, 'Pair');

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
    $this->assertEquals($result[1]->name, 'Pair');
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
}