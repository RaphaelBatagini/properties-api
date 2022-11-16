<?php

namespace App\Controllers;

use App\Controllers\Controller;

class IndexController extends Controller 
{
    public function index()
    {
        echo '<h1>Grupo CompanyTwo</h1>';
        echo '<p>API que atende a regras de negócio pré-estabelecidas visando separar uma lista de imóveis entre os elegíveis para o CompanyTwo e Viva Real.</p>';
    }

    public function error($params)
    {
        echo '<h1>Ops! Parece que algo deu errado.</h1>';
        if (!empty($params['errcode'])) {
            echo "<p>Error Code: {$params['errcode']}</p>";
        }
    }
}