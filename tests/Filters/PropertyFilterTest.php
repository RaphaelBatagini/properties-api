<?php

use App\DTO\PropertyDTO;
use App\Filters\PropertyFilter;
use PHPUnit\Framework\TestCase;

final class PropertyFilterTest extends TestCase
{
    protected $properties;

    protected function setUp(): void
    {
        $json = json_decode('[
          {
            "usableAreas": 70,
            "listingType": "USED",
            "createdAt": "2017-04-22T18:39:31.138Z",
            "listingStatus": "ACTIVE",
            "id": "7baf2775d4a2",
            "parkingSpaces": 1,
            "updatedAt": "2017-04-22T18:39:31.138Z",
            "owner": false,
            "images": [
              "http://grupozap-code-challenge.s3-website-us-east-1.amazonaws.com/images/pic10.jpg",
              "http://grupozap-code-challenge.s3-website-us-east-1.amazonaws.com/images/pic5.jpg",
              "http://grupozap-code-challenge.s3-website-us-east-1.amazonaws.com/images/pic14.jpg",
              "http://grupozap-code-challenge.s3-website-us-east-1.amazonaws.com/images/pic1.jpg",
              "http://grupozap-code-challenge.s3-website-us-east-1.amazonaws.com/images/pic4.jpg"
            ],
            "address": {
              "city": "",
              "neighborhood": "",
              "geoLocation": {
                "precision": "NO_GEOCODE",
                "location": {
                  "lon": 0,
                  "lat": 0
                }
              }
            },
            "bathrooms": 1,
            "bedrooms": 2,
            "pricingInfos": {
              "yearlyIptu": "60",
              "price": "276000",
              "businessType": "SALE",
              "monthlyCondoFee": "0"
            }
          },
          {
            "usableAreas": 69,
            "listingType": "USED",
            "createdAt": "2016-11-16T04:14:02Z",
            "listingStatus": "ACTIVE",
            "id": "a0f9d9647551",
            "parkingSpaces": 1,
            "updatedAt": "2016-11-16T04:14:02Z",
            "owner": false,
            "images": [
              "http://grupozap-code-challenge.s3-website-us-east-1.amazonaws.com/images/pic9.jpg",
              "http://grupozap-code-challenge.s3-website-us-east-1.amazonaws.com/images/pic18.jpg",
              "http://grupozap-code-challenge.s3-website-us-east-1.amazonaws.com/images/pic1.jpg",
              "http://grupozap-code-challenge.s3-website-us-east-1.amazonaws.com/images/pic5.jpg",
              "http://grupozap-code-challenge.s3-website-us-east-1.amazonaws.com/images/pic8.jpg"
            ],
            "address": {
              "city": "",
              "neighborhood": "",
              "geoLocation": {
                "precision": "ROOFTOP",
                "location": {
                  "lon": -46.659002,
                  "lat": -23.553518
                }
              }
            },
            "bathrooms": 2,
            "bedrooms": 3,
            "pricingInfos": {
              "yearlyIptu": "0",
              "price": "405000",
              "businessType": "SALE",
              "monthlyCondoFee": "495"
            }
          }
        ]');

        $this->properties = array_map(function ($propertyArray) {
            return new PropertyDTO($propertyArray);
        }, $json);
    }

    public function testShouldRemovePropertyWithNoLatLon(): void
    {
        $filter = new PropertyFilter(new ArrayIterator($this->properties));
        $this->assertCount(1, iterator_to_array($filter));
    }
}