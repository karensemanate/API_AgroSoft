<?php

require_once (__DIR__ . '/../config/DataBase.php');

class User {
    private $connect;
    private $table = "usuarios";

    public function __construct($db) {
        $this->connect = $db;
    }

    private function exists($id) {
        $query = "SELECT COUNT(*) FROM " . $this->table . " WHERE identificacion = :id";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchColumn() > 0; 
    }

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

    public function getById($id) {
        try {
            $query = "SELECT * FROM " . $this->table . " WHERE identificacion = :id";
            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC) ?: ["error" => "Usuario no encontrado."];
        } catch (PDOException $e) {
            return ["error" => $e->getMessage()];
        }
    }

    public function create($data) {
        try {
            $query = "INSERT INTO " . $this->table . " 
                      (identificacion, nombre, apellidos, fechaNacimiento, telefono, correoElectronico, passwordHash, admin) 
                      VALUES (:identificacion, :nombre, :apellidos, :fechaNacimiento, :telefono, :correoElectronico, :passwordHash, :admin)";
    
            $stmt = $this->connect->prepare($query);
    
            if ($stmt->execute($data)) {
                return ["success" => "Usuario creado correctamente."];
            } else {
                return ["error" => "Error al insertar el usuario."];
            }
        } catch (PDOException $e) {
            return ["error" => $e->getMessage()];
        }
    }

    public function update($id, $data) {
        try {
            if (!$this->exists($id)) {
                return ["error" => "El usuario con ID $id no existe."];
            }

            $query = "UPDATE " . $this->table . " SET 
                      nombre = :nombre, apellidos = :apellidos, fechaNacimiento = :fechaNacimiento, 
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

    public function delete($id) {
        try {
            if (!$this->exists($id)) {
                return ["error" => "El usuario con ID $id no existe."];
            }

            $query = "DELETE FROM " . $this->table . " WHERE identificacion = :id";
            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_STR);
            $stmt->execute();

            return ($stmt->rowCount() > 0) ? ["success" => "Usuario eliminado correctamente."] : ["info" => "No se eliminó ningún usuario."];
        } catch (PDOException $e) {
            return ["error" => $e->getMessage()];
        }
    }

    public function patch($id, $data) {
        try {
            if (!$this->exists($id)) {
                return ["error" => "El usuario con ID $id no existe."];
            }

            $set = [];
            foreach ($data as $key => $value) {
                $set[] = "$key = :$key";
            }
            $setStr = implode(", ", $set);

            $query = "UPDATE " . $this->table . " SET $setStr WHERE identificacion = :id";
            $stmt = $this->connect->prepare($query);

            foreach ($data as $key => &$value) {
                $stmt->bindParam(":$key", $value);
            }
            $stmt->bindParam(':id', $id, PDO::PARAM_STR);

            $stmt->execute();

            return ["success" => "Usuario actualizado correctamente."];
        } catch (PDOException $e) {
            return ["error" => $e->getMessage()];
        }
    }

    public function login($usuario, $contraseña) {
        try {
            $query = "SELECT * FROM " . $this->table . " WHERE correoElectronico = :usuario OR identificacion = :usuario";
            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(":usuario", $usuario, PDO::PARAM_STR);
            $stmt->execute();

            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$user || !password_verify($contraseña, $user['passwordHash'])) {
                return ["error" => "Credenciales incorrectas"];
            }

            return $user;
        } catch (PDOException $e) {
            return ["error" => $e->getMessage()];
        }
    }
}
?>