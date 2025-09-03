<?php
declare(strict_types=1);

namespace ResultSet\Concerns\Aggregating;

trait Grouping
{
    /**
     * Groups data into ResultSet based on
     * group field specified
     *
     * @param string $field Field name to group by
     *
     * @return static
     */
    public function groupBy($field)
    {
        $results = [];

        foreach ($this as $key => $item) {
            $fieldValue = static::getItemFieldValue($item, $field);
            $results[$fieldValue][] = $item;
        }

        return new static($results);
    }

    /**
     * Groups data into ResultSet based on
     * child group field specified
     * The child field must contain a key => value
     * to resolve the grouping
     *
     * @param string $field Field name to group by
     * @param string $childField
     *
     * @return static
     */
    public function groupByChildField($field, $childField)
    {
        $results = [];

        foreach ($this as $key => $item) {
            $child = static::getItemFieldValue($item, $field);
            $fieldValue = static::getItemFieldValue($child, $childField);
            $results[$fieldValue][] = $item;
        }

        return new static($results);
    }
}
