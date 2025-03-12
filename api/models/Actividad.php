<?php
require_once (__DIR__ . '/../config/DataBase.php');

class Actividad {
    private $conn;
    private $table = "actividades";

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
        $query = "INSERT INTO " . $this->table . " (fk_Cultivos, fk_Usuarios, titulo, descripcion, fecha, estado) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            $data['fk_Cultivos'],
            $data['fk_Usuarios'],
            $data['titulo'],
            $data['descripcion'],
            $data['fecha'],
            $data['estado']
        ]);
    }

    public function update($id, $data) {
        $query = "UPDATE " . $this->table . " 
                  SET fk_Cultivos = :fk_Cultivos, fk_Usuarios = :fk_Usuarios, titulo = :titulo, 
                      descripcion = :descripcion, fecha = :fecha, estado = :estado 
                  WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':fk_Cultivos', $data['fk_Cultivos'], PDO::PARAM_INT);
        $stmt->bindParam(':fk_Usuarios', $data['fk_Usuarios'], PDO::PARAM_INT);
        $stmt->bindParam(':titulo', $data['titulo'], PDO::PARAM_STR);
        $stmt->bindParam(':descripcion', $data['descripcion'], PDO::PARAM_STR);
        $stmt->bindParam(':fecha', $data['fecha'], PDO::PARAM_STR);
        $stmt->bindParam(':estado', $data['estado'], PDO::PARAM_STR);

        return $stmt->execute();
    }

    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$id]);
    }
}
