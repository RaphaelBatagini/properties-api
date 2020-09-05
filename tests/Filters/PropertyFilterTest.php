<?php

use App\DTO\PropertyDTO;
use App\Filters\PropertyFilter;
use PHPUnit\Framework\TestCase;

final class PropertyFilterTest extends TestCase
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
        $property->address->geoLocation->location->lon = 0;
        $property->address->geoLocation->location->lat = 0;
        $property->bathrooms = 1;
        $property->bedrooms = 2;
        $property->pricingInfos = new stdClass();
        $property->pricingInfos->yearlyIptu = 60;
        $property->pricingInfos->price = 276000;
        $property->pricingInfos->businessType = 'SALE';
        $property->pricingInfos->monthlyCondoFee = 0;

        $this->properties[] = new PropertyDTO($property);
    }

    public function testShouldRemovePropertyWithNoLatLon(): void
    {
        $filter = new PropertyFilter(new ArrayIterator($this->properties));
        $this->assertEmpty(iterator_to_array($filter));
    }

    public function testShouldKeepPropertyWithLatLon(): void
    {
        $location = $this->properties[0]
            ->getAddress()
            ->geoLocation
            ->location;

        $location->lon = -46.659002;
        $location->lat = -23.553518;

        $filter = new PropertyFilter(new ArrayIterator($this->properties));
        $this->assertCount(1, iterator_to_array($filter));
    }
}
