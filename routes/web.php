<?php

use App\Core\Route;

return [

    ...addMiddleware(
        ['InitCartMiddleware'],

        new Route('/', 'HomeController', 'index', 'GET', 'home'),

        // admin panel
        new Route('/admin/signin', 'AdminController', 'showLoginForm', 'GET', 'admin-signin', ['GuestMiddleware']),
        new Route('/admin/signin', 'AdminController', 'login', 'POST', 'admin-signin', ['GuestMiddleware']),

        // auth
        new Route('/signup', 'AuthController', 'showRegisterForm', 'GET', 'signup', ['GuestMiddleware']),
        new Route('/signin', 'AuthController', 'showLoginForm', 'GET', 'signin', ['GuestMiddleware']),
        new Route('/signup', 'AuthController', 'register', 'POST', 'signin', ['GuestMiddleware']),
        new Route('/signin', 'AuthController', 'login', 'POST', 'signin', ['GuestMiddleware']),
        new Route('/signout', 'AuthController', 'logout', 'GET', 'signout', ['AuthenticateMiddleware']),

        // product
        new Route('/products', 'ProductController', 'index', 'GET', 'products-index', ),
        new Route('/categories/(?P<category_id>[^/]+)/products', 'ProductController', 'filterByCategory', 'GET', 'products-filter', ),
        new Route('/products/(?P<product_id>[^/]+)', 'ProductController', 'show', 'GET', 'products-show', ),

        // users
        new Route('/users/my', 'UserController', 'getMyUser', 'GET'),

        // cart
        new Route('/carts/my', 'CartController', 'show', 'GET', 'carts-show'),
        new Route('/carts/my/items', 'CartController', 'getCartItems', 'GET'),
        new Route('/carts/my/items', 'CartController', 'createCartItem', 'POST', 'carts-items-create'),
        new Route('/carts/my/items/(?P<cart_item_id>[^/]+)', 'CartController', 'destroyCartItem', 'DELETE', 'carts-items-destroy'),

        // order
        new Route('/orders', 'OrderController', 'store', 'POST', 'orders-store'),

        ...addMiddleware(
            ['AuthenticateMiddleware', 'IsAdminMiddleware'],

            // categories
            new Route('/categories', 'CategoryController', 'index', 'GET', 'categories-index'),
            new Route('/categories/create', 'CategoryController', 'create', 'GET', 'categories-create'),
            new Route('/categories', 'CategoryController', 'store', 'POST', 'categories-store'),
            new Route('/categories/(?P<category_id>[^/]+)/edit', 'CategoryController', 'edit', 'GET', 'categories-edit'),
            new Route('/categories/(?P<category_id>[^/]+)/update', 'CategoryController', 'update', 'POST', 'categories-update'),
            new Route('/categories/(?P<category_id>[^/]+)', 'CategoryController', 'destroy', 'DELETE', 'categories-destroy'),

            // orders
            new Route('/orders', 'OrderController', 'index', 'GET', 'orders-index'),
            new Route('/orders/create', 'OrderController', 'create', 'GET', 'orders-create'),
            new Route('/orders/(?P<order_id>[^/]+)/edit', 'OrderController', 'edit', 'GET', 'orders-edit'),
            new Route('/orders/(?P<order_id>[^/]+)/update', 'OrderController', 'update', 'POST', 'orders-update'),
            new Route('/orders/(?P<order_id>[^/]+)', 'OrderController', 'destroy', 'DELETE', 'orders-destroy'),

            // users
            new Route('/users', 'UserController', 'index', 'GET', 'users-index'),
            new Route('/users/create', 'UserController', 'create', 'GET', 'users-create'),
            new Route('/users', 'UserController', 'store', 'POST', 'users-store'),
            new Route('/users/(?P<user_id>[^/]+)', 'UserController', 'destroy', 'DELETE', 'users-destroy'),

            // admin panel
            new Route('/admin', 'AdminController', 'index', 'GET', 'admin-index'),
            new Route('/admin/products', 'ProductController', 'indexForAdmin', 'GET', 'admin-products-index'),
            new Route('/admin/users', 'UserController', 'indexForAdmin', 'GET', 'admin-users-index'),
            new Route('/admin/categories', 'CategoryController', 'indexForAdmin', 'GET', 'admin-categories-index'),
            new Route('/admin/orders', 'OrderController', 'indexForAdmin', 'GET', 'admin-orders-index'),

            // product
            new Route('/products/create', 'ProductController', 'create', 'GET', 'products-create'),
            new Route('/products', 'ProductController', 'store', 'POST', 'products-store'),
            new Route('/products/(?P<product_id>[^/]+)/edit', 'ProductController', 'edit', 'GET', 'products-edit'),
            new Route('/products/(?P<product_id>[^/]+)/update', 'ProductController', 'update', 'POST', 'products-update'),
            new Route('/products/(?P<product_id>[^/]+)', 'ProductController', 'destroy', 'DELETE', 'products-destroy'),
        ),
    ),
];
