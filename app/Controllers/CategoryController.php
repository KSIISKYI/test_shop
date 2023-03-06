<?php

namespace App\Controllers;

use App\Core\{Controller, Paginator};
use App\Services\CategoryService;

class CategoryController extends Controller
{
    public function index()
    {
        $products = CategoryService::getCategories();
        $page_number = isset($this->request->data['page']) ? $this->request->data['page'] : 1;
        $pgn = new Paginator($products, 10);

        if (isset($this->request->server['CONTENT_TYPE']) &&  $this->request->server['CONTENT_TYPE'] == 'application/json') {
            header('Content-type: application/json');
            print_r(json_encode($pgn->getData($page_number)));
        }
    }

    public function indexForAdmin()
    {
        return $this->view->render('admin/category/index.twig');
    }

    public function create()
    {
        $data = $this->flash->getMessages();
        
        return $this->view->render('admin/category/create.twig', $data);
    }

    public function store()
    {
        $errors = CategoryService::validateCategoryForm($this->request->data);

        if ($errors) {
            $this->flash->addMessage('errors', $errors);
            $this->flash->addMessage('data', $this->request->data);
            
            redirect(route(['name' => 'categories-create',]));
        }

        CategoryService::createCategory($this->request->data);

        redirect(route(['name' => 'admin-categories-index']));
    }

    public function edit()
    {
        $data = $this->flash->getMessages();
        $data['category'] = CategoryService::getCategory($this->request->matches['category_id']);

        return $this->view->render('admin/category/edit.twig', $data);
    }

    public function update()
    {
        $errors = CategoryService::validateCategoryForm($this->request->data);

        if ($errors) {
            $this->flash->addMessage('errors', $errors);
            $this->flash->addMessage('data', $this->request->data);
            
            redirect(route(['name' => 'categories-edit', 'category_id' => $this->request->matches['category_id']]));
        }

        CategoryService::updateCategory($this->request->matches['category_id'], $this->request->data);

        redirect(route(['name' => 'admin-categories-index']));
    }

    public function destroy()
    {
        CategoryService::removeCategory($this->request);
    }
}
