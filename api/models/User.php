<?php

require_once (__DIR__ . '/../config/DataBase.php');

class User {
    private $connect;
    private $table = "usuarios";

    public function __construct($db) {
        $this->connect = $db;
    }

    // Verificar si un usuario existe en la base de datos
    private function exists($id) {
        $query = "SELECT COUNT(*) FROM " . $this->table . " WHERE identificacion = :id";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(':id', $id, is_numeric($id) ? PDO::PARAM_INT : PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchColumn() > 0; // Devuelve true si el usuario existe
    }

    // Obtener todos los usuarios
    public function getAll() {
        try {
            $query = "SELECT * FROM " . $this->table;
            $stmt = $this->connect->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return ["error" => $e->getMessage()];
        }
    }

    // Obtener un usuario por ID
    public function getById($id) {
        try {
            $query = "SELECT * FROM " . $this->table . " WHERE identificacion = :id";
            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(':id', $id, is_numeric($id) ? PDO::PARAM_INT : PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC) ?: ["error" => "Usuario no encontrado."];
        } catch (PDOException $e) {
            return ["error" => $e->getMessage()];
        }
    }

    // Crear un nuevo usuario
    public function create($data) {
        try {
            if (empty($data['password'])) {
                return ["error" => "La contraseña es obligatoria."];
            }

            $data['passwordHash'] = password_hash($data['password'], PASSWORD_DEFAULT); // Hashear la contraseña
            unset($data['password']); // Eliminar la clave en texto plano por seguridad

            $query = "INSERT INTO " . $this->table . " (identificacion, nombre, apellidos, fechaNacimiento, telefono, correoElectronico, passwordHash, admin) 
                      VALUES (:identificacion, :nombre, :apellidos, :fechaNacimiento, :telefono, :correoElectronico, :passwordHash, :admin)";
            $stmt = $this->connect->prepare($query);
            $stmt->execute($data);

            return ["success" => "Usuario creado correctamente."];
        } catch (PDOException $e) {
            return ["error" => $e->getMessage()];
        }
    }

    // Actualizar un usuario
    public function update($id, $data) {
        try {
            if (!$this->exists($id)) {
                return ["error" => "El usuario con ID $id no existe."];
            }

            $query = "UPDATE " . $this->table . " SET nombre = :nombre, apellidos = :apellidos, fechaNacimiento = :fechaNacimiento, 
                      telefono = :telefono, correoElectronico = :correoElectronico, admin = :admin 
                      WHERE identificacion = :id";

            $stmt = $this->connect->prepare($query);
            $data['id'] = $id;
            $stmt->execute($data);

            return ($stmt->rowCount() > 0) ? ["success" => "Usuario actualizado correctamente."] : ["info" => "No se realizaron cambios."];
        } catch (PDOException $e) {
            return ["error" => $e->getMessage()];
        }
    }

    // Eliminar un usuario
    public function delete($id) {
        try {
            if (!$this->exists($id)) {
                return ["error" => "El usuario con ID $id no existe."];
            }

            $query = "DELETE FROM " . $this->table . " WHERE identificacion = :id";
            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(':id', $id, is_numeric($id) ? PDO::PARAM_INT : PDO::PARAM_STR);
            $stmt->execute();

            return ($stmt->rowCount() > 0) ? ["success" => "Usuario eliminado correctamente."] : ["info" => "No se eliminó ningún usuario."];
        } catch (PDOException $e) {
            return ["error" => $e->getMessage()];
        }
    }
}
?>

