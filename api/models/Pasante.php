<?php
require_once (__DIR__ . '/../config/DataBase.php');
class Pasante {
    private $conn;
    private $table = "Pasantes";

    public function __construct($db) {
        $this->conn = $db;
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
        if (!isset($data['fk_Usuarios'], $data['fechaInicioPasantia'], $data['fechaFinalizacion'], $data['salarioHora'], $data['area'])) {
            return ["status" => "error", "message" => "Datos incompletos"];
        }
    
        $data['fk_Usuarios'] = trim($data['fk_Usuarios']);
    
        $query = "INSERT INTO " . $this->table . " (fk_Usuarios, fechaInicioPasantia, fechaFinalizacion, salarioHora, area) 
                  VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
    
        try {
            $stmt->execute([
                $data['fk_Usuarios'], 
                $data['fechaInicioPasantia'], 
                $data['fechaFinalizacion'], 
                $data['salarioHora'],
                $data['area']
            ]);
            return ["status" => "success", "message" => "Pasante creado con éxito"];
        } catch (PDOException $e) {
            return ["status" => "error", "message" => $e->getMessage()];
        }
    }
    

    public function update($id, $data) {
        $query = "UPDATE " . $this->table . " SET fk_Usuarios = ?, fechaInicioPasantia = ?, fechaFinalizacion = ?, salarioHora = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$data['fk_Usuarios'], $data['fechaInicioPasantia'], $data['fechaFinalizacion'], $data['salarioHora'], $id]);
    }

    // Eliminar un pasante
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
    
        return $stmt->execute() ? ["success" => "Pasante actualizado"] : ["error" => "No se actualizó nada"];
    }
}
?>

