<?php
require_once (__DIR__ . '/../config/DataBase.php');

class Eras {
    private $conn;
    private $table = "eras";
    
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
        $query = "INSERT INTO ". $this->table. "(fk_Lotes, tamX, tamY, posX, posY, estado) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            $data['fk_Lotes'], 
            $data['tamX'], 
            $data['tamY'], 
            $data['posX'], 
            $data['posY'], 
            $data['estado']
        ]);
    }
    
    public function update($id, $data) {
        $query = "UPDATE " . $this->table . " 
                  SET fk_Lotes = :fk_Lotes, tamX = :tamX, tamY = :tamY, posX = :posX, estado = :estado 
                  WHERE id = :id";
    
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':fk_Lotes', $data['fk_Lotes'], PDO::PARAM_INT);
        $stmt->bindParam(':tamX', $data['tamX'], PDO::PARAM_INT);
        $stmt->bindParam(':tamY', $data['tamY'], PDO::PARAM_INT);
        $stmt->bindParam(':posX', $data['posX'], PDO::PARAM_INT);
        $stmt->bindParam(':estado', $data['estado'], PDO::PARAM_INT);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);  // ← Faltaba enlazar el ID
    
        return $stmt->execute();
    }
    
    
    public function delete($id) {
        $query = "DELETE FROM ". $this->table. " WHERE id =?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$id]);
    }
    public function patch($id, $data) {
        if (empty($data)) return ["error" => "No hay datos para actualizar"];
    
        $set = implode(", ", array_map(fn($key) => "$key = :$key", array_keys($data)));
        $query = "UPDATE " . $this->table . " SET $set WHERE id = :id";
        $stmt = $this->conn->prepare($query);
    
        foreach ($data as $key => &$value) $stmt->bindParam(":$key", $value);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    
        return $stmt->execute() ? ["success" => "Era actualizada"] : ["error" => "No se actualizó nada"];
    }
    
    
}

