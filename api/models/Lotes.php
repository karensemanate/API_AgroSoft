<?php
require_once (__DIR__ . '/../config/DataBase.php');

class lotes {
    private $conn;
    private $table = "lotes";

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }
    public function getAll(){
        $query = "SELECT * FROM ". $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getById($id){
        $query = "SELECT * FROM ". $this->table. " WHERE id =?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function create($data){
        $query = "INSERT INTO ". $this->table . "(nombre, descripcion, tamX, tamY, estado, posX, posY) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            $data['nombre'], 
            $data['descripcion'], 
            $data['tamX'], 
            $data['tamY'], 
            $data['estado'], 
            $data['posX'], 
            $data['posY']
        ]);
    }
    public function update($id, $data){
        $query = "UPDATE ". $this->table. " SET nombre =?, descripcion =?, tamX =?, tamY =?, estado =?, posX =?, posY =? WHERE id =?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            $data['nombre'], 
            $data['descripcion'], 
            $data['tamX'], 
            $data['tamY'], 
            $data['estado'], 
            $data['posX'], 
            $data['posY'], 
            $id
        ]);
    }
    public function delete($id){
        $query = "DELETE FROM ". $this->table. " WHERE id =?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$id]);
    }
}