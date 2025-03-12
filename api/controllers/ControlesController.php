<?php
require_once './api/models/Control.php';
require_once(__DIR__ . '/../config/DataBase.php');

class ControlesController {
    private $model;
    public function __construct() {
        $this->model = new Control();
    }
    
    public function getAll() {
        echo json_encode($this->model->getAll());
    }
    
    public function getById($id) {
        echo json_encode($this->model->getById($id));
    }
    
    public function create() {
        $json = file_get_contents("php://input");
        $data = json_decode($json, true);

        if (!$data) {
            echo json_encode(["status" => "error", "message" => "Datos de entrada inválidos"]);
            return;
        }
        
        if ($this->model->create($data)) {
            echo json_encode(["status" => "success", "message" => "Control creado"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error al crear control"]);
        }
    }
    
    public function update($id) {
        $json = file_get_contents("php://input");
        $data = json_decode($json, true);
        if (!$data) {
            echo json_encode(["status" => "error", "message" => "Datos de entrada inválidos"]);
            return;
        }
        
        if ($this->model->update($id, $data)) {
            echo json_encode(["status" => "success", "message" => "Control actualizado"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error al actualizar control"]);
        }
    }
    
    public function delete($id) {
        if ($this->model->delete($id)) {
            echo json_encode(["status" => "success", "message" => "Control eliminado"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error al eliminar control"]);
        }
    }
}