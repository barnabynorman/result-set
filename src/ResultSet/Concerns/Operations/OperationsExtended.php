<?php
declare(strict_types=1);

namespace ResultSet\Concerns\Operations;

trait OperationsExtended
{
    /**
     * Removes the outer grouped keys
     *
     * @return \ResultSet\ResultSet instance
     */
    public function unGroup()
    {
        $results = [];

        foreach($this as $item) {
            foreach ($item as $groupedItem) {
                $results[] = $groupedItem;
            }
        }

        return new static($results);
    }

    public function last()
    {
        $it = $this->getIterator();

        if ($it->count() > 0) {
            $it->seek($it->count() - 1);

            return $it->current();
        }

        return false;
    }
}
