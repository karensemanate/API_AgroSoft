<?php
require_once (__DIR__ . '/../config/DataBase.php');

class Mediciones {
    private $conn;
    private $table = "mediciones";

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
        $query = "INSERT INTO " . $this->table . " (fk_Sensor, fk_Lote, fk_Era, valor, fecha) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([
            $data['fk_Sensor'],
            $data['fk_Lote'],
            $data['fk_Era'],
            $data['valor'],
            $data['fecha']
        ]);
        
        return $this->conn->lastInsertId();
    }
    
    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$id]);
    }

    /**
     * Calcular Evapotranspiración usando la fórmula de FAO Penman-Monteith
     */
    public function calcularEvapotranspiracion($loteId = null, $eraId = null) {
        // Obtener datos recientes de sensores en el lote o era
        $query = "SELECT s.tipo, m.valor FROM mediciones m
                  JOIN sensores s ON m.fk_Sensor = s.id
                  WHERE (m.fk_Lote = ? OR m.fk_Era = ?)
                  ORDER BY m.fecha DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$loteId, $eraId]);
        $datosSensores = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Variables para el cálculo
        $temperatura = null;
        $humedad = null;
        $radiacionSolar = null;
        $velocidadViento = null;

        // Asignar valores según el tipo de sensor
        foreach ($datosSensores as $dato) {
            switch ($dato['tipo']) {
                case 'temperatura':
                    $temperatura = $dato['valor'];
                    break;
                case 'humedad_ambiente':
                    $humedad = $dato['valor'];
                    break;
                case 'radiacion_solar':
                    $radiacionSolar = $dato['valor'];
                    break;
                case 'velocidad_viento':
                    $velocidadViento = $dato['valor'];
                    break;
            }
        }

        // Verificar si tenemos los datos necesarios
        if (is_null($temperatura) || is_null($humedad) || is_null($radiacionSolar) || is_null($velocidadViento)) {
            return "Datos insuficientes para calcular la evapotranspiración";
        }

        // Cálculo de Evapotranspiración (FAO Penman-Monteith simplificada)
        $ET0 = (0.408 * $radiacionSolar) + (0.063 * (900 / ($temperatura + 273)) * $velocidadViento * ($temperatura - 2));

        return round($ET0, 2);
    }
    public function update($id, $data) {
        $query = "UPDATE " . $this->table . " 
                  SET fk_Sensor = ?, fk_Lote = ?, fk_Era = ?, valor = ?, fecha = ?
                  WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        
        return $stmt->execute([
            $data['fk_Sensor'],
            $data['fk_Lote'],
            $data['fk_Era'],
            $data['valor'],
            $data['fecha'],
            $id
        ]);
    }
    
}
