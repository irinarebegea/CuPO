<?php
require_once 'Models/CategoriesModel.php';

class CategoriesController {
    private $model;

    public function __construct() {
        $this->model = new CategoriesModel();
    }

    public function get($id) {
        header('Content-Type: application/json');
        echo json_encode($this->model->getCategory($id));
    }

    public function getAll() {
        header('Content-Type: application/json');
        echo json_encode($this->model->getCategories());
    }

    public function create() {
        header('Content-Type: application/json');
        $data = json_decode(file_get_contents('php://input'), true);
        echo json_encode($this->model->insertCategory($data));
    }

    public function update($id) {
        header('Content-Type: application/json');
        $data = json_decode(file_get_contents('php://input'), true);
        echo json_encode(['success' => $this->model->updateCategory($id, $data)]);
    }

    public function delete($id) {
        header('Content-Type: application/json');
        echo json_encode(['success' => $this->model->deleteCategory($id)]);
    }
}



