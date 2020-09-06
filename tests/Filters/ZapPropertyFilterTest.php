<?php

use App\DTO\PropertyDTO;
use App\Filters\ZapPropertyFilter;
use PHPUnit\Framework\TestCase;

final class ZapPropertyFilterTest extends TestCase
{
    protected $properties;

    protected function setUp(): void
    {
        $property = new stdClass();
        $property->usableAreas = 70;
        $property->listingType = 'USED';
        $property->createdAt = '2017-04-22T18:39:31.138Z';
        $property->listingStatus = 'ACTIVE';
        $property->id = '7baf2775d4a2';
        $property->parkingSpaces = 1;
        $property->updatedAt = '2017-04-22T18:39:31.138Z';
        $property->owner = false;
        $property->address = new stdClass();
        $property->address->city = '';
        $property->address->neighborhood = '';
        $property->address->geoLocation = new stdClass();
        $property->address->geoLocation->precision = 'NO_GEOCODE';
        $property->address->geoLocation->location = new stdClass();
        $property->address->geoLocation->location->lon = PropertyDTO::BOUNDING_BOX_MAX_LON;
        $property->address->geoLocation->location->lat = PropertyDTO::BOUNDING_BOX_MAX_LAT;
        $property->bathrooms = 1;
        $property->bedrooms = 2;
        $property->pricingInfos = new stdClass();
        $property->pricingInfos->yearlyIptu = 60;
        $property->pricingInfos->price = 276000;
        $property->pricingInfos->businessType = PropertyDTO::TYPE_SALE;
        $property->pricingInfos->monthlyCondoFee = 0;

        $this->properties[] = new PropertyDTO($property);
    }

    public function testRemoveSalePropertyWhenIsNotInBoundBoxAndPriceIsLessThanMinumum(): void
    {
        $this->properties[0]
            ->getPricingInfos()
            ->price = ZapPropertyFilter::MIN_SALE_VALUE - 1;
        
        $location = $this->properties[0]
            ->getAddress()
            ->geoLocation
            ->location;

        $location->lon = PropertyDTO::BOUNDING_BOX_MAX_LON;
        $location->lat = PropertyDTO::BOUNDING_BOX_MAX_LAT - 1;

        $filter = new ZapPropertyFilter(new ArrayIterator($this->properties));
        $this->assertEmpty(iterator_to_array($filter));
    }

    public function testKeepSalePropertyWhenIsInBoundBoxAndPriceIsLessThanMinumum(): void
    {
        $this->properties[0]
            ->getPricingInfos()
            ->price = ZapPropertyFilter::MIN_SALE_VALUE - 1;
        
        $location = $this->properties[0]
            ->getAddress()
            ->geoLocation
            ->location;

        $location->lon = PropertyDTO::BOUNDING_BOX_MAX_LON;
        $location->lat = PropertyDTO::BOUNDING_BOX_MAX_LAT;

        $filter = new ZapPropertyFilter(new ArrayIterator($this->properties));
        $this->assertNotEmpty(iterator_to_array($filter));
    }

    public function testKeepRentPropertyWhenValueIsMoreThanMinimum(): void
    {
        $pricing = $this->properties[0]
            ->getPricingInfos();
            
        $pricing->businessType = PropertyDTO::TYPE_RENTAL;
        $pricing->rentalTotalPrice = ZapPropertyFilter::MIN_RENT_VALUE;

        $filter = new ZapPropertyFilter(new ArrayIterator($this->properties));
        $this->assertNotEmpty(iterator_to_array($filter));
    }

    public function testRemoveRentPropertyWhenValueIsLessThanMinimum(): void
    {
        $pricing = $this->properties[0]
            ->getPricingInfos();
            
        $pricing->businessType = PropertyDTO::TYPE_RENTAL;
        $pricing->rentalTotalPrice = ZapPropertyFilter::MIN_RENT_VALUE - 1;

        $filter = new ZapPropertyFilter(new ArrayIterator($this->properties));
        $this->assertEmpty(iterator_to_array($filter));
    }
}
