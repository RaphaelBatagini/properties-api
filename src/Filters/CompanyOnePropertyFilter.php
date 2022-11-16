<?php

namespace App\Filters;

class CompanyOnePropertyFilter extends PropertyFilter
{
    const MAX_SALE_VALUE = 700000;
    const MAX_RENT_VALUE = 4000;
    const MIN_USABLE_AREA_VALUE = 3500;
    const RENT_VALUE_MULTIPLIER_FOR_IN_BOUND_BOX = 1.5;
    const CONDO_FEE_MAX_VALUE_MULTIPLIER = 0.3;

    public function accept()
    {
        return parent::accept() 
            && ($this->isValidForRent() || $this->isValidForSale());
    }

    private function isValidForRent()
    {
        $current = $this->getInnerIterator()->current();
        $pricing = $current->getPricingInfos();

        if (!$this->isValidMonthlyCondoFee()) {
            return false;
        }

        return $current->isAvailableForRent() 
            && $pricing->rentalTotalPrice <= $this->getMaximumRentValue();
    }

    private function isValidForSale()
    {
        $current = $this->getInnerIterator()
            ->current();

        return $current->isAvailableForSale()
            && $current->getPricingInfos()->price <= self::MAX_SALE_VALUE;
    }

    private function getMaximumRentValue()
    {
        if ($this->getInnerIterator()->current()->isInBoundingBox()) {
            return self::MAX_RENT_VALUE * self::RENT_VALUE_MULTIPLIER_FOR_IN_BOUND_BOX;
        }
        return self::MAX_RENT_VALUE;
    }

    private function isValidMonthlyCondoFee()
    {
        $pricing = $this->getInnerIterator()->current()->getPricingInfos();
        $condoFeeMaxValue = $pricing->rentalTotalPrice * 
            self::CONDO_FEE_MAX_VALUE_MULTIPLIER;

        if (
            !is_numeric($pricing->monthlyCondoFee) 
            || $pricing->monthlyCondoFee <= 0
            || $pricing->monthlyCondoFee > $condoFeeMaxValue
        ) {
            return false;
        }

        return true;
    }
}
