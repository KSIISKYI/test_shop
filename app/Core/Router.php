<?php

namespace App\Core;

class Router
{
    protected $routes = [];
    protected $params = [];
    protected $request;
    protected $matches;

    function __construct($request)
    {
        $this->routes = require_once '../routes/web.php';
        $this->request = $request;
    }

    function match()
    {
        $url = parse_url($_SERVER['REQUEST_URI'])['path'];
        $matched_routes = [];

        foreach($this->routes as $route) {
            if (preg_match("#^$route->route$#", $url, $matches)) {
                $matched_routes[] = $route;
                $this->matches = $matches;
            }
        }
        
        return $matched_routes;
    }

    function run()
    {
        if ($matched_routes = $this->match()) {
            $matched_route = null;

            foreach($matched_routes as $route) {
                if ($route->http_method === $_SERVER['REQUEST_METHOD']) {
                    $matched_route = $route;
                }
            }

            if (!isset($matched_route)) {
                header("HTTP/1.0 405 Method Not Allowed");
                echo '405 Method Not Allowed';
                exit(); 
            } else {
                $this->request->matches = $this->matches;

                $controller_path = 'App\Controllers\\' . $matched_route->controller;

                if (class_exists($controller_path)) {
                    $action = $matched_route->action;

                    if (method_exists($controller_path, $action)) {
                        foreach($matched_route->middleware as $middleware) {
                            $middleware_path = 'App\Middleware\\' . $middleware;
                            $middleware = new $middleware_path;
                            $this->request =  $middleware->handle($this->request);
                        }

                        $controller = new $controller_path($this->request);

                        if ($this->matches) {
                            echo $controller->$action($this->matches);
                        } else {
                            echo $controller->$action(); 
                        }
                    } else {
                        exit("Method not found: <b>$action</b> in the controller: <b>$controller_path");
                    }
                } else {
                    exit("Controller not found: <b>$$controller_path</b>");
                }
            }

        } else {
            header("HTTP/1.0 404 Not Found");
            exit();
        }
    }
}
