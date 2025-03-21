<?php
require_once (__DIR__ . '/../config/DataBase.php');

class HorasMensuales {
    private $conn;
    private $table = "horasmensuales";

    public $id;
    public $fk_Pasantes;
    public $minutos;
    public $salario;
    public $mes;

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
        $query = "INSERT INTO " . $this->table . " (fk_Pasantes, minutos, salario, mes) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$data["fk_Pasantes"], $data["minutos"], $data["salario"], $data["mes"]]);
    }

    public function update($id, $data) {
        $query = "UPDATE " . $this->table . " SET fk_Pasantes = ?, minutos = ?, salario = ?, mes = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$data["fk_Pasantes"], $data["minutos"], $data["salario"], $data["mes"], $id]);
    }

    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = ?";
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
    
        return $stmt->execute() ? ["success" => "Horas mensuales actualizada"] : ["error" => "No se actualizó nada"];
    }
}
?>
