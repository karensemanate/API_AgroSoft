<?php

require_once (__DIR__ . '/../config/DataBase.php');
require_once (__DIR__ . '/../models/User.php');

class UserController {
    private $user;

    public function __construct(){
        $database = new Database();
        $this->db = $database->getConnection(); 
        $this->user = new User($this->db);
    }

    public function getAllUsers() {
        $users = $this->user->getAll();

        if (!empty($users)) {
            echo json_encode([
                'status' => 'success',
                'datos' => $users
            ]);
        } else {
            echo json_encode([
                'status' => 'Error',
                'message' => 'No se encontraron usuarios'
            ]);
        }
    }

    public function getUserById($id) {
        $user = $this->user->getById($id);
        echo json_encode($user ?: ["status" => "error", "message" => "Usuario no encontrado"]);
    }

    public function createUser($data) {
        if (!$this->validateUserData($data)) {
            echo json_encode(["status" => "error", "message" => "Datos inválidos"]);
            return;
        }

        $data['passwordHash'] = password_hash($data['passwordHash'], PASSWORD_BCRYPT);

        if ($this->user->create($data)) {
            echo json_encode(["status" => "success"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error al crear usuario"]);
        }
    }

    public function updateUser($id, $data) {
        if (!$this->validateUserData($data, false)) {
            echo json_encode(["status" => "error", "message" => "Datos inválidos"]);
            return;
        }

        if ($this->user->update($id, $data)) {
            echo json_encode(["status" => "success"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error al actualizar usuario"]);
        }
    }

    public function deleteUser($id) {
        if ($this->user->delete($id)) {
            echo json_encode(["status" => "success"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error al eliminar usuario"]);
        }
    }

    private function validateUserData($data, $isCreate = true) {
        if ($isCreate && (!isset($data['identificacion']) || !is_numeric($data['identificacion']))) return false;
        if (!isset($data['nombre']) || strlen($data['nombre']) < 3) return false;
        if (!isset($data['correoElectronico']) || !filter_var($data['correoElectronico'], FILTER_VALIDATE_EMAIL)) return false;
        if ($isCreate && (!isset($data['passwordHash']) || strlen($data['passwordHash']) < 6)) return false;
        return true;
    }
}
?>
