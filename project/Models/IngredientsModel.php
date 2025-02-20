<?php

require_once 'Database.php';

class IngredientsModel {
    private $db;

    function __construct() {
        $this->db = Database::getInstance();
    }

    function getIngredientsByCategory($categoryID) {
        try {
            $ingredientsQuery = $this->db->prepare("SELECT * FROM ingredients WHERE category_id = :categoryID");
            $ingredientsQuery->execute(['categoryID' => $categoryID]);
            return $ingredientsQuery->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            echo "Caught exception: " . $e->getMessage() . "\n";
        }
        return null;
    }

}