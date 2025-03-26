# API AgroSoft - Backend con JWT

Este es un sistema desarrollado en PHP bajo el patrón MVC, con autenticación mediante JWT, diseñado para gestionar información relacionada con las actividades agrícolas en la C.G.D.S.S. y sus áreas de influencia.

## Tecnologías Utilizadas

- **PHP 8+**
- **MySQL**
- **Composer**
- **Firebase JWT** (para autenticación)
- **Apache o Nginx**

## Repositorio

Puedes acceder al código fuente en GitHub:
[API_AgroSoft](https://github.com/karensemanate/API_AgroSoft.git)

## Estructura del Proyecto

```
/API_AgroSoft
│── api/
│   ├── config/
│   ├── controllers/
│   │   ├── ArticuloController.php
│   │   ├── LoteController.php
│   │   ├── ... (28 controladores en total)
│   ├── models/
│   │   ├── Articulo.php
│   │   ├── Lote.php
│   │   ├── ... (28 modelos en total)
│   ├── uploads/
│   ├── middleware.php
│── vendor/
│── .env
│── .htaccess
│── agrosoftnode.sql
│── autoload.php
│── composer.json
│── composer.lock
│── index.php
│── README.md
```

## Instalación y Configuración

1. Clonar este repositorio:
   ```bash
   git clone https://github.com/karensemanate/API_AgroSoft.git
   ```
2. Instalar las dependencias con Composer:
   ```bash
   composer install
   ```
3. Configurar la base de datos en `api/config/config.php`:
   ```php
   define('DB_HOST', 'localhost');
   define('DB_USER', 'root');
   define('DB_PASS', '');
   define('DB_NAME', 'agrosoftnode');
   define('SECRET_KEY', 'tu_clave_secreta_para_jwt');
   ```
4. Importar la base de datos desde el archivo `agrosoftnode.sql` en MySQL.
5. Ejecutar el servidor PHP:
   ```bash
   php -S localhost:8000 -t api
   ```

## Uso de la API en Postman

La API sigue la siguiente estructura de rutas:
```
http://localhost/API_AgroSoft/{controller}/{metodo}
```
Donde:
- **{controller}** es el nombre del controlador que deseas usar (por ejemplo, `user`, `articulo`, `lote`).
- **{metodo}** es el método que deseas ejecutar (`getAll`, `getById`, `create`, `update`, `delete`, `patch`).

### Ejemplos de Uso en Postman

#### 1. Obtener todos los registros de un controlador
- **Endpoint:** `GET http://localhost/API_AgroSoft/user/getAll`
- **Descripción:** Devuelve todos los usuarios.

#### 2. Obtener un registro por ID
- **Endpoint:** `GET http://localhost/API_AgroSoft/user/getById/{id}`
- **Ejemplo:** `GET http://localhost/API_AgroSoft/user/getById/1`

#### 3. Crear un nuevo registro
- **Endpoint:** `POST http://localhost/API_AgroSoft/user/create`
- **Body (JSON):**
  ```json
  {
    "nombre": "Karen",
    "correoElectronico": "karen@email.com",
    "password": "123456"
  }
  ```

#### 4. Actualizar un registro (PUT o PATCH)
- **PUT (actualización completa):** `PUT http://localhost/API_AgroSoft/user/update/{id}`
- **PATCH (actualización parcial):** `PATCH http://localhost/API_AgroSoft/user/patch/{id}`

#### 5. Eliminar un registro
- **Endpoint:** `DELETE http://localhost/API_AgroSoft/user/delete/{id}`

## Autenticación con JWT

El sistema usa **JSON Web Tokens (JWT)** para la autenticación.

### Endpoint de Login
- **POST** `/api/login` → Inicia sesión y devuelve un token JWT.

#### Ejemplo de Request:
```json
{
  "usuario": "correo@ejemplo.com",
  "password": "123456"
}
```

#### Ejemplo de Respuesta:
```json
{
  "status": "success",
  "token": "eyJhbGciOiJIUzI1..."
}
```

### Uso del Token JWT
Para acceder a rutas protegidas, agrega el token en el encabezado **Authorization**:
```
Authorization: Bearer {token}
```

## Middleware de Autenticación

Si el token es inválido, la API devuelve el siguiente mensaje:
```json
{
  "status": "error",
  "message": "Token inválido"
}
```

## Posibles Errores y Soluciones

- **Error 401 Unauthorized** → Asegúrate de enviar el token correcto en la cabecera **Authorization**.
- **Error 500 Internal Server Error** → Revisa la conexión a la base de datos en `api/config/config.php`.
- **Invalid JWT Token** → El token ha expirado o es incorrecto, inicia sesión nuevamente.

## Base de Datos

Ejemplo de conexión en `api/config/Database.php`:
```php
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
```

## Autor

Desarrollado por **Karen Yuliana Semanate Bolaños**.

Si tienes mejoras, siéntete libre de contribuir enviando un **Pull Request**. 🚀

