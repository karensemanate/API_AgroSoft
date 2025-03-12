<?php
require_once (__DIR__ . '/../config/DataBase.php');

class Sensores {
    private $conn;
    private $table = "sensores";

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }
    
    public function getAll() {
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function create($data) {
        $query = "INSERT INTO " . $this->table . " (nombre, tipo, descripcion) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            $data['nombre'],
            $data['tipo'],
            $data['descripcion'] ?? null
        ]);
    }
    
    public function update($id, $data) {
        $query = "UPDATE " . $this->table . " SET nombre = ?, tipo = ?, descripcion = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            $data['nombre'],
            $data['tipo'],
            $data['descripcion'] ?? null,
            $id
        ]);
    }
    
    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$id]);
    }
}
