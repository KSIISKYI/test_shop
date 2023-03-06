<?php

namespace App\Controllers;

use App\Models\Shipper;
use App\Services\CartService;

class CartController extends \App\Core\Controller
{
    public function show()
    {
        $shipper_model = new Shipper;
        $shippers = $shipper_model->filter();
        $cart = $this->request->cart;
        
        return $this->view->render('cart.twig', compact('cart', 'shippers'));
    }

    public function getCartItems()
    {
        $cart_items = CartService::getCartItems($this->request->cart['id']);

        header('Content-type: application/json');
        print_r(json_encode($cart_items));
    }

    public function createCartItem()
    {
        $result = CartService::createCartItem($this->request);

        header('Content-type: application/json');
        print_r(json_encode($result));
    }

    public function destroyCartItem()
    {
        CartService::removeCartItem($this->request);
    }
}
