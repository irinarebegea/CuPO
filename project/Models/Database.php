<?php

class Database {
    private $host = 'localhost';
    private $db_name = 'cupo';
    private $username = 'root';
    private $password = 'root';
    private $pdo;
    private $dsn;

    private static $instance = null; # Singleton instance

    public function __construct() {
        try {
            $this->dsn = "mysql:host={$this->host};dbname={$this->db_name}";
            $this->pdo = new PDO($this->dsn, $this->username, $this->password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch(Exception $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new Database();
        }

        return self::$instance->pdo;
    }

}