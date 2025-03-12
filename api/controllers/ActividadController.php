<?php
require_once './api/models/Actividad.php';
require_once(__DIR__ . '/../config/DataBase.php');

class ActividadController {
    private $model;

    public function __construct() {
        $this->model = new Actividad();
    }

    public function getAll() {
        echo json_encode($this->model->getAll());
    }

    public function getById($id) {
        $actividad = $this->model->getById($id);
        if ($actividad) {
            echo json_encode($actividad);
        } else {
            echo json_encode(["status" => "error", "message" => "Actividad no encontrada"]);
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
            echo json_encode(["status" => "success", "message" => "Actividad creada"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error al crear actividad"]);
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
            echo json_encode(["status" => "success", "message" => "Actividad actualizada"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error al actualizar actividad"]);
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
