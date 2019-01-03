<?php

namespace ResultSet\Traits;

use ResultSet\ResultSetInterface;

trait First
{
  /**
   * Returns the first element in the ResultSet
   *
   * @return Object the data stored in the ResultSet
   */
  public function first()
  {
    return reset($this);
  }
}
