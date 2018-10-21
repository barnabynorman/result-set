<?php

namespace Tests;

use ResultSet\ResultSet;
use PHPUnit\Framework\TestCase;

abstract class AbstractTestCase extends TestCase
{
  protected function setUp()
  {
    //
  }

  protected function tearDown()
  {
    //
  }

  public function assertInstanceOfResultSet($rs)
  {
      $this->assertInstanceOf(ResultSet::class, $rs);
  }

  public function assertNotInstanceOfResultSet($rs)
  {
      $this->assertNotInstanceOf(ResultSet::class, $rs);
  }

}
