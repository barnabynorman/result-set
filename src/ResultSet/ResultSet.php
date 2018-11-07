<?php

namespace ResultSet;

class ResultSet extends \ArrayObject {

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
   * @param Array of andClauses - all conditions must be met
   *
   * @return ResultSet
   */
  public function where($andClauses)
  {
    $results = [];

    if ((!is_array($andClauses)) || (count($andClauses) == 0)) {
      return new ResultSet([]);
    }

    foreach($this as $item) {

      $add = TRUE;
      foreach ($andClauses as $field => $value) {
        $fieldValue = static::getItemFieldValue($item, $field);
        if ($fieldValue != $value) {
          $add = FALSE;
        }
      }

      if ($add) {
        $results[] = $item;
      }
    }

    return new ResultSet($results);
  }

  /**
   * Returns a filtered ResultSet dependent any clauses passed matching
   *
   * Clauses in the format:
   *  [
   *    'fieldName' => 'value sought',
   *    'second_or_more_fieldNames' => 'value sought'
   *  ]
   *
   * @param Array of orClauses - any condition can be met
   *
   * @return ResultSet
   */
  public function whereOr($orClauses)
  {
    $results = [];

    if ((!is_array($orClauses)) || (count($orClauses) == 0)) {
      return new ResultSet([]);
    }

    foreach($this as $item) {

      $add = FALSE;
      foreach ($orClauses as $field => $value) {
        $fieldValue = static::getItemFieldValue($item, $field);
        if ($fieldValue == $value) {
          $add = TRUE;
        }
      }

      if ($add) {
        $results[] = $item;
      }
    }

    return new ResultSet($results);
  }

  /**
   * Where one or more options = value of field
   *
   * @param Mixed $values - Array or coma-seperated String of values being saught
   *
   * @return ResultSet Filtered set
   */
  public function whereIn($field, $values)
  {
    $results = [];

    if (!is_array($values)) {
      $values = explode(',', $values);
    }

    foreach($this as $item) {
      $fieldValue = static::getItemFieldValue($item, $field);
      if (in_array($fieldValue, $values)) {
        $results[] = $item;
      }
    }

    return new ResultSet($results);
  }

  /**
   * Filter ResultSet by elements in child array or ResultSet
   * whereChild() expects the field to contain an array of
   * child items
   *
   * @param String $field containing child items
   * @param Array andClauses - All conditions must be met to return the item
   *
   * @return ResultSet
   */
  public function whereChild($field, $andClauses)
  {
    $results = [];

    if ((!is_array($andClauses)) || (count($andClauses) == 0)) {
      return new ResultSet([]);
    }

    foreach($this as $item) {
      $fieldValue = static::getItemFieldValue($item, $field);
      $testResult = ResultSet::getInstance($fieldValue)->where($andClauses);

      if ($testResult->count() > 0) {
        $results[] = $item;
      }
    }

    return new ResultSet($results);
  }

  /**
   * Filter ResultSet by elements in sub field
   *
   * @param String $field containing sub-field
   * @param Array of andClauses
   *
   * @return ResultSet
   */
  public function whereSubField($field, $andClauses)
  {
    $results = [];

    if ((!is_array($andClauses)) || (count($andClauses) == 0)) {
      return new ResultSet([]);
    }

    foreach($this as $item) {
      $fieldValue = static::getItemFieldValue($item, $field);
      $testResult = ResultSet::getInstance([$fieldValue])->where($andClauses);

      if ($testResult->count() > 0) {
        $results[] = $item;
      }
    }

    return new ResultSet($results);
  }

