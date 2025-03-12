<?php
require_once './api/models/User.php';
require_once(__DIR__ . '/../config/DataBase.php');

class UserController {
    private $user;

    public function __construct(){
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

    // Obtener un usuario por ID
    public function getById($id) {
        header('Content-Type: application/json');
        $user = $this->user->getById($id);
        echo json_encode($user ?: ["status" => "error", "message" => "Usuario no encontrado"]);
    }

    // Crear un usuario
    public function create() {
        header('Content-Type: application/json');
        $data = json_decode(file_get_contents("php://input"), true);

        if (!$this->validateUserData($data)) {
            echo json_encode(["status" => "error", "message" => "Datos inválidos"]);
            return;
        }

        // Hashear la contraseña correctamente
        $data['passwordHash'] = password_hash($data['password'], PASSWORD_BCRYPT);
        unset($data['password']); // Eliminar el campo original por seguridad

        if ($this->user->create($data)) {
            echo json_encode(["status" => "success", "message" => "Usuario creado correctamente"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error al crear usuario"]);
        }
    }

    // Actualizar un usuario
    public function update($id) {
        header('Content-Type: application/json');
        $data = json_decode(file_get_contents("php://input"), true);

        if (!$this->validateUserData($data, false)) {
            echo json_encode(["status" => "error", "message" => "Datos inválidos"]);
            return;
        }

        $result = $this->user->update($id, $data);

        if ($result && $result['success']) {
            echo json_encode(["status" => "success", "message" => "Usuario actualizado correctamente"]);
        } else {
            echo json_encode(["status" => "error", "message" => $result['message'] ?? "Error al actualizar usuario"]);
        }
    }

    // Eliminar un usuario
    public function delete($id) {
        header('Content-Type: application/json');
        $result = $this->user->delete($id);

        echo json_encode([
            "status" => isset($result['success']) ? "success" : "error",
            "message" => $result['message'] ?? "Error al eliminar usuario"
        ]);
    }

    // Validar los datos del usuario antes de crearlo o actualizarlo
    private function validateUserData($data, $isCreate = true) {
        if ($isCreate && (!isset($data['identificacion']) || !is_numeric($data['identificacion']))) return false;
        if (!isset($data['nombre']) || strlen($data['nombre']) < 3) return false;
        if (!isset($data['correoElectronico']) || !filter_var($data['correoElectronico'], FILTER_VALIDATE_EMAIL)) return false;
        if ($isCreate && (!isset($data['password']) || strlen($data['password']) < 6)) return false;
        return true;
    }
}
?>