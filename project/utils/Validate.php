<?php

declare(strict_types=1);

require_once 'Models/AuthModel.php';

class Validate {
    private $username;
    private $email;
    private $password;
    private $confirmPassword;
    private $model;

    function __construct(string $username, string $email, string $password, string $confirmPassword) {
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->confirmPassword = $confirmPassword;

        $this->model = new AuthModel();
    }

    function validateData() {
        $errors = [];
        if (empty($this->username) || empty($this->email) || empty($this->password) || empty($this->confirmPassword)) {
            $errors["incomplete_form"] = "Please fill all the fields";
        }

        if (!empty($this->model->getUserByUsername($this->username))) {
            $errors["username_exists"] = "Username already exists";
        }

        if(!empty($this->model->getUserByEmail($this->email))) {
            $errors["email_exists"] = "Email already exists";
        }

        if ($this->password !== $this->confirmPassword) {
            $errors["password_match_error"] = "Passwords don't match";
        }

        if (strlen($this->password) < 5) {
            $errors["password_too_short"] = "Password must be at least 5 characters";
        }

        if (filter_var($this->email, FILTER_VALIDATE_EMAIL) === false) {
            $errors["invalid_email"] = "Invalid email";
        }

        if (!empty($errors)) {
            $_SESSION["register_errors"] = $errors;
            return false;
        }

        return true;
    }

}
