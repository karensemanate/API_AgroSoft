<?php
require_once (__DIR__ . '/../config/DataBase.php');

class Especie {
    private $conn;
    private $table = 'especies'; 
    
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
        $query = "INSERT INTO " . $this->table ."(nombre, descripcion, img, tiempoCrecimiento, fk_TiposEspecie ) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            $data['nombre'],
            $data['descripcion'],
            $data['img'],
            $data['tiempoCrecimiento'],
            $data['fk_TiposEspecie']
        ]);
    }
    
    public function update($id, $data) {
        $query = "UPDATE ". $this->table. " SET nombre =?, descripcion =?, img =?, tiempoCrecimiento =?, fk_TiposEspecie =? WHERE id =?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            $data['nombre'],
            $data['descripcion'],
            $data['img'],
            $data['tiempoCrecimiento'],
            $data['fk_TiposEspecie'],
            $id
        ]);
    }
    
    public function delete($id) {
        $query = "DELETE FROM ". $this->table. " WHERE id =?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$id]);
    }
}