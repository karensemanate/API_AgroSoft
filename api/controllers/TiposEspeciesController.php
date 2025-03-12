<?php
require_once './api/models/TipoEspecie.php';
require_once(__DIR__ . '/../config/DataBase.php');

class TiposEspeciesController {
    private $model;
    
    public function __construct() {
        $this->model = new TipoEspecie();
    }
    
    public function getAll() {
        echo json_encode($this->model->getAll());
    }

    public function getById($id) {
        $result = $this->model->getById($id);
        if ($result) {
            echo json_encode($result);
        } else {
            echo json_encode(["status" => "error", "message" => "Tipo de especie no encontrado"]);
        }
    }
    
    public function create() {
        // Obtener los datos enviados desde POST o JSON
        $jsonInput = file_get_contents("php://input");
        $data = !empty($_POST) ? $_POST : json_decode($jsonInput, true);
    
        // Validar que $data es un array
        if (!is_array($data)) {
            echo json_encode(["status" => "error", "message" => "Datos de entrada inválidos"]);
            return;
        }
    
        // Verificar si los campos requeridos existen y no están vacíos
        if (empty($data['nombre']) || empty($data['descripcion'])) {
            echo json_encode(["status" => "error", "message" => "Faltan campos obligatorios"]);
            return;
        }
    
        // Manejo de imagen si está presente
        if (isset($_FILES['img']) && $_FILES['img']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . "/../uploads/";
            if (!is_dir($uploadDir) && !mkdir($uploadDir, 0777, true) && !is_dir($uploadDir)) {
                echo json_encode(["status" => "error", "message" => "No se pudo crear la carpeta de imágenes"]);
                return;
            }
    
            $fileName = uniqid() . "_" . basename($_FILES['img']['name']);
            $targetPath = $uploadDir . $fileName;
            $relativePath = "uploads/" . $fileName;
    
            if (!move_uploaded_file($_FILES['img']['tmp_name'], $targetPath)) {
                echo json_encode(["status" => "error", "message" => "Error al mover la imagen"]);
                return;
            }
    
            $data['img'] = $relativePath;
        }
    
        // Guardar en la base de datos
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
    
        // Obtener datos desde $_REQUEST porque $_POST no funciona con form-data
        $data = $_REQUEST; 
    
        // Si $_REQUEST está vacío, intenta leer los datos en JSON (en caso de raw JSON)
        if (empty($data)) {
            $jsonInput = file_get_contents("php://input");
            $decodedJson = json_decode($jsonInput, true);
    
            if (is_array($decodedJson)) {
                $data = $decodedJson;
            }
        }
    
        // Si no hay datos, se devuelve error
        if (empty($data) && empty($_FILES)) {
            echo json_encode(["status" => "error", "message" => "No se recibieron datos para actualizar"]);
            return;
        }
    
        // Guardar imagen si se envió
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
    
        // Intentar actualizar en la base de datos
        if ($this->model->update($id, $data)) {
            echo json_encode(["status" => "success", "message" => "Actualizado correctamente"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error al actualizar"]);
        }
    }
    
    
    public function delete($id) {
        if ($this->model->delete($id)) {
            echo json_encode(["status" => "success", "message" => "Tipo de especie eliminado"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error al eliminar tipo de especie"]);
        }
    }

}