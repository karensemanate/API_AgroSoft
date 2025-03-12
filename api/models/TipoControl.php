<?php
require_once (__DIR__ . '/../config/DataBase.php');

class TipoControl {
    private $conn;
    private $table = "tiposcontrol";

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
        $query = "INSERT INTO ". $this->table. "(nombre, descripcion) VALUES (?,?)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            $data['nombre'], 
            $data['descripcion']
        ]);
    }

    public function update($id, $data) {
        $query = "UPDATE ". $this->table. " SET nombre =?, descripcion =? WHERE id =?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            $data['nombre'], 
            $data['descripcion'],
            $id
        ]);
    }
    
    public function delete($id) {
        $query = "DELETE FROM ". $this->table. " WHERE id =?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$id]);
    }
    
}