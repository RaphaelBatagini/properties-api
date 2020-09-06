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
        $this->returnJson(Properties::list($page, $portal));
    }
}