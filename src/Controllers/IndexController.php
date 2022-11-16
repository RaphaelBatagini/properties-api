<?php

namespace App\Controllers;

use App\Controllers\Controller;

class IndexController extends Controller 
{
    public function index()
    {
        echo '<h1>Properties REST API</h1>';
        echo '<p>API to split a list of properties between two Real State Companies (CompanyOne and Company Two) following some rules.</p>';
    }

    public function error($params)
    {
        echo '<h1>Ops! Looks like something went wrong.</h1>';
        if (!empty($params['errcode'])) {
            echo "<p>Error Code: {$params['errcode']}</p>";
        }
    }
}