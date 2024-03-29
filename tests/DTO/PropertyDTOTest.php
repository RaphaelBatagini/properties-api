<?php

use App\DTO\PropertyDTO;
use PHPUnit\Framework\TestCase;

final class PropertyDTOTest extends TestCase
{
    protected $property;
    protected $propertyDto;

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

        $this->property = $property;
        $this->propertyDto = new PropertyDTO($property);
    }

    public function testCanCalcUsableAreaValue(): void
    {
        $this->assertEquals(3942.86, $this->propertyDto->getUsableAreaValue());
    }

    public function testShouldReturnArray(): void
    {
        $this->assertEquals((array) $this->property, $this->propertyDto->toArray());
    }

    public function testIsInBoundingBoxTrueWhenCoordinatesAreAtRange(): void
    {
        $location = $this->propertyDto
            ->getAddress()
            ->geoLocation
            ->location;

        $location->lon = PropertyDTO::BOUNDING_BOX_MIN_LON;
        $location->lat = PropertyDTO::BOUNDING_BOX_MIN_LAT;

        $this->assertTrue($this->propertyDto->isInBoundingBox());
    }

    public function testIsInBoundingBoxFalseWhenLongitudeLessThanMinimum(): void
    {
        $location = $this->propertyDto
            ->getAddress()
            ->geoLocation
            ->location;

        $location->lon = PropertyDTO::BOUNDING_BOX_MIN_LON - 1;
        $location->lat = PropertyDTO::BOUNDING_BOX_MIN_LAT;

        $this->assertFalse($this->propertyDto->isInBoundingBox());
    }

    public function testIsInBoundingBoxFalseWhenLatitudeLessThanMinimum(): void
    {
        $location = $this->propertyDto
            ->getAddress()
            ->geoLocation
            ->location;

        $location->lon = PropertyDTO::BOUNDING_BOX_MIN_LON;
        $location->lat = PropertyDTO::BOUNDING_BOX_MIN_LAT - 1;

        $this->assertFalse($this->propertyDto->isInBoundingBox());
    }

    public function testIsInBoundingBoxFalseWhenLongitudeMoreThanMaximum(): void
    {
        $location = $this->propertyDto
            ->getAddress()
            ->geoLocation
            ->location;

        $location->lon = PropertyDTO::BOUNDING_BOX_MIN_LON + 1;
        $location->lat = PropertyDTO::BOUNDING_BOX_MAX_LAT;

        $this->assertFalse($this->propertyDto->isInBoundingBox());
    }

    public function testIsInBoundingBoxFalseWhenLatitudeMoreThanMaximum(): void
    {
        $location = $this->propertyDto
            ->getAddress()
            ->geoLocation
            ->location;

        $location->lon = PropertyDTO::BOUNDING_BOX_MIN_LON;
        $location->lat = PropertyDTO::BOUNDING_BOX_MAX_LAT + 1;

        $this->assertFalse($this->propertyDto->isInBoundingBox());
    }

    public function testIsAvailableForBusinessTypeSale()
    {
        $this->propertyDto->getPricingInfos()->businessType = PropertyDTO::TYPE_SALE;

        $this->assertTrue($this->propertyDto->isAvailableForSale());
        $this->assertFalse($this->propertyDto->isAvailableForRent());
    }

    public function testIsAvailableForBusinessTypeRental()
    {
        $this->propertyDto->getPricingInfos()->businessType = PropertyDTO::TYPE_RENTAL;
        $this->assertFalse($this->propertyDto->isAvailableForSale());
        $this->assertTrue($this->propertyDto->isAvailableForRent());
    }

    public function testIsAvailableForBothBusinessTypes()
    {
        $this->propertyDto
            ->getPricingInfos()
            ->businessType = PropertyDTO::TYPE_RENTAL . '|' . PropertyDTO::TYPE_SALE;
        $this->assertTrue($this->propertyDto->isAvailableForSale());
        $this->assertTrue($this->propertyDto->isAvailableForRent());
    }
}
