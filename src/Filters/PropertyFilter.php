<?php

namespace App\Filters;

use FilterIterator;
use Iterator;

class PropertyFilter extends FilterIterator
{
    const TYPE_RENTAL = 'RENTAL';
    const TYPE_SALE = 'SALE';

    public function accept()
    {
        $address = $this->getInnerIterator()
            ->current()
            ->getAddress();

        return $address->geoLocation->location->lon !== 0
            && $address->geoLocation->location->lat !== 0;
    }
}