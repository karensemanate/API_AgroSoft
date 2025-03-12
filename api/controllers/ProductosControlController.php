<?php
require_once './api/models/ProductoControl.php';
require_once(__DIR__ . '/../config/DataBase.php');

class ProductosControlController {
    private $model;
    public function __construct() {
        $this->model = new ProductoControl();
    }
    public function getAll() {
        echo json_encode($this->model->getAll());
    }
    public function getById($id) {
        echo json_encode($this->model->getById($id));
    }
    public function create($data) {
        $json = file_get_contents("php://input");
        $data = json_decode($json, true);
        
        if (!$data) {
            echo json_encode(["status" => "error", "message" => "Datos de entrada inválidos"]);
            return;
        }
        
        if ($this->model->create($data)) {
            echo json_encode(["status" => "success", "message" => "Producto creado"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error al crear producto"]);
        }
    }
    public function update($id, $data) {
        $json = file_get_contents("php://input");
        $data = json_decode($json, true);
        
        if (!$data) {
            echo json_encode(["status" => "error", "message" => "Datos de entrada inválidos"]);
            return;
        }
        
        if ($this->model->update($id, $data)) {
            echo json_encode(["status" => "success", "message" => "Producto actualizado"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error al actualizar producto"]);
        
        }
    }
    public function delete($id) {
        if ($this->model->delete($id)) {
            echo json_encode(["status" => "success", "message" => "Producto eliminado"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error al eliminar producto"]);
        }
    
    }
}