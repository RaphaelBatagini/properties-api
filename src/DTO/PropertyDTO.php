<?php

namespace App\DTO;

class PropertyDTO
{
    const TYPE_RENTAL = 'RENTAL';
    const TYPE_SALE = 'SALE';

    const BOUNDING_BOX_MIN_LON = -46.693419;
    const BOUNDING_BOX_MAX_LON = -46.641146;
    const BOUNDING_BOX_MIN_LAT = -23.568704;
    const BOUNDING_BOX_MAX_LAT = -23.546686;

    private $property;

    public function __construct($property)
    {
        $this->property = (array) $property;
    }
    
    function __call($name, $arguments) {
        if (strpos($name, 'get') !== false) {
            $attr = lcfirst(str_replace('get', '', $name));
            return $this->property[$attr];
        }
    }

    public function getUsableAreaValue()
    {
        $usableAreaValue = $this->getPricingInfos()->price / $this->getUsableAreas();
        return round($usableAreaValue, 2);
    }

    public function toArray()
    {
        return $this->property;
    }

    public function isInBoundBox()
    {
        $location = $this->getAddress()
            ->geoLocation
            ->location;

        return $location->lon >= self::BOUNDING_BOX_MIN_LON
            && $location->lon <= self::BOUNDING_BOX_MAX_LON
            && $location->lat >= self::BOUNDING_BOX_MIN_LAT
            && $location->lat <= self::BOUNDING_BOX_MAX_LAT;
    }

    private function isAvailableFor($businessType)
    {
        return strpos($this->getPricingInfos()->businessType, $businessType) !== false;
    }

    public function isAvailableForSale()
    {
        return $this->isAvailableFor(self::TYPE_SALE);
    }

    public function isAvailableForRent()
    {
        return $this->isAvailableFor(self::TYPE_RENTAL);
    }
}