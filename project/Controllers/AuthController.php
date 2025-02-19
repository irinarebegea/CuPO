<?php

require_once 'Models/AuthModel.php';
require_once 'Utils/ValidateRegister.php';
require_once 'Utils/ValidateLogin.php';

class AuthController {
    public $model;
    public function __construct() {
        $this->model = new AuthModel();
    }

    private function handleValidate($data, $validatorType): bool {
        /**
         * Handles input parsing and validation for login and register.
         * @param  array $data User input
         * @param class $validatorType Validator for either login or register
         * @return bool True if input is valid, false otherwise
         */
        $validator = new $validatorType($data, $this->model);

        if (!$validator->validateData()) {
            http_response_code(400);
            echo json_encode(['error' => 'Validation failed', 'details' => $_SESSION['errors']]);
            return false;
        }
        return true;
    }

    private function sendResponse($success, $errorMessage, $httpCode, $successMessage = null) {
        if ($success) {
            echo json_encode(['success' => $successMessage ?? $errorMessage]);
            unset($_SESSION['errors']);
        } else {
            echo json_encode(['error' => $errorMessage]);
        }
        http_response_code($httpCode);
    }


    public function login() {
        header('Content-type: application/json');
        $data = json_decode(file_get_contents('php://input'), true);

        if (!$this->handleValidate($data, ValidateLogin::class)) {
            return;
        }

        $result = $this->model->login($data['username'], $data['password']);
        $this->sendResponse($result, 'Failed to log in user', $result ? 201 : 500, 'User logged in successfully');
    }

    public function register() {
        header('Content-Type: application/json');
        $data = json_decode(file_get_contents('php://input'), true);

        if (!$this->handleValidate($data, ValidateRegister::class)) {
            return;
        }

        $result = $this->model->registerUser($data['username'], $data['email'], $data['password']);
        $this->sendResponse($result, 'Failed to register user', $result ? 201 : 500, 'User registered successfully');
    }
}
