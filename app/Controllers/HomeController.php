<?php

namespace App\Controllers;

class HomeController extends BaseController
{
    public function index()
    {
        return $this->twig->render('home/home.html.twig');
    }
}
