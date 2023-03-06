<?php

use App\Core\Route;

function route($arr)
{
    $routes = require '../routes/web.php';
    $url_prefix = 'http://' .$_SERVER['HTTP_HOST'];

    $route_pattern = null;

    foreach($routes as $route) {
        if (isset($route->name) && $route->name === $arr['name']) {
            $route_pattern = $route->route;
        }
    }

    if (!isset($route_pattern)) {
        return '#';
    } else {
        unset($arr['name']);
        foreach($arr as $key => $value) {
            $route_pattern = str_replace("/(?P<$key>[^/]+)", "/$value", $route_pattern);
        }

        return $url_prefix . $route_pattern;
    }
}

function addMiddleware(array $middleware, Route ...$routes)
{
    foreach($routes as $route) {
        $route->middleware = array_merge($middleware,  $route->middleware);
    }

    return $routes;
}

function redirect(string $route)
{
    header("location: $route");
    exit();
}