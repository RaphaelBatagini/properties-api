<?php

namespace App\Filters;

class ZapPropertyFilter extends PropertyFilter
{
    const MIN_SALE_VALUE = 600000;
    const MIN_RENT_VALUE = 3500;
    const MIN_USABLE_AREAS_VALUE = 3500;
    const SALE_VALUE_MULTIPLIER_FOR_IN_BOUND_BOX = 0.9;

    public function accept()
    {
        return parent::accept() 
            && ($this->isValidForRent() || $this->isValidForSale());
    }

    private function isValidForRent()
    {
        $current = $this->getInnerIterator()
            ->current();

        return $current->isAvailableForRent()
            && $current->getPricingInfos()->rentalTotalPrice >= self::MIN_RENT_VALUE;
    }

    private function isValidForSale()
    {
        $current = $this->getInnerIterator()
            ->current();

        if (!$current->isAvailableForSale() || $current->getUsableAreas() === 0) {
            return false;
        }

        $validPrice = $current->getPricingInfos()->price >= $this->getMinimumSaleValue();

        $validUsableAreas = $current->getUsableAreaValue() > self::MIN_USABLE_AREAS_VALUE;
        
        return $validPrice && $validUsableAreas;
    }

    private function getMinimumSaleValue()
    {
        if ($this->getInnerIterator()->current()->isInBoundBox()) {
            return self::MIN_SALE_VALUE * self::SALE_VALUE_MULTIPLIER_FOR_IN_BOUND_BOX;
        }
        return self::MIN_SALE_VALUE;
    }
}
