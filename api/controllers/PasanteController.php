<?php
require_once(__DIR__ . '/../config/DataBase.php');
require_once(__DIR__ . '/../models/Pasante.php');

class PasanteController {
    private $pasante;

    public function __construct() {
        $database = new Database();
        $this->pasante = new Pasante($database->getConnection());
    }

    public function getAll() {
        echo json_encode(["status" => "success", "data" => $this->pasante->getAll()]);
    }

    public function getById($id) {
        $pasante = $this->pasante->getById($id);
        if ($pasante) {
            echo json_encode(["status" => "success", "data" => $pasante]);
        } else {
            echo json_encode(["status" => "error", "message" => "Pasante no encontrado"]);
        }
    }

    public function create($data) {
        if (empty($data['fk_Usuarios']) || empty($data['fechaInicioPasantia']) || empty($data['fechaFinalizacion']) || empty($data['salarioHora']) || empty($data['area']) ) {
            echo json_encode(["status" => "error", "message" => "Datos incompletos"]);
            return;
        }

        if ($this->pasante->create($data)) {
            echo json_encode(["status" => "success", "message" => "Pasante creado correctamente"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error al registrar pasante"]);
        }
    }

    public function update($id, $data) {
        if ($this->pasante->update($id, $data)) {
            echo json_encode(["status" => "success", "message" => "Pasante actualizado correctamente"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error al actualizar pasante"]);
        }
    }

    public function delete($id) {
        if ($this->pasante->delete($id)) {
            echo json_encode(["status" => "success", "message" => "Pasante eliminado correctamente"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error al eliminar pasante"]);
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
?>
