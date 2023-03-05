<?php

use App\Core\Route;

return [
    new Route('/', 'HomeController', 'index', 'GET', 'home'),

    // admin panel
    new Route('/admin/signin', 'AdminController', 'showLoginForm', 'GET', 'admin-signin', ['GuestMiddleware']),
    new Route('/admin/signin', 'AdminController', 'login', 'POST', 'admin-signin', ['GuestMiddleware']),
    new Route('/admin', 'AdminController', 'index', 'GET', 'admin-index', ['AuthenticateMiddleware', 'IsAdminMiddleware']),
    new Route('/admin/products', 'ProductController', 'indexForAdmin', 'GET', 'admin-products-index', ['AuthenticateMiddleware', 'IsAdminMiddleware']),
    new Route('/admin/users', 'UserController', 'indexForAdmin', 'GET', 'admin-users-index', ['AuthenticateMiddleware', 'IsAdminMiddleware']),
    new Route('/admin/categories', 'CategoryController', 'indexForAdmin', 'GET', 'admin-categories-index', ['AuthenticateMiddleware', 'IsAdminMiddleware']),
    new Route('/admin/orders', 'OrderController', 'indexForAdmin', 'GET', 'admin-orders-index', ['AuthenticateMiddleware', 'IsAdminMiddleware']),

    // auth
    new Route('/signup', 'AuthController', 'showRegisterForm', 'GET', 'signup', ['GuestMiddleware']),
    new Route('/signin', 'AuthController', 'showLoginForm', 'GET', 'signin', ['GuestMiddleware']),
    new Route('/signup', 'AuthController', 'register', 'POST', 'signin', ['GuestMiddleware']),
    new Route('/signin', 'AuthController', 'login', 'POST', 'signin', ['GuestMiddleware']),
    new Route('/signout', 'AuthController', 'logout', 'GET', 'signout', ['AuthenticateMiddleware']),

    // product
    new Route('/products', 'ProductController', 'index', 'GET', 'products-index'),
    new Route('/products/create', 'ProductController', 'create', 'GET', 'products-create', ['AuthenticateMiddleware', 'IsAdminMiddleware']),
    new Route('/products', 'ProductController', 'store', 'POST', 'products-store', ['AuthenticateMiddleware', 'IsAdminMiddleware']),
    new Route('/products/(?P<product_id>[^/]+)/edit', 'ProductController', 'edit', 'GET', 'products-edit', ['AuthenticateMiddleware', 'IsAdminMiddleware']),
    new Route('/products/(?P<product_id>[^/]+)/update', 'ProductController', 'update', 'POST', 'products-update', ['AuthenticateMiddleware', 'IsAdminMiddleware']),
    new Route('/products/(?P<product_id>[^/]+)', 'ProductController', 'destroy', 'DELETE', 'products-destroy', ['AuthenticateMiddleware', 'IsAdminMiddleware']),

    // users
    new Route('/users', 'UserController', 'index', 'GET', 'users-index', ['AuthenticateMiddleware', 'IsAdminMiddleware']),
    new Route('/users/create', 'UserController', 'create', 'GET', 'users-create', ['AuthenticateMiddleware', 'IsAdminMiddleware']),
    new Route('/users', 'UserController', 'store', 'POST', 'users-store', ['AuthenticateMiddleware', 'IsAdminMiddleware']),
    new Route('/users/(?P<user_id>[^/]+)', 'UserController', 'destroy', 'DELETE', 'users-destroy', ['AuthenticateMiddleware', 'IsAdminMiddleware']),

    // categories
    new Route('/categories', 'CategoryController', 'index', 'GET', 'categories-index', ['AuthenticateMiddleware', 'IsAdminMiddleware']),
    new Route('/categories/create', 'CategoryController', 'create', 'GET', 'categories-create', ['AuthenticateMiddleware', 'IsAdminMiddleware']),
    new Route('/categories', 'CategoryController', 'store', 'POST', 'categories-store', ['AuthenticateMiddleware', 'IsAdminMiddleware']),
    new Route('/categories/(?P<category_id>[^/]+)/edit', 'CategoryController', 'edit', 'GET', 'categories-edit', ['AuthenticateMiddleware', 'IsAdminMiddleware']),
    new Route('/categories/(?P<category_id>[^/]+)/update', 'CategoryController', 'update', 'POST', 'categories-update', ['AuthenticateMiddleware', 'IsAdminMiddleware']),
    new Route('/categories/(?P<category_id>[^/]+)', 'CategoryController', 'destroy', 'DELETE', 'categories-destroy', ['AuthenticateMiddleware', 'IsAdminMiddleware']),

    // orders
    new Route('/orders', 'OrderController', 'index', 'GET', 'orders-index', ['AuthenticateMiddleware', 'IsAdminMiddleware']),
    new Route('/orders/create', 'OrderController', 'create', 'GET', 'orders-create', ['AuthenticateMiddleware', 'IsAdminMiddleware']),
    new Route('/orders', 'OrderController', 'store', 'POST', 'orders-store', ['AuthenticateMiddleware', 'IsAdminMiddleware']),
    new Route('/orders/(?P<order_id>[^/]+)/edit', 'OrderController', 'edit', 'GET', 'orders-edit', ['AuthenticateMiddleware', 'IsAdminMiddleware']),
    new Route('/orders/(?P<order_id>[^/]+)/update', 'OrderController', 'update', 'POST', 'orders-update', ['AuthenticateMiddleware', 'IsAdminMiddleware']),
    new Route('/orders/(?P<order_id>[^/]+)', 'OrderController', 'destroy', 'DELETE', 'orders-destroy', ['AuthenticateMiddleware', 'IsAdminMiddleware']),
];
