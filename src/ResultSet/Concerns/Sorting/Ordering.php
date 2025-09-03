<?php
declare(strict_types=1);

namespace ResultSet\Concerns\Sorting;

trait Ordering
{
    /**
     * Returns the ResultSet ordered by $order and
     * optionally $subOrder
     *
     * @param string $order
     * @param string $subOrder Optional
     *
     * @return static
     */
    public function orderBy($order, $subOrder = '')
    {
        $this->uasort(function ($a, $b) use ($order, $subOrder) {
            $a_order = static::getItemFieldValue($a, $order);
            $b_order = static::getItemFieldValue($b, $order);

            if ($a_order == $b_order && strlen($subOrder) > 0) {
                $a_subOrder = static::getItemFieldValue($a, $subOrder);
                $b_subOrder = static::getItemFieldValue($b, $subOrder);
                return $a_subOrder <=> $b_subOrder;
            }
            return $a_order <=> $b_order;
        });

        $result = [];
        foreach ($this as $item) {
            $result[] = $item;
        }

        return static::getInstance($result);
    }

    /**
     * Wrapper for uasort
     *
     * @param callable $comparisonFunction to do sort
     *
     * @return static
     */
    public function sort($comparisonFunction)
    {
        $this->uasort($comparisonFunction);
        return $this;
    }
}
