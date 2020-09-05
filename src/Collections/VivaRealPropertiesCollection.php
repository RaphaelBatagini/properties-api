<?php

namespace App\Collections;

use App\Filters\VivaRealPropertyFilter;

class VivaRealPropertiesCollection extends PropertiesCollection
{
    public function getIterator()
    {
        return new VivaRealPropertyFilter(parent::getIterator());
    }

    public function count()
    {
        return iterator_count($this->getIterator());
    }
}
