<?php

namespace App\Basket\Collections;

use Illuminate\Database\Eloquent\Collection as EloquentCollection;

abstract class Collection extends EloquentCollection
{
    /**
     * Pushes the object to the collection for the given amount of times.
     *
     * @return self
     */
    public function pushMany($item, int $count = 1)
    {
        for ($n = 0; $n < $count; $n++) {
            $this->push($item);
        }

        return $this;
    }

    /**
     * Adds an item to the collection for the given number of times.
     *
     * @return self
     */
    public function addMany($item, int $count = 1)
    {
        for ($n = 0; $n < $count; $n++) {
            $this->add($item);
        }

        return $this;
    }
}
