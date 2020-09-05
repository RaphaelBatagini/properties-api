<?php

namespace App\Collections;

use App\Filters\ZapPropertyFilter;

class ZapPropertiesCollection extends PropertiesCollection
{
    public function getIterator()
    {
        return new ZapPropertyFilter(parent::getIterator());
    }

    public function count()
    {
        return iterator_count($this->getIterator());
    }
}
