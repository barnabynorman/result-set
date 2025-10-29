<?php
declare(strict_types=1);

namespace ResultSet\Concerns\Sorting;

trait OrderingExtended
{
    public function orderByDesc($fieldName)
    {
        $data = $this->orderBy($fieldName);

        $reversedArray = array_reverse(array_values($data->getArrayCopy()));

        $reversed = new static($reversedArray);

        return $reversed;
    }

    public function keySort()
    {
        $arrayData = $this->getArrayCopy();

        ksort($arrayData);

        return new static($arrayData);
    }
}
