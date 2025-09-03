<?php

declare(strict_types=1);

namespace ResultSet;

use ResultSet\Concerns\Filtering\Predicates;
use ResultSet\Concerns\Filtering\Pattern;
use ResultSet\Concerns\Filtering\Nested;
use ResultSet\Concerns\Filtering\Search;
use ResultSet\Concerns\Filtering\Distinct;
use ResultSet\Concerns\Projecting\Fields;
use ResultSet\Concerns\Joining\Joins;
use ResultSet\Concerns\Sorting\Ordering;
use ResultSet\Concerns\Aggregating\Grouping;
use ResultSet\Concerns\Serialization\Output;
use ResultSet\Concerns\Operations\Ops;

class ResultSet extends \ArrayObject {

    use Predicates,
        Pattern,
        Nested,
        Search,
        Distinct,
        Fields,
        Joins,
        Ordering,
        Grouping,
        Output,
        Ops;

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

      return new static($data);

    } elseif (is_object($data)) {

      if (is_subclass_of($data, 'ArrayObject')) {
        return $data;
      }

      $data = get_object_vars($data);

    } else {
      $data = [$data];
    }

    return new static($data);
  }

  /**
   * Flatten any data into a searchable string
   *
   * @param mixed $data
   *
   * @return string
   */
  public static function convertToString($data)
  {
    if (is_string($data)) {
        return $data;
    } elseif (is_array($data) || is_object($data)) {
        return json_encode($data);
    } else {
        return (string) $data;
    }
  }

  /**
   * Creates a loaded instance of ResultSet based on data in
   * the CSV file specified in the filePath parameter
   *
   * @param String $filePath - path to CSV file
   * @param Integer $headings - optional heading row (default 1) - previous rows are ignored
   *
   * @return ResultSet instance
   */
  public static function getFromCsvFile ($filePath, $headings = 1) {
    $csvFile = [];
    if (($handle = fopen($filePath, 'r')) !== FALSE) {
      while (($data = fgetcsv($handle, 1000, ",", '"', "\\")) !== false) {
        $csvFile[] = $data;
      }

      fclose($handle);
    }

    $fields = [];
    if (is_integer($headings) && $headings > 0) {

      if ($headings >= count ($csvFile)) {
        return new static([]);
      }

      for ($rowCount = 0; $rowCount < $headings; $rowCount++) {
        $fields = array_shift($csvFile);
      }

    } else {
      $row = array_shift($csvFile);

      $fields = array_keys($row);

      array_unshift($csvFile, $row);
    }

    foreach ($fields as $id => $name) {
      $name = trim(str_replace(' ', '_', (string)$name));
      if (strlen($name) > 0) {
        $fields[$id] = $name;
      }
    }

    $items = [];

    foreach ($csvFile as $cols) {
      $record = [];
      foreach ($fields as $id => $fieldName) {
        if (isset($cols[$id])) {
          $record[$fieldName] = trim($cols[$id]);
        }
      }
      $items[] = new static($record);
    }

    return new static($items);
  }

















  /**
   * Get value from field in item
   *
   * @param Mixed item to get value from
   * @param String name of field to return
   *
   * @return Mixed
   */
  protected static function getItemFieldValue($item, $field)
  {
    if (((is_array($item)) || (is_subclass_of($item, 'ArrayObject'))) && (isset($item[$field]))) {
      return $item[$field];
    } elseif (isset($item->$field)) {
      return $item->$field;
    }

    return NULL;
  }

  /**
   * Set value in field on item
   *
   * @param Mixed item to set value on
   * @param String name of field to set
   * @param Mixed value to set
   *
   * @return Mixed
   */
  protected static function setItemFieldValue($item, $field, $value)
  {
    if (is_object($item)) {
      $item->$field = $value;
    } elseif (is_array($item)) {
      $item[$field] = $value;
    }

    return $item;
  }








}
