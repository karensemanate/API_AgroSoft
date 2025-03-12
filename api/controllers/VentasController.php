<?php
require_once './api/models/Ventas.php';
require_once(__DIR__ . '/../config/DataBase.php');

class VentasController {
    private $model;
    
    public function __construct() {
        $this->model = new Ventas();
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
    
    public function delete($id) {
        if ($this->model->delete($id)) {
            echo json_encode(["status" => "success", "message" => "Registro eliminado"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error al eliminar el registro"]);
        }
    }

    public function patch($id) {
        header('Content-Type: application/json');
        $data = json_decode(file_get_contents("php://input"), true);
    
        if (!$id || empty($data)) {
            echo json_encode(["status" => "error", "message" => "ID o datos inválidos"]);
            return;
        }
    
        $result = $this->model->patch($id, $data);
        echo json_encode($result);
        }
}