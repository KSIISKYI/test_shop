<?php 
namespace App\Models;

use App\Core\Models;

class Product extends Models
{
    protected $table = 'products';

    function get($field, $value, $table = null) {
        $data = parent::get($field, $value);
        $data['category'] = parent::get('id', $data['category_id'], 'categories');
        $data['product_images'] = parent::filter(['product_id' => $data['id']], 'product_images');

        return $data;
    }

    function filter(array $filers = [], $table = null) {
        $data = parent::filter($filers);

        foreach($data as $key => $item) {
            $data[$key]['category'] = parent::get('id', $item['category_id'], 'categories');
            $data[$key]['product_images'] = parent::filter(['product_id' => $item['id']], 'product_images');
        }

        return $data;
    }
}
