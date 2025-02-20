<?php
require_once 'Models/IngredientsModel.php';

class IngredientsController {
    private $model;

    public function __construct() {
        $this->model = new IngredientsModel();
    }

    public function getAll($categoryID) {
        header("Content-type: application/json");
        echo json_encode($this->model->getIngredientsByCategory($categoryID));
    }
}