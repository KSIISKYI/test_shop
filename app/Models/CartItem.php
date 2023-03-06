<?php 
namespace App\Models;

use App\Core\Models;

class CartItem extends Models
{
    protected $table = 'cart_items';

    function get($field, $value, $table = null) {
        $data = parent::get($field, $value);
        $data['cart'] = parent::get('id', $data['cart_id'], 'carts');
        $data['product'] = parent::get('id', $data['product_id'], 'products');

        return $data;
    }

    function filter(array $filers = [], $table = null) {
        $data = parent::filter($filers);

        foreach($data as $key => $item) {
            $data[$key]['cart'] = parent::get('id', $item['cart_id'], 'carts');
            $data[$key]['product'] = parent::get('id', $item['product_id'], 'products');
        }

        return $data;
    }
}
