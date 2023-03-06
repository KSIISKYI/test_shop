<?php

namespace App\Controllers;

use App\Core\{Controller, Paginator};
use App\Services\{ProductService, CategoryService};

class ProductController extends Controller
{
    public function index()
    {
        $products = ProductService::getProducts($this->request);
        $page_number = isset($this->request->data['page']) ? $this->request->data['page'] : 1;
        $pgn = new Paginator($products, 9);

        if (isset($this->request->server['CONTENT_TYPE']) &&  $this->request->server['CONTENT_TYPE'] == 'application/json') {
            header('Content-type: application/json');
            print_r(json_encode($pgn->getData($page_number)));
            exit();
        }
    }

    public function indexForAdmin()
    {
        return $this->view->render('admin/product/index.twig');
    }

    public function filterByCategory()
    {
        $products = ProductService::getProducts($this->request, ['category_id' => $this->request->matches['category_id']]);
        $page_number = isset($this->request->data['page']) ? $this->request->data['page'] : 1;
        $pgn = new Paginator($products, 9);

        if (isset($this->request->server['CONTENT_TYPE']) &&  $this->request->server['CONTENT_TYPE'] == 'application/json') {
            header('Content-type: application/json');
            print_r(json_encode($pgn->getData($page_number)));
            exit();
        }

        return $this->view->render('home.twig');
    }

    public function show()
    {
        $product = ProductService::getProduct($this->request->matches['product_id']);

        return $this->view->render('product/show.twig', compact('product'));
    }

    public function create()
    {
        $data = $this->flash->getMessages();
        $data['categories'] = CategoryService::getCategories();

        return $this->view->render('admin/product/create.twig', $data);
    }

    public function store()
    {
        $errors = ProductService::validateProductForm($this->request->data);

        if ($errors) {
            $this->flash->addMessage('errors', $errors);
            $this->flash->addMessage('data', $this->request->data);
            
            redirect(route(['name' => 'products-create',]));
        }

        ProductService::createProduct($this->request);

        redirect(route(['name' => 'admin-products-index',]));
    }

    public function edit()
    {
        $data = $this->flash->getMessages();
        $data['categories'] = CategoryService::getCategories();
        $data['product'] = ProductService::getProduct($this->request->matches['product_id']);

        return $this->view->render('admin/product/edit.twig', $data);
    }

    public function update()
    {
        $errors = ProductService::validateProductForm($this->request->data);

        if ($errors) {
            $this->flash->addMessage('errors', $errors);
            $this->flash->addMessage('data', $this->request->data);
            
            redirect(route(['name' => 'products-edit', 'product_id' => $this->request->matches['product_id']]));
        }

        ProductService::updateProduct($this->request->matches['product_id'], $this->request);

        redirect(route(['name' => 'admin-products-index',]));
    }

    public function destroy()
    {
        ProductService::removeProduct($this->request);
    }
}
