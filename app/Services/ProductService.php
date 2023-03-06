<?php

namespace App\Services;

use App\Models\Product;
use App\Core\Request;

class ProductService
{
    public static function validateProductForm(array $data)
    {
        $validator = require __DIR__ . '/../Validation/validator.php';

        $validation = $validator->make($data, [
            'name' => 'required|min:6|max:60',
            'category_id' => 'required|numeric',
            'guest_price' => 'required|numeric',
            'price' => 'required|numeric',
            'quantity_in_stock' => 'required|numeric'
        ]);

        $validation->validate();

        if ($validation->fails()) {
            return $validation->errors()->toArray();
        }
    }

    static public function getProducts(Request $request, array $filters = [])
    {
        $product_model = new Product;

        if (isset($_SESSION['user_id'])) {
            return $product_model->filter($filters); 
        }

        $filters['for_authorized'] = 0;

        return $product_model->filter($filters);
    }

    static public function getProduct($product_id)
    {
        $product_model = new Product;

        return $product_model->get('id', $product_id);
    }

    static public function createProduct(Request $request)
    {
        $product_model = new Product;
        isset($request->data['for_authorized']) ? $request->data['for_authorized'] = 1 : null;
        $new_product = $product_model->create($request->data);
        mkdir('img/product_images/' . $new_product['id'], 0777);
        ProductImageService::saveProfileImgs($new_product, $request->files);

        return $new_product;
    }

    static public function updateProduct($product_id, Request $request)
    {
        $product_model = new Product;
        isset($data['for_authorized']) ? $data['for_authorized'] = 1 : null;

        $product = $product_model->update($product_id, $request->data);
        ProductImageService::saveProfileImgs($product, $request->files);
    }

    static private function deleteProductDir($product_id)
    {
        array_map('unlink', glob("img/product_images/$product_id/*.*"));
        rmdir('img/product_images/' . $product_id);
    }

    static public function removeProduct(Request $request)
    {
        $product_model = new Product;
        self::deleteProductDir($request->matches['product_id']);
        $product_model->delete('id', $request->matches['product_id']);
    }

    static public function updateQuantity($product_id, $order_quantity)
    {
        $product_model = new Product;
        $product = $product_model->get('id', $product_id);
        
        $product_model->update($product_id, ['quantity_in_stock' => $product['quantity_in_stock'] + $order_quantity]);
    }
}
