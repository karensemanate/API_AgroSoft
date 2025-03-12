<?php
require_once './api/models/Desechos.php';
require_once(__DIR__ . '/../config/DataBase.php');

class DesechosController {
    private $model;

    public function __construct() {
        $this->model = new Desechos();
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
            echo json_encode(["status" => "success", "message" => "Desecho creado"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error al crear desecho"]);
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
            echo json_encode(["status" => "success", "message" => "Desecho actualizado"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error al actualizar desecho"]);
        }
    }
    
    public function delete($id) {
        if ($this->model->delete($id)) {
            echo json_encode(["status" => "success", "message" => "Desecho eliminado"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error al eliminar desecho"]);
        }
    }
}