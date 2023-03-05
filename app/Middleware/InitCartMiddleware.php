<?php

namespace App\Middleware;

use App\Core\{Middleware, Request};
use App\Models\Cart;

class InitCartMiddleware extends Middleware
{
    function handle(Request $request)
    {
        $cart_model = new Cart;
        $new_cart = $cart_model->create([]);
    }
}
