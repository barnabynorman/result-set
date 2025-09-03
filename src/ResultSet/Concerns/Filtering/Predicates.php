<?php
declare(strict_types=1);

namespace ResultSet\Concerns\Filtering;

/**
 * @internal Shared expectations:
 * - Host has: protected array $items
 * - Host has: protected function withItems(array $items): static
 */
trait Predicates
{
    /**
     * Returns a filtered ResultSet dependent on clauses passed
     *
     * Clauses in the format: ['fieldName' => 'value sought']
     *
     * @param array $andClauses - all conditions must be met
     *
     * @return static
     */
    public function where($andClauses)
    {
        $results = [];

        if ((!is_array($andClauses)) || (count($andClauses) == 0)) {
            return new static([]);
        }

        foreach ($this as $item) {

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

        return new static($results);
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
     * @param array $orClauses - any condition can be met
     *
     * @return static
     */
    public function whereOr($orClauses)
    {
        $results = [];

        if ((!is_array($orClauses)) || (count($orClauses) == 0)) {
            return new static([]);
        }

        foreach ($this as $item) {

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

        return new static($results);
    }

    /**
     * Where one or more options = value of field
     *
     * @param mixed $values - Array or coma-seperated String of values being saught
     *
     * @return static
     */
    public function whereIn($field, $values)
    {
        $results = [];

        if (!is_array($values)) {
            $values = explode(',', $values);
        }

        foreach ($this as $item) {
            $fieldValue = static::getItemFieldValue($item, $field);
            if (in_array($fieldValue, $values)) {
                $results[] = $item;
            }
        }

        return new static($results);
    }

    /**
     * Similare to where() but each tested field must
     * be greater than the value saught
     *
     * @param array $andClauses of clauses
     *
     * @return static
     */
    public function greaterThan($andClauses)
    {
        $results = [];

        if ((!is_array($andClauses)) || (count($andClauses) == 0)) {
            return new static([]);
        }

        foreach ($this as $item) {

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

        return new static($results);
    }

    /**
     * Similare to where() but each tested field must
     * be less than the value saught
     *
     * @param array $andClauses of clauses
     *
     * @return static
     */
    public function lessThan($andClauses)
    {
        $results = [];

        if ((!is_array($andClauses)) || (count($andClauses) == 0)) {
            return new static([]);
        }

        foreach ($this as $item) {

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

        return new static($results);
    }

    /**
     * Returns a filtered ResultSet dependent on clauses passed
     * Includes all results that are not in the clauses
     *
     * Clauses in the format: ['fieldName' => 'value sought']
     *
     * @param array $andClauses - all conditions must be met
     *
     * @return static
     */
    public function whereNot($andClauses)
    {
        $results = [];

        if ((!is_array($andClauses)) || (count($andClauses) == 0)) {
            return $this;
        }

        foreach ($this as $item) {

            $add = TRUE;
            foreach ($andClauses as $field => $value) {
                $fieldValue = static::getItemFieldValue($item, $field);
                if ($fieldValue == $value) {
                    $add = FALSE;
                }
            }

            if ($add) {
                $results[] = $item;
            }
        }

        return new static($results);
    }

    /**
     * Filters objects between positions
     * Note that the ResultSet counts from 0
     *
     * @param int $start - The position in the resultSet (counting from 0) of the first item
     * @param int $end - The position in the resultSet (counting from 0) of the last item
     *
     * @return static
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

        return new static($results);
    }

    /**
     * Limits the number of records returned
     * from the ResultSet
     *
     * @param int $no number of records
     *
     * @return static
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
     * Useses a supplied function to be run against
     * each item in the ResultSet, creating a new
     * ResultSet where items are only included where
     * the function returns TRUE
     *
     * Note to include or return other parameters in the closure
     * append the $function structure with "use ($myParameterName)"
     *
     * @param string $itemName - name of argument of function
     * @param \Closure $function - a closure function
     *
     * @return static
     */
    public function filter($itemName, $function)
    {
        $results = [];

        foreach ($this as $key => $$itemName) {
            if ($function($$itemName)) {
                $results[$key] = $$itemName;
            }
        }

        return new static($results);
    }
}
