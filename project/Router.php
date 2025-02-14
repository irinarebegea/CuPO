<?php

require_once 'Controllers/CategoriesController.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");


class Router {
    private $controller;
    private $method;
    private $id;
    private $endpoint;

    public function __construct() {
        $this->parseUri();
    }

    public function parseUri() {
        $uri = trim($_SERVER['REQUEST_URI'], '/');
        $uriParts = explode('/', $uri);

        $this->endpoint = $uriParts[0] ? $uriParts[0] : null;
        $this->id = $uriParts[1] ? $uriParts[1] : null;
        $this->method = $_SERVER['REQUEST_METHOD'];

    }

    public function route() {
        switch ($this->endpoint) {
            case 'categories':
                $this->controller = new CategoriesController();
                break;
            default:
                header('HTTP/1.1 404 Not Found');
                echo json_encode(['error' => 'Endpoint Not Found']);
                break;
        }

        switch ($this->method) {
            case 'GET':
                if ($this->id) {
                    $this->controller->get($this->id);
                } else {
                    $this->controller->getAll();
                }
                break;
            case 'POST':
                $this->controller->create();
                break;
            case 'PUT':
                $this->controller->update($this->id);
                break;
            case 'DELETE':
                $this->controller->delete($this->id);
                break;
            default:
                header('HTTP/1.1 405 Method Not Allowed');
                echo json_encode(['error' => 'Method Not Allowed']);
                break;
        }
    }

}

$router = new Router();
$router->route();