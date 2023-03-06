<?php

namespace App\Services;

use App\Models\Category;
use App\Core\Request;

class CategoryService
{
    static public function getCategories()
    {
        $category_model = new Category;

        return $category_model->filter();
    }

    static public function getCategory(int $id)
    {
        $category_model = new Category;

        return $category_model->get('id', $id);
    }

    static public function createCategory(array $data)
    {
        $category_model = new Category;

        return $category_model->create($data);
    }

    static public function validateCategoryForm(array $data)
    {
        $validator = require __DIR__ . '/../Validation/validator.php';

        $validation = $validator->make($data, [
            'name' => 'required|min:6|max:40'
        ]);

        $validation->validate();

        if ($validation->fails()) {
            return $validation->errors()->toArray();
        }
    }

    static public function updateCategory($category_id, array $data)
    {
        $category_model = new Category;
        $category_model->update($category_id, $data);
    }

    static public function removeCategory(Request $request)
    {
        $category_model = new Category;
        $category_model->delete('id', $request->matches['category_id']);
    }
}
