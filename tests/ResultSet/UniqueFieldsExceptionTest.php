<?php

namespace Tests\ResultSet;

use ResultSet\ResultSet;
use Tests\AbstractTestCase;

class UniqueFieldsExceptionTest extends AbstractTestCase
{
    public function testThrowsExceptionOnDuplicate()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Duplicate: field: id with value: 1');

        $data = [
            ['id' => 1, 'name' => 'John'],
            ['id' => 1, 'name' => 'Jane'],
        ];
        $rs = new ResultSet($data);
        $rs->uniqueFields('id', true);
    }

    public function testThrowsExceptionOnNoFields()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('uniqueFields - Please specify at least one field');

        $rs = new ResultSet([]);
        $rs->uniqueFields('', true);
    }
}
