<?php

class ResultSet extends ArrayObject {

  /**
   * Create an instance of ResultSet
   * Typically data held in elements are object instances
   *
   * @param Array $data - the dataset as array or another ResultSet
   */
  public function __construct($data)
  {
    parent::__construct($data);
  }

  /**
   * Gets instance of ResultSet ensuring that not already instance
   * and making date the right shape first
   *
   * @param Array $data - the dataset as array or another ResultSet
   *
   * @return ResultSet instance
   */
  public static function getInstance($data)
  {
    if (is_array($data)) {

      return new ResultSet($data);

    } elseif (is_object($data)) {

      if (is_subclass_of($data, 'ArrayObject')) {
        return $data;
      }

      $data = get_object_vars($data);

    } else {
      $data = [$data];
    }

    return new ResultSet($data);
  }

  /**
   * Returns the first element in the ResultSet
   *
   * @return Object the data stored in the ResultSet
   */
  public function first()
  {
    return reset($this);
  }

  /**
   * Returns a filtered ResultSet dependent on clauses passed
   *
   * Clauses in the format: ['fieldName' => 'value sought']
   *
   * @param Array of clauses
   *
   * @return ResultSet
   */
  public function where($clauses)
  {
    $results = [];

    foreach ($clauses as $field => $value) {

      foreach($this as $item) {
        if (is_array($item)) {
          if ($item[$field] == $value) {
              $results[] = $item;
          }
        } elseif (isset($item->$field)) {
          if ($item->$field == $value) {
              $results[] = $item;
          }
        }
      }
    }

    return new ResultSet($results);
  }

  /**
   * Where one or more options = value of field
   *
   * @param String Comma seperated list
   *
   * @return ResultSet Filtered set
   */
  public function whereIn($field, $options)
  {
    $results = [];

    $optionList = explode(',', $options);

    foreach ($optionList as $value) {

      foreach($this as $item) {
        if (is_array($item)) {
          if ($item[$field] == $value) {
            $results[] = $item;
          }
        } elseif (isset($item->$field)) {
          if ($item->$field == $value) {
            $results[] = $item;
          }
        }
      }
    }

    return new ResultSet($results);
  }

  /**
   * Filter ResultSet by array or ResultSet of a child field
   *
   * @param String $fieldName in each element to filter by
   * @param Array of clauses
   *
   * @return ResultSet
   */
  public function whereChild($fieldName, $clauses)
  {
    $results = [];

    foreach($this as $item) {
      if (isset($item->$fieldName)) {
        $testSet = new ResultSet($item->$fieldName);
        $testResult = $testSet->where($clauses);
        if ($testResult->count() > 0) {
          $results[] = $item;
        }
      }
    }

    return new ResultSet($results);
  }

  /**
   * Matches elements where field contains value
   *
   * @param Array of clauses
   *
   * @return ResultSet
   */
  public function like($clauses)
  {
    $results = [];

    foreach ($clauses as $field => $value) {
      foreach($this as $key => $item) {
        $fieldValue = static::getItemFieldValue($item, $field);

        if ((strlen($value)) && (stripos($fieldValue, $value) !== FALSE)) {
          $results[$key] = $item;
        }
      }
    }

    return new ResultSet(array_values($results));
  }

  /**
   * Backwards like
   * Similar to like() but looks for match from items in value passed
   *
   * @param Array of clauses
   *
   * @return ResultSet
   */
  public function ekil($clauses)
  {
    $results = [];

    foreach ($clauses as $field => $value) {
      foreach($this as $key => $item) {
        $fieldValue = static::getItemFieldValue($item, $field);

        if ((strlen($value)) && (stripos($value, $fieldValue) !== FALSE)) {
          $results[] = $item;
        }
      }
    }

    return new ResultSet($results);
  }

  /**
   * Matches elements where field contains value from child array / ResultSet
   *
   * @param String $fieldName in each element to filter by
   * @param Array of clauses
   *
   * @return ResultSet
   */
  public function likeChild($fieldName, $clauses)
  {
    $results = [];

    foreach ($clauses as $field => $value) {
      foreach($this as $key => $item) {
        $fieldValue = static::getItemFieldValue($item, $fieldName);
        $fieldValueRs = ResultSet::getInstance($fieldValue);
        $found = $fieldValueRs->like([$field => $value]);

        if ($found->count() > 0) {
          $results[] = $item;
        }
      }
    }

    return new ResultSet($results);
  }