  /**
   * Matches elements where field contains value
   *
   * @param Array orClauses - any conditions can be met to return the item
   *
   * @return ResultSet
   */
  public function like($orClauses)
  {
    $results = [];

    if (!is_array($orClauses)) {
      $orClauses = [];
    }

    foreach ($orClauses as $field => $value) {
      foreach($this as $key => $item) {
        $fieldValue = static::getItemFieldValue($item, $field);

        if ((strlen($value)) && (stripos((string)$fieldValue, (string)$value) !== FALSE)) {
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
   * @param Array orClauses - any conditions can be met to return the item
   *
   * @return ResultSet
   */
  public function ekil($orClauses)
  {
    $results = [];

    foreach ($orClauses as $field => $value) {
      foreach($this as $key => $item) {
        $fieldValue = static::getItemFieldValue($item, $field);

        if ((strlen($value)) && (stripos((string)$value, (string)$fieldValue) !== FALSE)) {
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
   * @param Array orClauses - any condition can be met to return the item being tested
   *
   * @return ResultSet
   */
  public function likeChild($fieldName, $orClauses)
  {
    $results = [];

    foreach($this as $key => $item) {
      $fieldValue = static::getItemFieldValue($item, $fieldName);
      $childCount = ResultSet::getInstance($fieldValue)->like($orClauses)->count();

      if ($childCount > 0) {
        $results[] = $item;
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
  public function greaterThan($andClauses)
  {
    $results = [];

    if ((!is_array($andClauses)) || (count($andClauses) == 0)) {
      return new ResultSet([]);
    }

    foreach($this as $item) {

      $add = TRUE;
      foreach ($andClauses as $field => $value) {
        $fieldValue = static::getItemFieldValue($item, $field);
        if (($fieldValue == $value) || ($fieldValue < $value)) {
          $add = FALSE;
        }
      }

      if ($add) {
        $results[] = $item;
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
  public function lessThan($andClauses)
  {
    $results = [];

    if ((!is_array($andClauses)) || (count($andClauses) == 0)) {
      return new ResultSet([]);
    }

    foreach($this as $item) {

      $add = TRUE;
      foreach ($andClauses as $field => $value) {
        $fieldValue = static::getItemFieldValue($item, $field);
        if (($fieldValue == $value) || ($fieldValue > $value)) {
          $add = FALSE;
        }
      }

      if ($add) {
        $results[] = $item;
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
        if (($item == $searchPhrase) || (stripos((string)$item, (string)$searchPhrase) !== FALSE)) {
          $results[] = $item;
        }
      } else {
        $childSearchCount = ResultSet::getInstance($item)->search($searchPhrase)->count();
        if ($childSearchCount > 0) {
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
        $testa = static::getItemFieldValue($a, $order);
        $testb = static::getItemFieldValue($b, $order);
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
   */
  public function field($field)
  {
    $fieldValues = [];

    foreach($this as $key => $item) {
      $value = static::getItemFieldValue($item, $field);
      $fieldValues[] = $value;
    }

    return new ResultSet($fieldValues);
  }

  /**
   * Filters the contained objects to only return
   * the specified fields as a ResultSet of Arrays
   * containing the fields and their values
   *
   * @param Array of fields to return
   *
   * @return ResultSet of Arrays
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
   * @param Array $clauses - array formed of [local_id => join_id]
   *
   * @return ResultSet containing joined sets
   */
  public function leftOuterJoin($joinData, $newField, $andClauses)
  {
    $results = [];
    $joinDataRs = ResultSet::getInstance($joinData);

    foreach ($this as $item) {
      $joinClauses = [];
      foreach ($andClauses as $localKey => $forignKey) {
        $localFieldValue = static::getItemFieldValue($item, $localKey);
        $joinClauses[$forignKey] = $localFieldValue;
      }

      $joined = $joinDataRs->where($joinClauses);
      $item->$newField = $joined;

      $results[] = $item;
    }

    return new ResultSet($results);
  }

  /**
   * Returns resultSet with where matching items only
   * matching from the supplied ResultSet / Array
   *
   * Note that if the supplied Set contains more than one match
   * the last match will be returned
   *
   * @param Array $joinData - the data to join with
   * @param String $newField - the new field name to add
   * @param Array $clauses - array formed of [local_id => join_id]
   *
   * @return ResultSet containing joined sets
   */
  public function innerJoin($joinData, $newField, $andClauses)
  {
    $results = [];
    $joinDataRs = ResultSet::getInstance($joinData);

    foreach ($this as $item) {
      $joinClauses = [];
      foreach ($andClauses as $localKey => $forignKey) {
        $localFieldValue = static::getItemFieldValue($item, $localKey);
        $joinClauses[$forignKey] = $localFieldValue;
      }

      $joined = $joinDataRs->where($joinClauses);

      if ($joined->count() > 0) {
        $results[] = static::setItemFieldValue($item, $newField, $joined->first());
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
  public function unique($field = '')
  {
    if (strlen($field) == 0) {
      $unique = array_unique($this->toArray());
      return new ResultSet($unique);
    }

    $results = [];

    foreach ($this as $item) {
      $fieldValue = static::getItemFieldValue($item, $field);
      if (is_scalar($fieldValue)) {
        $results[$fieldValue] = $item;
      }
    }

    return new ResultSet(array_values($results));
  }

  /**
   * Filters objects between positions
   * Note that the ResultSet counts from 0
   *
   * @param Integer $start - The position in the resultSet (counting from 0) of the first item
   * @param Integer $end - The position in the resultSet (counting from 0) of the last item
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

  /**
   * Allows a supplied function to be run against
   * each item in ResultSet
   *
   * Note to include or return other parameters in the closure
   * append the $function structure with "use ($myParameterName)"
   * Also pass by address (&) if the parameter is to be mutated
   *
   * @param String $paramName - name of argument of function
   * @param Function $function - a closure function
   *
   * @return ResultSet
   */
  public function each($paramName, $function)
  {
    foreach ($this as $$paramName) {
      $function($$paramName);
    }

    return $this;
  }

  /**
   * Calls method specified on each item in ResultSet
   * Note that the method will ignore any item that
   * does not support the method passed without error!
   *
   * @param String $method name in item to call
   *
   * @return ResultSet
   */
  public function callMethod($method)
  {
    foreach ($this as $item) {
      if (method_exists($item, $method)) {
        $item->$method();
      }
    }

    return $this;
  }

  /**
   * Wrapper for uasort
   *
   * @param Function $comparisonFunction to do sort
   *
   * @return ResultSet
   */
  public function sort($comparisonFunction)
  {
    $this->uasort($comparisonFunction);
    return $this;
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

  protected static function setItemFieldValue($item, $field, $value)
  {
    if (is_object($item)) {
      $item->$field = $value;
    } elseif (is_array($item)) {
      $item[$field] = $value;
    }

    return $item;
  }

  /**
   * Returns original ResultSet with extra field containing
   * the first matching from the supplied ResultSet / Array
   *
   * @param Array $joinData - the data to join with
   * @param String $newField - the new field name to add
   * @param Array $andClauses - array formed of [local_id => join_id]
   *
   * @return ResultSet containing joined sets
   */
  public function leftOuterJoinFirst($joinData, $newField, $andClauses)
  {
    $results = [];
    $joinDataRs = ResultSet::getInstance($joinData);

    foreach ($this as $item) {
      $joinClauses = [];
      foreach ($andClauses as $localKey => $forignKey) {
        $localFieldValue = static::getItemFieldValue($item, $localKey);
        $joinClauses[$forignKey] = $localFieldValue;
      }

      $joined = $joinDataRs->where($joinClauses);

      if ($joined->count() > 0) {
        $item->$newField = $joined->first();
      }

      $results[] = $item;
    }

    return new ResultSet($results);
  }

  public function joinFields($joinData, $newFields, $localKey, $forignKey)
  {
    $results = [];

    foreach ($this as $item) {
      $localFieldValue = static::getItemFieldValue($item, $localKey);
      foreach ($joinData as $fData) {
        $forignFieldValue = static::getItemFieldValue($fData, $forignKey);

        if ($localFieldValue == $forignFieldValue) {
          foreach ($newFields as $field => $newFieldName) {
            $item->$newFieldName = static::getItemFieldValue($fData, $field);
          }

          $results[] = $item;
        }
      }
    }

    return new ResultSet($results);
  }

  public function setKeysFromField($field)
  {
    $results = [];

    foreach($this as $item) {
      $fieldValue = static::getItemFieldValue($item, $field);
      $keyName = strtolower(str_replace(' ', '_', $fieldValue));
      $results[$keyName] = $item;
    }

    return new ResultSet($results);
  }

}
