<?php
declare(strict_types=1);

namespace ResultSet\Concerns\Operations;

trait Ops
{
    /**
     * Allows a supplied function to be run against
     * each item in ResultSet
     *
     * Note to include or return other parameters in the closure
     * append the $function structure with "use ($myParameterName)"
     * Also pass by address (&) if the parameter is to be mutated
     *
     * @param string $paramName - name of argument of function
     * @param \Closure $function - a closure function
     *
     * @return static
     */
    public function each($paramName, $function)
    {
        foreach ($this as $$paramName) {
            $function($$paramName);
        }

        return $this;
    }

    /**
     * Calls method specified on each item in ResultSet
     * Note that the method will ignore any item that
     * does not support the method passed without error!
     *
     * @param string $method name in item to call
     *
     * @return static
     */
    public function callMethod($method)
    {
        foreach ($this as $item) {
            if (method_exists($item, $method)) {
                $item->$method();
            }
        }

        return $this;
    }

    /**
     * Returns the first element in the ResultSet
     *
     * @return mixed
     */
    public function first()
    {
        $iterator = $this->getIterator();
        return $iterator->current();
    }
}
