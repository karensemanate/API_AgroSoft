<?php
require_once './api/models/Lotes.php';
require_once(__DIR__ . '/../config/DataBase.php');

class LotesController {
    private $model;
    
    public function __construct() {
        $this->model = new Lotes();
    }
    
    public function getAll() {
        echo json_encode($this->model->getAll());
    }
    
    public function getById($id) {
        $lote = $this->model->getById($id);
        if ($lote) {
            echo json_encode($lote);
        } else {
            echo json_encode(["status" => "error", "message" => "Lote no encontrado"]);
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
            echo json_encode(["status" => "success", "message" => "Lote creado con éxito"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error al crear el lote"]);
        }
    }
    
    public function update($id, $data) {
        $lote = $this->model->getById($id);
        
        if (!$lote) {
            echo json_encode(["status" => "error", "message" => "Lote no encontrado"]);
            return;
        }
        
        if ($this->model->update($id, $data)) {
            echo json_encode(["status" => "success", "message" => "Lote actualizado"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error al actualizar el lote"]);
        }
    }
    
    public function delete($id) {
        if ($this->model->delete($id)) {
            echo json_encode(["status" => "success", "message" => "Actividad eliminada"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error al eliminar actividad"]);
        }
    }
}