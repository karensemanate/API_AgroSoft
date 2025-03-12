<?php
require_once './api/models/UsoProductoControl.php';
require_once(__DIR__ . '/../config/DataBase.php');

class UsosProductoControlController {
    private $model;
    public function __construct() {
        $this->model = new UsoProductoControl();
    }
    
    public function getAll() {
        echo json_encode($this->model->getAll());
    }
    
    public function getById($id) {
        $result = $this->model->getById($id);
        if ($result) {
            echo json_encode($result);
        } else {
            echo json_encode(["status" => "error", "message" => "Uso de producto no encontrado"]);
        }
    
    }
    
    public function create($data) {
        $json = file_get_contents("php://input");
        $data = json_decode($json, true);
        
        if (!$data) {
            echo json_encode(["status" => "error", "message" => "Datos de entrada inválidos"]);
            return;
        }
        
        if ($this->model->create($data)) {
            echo json_encode(["status" => "success", "message" => "Registro Exitoso"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error"]);
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
            echo json_encode(["status" => "success", "message" => "Registro actualizado"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error al actualizar el registro"]);
        }
    
    }
}