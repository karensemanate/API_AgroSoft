<?php
require_once './api/models/UsosHerramientas.php';
require_once(__DIR__ . '/../config/DataBase.php');

class UsosHerramientasController {
    private $model;
    private $db;

    public function __construct() {
        $this->db = new Database();
        $this->model = new UsosHerramientas($this->db);
    }

    public function getAll() {
        echo json_encode($this->model->getAll());
    }
    
    public function getById($id) {
        $usoHerramientas = $this->model->getById($id);
        if ($usoHerramientas) {
            echo json_encode($usoHerramientas);
        } else {
            echo json_encode(["status" => "error", "message" => "Uso de herramientas no encontrado"]);
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
            echo json_encode(["status" => "success", "message" => "Registro Exitoso"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error :("]);
        }
    }
    
    public function update($id, $data) {
        $json = file_get_contents("php://input");
        $data = json_decode($json, true);
        
        if (!$data) {
            echo json_encode(["status" => "error", "message" => "Datos de entrada inválidos"]);
            return;
        }
        
        if ($this->model->update($id, $data)) {
            echo json_encode(["status" => "success", "message" => "Registro actualizado"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error al actualizar"]);
        }
    }

    public function delete($id){
        if ($this->model->delete($id)) {
            echo json_encode(["status" => "success", "message" => "Registro eliminado"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error al eliminar"]);
        }
    }
}