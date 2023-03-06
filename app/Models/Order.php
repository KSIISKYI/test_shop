<?php 
namespace App\Models;

use App\Core\Models;

class Order extends Models
{
    protected $table = 'orders';

    function get($field, $value, $table = null) {
        $order_model = new OrderItem;

        $data = parent::get($field, $value);
        $data['user'] = parent::get('id', $data['user_id'], 'users');
        $data['order_items'] = $order_model->filter(['order_id' => $data['id']], 'order_items');
        $data['shipper'] = parent::get('id', $data['shipper_id'], 'shippers');

        return $data;
    }

    function filter(array $filers = [], $table = null) {
        $data = parent::filter($filers);

        foreach($data as $key => $item) {
            $data[$key]['user'] = parent::get('id', $item['user_id'], 'users');
            $data[$key]['shipper'] = parent::get('id', $item['shipper_id'], 'shippers');
        }

        return $data;
    }
}
