<?php 
namespace App\Models;

use App\Core\Models;

class Cart extends Models
{
    protected $table = 'carts';

    function get($field, $value, $table = null) {
        $data = parent::get($field, $value);
        // $data['user'] = parent::get('id', $data['user_id'], 'users');
        $data['cart_items'] = parent::filter(['cart_id' => $data['id']], 'cart_items');

        return $data;
    }

    function filter(array $filers = [], $table = null) {
        $data = parent::filter($filers);

        foreach($data as $key => $item) {
            // $data[$key]['user'] = parent::get('id', $item['user_id'], 'users');
            $data[$key]['cart_items'] = parent::filter(['cart_id' => $item['id']], 'cart_items');
        }

        return $data;
    }
}
