<?php 
namespace App\Models;

use App\Core\Models;

class ProductImage extends Models
{
    protected $table = 'product_images';

    function get($field, $value, $table = null) {
        $data = parent::get($field, $value);
        $data['user'] = parent::get('id', $data['user_id'], 'users');

        return $data;
    }

    function filter(array $filers = [], $table = null) {
        $data = parent::filter($filers);

        foreach($data as $key => $item) {
            $data[$key]['user'] = parent::get('id', $item['user_id'], 'users');
        }

        return $data;
    }
}
