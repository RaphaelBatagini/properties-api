<?php

namespace App\Controllers;

use App\Controllers\Controller;

use App\Services\Properties;

class PropertiesController extends Controller 
{
    public function index($params)
    {
        if (empty($params['page'])) {
            $params['page'] = 0;
        } else {
            $params['page']--;
        }

        $properties = Properties::list($params['page']);

        foreach ($properties as $key => $value) {
            echo '<pre>';
            var_dump($key, $value);
            echo '</pre>';
        }
    }
}