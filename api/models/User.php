<?php

require_once (__DIR__ . '/../config/DataBase.php');

class User {
    private $connect;
    private $table = "usuarios";

    public function __construct($db) {
        $this->connect = $db;
    }

    public function getAll() {
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->connect->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE identificacion = :id";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $query = "INSERT INTO " . $this->table . " (identificacion, nombre, apellidos, fechaNacimiento, telefono, correoElectronico, passwordHash, admin) 
                  VALUES (:identificacion, :nombre, :apellidos, :fechaNacimiento, :telefono, :correoElectronico, :passwordHash, :admin)";
        $stmt = $this->connect->prepare($query);
        return $stmt->execute($data);
    }

    public function update($id, $data) {
        $query = "UPDATE " . $this->table . " SET nombre = :nombre, apellidos = :apellidos, fechaNacimiento = :fechaNacimiento, 
                  telefono = :telefono, correoElectronico = :correoElectronico, admin = :admin 
                  WHERE identificacion = :id";
        $stmt = $this->connect->prepare($query);
        $data['id'] = $id;
        return $stmt->execute($data);
    }

    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE identificacion = :id";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
?>
