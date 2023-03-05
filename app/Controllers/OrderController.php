<?php

namespace App\Controllers;

use App\Core\{Controller, Paginator};
use App\Services\{OrderService, ProductService};
use App\Models\{Shipper, Order};

class OrderController extends Controller
{
    public function index()
    {
        $products = OrderService::getOrders();
        $page_number = isset($this->request->data['page']) ? $this->request->data['page'] : 1;
        $pgn = new Paginator($products, 10);

        if (isset($this->request->server['CONTENT_TYPE']) &&  $this->request->server['CONTENT_TYPE'] == 'application/json') {
            header('Content-type: application/json');
            print_r(json_encode($pgn->getData($page_number)));
        }
    }

    public function indexForAdmin()
    {
        return $this->view->render('admin/order/index.twig');
    }

    public function create()
    {
        $shipper_model = new Shipper;
        $shippers = $shipper_model->filter();
        $products = ProductService::getProducts();

        return $this->view->render('admin/order/create.twig', compact('products', 'shippers'));
    }

    public function store()
    {
        OrderService::createOrder($this->request);
    }

    public function edit()
    {
        $shipper_model = new Shipper;
        $order_model = new Order;
        $shippers = $shipper_model->filter();
        $products = ProductService::getProducts();
        $order = $order_model->get('id', $this->request->matches['order_id']);

        if (isset($this->request->server['CONTENT_TYPE']) &&  $this->request->server['CONTENT_TYPE'] == 'application/json') {
            header('Content-type: application/json');
            print_r(json_encode(compact('products', 'shippers', 'order')));
            exit();
        }

        return $this->view->render('admin/order/edit.twig', compact('products', 'shippers', 'order'));
    }

    public function update()
    {
        OrderService::updateOrder($this->request);
    }

    public function destroy()
    {
        OrderService::removeOrder($this->request->matches['order_id']);
    }
}