  /**
   * Matches elements by key
   *
   * @param String $searchKey to match
   *
   * @return ResultSet
   */
  public function keyLike($searchKey)
  {
    $results = [];

    foreach($this as $key => $item) {
      if (stripos($key, $searchKey) !== FALSE) {
        $results[$key] = $item;
      }
    }

    return new ResultSet(array_values($results));
  }

  /**
   * Similare to where() but each tested field must
   * be greater than the value saught
   *
   * @param Array of clauses
   *
   * @return ResultSet
   */
  public function greaterThan($clauses)
  {
    $results = [];

    foreach ($clauses as $fieldName => $value) {
      foreach($this as $item) {
        $fieldValue = static::getItemFieldValue($item, $fieldName);
        if ($fieldValue > $value) {
            $results[] = $item;
        }
      }
    }

    return new ResultSet($results);
  }

  /**
  * Similare to where() but each tested field must
  * be less than the value saught
  *
  * @param Array of clauses
  *
  * @return ResultSet
  */
  public function lessThan($clauses)
  {
    $results = [];

    foreach ($clauses as $fieldName => $value) {
      foreach($this as $item) {
        $fieldValue = static::getItemFieldValue($item, $fieldName);
        if ($fieldValue < $value) {
            $results[] = $item;
        }
      }
    }

    return new ResultSet($results);
  }

  /**
   * Searches all fields in all elements
   *
   * @param String phrase to search for
   *
   * @return ResultSet
   */
  public function search($searchPhrase)
  {
    $results = [];

    foreach($this as $item) {
      if (is_scalar($item)) {
        if ((stripos($item, $searchPhrase) !== FALSE) || ($item == $searchPhrase)) {
          $results[] = $item;
        }
      } else {
        $itemRs = new ResultSet($item);
        $childSearch = $itemRs->search($searchPhrase);
        if (count($childSearch) > 0) {
          $results[] = $item;
        }
      }
    }

    return new ResultSet($results);
  }

  /**
   * Returns the ResultSet ordered by $order and
   * optionally $subOrder
   *
   * @param String $order
   * @param String Optional $subOrder
   *
   * @return ResultSet
   */
  public function orderBy($order, $subOrder = '')
  {
    if (strlen($subOrder) > 0) {
      $this->uasort(function ($a, $b) use($order, $subOrder) {
        if ($a->$order == $b->$order) {
          return $a->$subOrder <=> $b->$subOrder;
        }
        return strcmp($a->$order, $b->$order);
      });
    } else {
      $this->uasort(function ($a, $b) use($order) {
        $testa = (is_array($a)) ? $a[$order] : $a->$order;
        $testb = (is_array($b)) ? $b[$order] : $b->$order;
        return $testa <=> $testb;
      });
    }

    $result = [];
    foreach ($this as $item) {
      $result[] = $item;
    }

    return ResultSet::getInstance($result);
  }

  /**
   * Groups data into ResultSet based on
   * group field specified
   *
   * @param String Field name to group by
   *
   * @return ResultSet
   */
  public function groupBy($field)
  {
    $results = [];

    foreach($this as $key => $item) {
      $fieldValue = static::getItemFieldValue($item, $field);
      $results[$fieldValue][] = $item;
    }

    return new ResultSet($results);
  }

  /**
   * Groups data into ResultSet based on
   * child group field specified
   * The child field must contain a key => value
   * to resolve the grouping
   *
   * @param String Field name to group by
   *
   * @return ResultSet
   */
  public function groupByChildField($field, $childField)
  {
    $results = [];

    foreach($this as $key => $item) {
      $child = static::getItemFieldValue($item, $field);
      $fieldValue = static::getItemFieldValue($child, $childField);
      $results[$fieldValue][] = $item;
    }

    return new ResultSet($results);
  }

  /**
   * Filters the contained objects to only return
   * the specified field
   *
   * @param String field to return
   *
   * @return ResultSet
   *
   * @todo Deal with where field contains non-scalar value
   */
  public function field($field)
  {
    $fieldValues = [];

    foreach($this as $key => $item) {
      $value = static::getItemFieldValue($item, $field);
      $fieldValues[strtolower($value)] = $value;
    }

    return new ResultSet(array_values($fieldValues));
  }

