<?php

namespace App\Controllers;

use App\Controllers\Controller;

class IndexController extends Controller 
{
    public function index()
    {
        echo '<h1>Grupo Zap</h1>';
        echo '<p>API que atende a regras de negócio pré-estabelecidas visando separar uma lista de imóveis entre os elegíveis para o Zap e Viva Real.</p>';
    }
}