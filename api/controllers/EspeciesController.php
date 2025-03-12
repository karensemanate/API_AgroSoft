<?php
require_once './api/models/Especie.php';
require_once(__DIR__ . '/../config/DataBase.php');

class EspeciesController {
    private $model;
    
    public function __construct() {
        $this->model = new Especie();
    }
    
    public function getAll() {
        echo json_encode($this->model->getAll());
    }

    public function getById($id) {
        echo json_encode($this->model->getById($id));
    }

    public function create() {
        $data = $_REQUEST;  // Usar $_REQUEST para recibir datos de form-data

        if (empty($data['nombre']) || empty($data['descripcion']) || empty($data['tiempoCrecimiento'])) {
            echo json_encode(["status" => "error", "message" => "Faltan campos obligatorios"]);
            return;
        }

        // Procesar la imagen si se envió
        if (!empty($_FILES['img']['name']) && $_FILES['img']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . "/../uploads/";
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

            $fileName = uniqid() . "_" . basename($_FILES['img']['name']);
            $targetPath = $uploadDir . $fileName;
            $relativePath = "uploads/" . $fileName;

            if (!move_uploaded_file($_FILES['img']['tmp_name'], $targetPath)) {
                echo json_encode(["status" => "error", "message" => "Error al mover la imagen"]);
                return;
            }
            $data['img'] = $relativePath;
        }

        if ($this->model->create($data)) {
            echo json_encode(["status" => "success", "message" => "Registro creado exitosamente"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error al guardar en la base de datos"]);
        }
    }

    public function update($id) {
        if (!is_numeric($id) || $id <= 0) {
            echo json_encode(["status" => "error", "message" => "ID inválido"]);
            return;
        }

        $data = $_REQUEST; // Obtener datos de form-data

        if (empty($data) && empty($_FILES)) {
            echo json_encode(["status" => "error", "message" => "No se recibieron datos para actualizar"]);
            return;
        }

        // Procesar la imagen si se envió
        if (!empty($_FILES['img']['name']) && $_FILES['img']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . "/../uploads/";
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

            $fileName = uniqid() . "_" . basename($_FILES['img']['name']);
            $targetPath = $uploadDir . $fileName;
            $relativePath = "uploads/" . $fileName;

            if (!move_uploaded_file($_FILES['img']['tmp_name'], $targetPath)) {
                echo json_encode(["status" => "error", "message" => "Error al mover la imagen"]);
                return;
            }
            $data['img'] = $relativePath;
        }

        if ($this->model->update($id, $data)) {
            echo json_encode(["status" => "success", "message" => "Registro actualizado exitosamente"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error al actualizar en la base de datos"]);
        }
    }

    public function delete($id) {
        if ($this->model->delete($id)) {
            echo json_encode(["status" => "success", "message" => "Registro eliminado exitosamente"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error al eliminar en la base de datos"]);
        }
    }
}
