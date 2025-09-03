<?php
declare(strict_types=1);

namespace ResultSet\Concerns\Filtering;

trait Pattern
{
    /**
     * Matches elements where field contains value
     *
     * @param array $orClauses - any conditions can be met to return the item
     *
     * @return static
     */
    public function like($orClauses)
    {
        $results = [];

        if (!is_array($orClauses)) {
            $orClauses = [];
        }

        foreach ($orClauses as $field => $value) {
            foreach ($this as $key => $item) {
                $fieldValue = static::getItemFieldValue($item, $field);

                if ((strlen((string)$value)) && (stripos((string)$fieldValue, (string)$value) !== FALSE)) {
                    $results[$key] = $item;
                }
            }
        }

        return new static(array_values($results));
    }

    /**
     * Backwards like
     * Similar to like() but looks for match from items in value passed
     *
     * @param array $orClauses - any conditions can be met to return the item
     *
     * @return static
     */
    public function ekil($orClauses)
    {
        $results = [];

        foreach ($orClauses as $field => $value) {
            foreach ($this as $key => $item) {
                $fieldValue = static::getItemFieldValue($item, $field);

                if ((strlen($value)) && (stripos((string)$value, (string)$fieldValue) !== FALSE)) {
                    $results[] = $item;
                }
            }
        }

        return new static($results);
    }

    /**
     * Matches elements where field contains value from child array / ResultSet
     *
     * @param string $fieldName in each element to filter by
     * @param array $orClauses - any condition can be met to return the item being tested
     *
     * @return static
     */
    public function likeChild($fieldName, $orClauses)
    {
        $results = [];

        foreach ($this as $key => $item) {
            $fieldValue = static::getItemFieldValue($item, $fieldName);
            $childCount = static::getInstance($fieldValue)->like($orClauses)->count();

            if ($childCount > 0) {
                $results[] = $item;
            }
        }

        return new static($results);
    }

    /**
     * Matches elements by key
     *
     * @param string $searchKey to match
     *
     * @return static
     */
    public function keyLike($searchKey)
    {
        $results = [];

        foreach ($this as $key => $item) {
            if (stripos($key, $searchKey) !== FALSE) {
                $results[$key] = $item;
            }
        }

        return new static(array_values($results));
    }
}
