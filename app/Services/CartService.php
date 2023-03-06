<?php

namespace App\Services;

use App\Models\CartItem;
use App\Core\Request;

class CartService
{
    static public function getCartItems($cart_id)
    {
        $cart_item_model = new CartItem;

        return $cart_item_model->filter(['cart_id' => $cart_id]);
    }

    static public function createCartItem(Request $request)
    {
        $cart_item_model = new CartItem;

        if (count($cart_item_model->filter(['cart_id' => $request->cart['id']])) < 20) {
            $cart_item_model->create([
                'cart_id' => $request->cart['id'],
                'product_id' => $request->data['product_id'],
                'quantity' => $request->data['quantity'],
            ]);

            return ['result' => 1];
        }

        return ['result' => 0];
    }

    static public function removeCartItem(Request $request)
    {
        $cart_item_model = new CartItem;

        if ($cart_item_model->filter(['cart_id' => $request->cart['id'], 'id' => $request->matches['cart_item_id']])) {
            $cart_item_model->delete('id', $request->matches['cart_item_id']);
        } 
    }
}
