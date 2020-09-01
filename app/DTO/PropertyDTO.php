<?php

namespace App\DTO;

class PropertyDTO
{
    public function __construct($property)
    {
        $this->address = $property->address;
        $this->bathrooms = $property->bathrooms;
        $this->bedrooms = $property->bedrooms;
        $this->createdAt = $property->createdAt;
        $this->id = $property->id;
        $this->images = $property->images;
        $this->listingStatus = $property->listingStatus;
        $this->listingType = $property->listingType;
        $this->owner = $property->owner;
        $this->parkingSpaces = $property->parkingSpaces;
        $this->pricingInfos = $property->pricingInfos;
        $this->updatedAt = $property->updatedAt;
        $this->usableAreas = $property->usableAreas;
    }

    function __get($prop) {
        $prop = lcfirst($prop);
        return $this->$prop;
    }
}