<?php
require_once './api/models/Afeccion.php';
require_once(__DIR__ . '/../config/DataBase.php');

class AfeccionesController {
    private $model;

    public function __construct() {
        $this->model = new Afeccion();
    }

    public function getAll() {
        echo json_encode($this->model->getAll());
    }

    public function getById($id) {
        $actividad = $this->model->getById($id);
        if ($actividad) {
            echo json_encode($actividad);
        } else {
            echo json_encode(["status" => "error", "message" => "Afeccion no encontrada"]);
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
            echo json_encode(["status" => "success", "message" => "Afeccion creada"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error al crear afeccion"]);
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
            echo json_encode(["status" => "success", "message" => "Afeccion actualizada"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error al actualizar afeccion"]);
        
        }
    }
    
    public function delete($id) {
        if ($this->model->delete($id)) {
            echo json_encode(["status" => "success", "message" => "Afeccion eliminada"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error al eliminar afeccion"]);
        }
    
    }
}