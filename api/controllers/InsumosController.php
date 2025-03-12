<?php
require_once './api/models/Insumos.php';
require_once(__DIR__ . '/../config/DataBase.php');

class InsumosController {
    private $model;
    public function __construct() {
        $this->model = new Insumos();
    }
    public function getAll() {
        echo json_encode($this->model->getAll());
    }
    public function getById($id) {
        $insumos = $this->model->getById($id);
        if ($insumos) {
            echo json_encode($insumos);
        } else {
            echo json_encode(["status" => "error", "message" => "Insumo no encontrada"]);

        }

    }
    public function create($data) {
        $json = file_get_contents("php://input");
        $data = json_decode($json, true);
        if ($this->model->create($data)) {
            echo json_encode(["status" => "success", "message" => "Insumo creado"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error al crear el insumo"]);
        }
    }
    public function update($id, $data) {
        $json = file_get_contents("php://input");
        $data = json_decode($json, true);
        if ($this->model->update($id, $data)) {
            echo json_encode(["status" => "success", "message" => "Insumo actualizado"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error al actualizar el insumo"]);
        }
    }
    public function delete($id) {
        if ($this->model->delete($id)) {
            echo json_encode(["status" => "success", "message" => "Insumo eliminado"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error al eliminar el insumo"]);
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