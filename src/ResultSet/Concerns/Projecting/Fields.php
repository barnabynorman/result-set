<?php
declare(strict_types=1);

namespace ResultSet\Concerns\Projecting;

trait Fields
{
    /**
     * Filters the contained objects to only return
     * the specified field
     *
     * @param string $field to return
     *
     * @return static
     */
    public function field($field)
    {
        $fieldValues = [];

        foreach ($this as $key => $item) {
            $value = static::getItemFieldValue($item, $field);
            $fieldValues[] = $value;
        }

        return new static($fieldValues);
    }

    /**
     * Filters the contained objects to only return
     * the specified fields as a ResultSet of Arrays
     * containing the fields and their values
     *
     * @param array $fieldNames of fields to return - passing an array as a field will include a subfields
     *
     * @return static
     */
    public function fields($fieldNames = [])
    {
        $results = [];

        foreach ($this as $key => $item) {
            $justFieldsItem = [];
            foreach ($fieldNames as $field) {

                if (is_array($field)) {
                    $child = static::getItemFieldValue($item, key($field));
                    $field = reset($field);
                    if (is_array($field)) {
                        $alias = key($field);
                        $field = reset($field);
                    }
                    $fieldValue = static::getItemFieldValue($child, $field);
                    $field = $alias ?? $field;
                } else {
                    $fieldValue = static::getItemFieldValue($item, $field);
                }

                $justFieldsItem[$field] = $fieldValue;
            }
            $results[] = $justFieldsItem;
        }

        return new static($results);
    }

    /**
     * Filters the contained objects to only return
     * the specified fields as a ResultSet of Arrays
     * containing the fields and their values.
     * Each field is aliased
     *
     * @param array $fieldNames of fields and their aliases
     *
     * @return static
     */
    public function fieldsAs($fieldNames = [])
    {
        $results = [];

        foreach ($this as $key => $item) {
            $justFieldsItem = [];
            foreach ($fieldNames as $field) {

                if (is_array($field)) {
                    $key = key($field);
                    $fieldValue = static::getItemFieldValue($item, $key);
                    $field = reset($field);
                } else {
                    $fieldValue = static::getItemFieldValue($item, $field);
                }

                $justFieldsItem[$field] = $fieldValue;
            }
            $results[] = $justFieldsItem;
        }

        return new static($results);
    }

    /**
     * Set the key for each item to be made from a field value
     * Spaces are replaced with underscores
     * The key will be lower-case
     *
     * @param string $field - the field to take the value from
     *
     * @return static
     */
    public function setKeysFromField($field)
    {
        $results = [];

        foreach ($this as $item) {
            $fieldValue = static::getItemFieldValue($item, $field);
            $keyName = strtolower(str_replace(' ', '_', $fieldValue));
            $results[$keyName] = $item;
        }

        return new static($results);
    }
}
