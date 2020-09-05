<?php

namespace App\Collections;

use ArrayIterator;
use App\Iterators\ZapPropertyFilter;

class ZapPropertiesCollection extends PropertiesCollection
{
    public function getIterator()
    {
        return new ZapPropertyFilter(new ArrayIterator($this->items));
    }

    public function count()
    {
        return iterator_count($this->getIterator());
    }
}
