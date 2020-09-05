<?php

namespace App\DTO;

class PropertyDTO
{
    private $property;

    public function __construct($property)
    {
        $this->property = (array) $property;
    }
    
    function __call($name, $arguments) {
        if (strpos($name, 'get') !== false) {
            $attr = lcfirst(str_replace('get', '', $name));
            return $this->property[$attr];
        }
    }

    public function getUsableAreaValue()
    {
        return $this->getPricingInfos()->price / $this->getUsableAreas();
    }

    public function toArray()
    {
        return $this->property;
    }
}