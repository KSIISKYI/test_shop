<?php

namespace App\Controllers;

use App\Core\{Controller};
use App\Models\{Category, Product, Cart};

class HomeController extends Controller
{
    public function index()
    {
        // $res = new Product;
        // echo '<pre>';
        // print_r($res->create([
        //     'name' => 'product123', 
        //     'description' => 'seme_text', 
        //     'category_id' => 1, 
        //     'guest_price' => 121,
        //     'price' => 100,
        //     'quantity_in_stock' => 12
        // ]));
        // echo '</pre>';
        return $this->view->render('home.twig');
    }
}
