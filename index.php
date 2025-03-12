<?php
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");


require_once "./Router.php";
require_once "./api/controllers/UserController.php";
require_once "./api/controllers/PasanteController.php";
require_once "./api/controllers/HorasMensualesController.php"; 
require_once "./api/controllers/ActividadController.php"; 
require_once "./api/controllers/UsoProductoController.php";
require_once "./api/controllers/InsumosController.php";
require_once "./api/controllers/UsosHerramientasController.php";
require_once "./api/controllers/LotesController.php";
require_once "./api/controllers/ErasController.php";
require_once "./api/controllers/TiposEspeciesController.php";
require_once "./api/controllers/EspeciesController.php";
require_once "./api/controllers/SemillerosController.php";
require_once "./api/controllers/CultivosController.php";
require_once "./api/controllers/PlantacionesController.php";
require_once "./api/controllers/TipoDesechosController.php";
require_once "./api/controllers/DesechosController.php";
require_once "./api/controllers/CosechaController.php";
require_once "./api/controllers/VentasController.php";
require_once "./api/controllers/SensoresController.php";
require_once "./api/controllers/MedicionesController.php";
require_once "./api/controllers/HerramientasController.php";
require_once "./api/controllers/TiposPlagasController.php";
require_once "./api/controllers/PlagasController.php";
require_once "./api/controllers/AfeccionesController.php";
require_once "./api/controllers/TiposControlController.php";
require_once "./api/controllers/ControlesController.php";
require_once "./api/controllers/ProductosControlController.php";
require_once "./api/controllers/UsoProductoController.php";
$router = new Router();


//1-Usuarios
$router->register("GET", "usuarios", "UserController@getAllUsers");
$router->register("GET", "usuarios/{id}", "UserController@getUserById");
$router->register("POST", "usuarios", "UserController@createUser");
$router->register("PUT", "usuarios/{id}", function($id) {
    $controller = new UserController();
    $controller->updateUser($id);
});
$router->register("DELETE", "usuarios/{id}", function($id) {
    $controller = new UserController();
    $controller->deleteUser($id);
});


//2-Pasantes
$router->register("GET", "pasantes", "PasanteController@getAll");
$router->register("GET", "pasantes/{id}", "PasanteController@getById");
$router->register("POST", "pasantes", "PasanteController@create");
$router->register("PUT", "pasantes/{id}", "PasanteController@update");
$router->register("DELETE", "pasantes/{id}", "PasanteController@delete");

//3-Horas Mensuales
$router->register("GET", "horas-mensuales", "HorasMensualesController@getAll");
$router->register("GET", "horas-mensuales/{id}", "HorasMensualesController@getById");
$router->register("POST", "horas-mensuales", "HorasMensualesController@create");
$router->register("PUT", "horas-mensuales/{id}", "HorasMensualesController@update");
$router->register("DELETE", "horas-mensuales/{id}", "HorasMensualesController@delete");


//4-Actividades
$router->register("GET", "actividades", "ActividadController@getAll");
$router->register("GET", "actividades/{id}", "ActividadController@getById");
$router->register("POST", "actividades", "ActividadController@create");
$router->register("PUT", "actividades/{id}", "ActividadController@update");
$router->register("DELETE", "actividades/{id}", "ActividadController@delete");

//5-Uso de Productos
$router->register("GET", "uso-productos", "UsoProductoController@getAll");
$router->register("GET", "uso-productos/{id}", "UsoProductoController@getById");
$router->register("POST", "uso-productos", "UsoProductoController@create");
$router->register("PUT", "uso-productos/{id}", "UsoProductoController@update");
$router->register("DELETE", "uso-productos/{id}", "UsoProductoController@delete");

//6-Insumos
$router->register("GET", "insumos", "InsumosController@getAll");
$router->register("GET", "insumos/{id}", "InsumosController@getById");
$router->register("POST", "insumos", "InsumosController@create");
$router->register("PUT", "insumos/{id}", "InsumosController@update");
$router->register("DELETE", "insumos/{id}", "InsumosController@delete");

//7-Usos de Herramientas
$router->register("GET", "usos-herramientas", "UsosHerramientasController@getAll");
$router->register("GET", "usos-herramientas/{id}", "UsosHerramientasController@getById");
$router->register("POST", "usos-herramientas", "UsosHerramientasController@create");
$router->register("PUT", "usos-herramientas/{id}", "UsosHerramientasController@update");
$router->register("DELETE", "usos-herramientas/{id}", "UsosHerramientasController@delete");

//8-Lotes
$router->register("GET", "lotes", "LotesController@getAll");
$router->register("GET", "lotes/{id}", "LotesController@getById");
$router->register("POST", "lotes", "LotesController@create");
$router->register("PUT", "lotes/{id}", "LotesController@update");
$router->register("DELETE", "lotes/{id}", "LotesController@delete");

//9-Eras
$router->register("GET", "eras", "ErasController@getAll");
$router->register("GET", "eras/{id}", "ErasController@getById");
$router->register("POST", "eras", "ErasController@create");
$router->register("PUT", "eras/{id}", "ErasController@update");
$router->register("DELETE", "eras/{id}", "ErasController@delete");

