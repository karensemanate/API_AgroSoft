<?php
require_once (__DIR__ . '/../config/DataBase.php');

class Control {
    private $conn;
    private $table = "controles";

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getAll() {
        $query = "SELECT * FROM ". $this->table;
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
        $query = "INSERT INTO ". $this->table. "(fk_Afecciones, fk_TiposControl , descripcion, fechaControl) VALUES (?, ?, ?, ?) ";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            $data['fk_Afecciones'],
            $data['fk_TiposControl'],
            $data['descripcion'],
            $data['fechaControl']
        ]);
    }
    
    public function update($id, $data) {
        $query = "UPDATE ". $this->table. " SET fk_Afecciones =?, fk_TiposControl =?, descripcion =?, fechaControl =? WHERE id =?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            $data['fk_Afecciones'],
            $data['fk_TiposControl'],
            $data['descripcion'],
            $data['fechaControl'],
            $id
        ]);
    
    }
    
    public function delete($id) {
        $query = "DELETE FROM ". $this->table. " WHERE id =?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$id]);
    }
}