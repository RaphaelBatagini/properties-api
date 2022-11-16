<?php

namespace App\Collections;

use App\Filters\CompanyTwoPropertyFilter;

class CompanyTwoPropertiesCollection extends PropertiesCollection
{
    public function getIterator()
    {
        return new CompanyTwoPropertyFilter(parent::getIterator());
    }

    public function count()
    {
        return iterator_count($this->getIterator());
    }
}
