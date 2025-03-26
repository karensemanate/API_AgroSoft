<?php
require_once 'autoload.php';
require_once 'api/controllers/AuthController.php'; 

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *"); 
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, PATCH, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");


if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

$authController = new AuthController();
$headers = getallheaders();

// Capturar la ruta desde la URL
$requestUri = $_SERVER['REQUEST_URI'];
$basePath = '/API_AgroSoft/'; 
$route = str_replace($basePath, '', $requestUri);
$route = trim($route, '/');
$segments = explode('/', $route);

// Verificar controlador y acción
$controllerName = !empty($segments[0]) ? ucfirst($segments[0]) . 'Controller' : null;
$action = $segments[1] ?? null;
$id = isset($segments[2]) && is_numeric($segments[2]) ? intval($segments[2]) : null;

// Definir rutas que NO requieren autenticación
$rutasPublicas = [
    'auth/login',
    'auth/register'
];

// Verificar si la ruta necesita autenticación
if (!in_array(strtolower($route), $rutasPublicas)) {
    if (!isset($headers['Authorization'])) {
        http_response_code(401);
        echo json_encode(["status" => "error", "message" => "Token no proporcionado"]);
        exit();
    }

    $token = str_replace("Bearer ", "", $headers['Authorization']);
    $verificacion = $authController->verifyToken($token);

    if ($verificacion['status'] === 'error') {
        http_response_code(401);
        echo json_encode($verificacion);
        exit();
    }
}

// Verificar si el controlador existe
if ($controllerName && file_exists("api/controllers/$controllerName.php")) {
    require_once "api/controllers/$controllerName.php";

    if (class_exists($controllerName)) {
        $controller = new $controllerName();
        $method = $_SERVER['REQUEST_METHOD'];
        $data = json_decode(file_get_contents("php://input"), true);

        switch ($method) {
            case 'GET':
                if ($action && method_exists($controller, $action)) {
                    $response = $controller->$action($id);
                } elseif (method_exists($controller, 'index')) {
                    $response = $controller->index();
                } else {
                    http_response_code(400);
                    $response = ["status" => "error", "message" => "Método GET no válido"];
                }
                break;

            case 'POST':
                if ($controllerName === 'AuthController' && $action === 'login' && method_exists($controller, "login")) {
                    $response = $controller->login();
                } elseif (method_exists($controller, "create")) {
                    $response = $controller->create($data);
                } else {
                    http_response_code(400);
                    $response = ["status" => "error", "message" => "Método POST no válido"];
                }
                break;

            case 'PUT':
                if ($id && method_exists($controller, "update")) {
                    $response = $controller->update($id, $data);
                } else {
                    http_response_code(400);
                    $response = ["status" => "error", "message" => "Método PUT no válido"];
                }
                break;

            case 'DELETE':
                if ($id && method_exists($controller, "delete")) {
                    $response = $controller->delete($id);
                } else {
                    http_response_code(400);
                    $response = ["status" => "error", "message" => "Método DELETE no válido"];
                }
                break;

            case 'PATCH':
                if ($id && method_exists($controller, "patch")) {
                    $response = $controller->patch($id, $data);
                } else {
                    http_response_code(400);
                    $response = ["status" => "error", "message" => "Método PATCH no válido"];
                }
                break;

            default:
                http_response_code(405);
                $response = ["status" => "error", "message" => "Método HTTP no soportado"];
                break;
        }
    } else {
        http_response_code(500);
        $response = ["status" => "error", "message" => "Clase del controlador no encontrada"];
    }
} else {
    http_response_code(404);
    $response = ["status" => "error", "message" => "Controlador no encontrado"];
}

// Respuesta en JSON
echo json_encode($response, JSON_UNESCAPED_UNICODE);
?>
