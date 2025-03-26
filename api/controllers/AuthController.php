<?php
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../config/DataBase.php';
require_once __DIR__ . '/../../vendor/autoload.php'; // Corregida la ruta

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthController {
    private $db;
    private $user;
    private $secretKey;

    public function __construct() {
        // Conexión a la base de datos
        $database = new Database();
        $this->db = $database->getConnection();
        $this->user = new User($this->db);

        // Clave secreta para JWT
        $this->secretKey = "tu_secreto_super_seguro"; // Puedes cambiarlo por una variable de entorno si decides usar .env
    }

    public function login() {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(["status" => "error", "message" => "Método no permitido"]);
            return;
        }        

        $data = json_decode(file_get_contents("php://input"), true);

        if (empty($data['identificacion']) || empty($data['password'])) {
            http_response_code(400);
            echo json_encode(["status" => "error", "message" => "Identificación y contraseña requeridas"]);
            return;
        }

        // Cambiamos el login para buscar por identificación
        $usuario = $this->user->login($data['identificacion'], $data['password']);

        if (!$usuario || isset($usuario['error'])) {
            http_response_code(401);
            echo json_encode(["status" => "error", "message" => "Identificación o contraseña incorrectas"]);
            return;
        }

        // Crear el payload del JWT
        $payload = [
            "iat" => time(),
            "exp" => time() + (60 * 60), // Token válido por 1 hora
            "data" => [
                "identificacion" => $usuario["identificacion"],
                "nombre" => $usuario["nombre"],
                "admin" => $usuario["admin"]
            ]
        ];

        // Generar el token JWT
        $jwt = JWT::encode($payload, $this->secretKey, 'HS256');

        echo json_encode([
            "status" => "success",
            "message" => "Inicio de sesión exitoso",
            "token" => $jwt
        ]);
    }

    public function verifyToken($token) {
        try {
            $decoded = JWT::decode($token, new Key($this->secretKey, 'HS256'));
            return ["status" => "success", "data" => $decoded];
        } catch (\Firebase\JWT\ExpiredException $e) {
            return ["status" => "error", "message" => "Token expirado"];
        } catch (\Firebase\JWT\SignatureInvalidException $e) {
            return ["status" => "error", "message" => "Firma del token inválida"];
        } catch (Exception $e) {
            return ["status" => "error", "message" => "Token inválido"];
        }
    }

    public function checkAuth() {
        $headers = getallheaders();
    
        if (!isset($headers['Authorization'])) {
            http_response_code(401);
            echo json_encode(["status" => "error", "message" => "Token no proporcionado"]);
            exit;
        }
    
        $token = str_replace("Bearer ", "", $headers['Authorization']);
    
        $verification = $this->verifyToken($token);
    
        if ($verification['status'] === 'error') {
            http_response_code(401);
            echo json_encode($verification);
            exit;
        }
    
        return $verification['data'];
    }
    
    public function obtenerUsuarios() {
        header('Content-Type: application/json');
    
        // Verificar autenticación
        $usuarioAutenticado = $this->checkAuth();
    
        // Si el usuario está autenticado, continuar con la lógica
        echo json_encode(["status" => "success", "message" => "Acceso permitido", "usuario" => $usuarioAutenticado]);
    }
    
}
?>