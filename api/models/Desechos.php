<?php
require_once (__DIR__ . '/../config/DataBase.php');

class Desechos {
    private $conn;
    private $table = "desechos";
    
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
        $query = "INSERT INTO ". $this->table. " (fk_Cultivos, fk_TiposDesecho, nombre, descripcion) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            $data['fk_Cultivos'],
            $data['fk_TiposDesecho'],
            $data['nombre'],
            $data['descripcion']
        ]);
    }
    
    public function update($id, $data) {
        $query = "UPDATE ". $this->table. " SET fk_Cultivos =?, fk_TiposDesecho =?, nombre =?, descripcion =? WHERE id =?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            $data['fk_Cultivos'],
            $data['fk_TiposDesecho'],
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

    public function patch($id, $data) {
        if (empty($data)) return ["error" => "No hay datos para actualizar"];
    
        $set = implode(", ", array_map(fn($key) => "$key = :$key", array_keys($data)));
        $query = "UPDATE " . $this->table . " SET $set WHERE id = :id";
        $stmt = $this->conn->prepare($query);
    
        foreach ($data as $key => &$value) $stmt->bindParam(":$key", $value);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    
        return $stmt->execute() ? ["success" => "Desechos actualizada"] : ["error" => "No se actualizó nada"];
    }

}