<?php

namespace App\Collections;

use App\Collections\Collection;

class PropertiesCollection extends Collection
{
    public function paginate($offset = 0)
    {
        $iterator = parent::paginate($offset);

        $properties = [];
        foreach ($iterator as $property) {
            $properties[] = $property->toArray();
        }

        return $properties;
    }
}
