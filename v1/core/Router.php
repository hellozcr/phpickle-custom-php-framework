<?php
namespace Core;

class Router {
    protected $routes = [];

    public function __construct() {
        $this->routes = require __DIR__ . '/../config/routes.php';
    }

    public function dispatch($url) {
        $requestMethod = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $url = '/' . trim($url, '/'); // Always start with /

        foreach ($this->routes as $route) {
            list($method, $pattern, $handler) = $route;
            if (strtoupper($method) !== $requestMethod) continue;

            // Convert CI-style (:num) to regex
            $regex = preg_replace('/\(:num\)/', '(\\d+)', $pattern);
            $regex = '#^' . $regex . '$#';

            if (preg_match($regex, $url, $matches)) {
                array_shift($matches); // Remove full match
                list($controller, $action) = explode('@', $handler);
                $controllerClass = 'App\\Controllers\\' . $controller;
                if (!class_exists($controllerClass)) {
                    http_response_code(404);
                    echo "Controller $controllerClass not found.";
                    return;
                }
                $controllerInstance = new $controllerClass();
                if (!method_exists($controllerInstance, $action)) {
                    http_response_code(404);
                    echo "Action $action not found in controller $controllerClass.";
                    return;
                }
                call_user_func_array([$controllerInstance, $action], $matches);
                return;
            }
        }
        // No route matched
        http_response_code(404);
        echo "404 Not Found";
    }
} 