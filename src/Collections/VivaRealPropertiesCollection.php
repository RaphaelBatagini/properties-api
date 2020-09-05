<?php

namespace App\Collections;

use ArrayIterator;
use App\Iterators\VivaRealPropertyFilter;

class VivaRealPropertiesCollection extends PropertiesCollection
{
    public function getIterator()
    {
        return new VivaRealPropertyFilter(new ArrayIterator($this->items));
    }

    public function count()
    {
        return iterator_count($this->getIterator());
    }
}
