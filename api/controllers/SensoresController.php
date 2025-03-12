<?php
require_once './api/models/Sensor.php';
require_once(__DIR__ . '/../config/DataBase.php');

class SensoresController {
    private $model;
    
    public function __construct() {
        $this->model = new Sensores();
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
            echo json_encode(["status" => "success", "message" => "Sensor registrado"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error al registrar el sensor"]);
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
            echo json_encode(["status" => "success", "message" => "Sensor actualizado"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error al actualizar el sensor"]);
        }
    }
    
    public function delete($id) {
        if ($this->model->delete($id)) {
            echo json_encode(["status" => "success", "message" => "Sensor eliminado"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error al eliminar el sensor"]);
        }
    }
}
