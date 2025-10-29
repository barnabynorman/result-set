<?php

namespace Tests\ResultSet;

use ResultSet\ResultSet;
use Tests\AbstractTestCase;

class ExtendedMethodsTest extends AbstractTestCase
{

    public function testUnGroup()
    {
        $people = TestData::getPeople();
        $peopleRs = new ResultSet($people);

        $grouped = $peopleRs->groupBy('gender');
        $unGrouped = $grouped->unGroup();

        $this->assertInstanceOfResultSet($unGrouped);
        $this->assertEquals(count($unGrouped), 17);
    }

    public function testLast()
    {
        $people = TestData::getPeople();
        $peopleRs = new ResultSet($people);

        $last = $peopleRs->last();

        $this->assertEquals('Alfie', $last->firstname);
    }

    public function testOrderByDesc()
    {
        $people = TestData::getPeople();
        $peopleRs = new ResultSet($people);

        $result = $peopleRs->orderByDesc('firstname');

        $this->assertEquals($result[0]->firstname, 'Sophia');
        $this->assertEquals($result[16]->firstname, 'Alfie');
    }

    public function testKeySort()
    {
        $people = TestData::getPeople();
        $peopleRs = new ResultSet($people);

        // Create a new ResultSet with keys that are out of order
        $keyedRs = new ResultSet([
            'b' => $peopleRs[1],
            'a' => $peopleRs[0]
        ]);

        $result = $keyedRs->keySort();
        $resultArray = $result->getArrayCopy();

        $this->assertEquals(array_keys($resultArray)[0], 'a');
        $this->assertEquals(array_keys($resultArray)[1], 'b');
    }
}
