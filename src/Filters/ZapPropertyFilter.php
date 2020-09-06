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
        $pricing = $this->getInnerIterator()
            ->current()
            ->getPricingInfos();

        return strpos($pricing->businessType, self::TYPE_RENTAL) !== false 
            && $pricing->rentalTotalPrice >= self::MIN_RENT_VALUE;
    }

    private function isValidForSale()
    {
        $current = $this->getInnerIterator()
            ->current();

        if (
            strpos($current->getPricingInfos()->businessType, self::TYPE_SALE) === false
            || $current->getUsableAreas() === 0
        ) {
            return false;
        }

        $minimumValue = self::MIN_SALE_VALUE;

        if ($current->isInBoundBox()) {
            $minimumValue = self::inBoundBoxMinimumSaleValue();
        }

        $validPrice = $current->getPricingInfos()->price >= $minimumValue;

        $validUsableAreas = $current->getUsableAreaValue() > self::MIN_USABLE_AREAS_VALUE;
        
        return $validPrice && $validUsableAreas;
    }

    private static function inBoundBoxMinimumSaleValue()
    {
        return self::MIN_SALE_VALUE * self::SALE_VALUE_MULTIPLIER_FOR_IN_BOUND_BOX;
    }
}
