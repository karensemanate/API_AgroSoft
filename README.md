# API AgroSoft - Backend con JWT

Este backend proporciona un sistema de autenticación y gestión de datos agrícolas basado en **PHP** con **JWT**.

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
/mi-proyecto
│── app/
│   ├── Controllers/
│   │   ├── ArticuloController.php
│   │   ├── LoteController.php
│   │   ├── ... (28 controladores en total)
│   ├── Models/
│   │   ├── Articulo.php
│   │   ├── Lote.php
│   │   ├── ... (28 modelos en total)
│   ├── Middleware/
│   │   ├── AuthMiddleware.php
│   ├── Routes/
│   │   ├── api.php
│── public/
│── config/
│── database/
│── views/
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
3. Configurar la base de datos en `config/config.php`:
   ```php
   define('DB_HOST', 'localhost');
   define('DB_USER', 'root');
   define('DB_PASS', '');
   define('DB_NAME', 'agrosoftnode');
   define('SECRET_KEY', 'tu_clave_secreta_para_jwt');
   ```
4. Ejecutar el servidor PHP:
   ```bash
   php -S localhost:8000 -t public
   ```

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

## Rutas de la API

### Usuarios
- **GET** `/api/users` → Obtiene todos los usuarios (requiere token JWT).
- **GET** `/api/users/{id}` → Obtiene un usuario por su ID.
- **POST** `/api/users` → Crea un nuevo usuario.
- **PUT** `/api/users/{id}` → Actualiza un usuario.
- **DELETE** `/api/users/{id}` → Elimina un usuario.

#### Ejemplo de Request para Crear Usuario:
```json
{
  "nombre": "Karen",
  "correoElectronico": "karen@email.com",
  "password": "123456"
}
```

## Middleware de Autenticación

Para proteger las rutas, se utiliza un middleware que valida el token JWT en la cabecera **Authorization**.

Si el token es inválido, la API devuelve el siguiente mensaje:
```json
{
  "status": "error",
  "message": "Token inválido"
}
```

## Posibles Errores y Soluciones

- **Error 401 Unauthorized** → Asegúrate de enviar el token correcto en la cabecera **Authorization**.
- **Error 500 Internal Server Error** → Revisa la conexión a la base de datos en `config/config.php`.
- **Invalid JWT Token** → El token ha expirado o es incorrecto, inicia sesión nuevamente.

## Base de Datos

Ejemplo de conexión en `database/Database.php`:
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

