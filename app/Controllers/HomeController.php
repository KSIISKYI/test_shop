<?php

namespace App\Controllers;

class HomeController extends \App\Core\Controller
{
    public function index()
    {
        return $this->view->render('home.twig');
    }
}
