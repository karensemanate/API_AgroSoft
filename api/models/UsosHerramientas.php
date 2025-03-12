<?php
require_once (__DIR__ . '/../config/DataBase.php');

class UsosHerramientas {
    private $conn;
    private $table = "usosherramientas";

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
        $query = "SELECT * FROM ". $this->table. " WHERE id =?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $query = "INSERT INTO ". $this->table. " (fk_Herramientas, fk_Actividades) VALUES (?,?)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            $data['fk_Herramientas'], 
            $data['fk_Actividades']
        ]);
    }
    
    public function delete($id) {
        $query = "DELETE FROM ". $this->table. " WHERE id =?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$id]);
    }
    
    public function update($id, $data) {
        $query = "UPDATE ". $this->table. " SET fk_Herramientas =?, fk_Actividades =? WHERE id =?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            $data['fk_Herramientas'], 
            $data['fk_Actividades'],
            $id
        ]);
    }
        
}