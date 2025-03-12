<?php
require_once './api/models/Semillero.php';
require_once(__DIR__ . '/../config/DataBase.php');

class SemillerosController {
    private $model;
    
    public function __construct() {
        $this->model = new Semillero();
    }
    
    public function getAll() {
        echo json_encode($this->model->getAll());
    }
    
    public function getById($id) {
        $semillero = $this->model->getById($id);
        if ($semillero) {
            echo json_encode($semillero);
        } else {
            echo json_encode(["status" => "error", "message" => "Semillero no encontrado"]);
        }
    }
    
    public function create() {
        $json = file_get_contents("php://input");
        $data = json_decode($json, true);
        
        if (!$data) {
            echo json_encode(["status" => "error", "message" => "Datos de entrada inválidos"]);
            return;
        }

        if ($this->model->create($data)) {
            echo json_encode(["status" => "success", "message" => "Semillero creado"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error al crear el semillero"]);
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
            echo json_encode(["status" => "success", "message" => "Semillero actualizado"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error al actualizar el semillero"]);
        }
    }
    
    public function delete($id) {
        if ($this->model->delete($id)) {
            echo json_encode(["status" => "success", "message" => "Semillero eliminado"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error al eliminar el semillero"]);
        }
    }
}