//10-Tipos de Especies
$router->register("GET", "tipos-especies", "TiposEspeciesController@getAll");
$router->register("GET", "tipos-especies/{id}", "TiposEspeciesController@getById");
$router->register("POST", "tipos-especies", "TiposEspeciesController@create");
$router->register("PUT", "tipos-especies/{id}", "TiposEspeciesController@update");
$router->register("DELETE", "tipos-especies/{id}", "TiposEspeciesController@delete");

//11-Especies
$router->register("GET", "especies", "EspeciesController@getAll");
$router->register("GET", "especies/{id}", "EspeciesController@getById");
$router->register("POST", "especies", "EspeciesController@create");
$router->register("PUT", "especies/{id}", "EspeciesController@update");
$router->register("DELETE", "especies/{id}", "EspeciesController@delete");

//12-Semilleros
$router->register("GET", "semilleros", "SemillerosController@getAll");
$router->register("GET", "semilleros/{id}", "SemillerosController@getById");
$router->register("POST", "semilleros", "SemillerosController@create");
$router->register("PUT", "semilleros/{id}", "SemillerosController@update");
$router->register("DELETE", "semilleros/{id}", "SemillerosController@delete");

//13-Cultivos
$router->register("GET", "cultivos", "CultivosController@getAll");
$router->register("GET", "cultivos/{id}", "CultivosController@getById");
$router->register("POST", "cultivos", "CultivosController@create");
$router->register("PUT", "cultivos/{id}", "CultivosController@update");
$router->register("DELETE", "cultivos/{id}", "CultivosController@delete");

//14-Plantaciones
$router->register("GET", "plantaciones", "PlantacionesController@getAll");
$router->register("GET", "plantaciones/{id}", "PlantacionesController@getById");
$router->register("POST", "plantaciones", "PlantacionesController@create");
$router->register("PUT", "plantaciones/{id}", "PlantacionesController@update");
$router->register("DELETE", "plantaciones/{id}", "PlantacionesController@delete");

//15-Tipo de desechos
$router->register("GET", "tipo-desechos", "TipoDesechosController@getAll");
$router->register("GET", "tipo-desechos/{id}", "TipoDesechosController@getById");
$router->register("POST", "tipo-desechos", "TipoDesechosController@create");
$router->register("PUT", "tipo-desechos/{id}", "TipoDesechosController@update");
$router->register("DELETE", "tipo-desechos/{id}", "TipoDesechosController@delete");

//16-Desechos
$router->register("GET", "desechos", "DesechosController@getAll");
$router->register("GET", "desechos/{id}", "DesechosController@getById");
$router->register("POST", "desechos", "DesechosController@create");
$router->register("PUT", "desechos/{id}", "DesechosController@update");
$router->register("DELETE", "desechos/{id}", "DesechosController@delete");

//17-Cosecha
$router->register("GET", "cosecha", "CosechaController@getAll");
$router->register("GET", "cosecha/{id}", "CosechaController@getById");
$router->register("POST", "cosecha", "CosechaController@create");
$router->register("PUT", "cosecha/{id}", "CosechaController@update");
$router->register("DELETE", "cosecha/{id}", "CosechaController@delete");

//18-ventas
$router->register("GET", "ventas", "VentasController@getAll");
$router->register("GET", "ventas/{id}", "VentasController@getById");
$router->register("POST", "ventas", "VentasController@create");
$router->register("PUT", "ventas/{id}", "VentasController@update");
$router->register("DELETE", "ventas/{id}", "VentasController@delete");

//19-Sensores
$router->register("GET", "sensores", "SensoresController@getAll");
$router->register("GET", "sensores/{id}", "SensoresController@getById");
$router->register("POST", "sensores", "SensoresController@create");
$router->register("PUT", "sensores/{id}", "SensoresController@update");
$router->register("DELETE", "sensores/{id}", "SensoresController@delete");

//20-Mediciones
$router->register("GET", "mediciones", "MedicionesController@getAll");
$router->register("GET", "mediciones/{id}", "MedicionesController@getById");
$router->register("POST", "mediciones", "MedicionesController@create");
$router->register("PUT", "mediciones/{id}", "MedicionesController@update");
$router->register("DELETE", "mediciones/{id}", "MedicionesController@delete");
$router->register("GET", "evapotranspiracion", "MedicionesController@calcularEvapotranspiracion");

//21-Herramientas
$router->register("GET", "herramientas", "HerramientasController@getAll");
$router->register("GET", "herramientas/{id}", "HerramientasController@getById");
$router->register("POST", "herramientas", "HerramientasController@create");
$router->register("PUT", "herramientas/{id}", "HerramientasController@update");
$router->register("DELETE", "herramientas/{id}", "HerramientasController@delete");

