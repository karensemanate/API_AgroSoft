<?php
require_once './api/models/Eras.php';
require_once(__DIR__ . '/../config/DataBase.php');

class ErasController {
    private $model;

    public function __construct() {
        $this->model = new Eras();
    }
    public function getAll() {
        echo json_encode($this->model->getAll());
    }
    public function getById($id) {
        $era = $this->model->getById($id);
        if ($era) {
            echo json_encode($era);
        } else {
            echo json_encode(["status" => "error", "message" => "Era no encontrada"]);
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
            echo json_encode(["status" => "success", "message" => "Era creada"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error al crear la Era"]);
        }
    }
    public function update($id, $data) {
        $json = file_get_contents("php://input");
        $data = json_decode($json, true);
        if ($this->model->update($id, $data)) {
            echo json_encode(["status" => "success", "message" => "Era actualizada"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error al actualizar la era"]);
        }
    }
    public function delete($id) {
        if ($this->model->delete($id)) {
            echo json_encode(["status" => "success", "message" => "Era eliminada"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error al eliminar la era"]);
        }
    }

}