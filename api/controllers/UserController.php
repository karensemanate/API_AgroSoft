<?php
require_once './api/models/User.php';
require_once(__DIR__ . '/../config/DataBase.php');

class UserController {
    private $db; 
    private $user;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->user = new User($this->db);
    }

    public function getAll() {
        header('Content-Type: application/json');
        
        $users = $this->user->getAll();

        echo json_encode([
            'status' => !empty($users) ? 'success' : 'error',
            'message' => !empty($users) ? 'Usuarios encontrados' : 'No se encontraron usuarios',
            'datos' => $users
        ]);
    }

    public function getById($identificacion) {
        header('Content-Type: application/json');
        $user = $this->user->getById($identificacion);
        echo json_encode($user ?: ["status" => "error", "message" => "Usuario no encontrado"]);
    }

    public function create() {
        header('Content-Type: application/json');
        $data = json_decode(file_get_contents("php://input"), true);
    
        if (!$data) {
            echo json_encode(["status" => "error", "message" => "JSON inválido"]);
            return;
        }
    
        if (!$this->validateUserData($data)) {
            echo json_encode(["status" => "error", "message" => "Datos inválidos"]);
            return;
        }
    
        $data['admin'] = isset($data['admin']) ? (int)$data['admin'] : 0;
        $data['passwordHash'] = password_hash($data['password'], PASSWORD_BCRYPT);
        unset($data['password']);
    
        $result = $this->user->create($data);
    
        echo json_encode($result);
    }
    
    public function update($identificacion) {
        header('Content-Type: application/json');
        $data = json_decode(file_get_contents("php://input"), true);

        if (!$this->validateUserData($data, false)) {
            echo json_encode(["status" => "error", "message" => "Datos inválidos"]);
            return;
        }

        $result = $this->user->update($identificacion, $data);

        if ($result && isset($result['success'])) {
            echo json_encode(["status" => "success", "message" => "Usuario actualizado correctamente"]);
        } else {
            echo json_encode(["status" => "error", "message" => $result['message'] ?? "Error al actualizar usuario"]);
        }
    }

    public function delete($identificacion) {
        header('Content-Type: application/json');
        $result = $this->user->delete($identificacion);

        echo json_encode([
            "status" => isset($result['success']) ? "success" : "error",
            "message" => $result['message'] ?? "Error al eliminar usuario"
        ]);
    }

    public function patch($identificacion) {
        header('Content-Type: application/json');
        $data = json_decode(file_get_contents("php://input"), true);

        if (empty($data)) {
            echo json_encode(["status" => "error", "message" => "No hay datos para actualizar"]);
            return;
        }

        $result = $this->user->patch($identificacion, $data);

        if (isset($result['success'])) {
            echo json_encode(["status" => "success", "message" => "Usuario actualizado correctamente"]);
        } else {
            echo json_encode(["status" => "error", "message" => $result['message'] ?? "Error al actualizar usuario"]);
        }
    }

    private function validateUserData($data, $isCreate = true) {
        if ($isCreate && (!isset($data['identificacion']) || !is_numeric($data['identificacion']))) return false;
        if (!isset($data['nombre']) || strlen($data['nombre']) < 3) return false;
        if (!isset($data['correoElectronico']) || !filter_var($data['correoElectronico'], FILTER_VALIDATE_EMAIL)) return false;
        if ($isCreate && (!isset($data['password']) || strlen($data['password']) < 6)) return false;
        return true;
    }
}
?>
