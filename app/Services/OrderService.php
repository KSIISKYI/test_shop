<?php

namespace App\Services;

use App\Models\{Order, OrderItem};
use App\Core\Request;

class OrderService
{
    static public function getOrders()
    {
        $order_model = new Order;

        return array_reverse($order_model->filter());
    }

    static public function createOrder(Request $request)
    {
        $order_model = new Order;
        $data = [
            'total' => $request->data['total'],
            'delivery_region' => $request->data['delivery_region'],
            'delivery_city' => $request->data['delivery_city'],
            'delivery_address' => $request->data['delivery_address'],
            'post_code' => $request->data['post_code'],
            'shipper_id' => $request->data['shipper_id']
        ];

        if ($user = $request->user) {
            $data['user_id'] = $user['id'];
        }

        $new_order = $order_model->create($data);

        foreach($request->data['products'] as $product) {
            $product = json_decode($product);
            
            ProductService::updateQuantity($product->product_id, -$product->quantity);
            self::createOrederItem($new_order['id'], $product->product_id, $product->quantity);
        }
    }

    static public function updateOrder(Request $request)
    {
        $order_model = new Order;
        $data = [
            'total' => $request->data['total'],
            'delivery_region' => $request->data['delivery_region'],
            'delivery_city' => $request->data['delivery_city'],
            'delivery_address' => $request->data['delivery_address'],
            'post_code' => $request->data['post_code'],
            'shipper_id' => $request->data['shipper_id']
        ];

        if ($user = $request->user) {
            $data['user_id'] = $user['id'];
        }

        $order = $order_model->update($request->matches['order_id'], $data);
        self::removeOrderItems($order['id']);

        foreach($request->data['products'] as $product) {
            $product = json_decode($product);
            
            ProductService::updateQuantity($product->product_id, -$product->quantity);
            self::createOrederItem($order['id'], $product->product_id, $product->quantity);
        }
    }

    static public function removeOrder($order_id)
    {
        $order_model = new Order;
        
        self::removeOrderItems($order_id);
        $order_model->delete('id', $order_id);
    }

    static public function createOrederItem($order_id, $product_id, $quantity)
    {
        $order_item_model = new OrderItem;

        $order_item_model->create(compact('order_id', 'product_id', 'quantity'));
    }

    static public function removeOrderItems($order_id)
    {
        $order_item_model = new OrderItem;
        $order_items = $order_item_model->filter(['order_id' => $order_id]);

        foreach($order_items as $order_item) {
            ProductService::updateQuantity($order_item['product']['id'], $order_item['quantity']);
            $order_item_model->delete('id', $order_item['id']);
        }

    }
}
