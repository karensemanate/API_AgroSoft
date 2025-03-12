<?php
require_once './api/models/Cosecha.php';
require_once(__DIR__ . '/../config/DataBase.php');

class CosechaController {
    private $model;
    
    public function __construct() {
        $this->model = new Cosecha();
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
            echo json_encode(["status" => "success", "message" => "Cosecha creada"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error al crear la cosecha"]);
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
            echo json_encode(["status" => "success", "message" => "Cosecha actualizada"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error al actualizar la cosecha"]);
        }
    
    }
    
    public function delete($id) {
        if ($this->model->delete($id)) {
            echo json_encode(["status" => "success", "message" => "Cosecha eliminada"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error al eliminar la cosecha"]);
        }
    
    }
}