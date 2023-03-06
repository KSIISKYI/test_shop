<?php

require_once '../vendor/autoload.php';
require_once '../app/Core/helpers.php';

use App\Core\{Router, Request};

session_start();

// Looing for .env at the root directory
$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$router = new Router(new Request);
$router->run();
