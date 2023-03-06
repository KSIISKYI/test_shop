<?php

namespace App\Services;

use App\Models\{Product, ProductImage};

class ProductImageService
{
    static private function generateProductName(array $product, $index)
    {
        if ($product['product_images']) {
            return $product['id'] . '/' . count($product['product_images']) + $index . '.jpeg';
        }

        return $product['id'] . '/' .$index . '.jpeg';
    }

    static public function createProductImg($product_id, $path)
    {
        $product_image_model = new ProductImage;

        $product_image_model->create(compact('product_id', 'path'));
    }

    static public function saveProfileImgs(array $product, array $files)
    {
        for($i = 0; $i < count($files['product_imgs']['tmp_name']); $i++) {
            if ($files['product_imgs']['tmp_name'][$i]) {
                $product_img_name = self::generateProductName($product, $i + 1);
                self::createProductImg($product['id'], $product_img_name);

                move_uploaded_file($files['product_imgs']['tmp_name'][$i], 'img/product_images/' . $product_img_name);
            } 
        }
    }
}
