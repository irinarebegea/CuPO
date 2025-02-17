<?php
require_once 'Database.php';

class CategoriesModel {
    private $db;
    function __construct() {
        $this->db = Database::getInstance();
    }

    function getCategories() {
        if ($this->db === null) {
            echo 'Database connection is not initialized.';
        } else {
            $categoryQuery = $this->db->prepare("SELECT * FROM categories");
            $categoryQuery->execute();
            return $categoryQuery->fetchAll(\PDO::FETCH_ASSOC);
        }
        return null;
    }

    function getCategory($id) {
        try {
            $categoryQuery = $this->db->prepare("SELECT * FROM categories WHERE id = :id");
            $categoryQuery->execute(["id"=>$id]);
            return $categoryQuery->fetch(\PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            echo "Caught exception: ", $e->getMessage(), "\n";
        }
        return null;
    }

    function insertCategory($name): bool
    {
        try {
            $insertCategory = $this->db->prepare("INSERT INTO categories (name) VALUES (:name)");
            $insertCategory->execute(["name"=>$name]);
            return true;
        } catch (\Exception $e) {
            echo "Caught exception: ", $e->getMessage(), "\n";
        }
        return false;
    }

    function updateCategory($id, $name): bool
    {
        try {
            $updateCategory = $this->db->prepare("UPDATE categories SET name = :name WHERE id = :id");
            $updateCategory->execute(["name"=>$name, "id"=>$id]);
            return true;
        } catch (\Exception $e) {
            echo "Caught exception: ", $e->getMessage(), "\n";
        }
        return false;
    }

    function deleteCategory($id): bool
    {
        try {
            $deleteCategory = $this->db->prepare("DELETE FROM categories WHERE id = :id");
            $deleteCategory->execute(["id"=>$id]);
            return true;
        } catch (\Exception $e) {
            echo "Caught exception: ", $e->getMessage(), "\n";
        }
        return false;
    }

}
