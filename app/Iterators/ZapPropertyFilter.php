<?php

namespace App\Iterators;

use Iterator;

class ZapPropertyFilter extends PropertyFilter
{
    public function __construct(Iterator $iterator)
    {
        $this->minimumSaleValue = 600000;
        $this->minimumRentValue = 3500;
        $this->minimumUsableAreasValue = 3500;

        parent::__construct($iterator);
    }

    public function accept()
    {
        return $this->isValidForRent() || $this->isValidForSale();
    }

    private function isValidForRent()
    {
        $pricing = $this->getInnerIterator()
            ->current()
            ->getPricingInfos();

        return strpos($pricing->businessType, self::TYPE_RENTAL) !== false 
            && $pricing->rentalTotalPrice >= $this->minimumRentValue;
    }

    private function isValidForSale()
    {
        $current = $this->getInnerIterator()
            ->current();

        if (
            strpos($current->getPricingInfos()->businessType, self::TYPE_SALE) === false
            || $current->getUsableAreas() == 0
        ) {
            return false;
        }

        $minimumValue = $this->minimumSaleValue;

        if ($this->isInBoundBox()) {
            $minimumValue = $this->minimumSaleValue * 0.9;
        }

        $validPrice = $current->getPricingInfos()->price >= $minimumValue;
        
        $usableAreaValue = $current->getPricingInfos()->price / $current->getUsableAreas();
        $validUsableAreas = $usableAreaValue > $this->minimumUsableAreasValue;
        
        return $validPrice && $validUsableAreas;
    }
}
