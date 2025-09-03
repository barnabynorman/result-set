<?php
declare(strict_types=1);

namespace ResultSet\Concerns\Serialization;

trait Output
{
    /**
     * Degrades ResultSet back to Array
     *
     * @return array
     */
    public function toArray()
    {
        return $this->getArrayCopy();
    }

    /**
     * Degrades ResultSet into JSON string
     *
     * @return string JSON
     */
    public function toJson()
    {
        return json_encode($this->getArrayCopy());
    }

    /**
     * Degrades ResultSet into JSON string
     * Each item is returned as an object
     * with id provided by the 'id' field
     * which can be optionally specified
     *
     * @param string $id
     * @return string JSON
     */
    public function toJsonRecords($id = 'id')
    {
        $data = $this->toArray();

        $records = [];

        foreach ($data as $row) {
            $idValue = static::getItemFieldValue($row, $id);
            $records[$idValue] = $row;
        }

        return json_encode($records);
    }
}
