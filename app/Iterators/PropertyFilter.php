<?php

namespace App\Iterators;

use FilterIterator;

class PropertyFilter extends FilterIterator
{
    protected $minimumSaleValue;
    protected $minimumRentValue;
    protected $minimumUsableAreasValue;
    protected $boundingBoxMinimumLongitude;
    protected $boundingBoxMaximumLongitude;
    protected $boundingBoxMinimumLatitude;
    protected $boundingBoxMaximumLatitude;

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

    protected function isInBoundBox()
    {
        $location = $this->getInnerIterator()
            ->current()
            ->getAddress()
            ->geoLocation
            ->location;

        return $location->lon >= $this->boundingBoxMinimumLongitude
            && $location->lon <= $this->boundingBoxMaximumLongitude
            && $location->lat >= $this->boundingBoxMinimumLatitude
            && $location->lat <= $this->boundingBoxMaximumLatitude;
    }
}