<?php
declare(strict_types=1);

namespace ResultSet\Concerns\Filtering;

trait Search
{
    /**
     * Searches all fields in all elements
     *
     * @param string $searchPhrase to search for
     * @param boolean $caseSensitive option to search case sensitive - deafault false
     *
     * @return static
     */
    public function search($searchPhrase, $caseSensitive = false)
    {
        $results = [];

        foreach ($this as $item) {
            $data = static::convertToString($item);

            if ($caseSensitive) {
                if (strpos($data, $searchPhrase) !== false) {
                    $results[] = $item;
                }
            } else {
                if (stripos($data, $searchPhrase) !== false) {
                    $results[] = $item;
                }
            }
        }

        return new static($results);
    }
}
