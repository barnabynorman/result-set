<?php
declare(strict_types=1);

namespace ResultSet\Concerns\Filtering;

trait Distinct
{
    /**
     * Ensures that the contents of the ResultSet
     * are unique by a field specified as a key
     *
     * @param string $field to use as unique key
     *
     * @return static
     */
    public function unique($field = '')
    {
        if (strlen($field) == 0) {
            $unique = array_unique($this->toArray());
            return new static($unique);
        }

        $results = [];

        foreach ($this as $item) {
            $fieldValue = static::getItemFieldValue($item, $field);
            if (is_scalar($fieldValue)) {
                $results[$fieldValue] = $item;
            }
        }

        return new static(array_values($results));
    }

    /**
     * Ensures that the contents of the ResultSet
     * are unique by all fields specified.
     *
     * Resuls will only contain non-duplicate records
     *
     * The result will fail when duplicates are found
     * and onErrorStop is set to true
     *
     * @param array|string $fields to use as unique key
     * @param bool $onErrorStop optional end when duplicate found
     *
     * @return static
     * @throws \Exception
     */
    public function uniqueFields($fields = '', $onErrorStop = FALSE)
    {
        if (!is_array($fields) && strlen($fields) == 0) {
            throw new \Exception('uniqueFields - Please specify at least one field');
        }

        if (!is_array($fields)) {
            $fields = [$fields];
        }

        foreach ($fields as $field) {
            $results = [];

            foreach ($this as $key => $item) {
                $fieldValue = static::getItemFieldValue($item, $field);
                if (is_scalar($fieldValue)) {
                    if (isset($results[$fieldValue]) && $onErrorStop) {
                        throw new \Exception(sprintf("Duplicate: field: %s with value: %s", $field, $fieldValue));
                    } elseif (isset($results[$fieldValue])) {
                        unset($this[$key]);
                    } else {
                        $results[$fieldValue] = $item;
                    }
                } else {
                    return new static([]);
                }
            }
        }

        return $this;
    }

    /**
     * Returns resultSet randomly selected
     *
     * @param int $number of items to return
     *
     * @return static
     */
    public function rand($number = 1)
    {
        if ($number > $this->count()) {
            $number = $this->count();
        }

        $ids = array_rand($this->toArray(), $number);

        $ids = (is_array($ids)) ? $ids : [$ids];

        $results = [];

        foreach ($ids as $id) {
            $results[] = $this[$id];
        }

        return new static($results);
    }
}
