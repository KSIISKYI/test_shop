<?php 
namespace App\Models;

use App\Core\Models;

class Cart extends Models
{
    protected $table = 'carts';

    function get($field, $value, $table = null) {
        $data = parent::get($field, $value);
        if ($data) {
            $data['cart_items'] = parent::filter(['cart_id' => $data['id']], 'cart_items');
        }
    
        return $data;
    }

    function filter(array $filers = [], $table = null) {
        $data = parent::filter($filers);

        foreach($data as $key => $item) {
            $data[$key]['cart_items'] = parent::filter(['cart_id' => $item['id']], 'cart_items');
        }

        return $data;
    }
}
