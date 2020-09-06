<?php

namespace App\Filters;

use FilterIterator;

class PropertyFilter extends FilterIterator
{
    public function accept()
    {
        $address = $this->getInnerIterator()
            ->current()
            ->getAddress();

        return $address->geoLocation->location->lon !== 0
            && $address->geoLocation->location->lat !== 0;
    }
}