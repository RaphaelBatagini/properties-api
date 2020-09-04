<?php

namespace App\Controllers;

use App\Controllers\Controller;

use App\Services\Properties;

class PropertiesController extends Controller 
{
    public function index($params)
    {
        $page = empty($params['page']) ? 0 : --$params['page'];
        $portal = empty($params['portal']) ? null : $params['portal'];

        $properties = Properties::list($page, $portal);

        foreach ($properties as $key => $value) {
            echo '<pre>';
            var_dump($key, $value);
            echo '</pre>';
        }
    }
}