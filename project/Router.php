<?php

require_once 'Controllers/CategoriesController.php';
require_once 'Controllers/IngredientsController.php';
require_once 'Controllers/AuthController.php';

class Router {
    private $controller;
    private $method;
    private $id;
    private $endpoint;
    private $routes = [];

    private $params;

    public function __construct() {
        $this->defineRoutes();
        $this->setHeaders();
        $this->parseUri();

    }

    private function defineRoutes() {
        $this->routes = [
            'categories' => [
                'GET'    => [CategoriesController::class, 'getAll'],
//                'POST'   => [CategoriesController::class, 'create'],
            ],
            'categories/{id}' => [
                'GET'    => [CategoriesController::class, 'get'],
//                'PUT'    => [IngredientsController::class, 'update'],
//                'DELETE' => [IngredientsController::class, 'delete'],
            ],
            'categories/{id}/ingredients' => [
                'GET'    => [IngredientsController::class, 'getAll'],
//                'POST'   => [IngredientsController::class, 'create'],
            ],
            'users/login' => [
                'POST'  => [AuthController::class, 'login'],
            ],
            'users/register' => [
                'POST'  => [AuthController::class, 'register'],
            ]
        ];
    }

    public function setHeaders() {
        header("Access-Control-Allow-Credentials: true");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

        $allowedOrigins = ['http://127.0.0.1:3000', 'http://localhost:3000'];
        $origin = $_SERVER['HTTP_ORIGIN'] ?? '';

        // commented to work with postman
//        if (in_array($origin, $allowedOrigins)) {
//            header('Access-Control-Allow-Origin: ' . $origin);
//        } else {
//            header('HTTP/1.1 403 Access Forbidden');
//            die('You are not allowed to access this file.');
//        }

        header('Access-Control-Allow-Origin: *');

        if($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            header('HTTP/1.1 204 No Content');
            exit;
        }

    }

    public function parseUri() {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $uri = trim($uri, '/');
        $uriParts = explode('/', $uri);

        foreach ($this->routes as $pattern => $methods) {
            $patternParts = explode('/', trim($pattern, '/'));
            if (count($uriParts) != count($patternParts)) {
                continue;
            }

            $match = true;
            $params = [];
            foreach ($patternParts as $key => $part) {
                if (preg_match('/^{[^}]+}$/', $part)) {
                    $params[trim($part, '{}')] = $uriParts[$key];
                } elseif ($uriParts[$key] != $part) {
                    $match = false;
                    break;
                }
            }

            if ($match) {
                $this->endpoint = $pattern;
                $this->params = $params;
                break;
            }
        }

        $this->method = $_SERVER['REQUEST_METHOD'];
        error_log('Matched Endpoint: ' . $this->endpoint);
        error_log('Params: ' . print_r($this->params, true));
    }



    public function route() {
        error_log(print_r($this->routes, true));

        if (!isset($this->routes[$this->endpoint][$this->method])) {
            header('HTTP/1.1 404 Not Found');
            echo json_encode(['error' => 'Endpoint or Method Not Supported']);
            return;
        }

        [$controllerName, $method] = $this->routes[$this->endpoint][$this->method];
        if (!class_exists($controllerName)) {
            header('HTTP/1.1 500 Internal Server Error');
            echo json_encode(['error' => 'Server configuration error']);
            return;
        }

        $this->controller = new $controllerName();
        if (!empty($this->params)) {
            $this->controller->$method(...array_values($this->params));
        } else {
            $this->controller->$method();
        }
    }

}

$router = new Router();
$router->route();