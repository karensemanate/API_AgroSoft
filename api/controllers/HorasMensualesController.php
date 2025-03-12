<?php
require_once "./api/models/HorasMensuales.php";
require_once(__DIR__ . '/../config/DataBase.php');

class HorasMensualesController {
    private $model;

    public function __construct() {
        $this->model = new HorasMensuales();
    }

    public function getAll() {
        echo json_encode($this->model->getAll());
    }

    public function getById($id) {
        $result = $this->model->getById($id);
        if ($result) {
            echo json_encode($result);
        } else {
            echo json_encode(["status" => "error", "message" => "Registro no encontrado"]);
        }
    }

    public function create($data) {
        if ($this->model->create($data)) {
            echo json_encode(["status" => "success", "message" => "Registro creado con éxito"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error al crear el registro"]);
        }
    }

    public function update($id, $data) {
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
?>

