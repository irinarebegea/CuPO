<?php

require_once 'Controllers/CategoriesController.php';
require_once 'Controllers/AuthController.php';

class Router {
    private $controller;
    private $method;
    private $id;
    private $endpoint;
    private $routes = [];

    public function __construct() {
        $this->parseUri();
        $this->setHeaders();
        $this->defineRoutes();
    }

    private function defineRoutes() {
        $this->routes = [
            'categories' => [
                'GET'    => [CategoriesController::class, 'getAll'],
                'POST'   => [CategoriesController::class, 'create'],
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

        if (in_array($origin, $allowedOrigins)) {
            header('Access-Control-Allow-Origin: ' . $origin);
        } else {
            header('HTTP/1.1 403 Access Forbidden');
            die('You are not allowed to access this file.');
        }

        if($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            header('HTTP/1.1 204 No Content');
            exit;
        }

    }

    public function parseUri() {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $uri = trim($uri, '/');
        $uriParts = explode('/', $uri);

        if (isset($uriParts[1])) {
            $this->endpoint = $uriParts[0] . '/' . $uriParts[1];
            $this->id = $uriParts[2] ?? null;
        } else {
            $this->endpoint = $uriParts[0];
            $this->id = null;
        }

        $this->method = $_SERVER['REQUEST_METHOD'];
    }


    public function route() {
        if (!isset($this->routes[$this->endpoint][$this->method])) {
            error_log($this->endpoint);
            error_log($this->method);
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
        $this->controller->$method();
    }


}

$router = new Router();
$router->route();