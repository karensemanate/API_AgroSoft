<?php
require_once (__DIR__ . '/../config/DataBase.php');

class Herramienta {
    private $conn;
    private $table = 'herramientas';

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
        $query = "INSERT INTO ". $this->table. "(fk_Lotes, nombre, descripcion, unidades, estado) VALUES (?,?,?,?, ?)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            $data['fk_Lotes'],
            $data['nombre'],
            $data['descripcion'],
            $data['unidades'],
            $data['estado']
        ]); 
    }
    
    public function update($id, $data) {
        $query = "UPDATE ". $this->table. " SET fk_Lotes =?, nombre =?, descripcion =?, unidades =?, estado =? WHERE id =?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            $data['fk_Lotes'],
            $data['nombre'],
            $data['descripcion'],
            $data['unidades'],
            $data['estado'],
            $id
        ]);
    
    }
    
    public function delete($id) {
        $query = "DELETE FROM ". $this->table. " WHERE id =?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$id]);
    }
}