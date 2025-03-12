<?php
require_once './api/models/Mediciones.php';
require_once(__DIR__ . '/../config/DataBase.php');

class MedicionesController {
    private $model;
    
    public function __construct() {
        $this->model = new Mediciones();
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
        
        $medicionId = $this->model->create($data);
        
        if ($medicionId) {
            $evapotranspiracion = $this->model->calcularEvapotranspiracion($data['fk_Lote'] ?? null, $data['fk_Era'] ?? null);
            
            echo json_encode([
                "status" => "success",
                "message" => "Medición registrada",
                "evapotranspiracion" => $evapotranspiracion
            ]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error al registrar la medición"]);
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
            echo json_encode(["status" => "success", "message" => "Mediciones actualizadas"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error al actualizar Mediciones"]);
        }
    }

    public function delete($id) {
        if ($this->model->delete($id)) {
            echo json_encode(["status" => "success", "message" => "Medición eliminada"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error al eliminar la medición"]);
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
