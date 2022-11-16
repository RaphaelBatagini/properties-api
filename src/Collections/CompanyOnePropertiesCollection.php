<?php

namespace App\Collections;

use App\Filters\CompanyOnePropertyFilter;

class CompanyOnePropertiesCollection extends PropertiesCollection
{
    public function getIterator()
    {
        return new CompanyOnePropertyFilter(parent::getIterator());
    }

    public function count()
    {
        return iterator_count($this->getIterator());
    }
}