//22-Tipos de Plagas
$router->register("GET", "tipos-plagas", "TiposPlagasController@getAll");
$router->register("GET", "tipos-plagas/{id}", "TiposPlagasController@getById");
$router->register("POST", "tipos-plagas", "TiposPlagasController@create");
$router->register("PUT", "tipos-plagas/{id}", "TiposPlagasController@update");
$router->register("DELETE", "tipos-plagas/{id}", "TiposPlagasController@delete");

//23-Plagas
$router->register("GET", "plagas", "PlagasController@getAll");
$router->register("GET", "plagas/{id}", "PlagasController@getById");
$router->register("POST", "plagas", "PlagasController@create");
$router->register("PUT", "plagas/{id}", "PlagasController@update");
$router->register("DELETE", "plagas/{id}", "PlagasController@delete");

//24-Afecciones
$router->register("GET", "afecciones", "AfeccionesController@getAll");
$router->register("GET", "afecciones/{id}", "AfeccionesController@getById");
$router->register("POST", "afecciones", "AfeccionesController@create");
$router->register("PUT", "afecciones/{id}", "AfeccionesController@update");
$router->register("DELETE", "afecciones/{id}", "AfeccionesController@delete");

//25-Controles
$router->register("GET", "controles", "ControlesController@getAll");
$router->register("GET", "controles/{id}", "ControlesController@getById");
$router->register("POST", "controles", "ControlesController@create");
$router->register("PUT", "controles/{id}", "ControlesController@update");
$router->register("DELETE", "controles/{id}", "ControlesController@delete");

//26-Tipo de control
$router->register("GET", "tipos-control", "TiposControlController@getAll");
$router->register("GET", "tipos-control/{id}", "TiposControlController@getById");
$router->register("POST", "tipos-control", "TiposControlController@create");
$router->register("PUT", "tipos-control/{id}", "TiposControlController@update");
$router->register("DELETE", "tipos-control/{id}", "TiposControlController@delete");

//27-ProductosControl
$router->register("GET", "productos-control", "ProductosControlController@getAll");
$router->register("GET", "productos-control/{id}", "ProductosControlController@getById");
$router->register("POST", "productos-control", "ProductosControlController@create");
$router->register("PUT", "productos-control/{id}", "ProductosControlController@update");
$router->register("DELETE", "productos-control/{id}", "ProductosControlController@delete");

//28-Uso Producto 
$router->register("GET", "uso-producto", "UsoProductoController@getAll");
$router->register("GET", "uso-producto/{id}", "UsoProductoController@getById");
$router->register("POST", "uso-producto", "UsoProductoController@create");
$router->register("PUT", "uso-producto/{id}", "UsoProductoController@update");
$router->register("DELETE", "uso-producto/{id}", "UsoProductoController@delete");
//Manejar la solicitud
$router->handleRequest("/API_AgroSoft"); */
?>

<?php
require_once 'autoload.php';

header("Content-Type: application/json");

// Capturar la ruta desde la URL
$requestUri = $_SERVER['REQUEST_URI'];
$basePath = '/API_AgroSoft/'; // Ajusta según la carpeta de tu proyecto
$route = str_replace($basePath, '', $requestUri);
$route = trim($route, '/');
$segments = explode('/', $route);

// Verificar controlador y acción
$controllerName = !empty($segments[0]) ? ucfirst($segments[0]) . 'Controller' : null;
$action = $segments[1] ?? null;
$id = $segments[2] ?? null;

// Verificar si el controlador existe
if ($controllerName && file_exists("api/controllers/$controllerName.php")) {
    require_once "api/controllers/$controllerName.php";
    
    if (class_exists($controllerName)) {
        $controller = new $controllerName();
        $method = $_SERVER['REQUEST_METHOD'];

        // Manejar las solicitudes según el método HTTP
        switch ($method) {
            case 'GET':
                if ($action && method_exists($controller, $action)) {
                    $response = $controller->$action($id);
                } elseif (method_exists($controller, 'index')) {
                    $response = $controller->index(); // Método para traer todos los datos
                } else {
                    $response = ["status" => "error", "message" => "Método GET no válido"];
                }
                break;

            case 'POST':
                $data = json_decode(file_get_contents("php://input"), true);
                if (method_exists($controller, "create")) {
                    $response = $controller->create($data);
                } else {
                    $response = ["status" => "error", "message" => "Método POST no válido"];
                }
                break;

            case 'PUT':
                $data = json_decode(file_get_contents("php://input"), true);
                if ($id && method_exists($controller, "update")) {
                    $response = $controller->update($id, $data);
                } else {
                    $response = ["status" => "error", "message" => "Método PUT no válido"];
                }
                break;

            case 'DELETE':
                if ($id && method_exists($controller, "delete")) {
                    $response = $controller->delete($id);
                } else {
                    $response = ["status" => "error", "message" => "Método DELETE no válido"];
                }
                break;

            default:
                $response = ["status" => "error", "message" => "Método HTTP no soportado"];
                break;
        }
    } else {
        $response = ["status" => "error", "message" => "Clase del controlador no encontrada"];
    }
} else {
    $response = ["status" => "error", "message" => "Controlador no encontrado"];
}

// Devolver la respuesta en JSON
echo json_encode($response);
?>