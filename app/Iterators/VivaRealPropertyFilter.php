<?php

namespace App\Iterators;

use Iterator;

class VivaRealPropertyFilter extends PropertyFilter
{
    public function __construct(Iterator $iterator)
    {
        $this->maximumSaleValue = 700000;
        $this->maximumRentValue = 4000;
        $this->minimumUsableAreasValue = 3500;

        parent::__construct($iterator);
    }

    public function accept()
    {
        return parent::accept() 
            && ($this->isValidForRent() || $this->isValidForSale());
    }

    private function isValidForRent()
    {
        $pricing = $this->getInnerIterator()
            ->current()
            ->getPricingInfos();

        if (
            !is_numeric($pricing->monthlyCondoFee) 
            || $pricing->monthlyCondoFee == 0
        ) {
            return false;
        }

        if ($pricing->monthlyCondoFee > ($pricing->rentalTotalPrice * 0.3)) {
            return false;
        }

        $rentValue = $this->maximumRentValue;

        if ($this->isInBoundBox()) {
            $rentValue *= 1.5;
        }

        return strpos($pricing->businessType, self::TYPE_RENTAL) !== false 
            && $pricing->rentalTotalPrice <= $rentValue;
    }

    private function isValidForSale()
    {
        $pricing = $this->getInnerIterator()
            ->current()
            ->getPricingInfos();

        return strpos($pricing->businessType, self::TYPE_SALE) !== false
            && $pricing->price <= $this->maximumSaleValue;
    }
}
