<?php

namespace App\Middleware;

use App\Core\{Middleware, Request};
use App\Models\Cart;

class InitCartMiddleware extends Middleware
{
    function handle(Request $request)
    {
        $cart_model = new Cart;
        if (!isset($_SESSION['cart_id']) || !$cart = $cart_model->get('id', $_SESSION['cart_id'])) {
            $cart = $cart_model->create([]);
            $request->cart = $cart;

        } else {
            $request->cart = $cart;
        }

        $_SESSION['cart_id'] = $cart['id'];

        return $request;
    }
}
