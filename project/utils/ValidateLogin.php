<?php

declare(strict_types = 1);
require_once 'Models/AuthModel.php';
class ValidateLogin {
    private $username;
    private $password;

    private $model;

    public function __construct($data, AuthModel $model) {
        $this->username = $data['username'] ?? null;
        $this->password = $data['password'] ?? null;

        $this->model = $model;
    }

    function validateData(): bool {
        $errors = [];
        if (empty($this->username) || empty($this->password)) {
            $errors["incomplete_form"] = "Please fill in all fields";
        }

        $user = $this->model->getUserByUsername($this->username);

        if (!$user) {
            $errors["invalid_username"] = "Invalid username";
        }

        if ($user && !password_verify($this->password, $user['pwd'])) {
            $errors["invalid_password"] = "Invalid password";
        }

        if (!empty($errors)) {
            $_SESSION["errors"] = $errors;
            return false;
        }
        return true;
    }
}
