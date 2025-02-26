<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

// Base path de la API (ajustar si está en una subcarpeta, ejemplo: /API_AgroSoft)
$basePath = "/API_AgroSoft";
$requestUri = str_replace($basePath, '', $_SERVER['REQUEST_URI']);
$request = explode('/', trim($requestUri, '/'));

$resource = $request[0] ?? '';
$id = $request[1] ?? null;
$action = $_SERVER['REQUEST_METHOD'];

// Manejo de preflight para CORS en solicitudes OPTIONS
if ($action === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once "./api/controllers/UserController.php";
$userController = new UserController();

if ($resource === "usuarios") {
    switch ($action) {
        case 'GET':
            if ($id) {
                $userController->getUserById($id);
            } else {
                $userController->getAllUsers();
            }
            break;
        case 'POST':
            $data = json_decode(file_get_contents("php://input"), true);
            if (!$data) {
                echo json_encode(["status" => "error", "message" => "Datos inválidos"]);
                exit;
            }
            $userController->createUser($data);
            break;
        case 'PUT':
            if (!$id) {
                echo json_encode(["status" => "error", "message" => "ID requerido"]);
                exit;
            }
            $data = json_decode(file_get_contents("php://input"), true);
            if (!$data) {
                echo json_encode(["status" => "error", "message" => "Datos inválidos"]);
                exit;
            }
            $userController->updateUser($id, $data);
            break;
        case 'DELETE':
            if (!$id) {
                echo json_encode(["status" => "error", "message" => "ID requerido"]);
                exit;
            }
            $userController->deleteUser($id);
            break;
        default:
            echo json_encode(["status" => "error", "message" => "Método no permitido"]);
            break;
    }
} else {
    echo json_encode(["status" => "error", "message" => "Endpoint no encontrado"]);
}
?>
