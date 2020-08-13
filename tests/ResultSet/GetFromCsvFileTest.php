<?php

namespace Tests\ResultSet;

use ResultSet\ResultSet;
use Tests\AbstractTestCase;

class GetFromCsvFileTest extends AbstractTestCase {

  public function testReturnsResultSet()
  {
    $rs = ResultSet::getFromCsvFile('./tests/ResultSet/testDataHeadingsFirstRow.csv');
    $this->assertInstanceOfResultSet($rs);
  }

  public function testCorrectKeysAndValues()
  {
    $testData = [];
    $row1 = new ResultSet([ 'heading1' => 'one', 'heading2' => 'two', 'heading3' => 'three' ]);
    $row2 = new ResultSet([ 'heading1' => 'four', 'heading2' => 'five', 'heading3' => 'six' ]);
 
    $testData[] = $row1;
    $testData[] = $row2;

    $expected = new ResultSet($testData);

    $rs = ResultSet::getFromCsvFile('./tests/ResultSet/testDataHeadingsFirstRow.csv');

    $this->assertEquals($rs, $expected);
  }

  public function testCorrectKeysAndValuesNoHeading()
  {
    $testData = [];
    $row1 = new ResultSet([ 'one', 'two', 'three' ]);
    $row2 = new ResultSet([ 'four', 'five', 'six' ]);
 
    $testData[] = $row1;
    $testData[] = $row2;

    $expected = new ResultSet($testData);

    $rs = ResultSet::getFromCsvFile('./tests/ResultSet/testDataNoHeadings.csv', FALSE);

    $this->assertEquals($rs, $expected);
  }

  public function testWithKeysInSecondRow()
  {
    $testData = [];
    $row1 = new ResultSet([ 'heading1' => 'one', 'heading2' => 'two', 'heading3' => 'three' ]);
    $row2 = new ResultSet([ 'heading1' => 'four', 'heading2' => 'five', 'heading3' => 'six' ]);
 
    $testData[] = $row1;
    $testData[] = $row2;

    $expected = new ResultSet($testData);

    $rs = ResultSet::getFromCsvFile('./tests/ResultSet/testDataHeadingsSecondRow.csv', 2);

    $this->assertEquals($rs, $expected);
  }

  public function testWithNoData()
  {
    $testData = [];

    $expected = new ResultSet($testData);

    $rs = ResultSet::getFromCsvFile('./tests/ResultSet/testNoData.csv', 2);

    $this->assertEquals($rs, $expected);
  }
}
