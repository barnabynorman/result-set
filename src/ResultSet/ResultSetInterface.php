<?php

namespace ResultSet;

interface ResultSetInterface
{
  /**
   * Returns the first element in the ResultSet
   *
   * @return Object the data stored in the ResultSet
   */
  public function first();

}