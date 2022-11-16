<?php

use App\DTO\PropertyDTO;
use App\Filters\CompanyOnePropertyFilter;
use PHPUnit\Framework\TestCase;

final class VivaPropertyFilterTest extends TestCase
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
        $property->pricingInfos->price = 2140;
        $property->pricingInfos->rentalTotalPrice = 2596;
        $property->pricingInfos->businessType = PropertyDTO::TYPE_RENTAL;
        $property->pricingInfos->monthlyCondoFee = 456;

        $this->properties[] = new PropertyDTO($property);
    }

    public function testShouldKeepValidRentalProperty(): void
    {
        $filter = new CompanyOnePropertyFilter(new ArrayIterator($this->properties));
        $this->assertCount(1, iterator_to_array($filter));
    }

    public function testShouldRemoveNonNumericCondoFeeProperty(): void
    {
        $this->properties[0]->getPricingInfos()->monthlyCondoFee = 'hello world';
        $filter = new CompanyOnePropertyFilter(new ArrayIterator($this->properties));
        $this->assertEmpty(iterator_to_array($filter));
    }

    public function testShouldRemovePropertyWhenCondoFeeEqualZero(): void
    {
        $this->properties[0]->getPricingInfos()->monthlyCondoFee = 0;
        $filter = new CompanyOnePropertyFilter(new ArrayIterator($this->properties));
        $this->assertEmpty(iterator_to_array($filter));
    }

    public function testShouldRemovePropertyWhenCondoFeeExceedsMaximumValue(): void
    {
        $pricing = $this->properties[0]->getPricingInfos();
        $pricing->monthlyCondoFee = $pricing->rentalTotalPrice * 
            CompanyOnePropertyFilter::CONDO_FEE_MAX_VALUE_MULTIPLIER + 1;
        $filter = new CompanyOnePropertyFilter(new ArrayIterator($this->properties));
        $this->assertEmpty(iterator_to_array($filter));
    }

    public function testShouldKeepSalePropertyWhenPriceIsUnderMaximumValue(): void
    {
        $pricing = $this->properties[0]->getPricingInfos();
        $pricing->businessType = PropertyDTO::TYPE_SALE;
        $pricing->price = CompanyOnePropertyFilter::MAX_SALE_VALUE;

        $filter = new CompanyOnePropertyFilter(new ArrayIterator($this->properties));
        $this->assertCount(1, iterator_to_array($filter));
    }

    public function testShouldRemoveSalePropertyWhenPriceIsExceedsMaximumValue(): void
    {
        $pricing = $this->properties[0]->getPricingInfos();
        $pricing->businessType = PropertyDTO::TYPE_SALE;
        $pricing->price = CompanyOnePropertyFilter::MAX_SALE_VALUE + 1;

        $filter = new CompanyOnePropertyFilter(new ArrayIterator($this->properties));
        $this->assertEmpty(iterator_to_array($filter));
    }
}
