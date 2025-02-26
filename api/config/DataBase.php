<?php
class Database {
    private $host = 'localhost';
    private $username = 'root';
    private $password = '';
    private $dbname = 'agrosoftnode';
    private $connect;

    public function getConnection() {
        $this->connect = null;

        try {
            $this->connect = new PDO("mysql:host=$this->host;dbname=$this->dbname", $this->username, $this->password);
            $this->connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->connect->exec("set names utf8");
        } catch (PDOException $e) {
            die("Error en la conexión de la base de datos: " . $e->getMessage()); 
        }

        return $this->connect;
    }
}
?>