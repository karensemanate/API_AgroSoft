<?php
require_once './api/models/TipoControl.php';
require_once(__DIR__ . '/../config/DataBase.php');

class TiposControlController {
    private $model;
    
    public function __construct() {
        $this->model = new TipoControl();
    }
    
    public function getAll() {
        echo json_encode($this->model->getAll());
    }
    public function getById($id) {
        echo json_encode($this->model->getById($id));
    }
    public function create($data) {
        $this->model->create($data);
        echo json_encode(["status" => "success", "message" => "Tipo de control creado correctamente"]);
    }
    public function update($id, $data) {
        $this->model->update($id, $data);
        echo json_encode(["status" => "success", "message" => "Tipo de control actualizado correctamente"]);
    }
    public function delete($id) {
        $this->model->delete($id);
        echo json_encode(["status" => "success", "message" => "Tipo de control eliminado correctamente"]);
    }
}