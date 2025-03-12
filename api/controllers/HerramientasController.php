<?php
require_once './api/models/Herramienta.php';
require_once(__DIR__ . '/../config/DataBase.php');

class HerramientasController {
    private $model;
    public function __construct() {
        $this->model = new Herramienta();
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
            echo json_encode(["status" => "error", "message" => "No se pudo procesar la información"]);
            return;
        }
        
        $result = $this->model->create($data);
        if ($result) {
            echo json_encode(["status" => "success", "message" => "Herramienta creada exitosamente"]);
        } else {
            echo json_encode(["status" => "error", "message" => "No se pudo crear la herramienta"]);
        }
    }
    
    public function update($id) {
        $json = file_get_contents("php://input");
        $data = json_decode($json, true);
        if (!$data) {
            echo json_encode(["status" => "error", "message" => "No se pudo procesar la información"]);
            return;
        }
        
        $result = $this->model->update($id, $data);
        if ($result) {
            echo json_encode(["status" => "success", "message" => "Herramienta actualizada exitosamente"]);
        } else {
            echo json_encode(["status" => "error", "message" => "No se pudo actualizar la herramienta"]);
        }
    
    }
    
    public function delete($id) {
        if ($this->model->delete($id)) {
            echo json_encode(["status" => "success", "message" => "Herramienta eliminada exitosamente"]);
        } else {
            echo json_encode(["status" => "error", "message" => "No se pudo eliminar la herramienta"]);
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