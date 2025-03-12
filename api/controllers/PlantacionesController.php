<?php
require_once './api/models/Plantaciones.php';
require_once(__DIR__ . '/../config/DataBase.php');

class PlantacionesController {
    private $model;
    
    public function __construct() {
        $this->model = new Plantaciones();
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
            echo json_encode(["status" => "success", "message" => "Registro creado"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error al crear el registro"]);
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
    
}