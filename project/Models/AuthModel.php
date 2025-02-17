<?php

require_once 'Database.php';

class AuthModel
{
    private $db;

    function __construct()
    {
        $this->db = Database::getInstance();
    }

    function registerUser($username, $email, $pwd, $role = 0): bool
    {
        $pwd = password_hash($pwd, PASSWORD_DEFAULT);

        try {
            $checkUser = $this->db->prepare("SELECT 1 FROM users WHERE email = :email");
            $checkUser->execute(["email" => $email]);
            if ($checkUser->rowCount() > 0) {
                throw new Exception("User with this email already exists.");
            }

            $insertUser = $this->db->prepare("INSERT INTO users (username, email, role, pwd) VALUES (:username, :email, :role, :pwd)");
            $insertUser->execute(["username" => $username, "email" => $email, "pwd" => $pwd, "role" => $role]);

            return $insertUser->rowCount() > 0;
        } catch (\Exception $e) {
            error_log("Error in registerUser: " . $e->getMessage());
            return false;
        }
    }

    function getUserByUsername($username) {
        $getUser = $this->db->prepare("SELECT * FROM users WHERE username = :username");
        $getUser->execute(["username" => $username]);

        return $getUser->fetch(PDO::FETCH_ASSOC);

    }

    function getUserByEmail($email) {
        $getUser = $this->db->prepare("SELECT * FROM users WHERE email = :email");
        $getUser->execute(["email" => $email]);

        return $getUser->fetch(PDO::FETCH_ASSOC);
    }

}
