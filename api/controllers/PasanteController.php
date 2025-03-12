<?php
require_once(__DIR__ . '/../config/DataBase.php');
require_once(__DIR__ . '/../models/Pasante.php');

class PasanteController {
    private $pasante;

    public function __construct() {
        $database = new Database();
        $this->pasante = new Pasante($database->getConnection());
    }

    // Obtener todos los pasantes
    public function getAll() {
        echo json_encode(["status" => "success", "data" => $this->pasante->getAll()]);
    }

    // Obtener un pasante por ID
    public function getById($id) {
        $pasante = $this->pasante->getById($id);
        if ($pasante) {
            echo json_encode(["status" => "success", "data" => $pasante]);
        } else {
            echo json_encode(["status" => "error", "message" => "Pasante no encontrado"]);
        }
    }

    // Crear un pasante
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

    // Actualizar un pasante
    public function update($id, $data) {
        if ($this->pasante->update($id, $data)) {
            echo json_encode(["status" => "success", "message" => "Pasante actualizado correctamente"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error al actualizar pasante"]);
        }
    }

    // Eliminar un pasante
    public function delete($id) {
        if ($this->pasante->delete($id)) {
            echo json_encode(["status" => "success", "message" => "Pasante eliminado correctamente"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error al eliminar pasante"]);
        }
    }
}
?>
