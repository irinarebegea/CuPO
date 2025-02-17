<?php

require_once 'Models/AuthModel.php';
require_once 'Utils/Validate.php';

class AuthController {
    private $model;
    public function __construct() {
        $this->model = new AuthModel();
    }

    public function create() {
        header('Content-Type: application/json');
        $rawData = file_get_contents('php://input');
        #TODO get input another way
        $data = json_decode($rawData, true);

        $validator = new Validate($data['username'], $data['email'], $data['password'], $data['confirm-password']);

        if (!$validator->validateData()) {
            echo json_encode(['error' => 'Validation failed', 'details' => $_SESSION['register_errors']]);
            http_response_code(400);
            error_log(implode(',', $_SESSION["register_errors"]));
            return;
        }

        $result = $this->model->registerUser($data['username'], $data['email'], $data['password']);

        if ($result) {
            echo json_encode(['success' => 'User registered successfully']);
            http_response_code(201);
        } else {
            echo json_encode(['error' => 'Failed to register user']);
            http_response_code(500);
        }
    }

}