<?php 
namespace App\Models;

use App\Core\Models;

class OrderItem extends Models
{
    protected $table = 'order_items';

    function get($field, $value, $table = null) {
        $data = parent::get($field, $value);
        $data['order'] = parent::get('id', $data['order_id'], 'orders');
        $data['product'] = parent::get('id', $data['product_id'], 'products');

        return $data;
    }

    function filter(array $filers = [], $table = null) {
        $data = parent::filter($filers);

        foreach($data as $key => $item) {
            $data[$key]['order'] = parent::get('id', $item['order_id'], 'orders');
            $data[$key]['product'] = parent::get('id', $item['product_id'], 'products');
        }

        return $data;
    }
}
