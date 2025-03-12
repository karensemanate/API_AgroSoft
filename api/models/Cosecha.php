<?php
require_once (__DIR__ . '/../config/DataBase.php');

class Cosecha {
    private $conn;
    private $table = "cosechas";

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
        $query = "INSERT INTO ". $this->table. "(fk_Cultivos , unidades, fecha) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            $data['fk_Cultivos'],
            $data['unidades'],
            $data['fecha']
        ]);
    }
    
    public function update($id, $data) {
        $query = "UPDATE ". $this->table. " SET fk_Cultivos =?, unidades =?, fecha =? WHERE id =?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            $data['fk_Cultivos'],
            $data['unidades'],
            $data['fecha'],
            $id
        ]);
    
    }
    
    public function delete($id) {
        $query = "DELETE FROM ". $this->table. " WHERE id =?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$id]);
    }
}