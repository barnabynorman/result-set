<?php
declare(strict_types=1);

namespace ResultSet\Concerns\Filtering;

trait Nested
{
    /**
     * Filter ResultSet by elements in child array or ResultSet
     * whereChild() expects the field to contain an array of
     * child items
     *
     * @param string $field containing child items
     * @param array $andClauses - All conditions must be met to return the item
     *
     * @return static
     */
    public function whereChild($field, $andClauses)
    {
        $results = [];

        if ((!is_array($andClauses)) || (count($andClauses) == 0)) {
            return new static([]);
        }

        foreach ($this as $item) {
            $fieldValue = static::getItemFieldValue($item, $field);
            $testResult = static::getInstance($fieldValue)->where($andClauses);

            if ($testResult->count() > 0) {
                $results[] = $item;
            }
        }

        return new static($results);
    }

    /**
     * Filter ResultSet by elements in sub field
     *
     * @param string $field containing sub-field
     * @param array $andClauses of andClauses
     *
     * @return static
     */
    public function whereSubField($field, $andClauses)
    {
        $results = [];

        if ((!is_array($andClauses)) || (count($andClauses) == 0)) {
            return new static([]);
        }

        foreach ($this as $item) {
            $fieldValue = static::getItemFieldValue($item, $field);
            $testResult = static::getInstance([$fieldValue])->where($andClauses);

            if ($testResult->count() > 0) {
                $results[] = $item;
            }
        }

        return new static($results);
    }

    /**
     * Filter resultSet by elements in child resultSet
     * whereChildNot() excludes any item where the child matches
     *
     * @param string $field containing child items
     * @param array $andClauses - All conditions must be met to return the item
     *
     * @return static
     */
    public function whereChildNot($field, $andClauses)
    {
        $results = [];

        if ((!is_array($andClauses)) || (count($andClauses) == 0)) {
            return $this;
        }

        foreach ($this as $item) {
            $fieldValue = static::getItemFieldValue($item, $field);
            $testResult = static::getInstance($fieldValue)->where($andClauses);

            if ($testResult->count() == 0) {
                $results[] = $item;
            }
        }

        return new static($results);
    }

    /**
     * Get the value from a subfield
     *
     * @param string $field in the idtem containing the value
     * @param string $subField in the items field
     *
     * @return static
     */
    public function subField($field, $subField)
    {
        $fieldValues = [];

        foreach ($this as $key => $item) {
            $fieldValue = static::getItemFieldValue($item, $field);
            $childValue = static::getItemFieldValue($fieldValue, $subField);
            $fieldValues[] = $childValue;
        }

        return new static($fieldValues);
    }
}
