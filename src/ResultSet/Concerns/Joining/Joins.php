<?php
declare(strict_types=1);

namespace ResultSet\Concerns\Joining;

trait Joins
{
    /**
     * Returns original ResultSet with extra field containing array of
     * all matching from the supplied ResultSet / Array
     *
     * @param array|\ArrayObject $joinData - the data to join with
     * @param string $newField - the new field name to add
     * @param array $andClauses - array formed of [local_id => join_id]
     *
     * @return static
     */
    public function leftOuterJoin($joinData, $newField, $andClauses)
    {
        $results = [];
        $joinDataRs = static::getInstance($joinData);

        foreach ($this as $item) {
            $joinClauses = [];
            foreach ($andClauses as $localKey => $forignKey) {
                $localFieldValue = static::getItemFieldValue($item, $localKey);
                $joinClauses[$forignKey] = $localFieldValue;
            }

            $joined = $joinDataRs->where($joinClauses);
            $item = static::setItemFieldValue($item, $newField, $joined);

            $results[] = $item;
        }

        return new static($results);
    }

    /**
     * Returns resultSet with where matching items only
     * matching from the supplied ResultSet / Array
     *
     * Note that if the supplied Set contains more than one match
     * the last match will be returned
     *
     * @param array|\ArrayObject $joinData - the data to join with
     * @param string $newField - the new field name to add
     * @param array $andClauses - array formed of [local_id => join_id]
     *
     * @return static
     */
    public function innerJoin($joinData, $newField, $andClauses)
    {
        $results = [];
        $joinDataRs = static::getInstance($joinData);

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

        return new static($results);
    }

    /**
     * An inner join with results more like traditinal inner join where
     * all columns appear in the same row
     *
     * @param array|\ArrayObject $joinData - the data to join with
     * @param array $newFields - formed of [field => label] for each field
     * @param array $andClauses - formed of [local_id => join_id]
     *
     * @return static
     */
    public function joinFields($joinData, $newFields, $andClauses)
    {
        $results = [];
        $joinDataRs = static::getInstance($joinData);

        foreach ($this as $item) {
            $joinClauses = [];
            foreach ($andClauses as $localKey => $forignKey) {
                $localFieldValue = static::getItemFieldValue($item, $localKey);
                $joinClauses[$forignKey] = $localFieldValue;
            }

            $joined = $joinDataRs->where($joinClauses);

            if ($joined->count() > 0) {
                $joinData = $joined->first();

                foreach ($newFields as $field => $name) {
                    $fieldVal = static::getItemFieldValue($joinData, $field);
                    $item = static::setItemFieldValue($item, $name, $fieldVal);
                }
                $results[] = $item;
            }
        }

        return new static($results);
    }

    /**
     * Returns original ResultSet with extra field containing
     * the first matching from the supplied ResultSet / Array
     *
     * @param array|\ArrayObject $joinData - the data to join with
     * @param string $newField - the new field name to add
     * @param array $andClauses - array formed of [local_id => join_id]
     *
     * @return static
     */
    public function leftOuterJoinFirst($joinData, $newField, $andClauses)
    {
        $results = [];
        $joinDataRs = static::getInstance($joinData);

        foreach ($this as $item) {
            $joinClauses = [];
            foreach ($andClauses as $localKey => $forignKey) {
                $localFieldValue = static::getItemFieldValue($item, $localKey);
                $joinClauses[$forignKey] = $localFieldValue;
            }

            $joined = $joinDataRs->where($joinClauses);

            if ($joined->count() > 0) {
                $item = static::setItemFieldValue($item, $newField, $joined->first());
            } else {
                $item = static::setItemFieldValue($item, $newField, null);
            }

            $results[] = $item;
        }

        return new static($results);
    }
}