  /**
   * Filters the contained objects to only return
   * the specified fields as a ResultSet of Arrays
   * containing the fields and their values
   *
   * @param Array of fields to return
   *
   * @return ResultSet of Arrays
   *
   * @todo Rewrite using filter()
   */
  public function fields($fieldNames = [])
  {
    $results = [];

    foreach($this as $key => $item) {
      $justFieldsItem = [];
      foreach($fieldNames as $field) {
        $fieldValue = static::getItemFieldValue($item, $field);
        $justFieldsItem[$field] = $fieldValue;
      }
      $results[] = $justFieldsItem;
    }

    return new ResultSet($results);
  }

  /**
   * Returns original ResultSet with extra field containing array of
   * all matching from the supplied ResultSet / Array
   *
   * @param Array $joinData - the data to join with
   * @param String $newField - the new field name to add
   * @param String $localKey - the name of the key from this ResultSet
   * @param String $forignKey - the name of the remote key used to match
   *
   * @return ResultSet containing joined sets
   */
  public function leftOuterJoin($joinData, $newField, $localKey, $forignKey)
  {
    $results = [];

    foreach ($this as $item) {
      $localFieldValue = static::getItemFieldValue($item, $localKey);
      $item->$newField = [];
      foreach ($joinData as $fData) {
        $forignFieldValue = static::getItemFieldValue($fData, $forignKey);

        if ($localFieldValue == $forignFieldValue) {
          $item->$newField[] = $fData;
        }
      }
      $results[] = $item;
    }

    return new ResultSet($results);
  }

  /**
   * Returns original ResultSet with extra field containing one
   * matching from the supplied ResultSet / Array
   * Any un-matched items will be filtered from the final ResultSet
   *
   * Note that if the supplied Set contains more than one match
   * the last match will be returned
   *
   * @param Array $joinData - the data to join with
   * @param String $newField - the new field name to add
   * @param String $localKey - the name of the key from this ResultSet
   * @param String $forignKey - the name of the remote key used to match
   *
   * @return ResultSet containing joined sets
   */
  public function innerJoin($joinData, $newField, $localKey, $forignKey)
  {
    $results = [];

    foreach ($this as $item) {
      $localFieldValue = static::getItemFieldValue($item, $localKey);
      foreach ($joinData as $fData) {
        $forignFieldValue = static::getItemFieldValue($fData, $forignKey);

        if ($localFieldValue == $forignFieldValue) {
          $item->$newField = $fData;
          $results[] = $item;
        }
      }
    }

    return new ResultSet($results);
  }

  /**
   * Degrades ResultSet back to Array
   *
   * @return Array
   */
  public function toArray()
  {
    return $this->getArrayCopy();
  }


    /**
     * Degrades ResultSet into JSON string
     *
     * @return JSON
     */
    public function toJson()
    {
        return json_encode($this->getArrayCopy());
    }

    /**
     * Ensures that the contents of the ResultSet
     * are unique by a field specified as a key
     *
     * @param String field to use as unique key
     *
     * @return ResultSet
     */
    public function unique($field)
    {
        $results = [];

        foreach ($this->toArray() as $value) {
            $results[$value->$field] = $value;
        }

        return new ResultSet(array_values($results));
    }

    /**
     * Filters objects between positions
     * Note that the ResultSet counts from 0
     *
     * @param Integer starting point
     * @param Integer end point
     *
     * @return ResultSet
     */
    public function between($start, $end = 0)
    {
        $count = 0;

        if ($end == 0) {
            $end = $this->count();
        }

        $results = [];

        foreach ($this as $item) {
            if (($count >= $start) && ($count < $end)) {
                $results[] = $item;
            }

            $count++;
        }

        return new ResultSet($results);
    }

    /**
     * Limits the number of records returned
     * from the ResultSet
     *
     * @param Integer number of records
     *
     * @return ResultSet
     */
    public function limit($no)
    {
        if ($no < 0) {
            $start = $this->count() + $no;
            return $this->between($start);
        }

        return $this->between(0, $no);
    }

    public function each($paramName, $function)
    {
      foreach ($this as $$paramName) {
        $function($$paramName);
      }
    }

    public function callMethod($method)
    {
      foreach ($this as $item) {
        $item->$method();
      }
    }

    protected static function getItemFieldValue($item, $field)
    {
      if (((is_array($item)) || (is_subclass_of($item, 'ArrayObject'))) && (isset($item[$field]))) {
        return $item[$field];
      } elseif (isset($item->$field)) {
        return $item->$field;
      }

      return NULL;
    }

    public function sort($comparisonFunction)
    {
      $this->uasort($comparisonFunction);
        return $this;
    }

}
