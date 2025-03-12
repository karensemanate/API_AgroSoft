-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 12-03-2025 a las 16:13:49
-- Versión del servidor: 8.0.30
-- Versión de PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `agrosoftnode`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actividades`
--

CREATE TABLE `actividades` (
  `id` int NOT NULL,
  `fk_Cultivos` int NOT NULL,
  `fk_Usuarios` bigint NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `descripcion` text NOT NULL,
  `fecha` date NOT NULL,
  `estado` enum('Asignada','Completada','Cancelada') NOT NULL DEFAULT (_cp850'Asignada')
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `actividades`
--

INSERT INTO `actividades` (`id`, `fk_Cultivos`, `fk_Usuarios`, `titulo`, `descripcion`, `fecha`, `estado`) VALUES
(5, 17, 123, 'cosecha', 'cosechar la lechuga', '2024-06-06', 'Asignada'),
(6, 17, 123, 'recolectar', 'cosechar la lechuga', '2024-06-06', 'Asignada');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `afecciones`
--

CREATE TABLE `afecciones` (
  `id` int NOT NULL,
  `fk_Plantaciones` int NOT NULL,
  `fk_Plagas` int NOT NULL,
  `fechaEncuentro` date NOT NULL,
  `estado` enum('SinTratamiento','EnControl','Eliminado') NOT NULL DEFAULT (_cp850'SinTratamiento')
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `afecciones`
--

INSERT INTO `afecciones` (`id`, `fk_Plantaciones`, `fk_Plagas`, `fechaEncuentro`, `estado`) VALUES
(2, 32, 1, '2025-04-09', 'EnControl'),
(4, 32, 1, '2025-03-08', 'EnControl');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `controles`
--

CREATE TABLE `controles` (
  `id` int NOT NULL,
  `fk_Afecciones` int NOT NULL,
  `fk_TiposControl` int NOT NULL,
  `descripcion` text NOT NULL,
  `fechaControl` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `controles`
--

INSERT INTO `controles` (`id`, `fk_Afecciones`, `fk_TiposControl`, `descripcion`, `fechaControl`) VALUES
(1, 2, 1, 'asdasdas', '2025-02-02'),
(3, 2, 1, 'fumigacion', '2025-03-03'),
(4, 2, 1, 'abonar', '2025-03-03');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cosechas`
--

CREATE TABLE `cosechas` (
  `id` int NOT NULL,
  `fk_Cultivos` int NOT NULL,
  `unidades` int NOT NULL,
  `fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `cosechas`
--

INSERT INTO `cosechas` (`id`, `fk_Cultivos`, `unidades`, `fecha`) VALUES
(3, 16, 2, '2025-03-02');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cultivos`
--

CREATE TABLE `cultivos` (
  `id` int NOT NULL,
  `fk_Especies` int NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `unidades` int NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT (1),
  `fechaSiembra` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `cultivos`
--

INSERT INTO `cultivos` (`id`, `fk_Especies`, `nombre`, `unidades`, `activo`, `fechaSiembra`) VALUES
(16, 1, 'Manzana', 50, 1, '2024-02-12'),
(17, 6, 'lechuga', 20, 1, '2025-02-19'),
(18, 1, 'Manzanas', 5, 0, '2025-02-01'),
(19, 3, 'tomate cherry', 50, 1, '2025-02-13'),
(20, 5, 'Manzana', 100, 1, '2025-02-13');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `desechos`
--

CREATE TABLE `desechos` (
  `id` int NOT NULL,
  `fk_Cultivos` int NOT NULL,
  `fk_TiposDesecho` int NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `descripcion` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `desechos`
--

INSERT INTO `desechos` (`id`, `fk_Cultivos`, `fk_TiposDesecho`, `nombre`, `descripcion`) VALUES
(3, 16, 2, 'Ejemplo Semillero', 'Este es un semillero de prueba');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `eras`
--

CREATE TABLE `eras` (
  `id` int NOT NULL,
  `fk_Lotes` int NOT NULL,
  `tamX` decimal(3,2) NOT NULL,
  `tamY` decimal(3,2) NOT NULL,
  `posX` decimal(3,2) NOT NULL,
  `posY` decimal(3,2) NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT (1)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `eras`
--

INSERT INTO `eras` (`id`, `fk_Lotes`, `tamX`, `tamY`, `posX`, `posY`, `estado`) VALUES
(1, 4, 2.00, 3.00, 3.21, -7.34, 1),
(3, 8, 1.50, 2.50, 3.21, -7.34, 1),
(4, 8, 1.80, 2.80, 3.21, -7.34, 0),
(5, 3, 1.40, 2.40, 3.21, -7.34, 1),
(6, 4, 2.00, 3.00, 3.21, -7.34, 1),
(7, 4, 2.20, 3.20, 3.21, -7.34, 0),
(8, 5, 1.60, 2.60, 3.21, -7.34, 1),
(9, 6, 2.50, 3.50, 3.22, -7.35, 1),
(10, 10, 1.00, 7.00, 6.00, -7.35, 1),
(18, 10, 1.00, 2.00, 5.00, 1.00, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `especies`
--

CREATE TABLE `especies` (
  `id` int NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `descripcion` text NOT NULL,
  `img` varchar(255) DEFAULT NULL,
  `tiempoCrecimiento` int NOT NULL,
  `fk_TiposEspecie` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `especies`
--

INSERT INTO `especies` (`id`, `nombre`, `descripcion`, `img`, `tiempoCrecimiento`, `fk_TiposEspecie`) VALUES
(1, 'Manzano', 'Árbol frutal que produce manzanas', NULL, 180, 1),
(2, 'Peral', 'Árbol frutal que produce peras', NULL, 160, 1),
(3, 'Tomate', 'Planta hortaliza que produce tomates', NULL, 80, 2),
(4, 'Lechuga', 'Hortaliza de hojas verdes comestibles', NULL, 30, 2),
(5, 'Zanahoria', 'Raíz comestible de color naranja', NULL, 75, 2),
(6, 'hortalizas', 'bella', NULL, 3, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `herramientas`
--

CREATE TABLE `herramientas` (
  `id` int NOT NULL,
  `fk_Lotes` int NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `descripcion` text NOT NULL,
  `unidades` int NOT NULL,
  `estado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `herramientas`
--

INSERT INTO `herramientas` (`id`, `fk_Lotes`, `nombre`, `descripcion`, `unidades`, `estado`) VALUES
(1, 1, 'Pica', 'Pica descripcion', 1, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horasmensuales`
--

CREATE TABLE `horasmensuales` (
  `id` int NOT NULL,
  `fk_Pasantes` int NOT NULL,
  `minutos` int NOT NULL,
  `salario` int NOT NULL,
  `mes` varchar(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `horasmensuales`
--

INSERT INTO `horasmensuales` (`id`, `fk_Pasantes`, `minutos`, `salario`, `mes`) VALUES
(51, 1, 480, 96000, 'marzo'),
(52, 1, 520, 104000, 'marzo'),
(53, 1, 500, 100000, 'abril'),
(54, 1, 530, 106000, 'abril'),
(55, 1, 510, 102000, 'mayo'),
(56, 1, 540, 108000, 'mayo'),
(57, 1, 520, 104000, 'junio'),
(58, 1, 550, 110000, 'junio'),
(59, 1, 530, 106000, 'julio'),
(60, 1, 560, 112000, 'julio'),
(61, 2, 450, 67500, 'febrer'),
(62, 2, 470, 70500, 'febrer'),
(63, 2, 460, 69000, 'marzo'),
(64, 2, 480, 72000, 'marzo'),
(65, 2, 470, 70500, 'abril'),
(66, 2, 490, 73500, 'abril'),
(67, 2, 480, 72000, 'mayo'),
(68, 2, 500, 75000, 'mayo'),
(69, 2, 490, 73500, 'junio'),
(70, 2, 510, 76500, 'junio'),
(71, 3, 600, 150000, 'enero'),
(72, 3, 620, 155000, 'enero'),
(73, 3, 610, 152500, 'febrer'),
(74, 3, 630, 157500, 'febrer'),
(75, 3, 620, 155000, 'marzo'),
(76, 3, 640, 160000, 'marzo'),
(77, 3, 630, 157500, 'abril'),
(78, 3, 650, 162500, 'abril'),
(79, 3, 640, 160000, 'mayo'),
(80, 3, 660, 165000, 'mayo'),
(81, 4, 400, 46667, 'abril'),
(82, 4, 420, 49000, 'abril'),
(83, 4, 410, 47833, 'mayo'),
(84, 4, 430, 50167, 'mayo'),
(85, 4, 420, 49000, 'junio'),
(86, 4, 440, 51400, 'junio'),
(87, 4, 430, 50167, 'julio'),
(88, 4, 450, 52500, 'julio'),
(89, 4, 440, 51400, 'agosto'),
(90, 4, 460, 53833, 'agosto'),
(91, 5, 550, 123750, 'mayo'),
(92, 5, 570, 128250, 'mayo'),
(93, 5, 560, 126000, 'junio'),
(94, 5, 580, 130500, 'junio'),
(95, 5, 570, 128250, 'julio'),
(96, 5, 590, 132750, 'julio'),
(97, 5, 580, 130500, 'agosto'),
(98, 5, 600, 135000, 'agosto'),
(99, 5, 590, 132750, 'septi'),
(100, 5, 610, 137250, 'septi'),
(101, 1, 120, 50000, '2024-02');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `insumos`
--

CREATE TABLE `insumos` (
  `id` int NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `descripcion` text NOT NULL,
  `precio` int NOT NULL,
  `unidades` tinyint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `insumos`
--

INSERT INTO `insumos` (`id`, `nombre`, `descripcion`, `precio`, `unidades`) VALUES
(1, 'purga', ' purga descripcion', 10000, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lotes`
--

CREATE TABLE `lotes` (
  `id` int NOT NULL,
  `nombre` varchar(15) NOT NULL,
  `descripcion` text NOT NULL,
  `tamX` tinyint NOT NULL,
  `tamY` tinyint NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT (1),
  `posX` decimal(3,2) NOT NULL,
  `posY` decimal(3,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `lotes`
--

INSERT INTO `lotes` (`id`, `nombre`, `descripcion`, `tamX`, `tamY`, `estado`, `posX`, `posY`) VALUES
(1, 'Lote 1', 'Cultivo de maíz', 50, 100, 1, 3.22, 7.63),
(2, 'Lote 2', 'Plantación de café', 80, 100, 1, 3.22, 7.63),
(3, 'Lote 3', 'Zona de frutales', 60, 100, 0, 3.22, 7.63),
(4, 'Lote 4', 'Campo de arroz', 70, 100, 1, 3.22, 7.63),
(5, 'Lote 5', 'Terreno de hortalizas', 40, 90, 1, 3.22, 7.63),
(6, 'Lote 6', 'Cultivo de papa', 100, 100, 1, 3.22, 7.63),
(7, 'Lote 7', 'Zona de cebolla', 45, 95, 1, 3.22, 7.63),
(8, 'Lote 8', 'Invernadero de lechuga', 30, 80, 1, 3.22, 7.63),
(9, 'Lote 9', 'Plantación de plátano', 85, 100, 1, 3.22, 7.63),
(10, 'Lote 10', 'Zona experimental', 55, 100, 0, 3.22, 7.63),
(11, 'Lote 11', 'Cultivo de fresas', 35, 70, 1, 3.23, 7.64),
(12, 'Lote 12', 'Viñedo', 90, 100, 1, 3.23, 7.64),
(13, 'Lote 13', 'Huerta de manzanas', 75, 100, 1, 3.23, 7.64),
(14, 'Lote 14', 'Plantación de mangos', 65, 100, 1, 3.23, 7.64),
(15, 'Lote 15', 'Cultivo de peras', 50, 100, 1, 3.23, 7.64);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mediciones`
--

CREATE TABLE `mediciones` (
  `id` int NOT NULL,
  `fk_Sensor` int DEFAULT NULL,
  `fk_Lote` int DEFAULT NULL,
  `fk_Era` int DEFAULT NULL,
  `valor` decimal(10,2) DEFAULT NULL,
  `fecha` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `mediciones`
--

INSERT INTO `mediciones` (`id`, `fk_Sensor`, `fk_Lote`, `fk_Era`, `valor`, `fecha`) VALUES
(4, 2, NULL, 1, 25.50, '2025-03-02 00:00:00'),
(5, 2, NULL, 3, 25.50, '2025-03-02 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pasantes`
--

CREATE TABLE `pasantes` (
  `id` int NOT NULL,
  `fk_Usuarios` bigint NOT NULL,
  `fechaInicioPasantia` date NOT NULL,
  `fechaFinalizacion` date NOT NULL,
  `salarioHora` int NOT NULL,
  `area` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `pasantes`
--

INSERT INTO `pasantes` (`id`, `fk_Usuarios`, `fechaInicioPasantia`, `fechaFinalizacion`, `salarioHora`, `area`) VALUES
(1, 123, '2025-03-12', '2025-08-12', 15000, 'Café'),
(2, 1047384923, '2025-02-15', '2025-07-15', 9000, 'Platanal'),
(3, 1067324819, '2025-01-10', '2025-06-10', 15000, 'Horticultura'),
(4, 1070598678, '2025-04-01', '2025-09-30', 7000, 'Café'),
(5, 1078236459, '2025-05-20', '2025-10-20', 13500, 'Platanal'),
(6, 123, '2025-03-12', '2025-08-12', 15000, 'Café');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `plagas`
--

CREATE TABLE `plagas` (
  `id` int NOT NULL,
  `fk_TiposPlaga` int NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `descripcion` text NOT NULL,
  `img` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `plagas`
--

INSERT INTO `plagas` (`id`, `fk_TiposPlaga`, `nombre`, `descripcion`, `img`) VALUES
(1, 1, 'insectos', 'asdasd', 'img'),
(2, 3, 'insectos', 'asdasd', 'uploads/0_529_arana-roja.jpg'),
(3, 3, 'Araña roja', 'rojita y muchas', 'uploads/67c6086a5ffda_ara.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `plantaciones`
--

CREATE TABLE `plantaciones` (
  `id` int NOT NULL,
  `fk_Cultivos` int NOT NULL,
  `fk_Eras` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `plantaciones`
--

INSERT INTO `plantaciones` (`id`, `fk_Cultivos`, `fk_Eras`) VALUES
(32, 16, 5),
(53, 16, 1),
(54, 17, 3),
(55, 17, 4),
(56, 18, 4),
(57, 19, 3),
(58, 20, 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productoscontrol`
--

CREATE TABLE `productoscontrol` (
  `id` int NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `precio` int NOT NULL,
  `compuestoActivo` varchar(20) NOT NULL,
  `fichaTecnica` text NOT NULL,
  `contenido` int NOT NULL,
  `tipoContenido` varchar(10) NOT NULL,
  `unidades` tinyint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `productoscontrol`
--

INSERT INTO `productoscontrol` (`id`, `nombre`, `precio`, `compuestoActivo`, `fichaTecnica`, `contenido`, `tipoContenido`, `unidades`) VALUES
(1, 'asda', 1111, 'ns', 'asda', 100, 'L', 20),
(2, 'Babosal', 12500, 'calcio', 'aaaaa', 100, 'L', 20);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `semilleros`
--

CREATE TABLE `semilleros` (
  `id` int NOT NULL,
  `fk_Especies` int NOT NULL,
  `unidades` int NOT NULL,
  `fechaSiembra` date NOT NULL,
  `fechaEstimada` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `semilleros`
--

INSERT INTO `semilleros` (`id`, `fk_Especies`, `unidades`, `fechaSiembra`, `fechaEstimada`) VALUES
(1, 1, 100, '2025-01-01', '2025-07-01'),
(2, 2, 120, '2025-02-01', '2025-08-01'),
(3, 3, 200, '2025-03-01', '2025-05-20'),
(4, 4, 300, '2025-04-01', '2025-05-01'),
(5, 5, 250, '2025-05-01', '2025-07-15');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sensores`
--

CREATE TABLE `sensores` (
  `id` int NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `tipo` enum('temperatura','humedad_terreno','humedad_ambiental','iluminacion','viento','pH') DEFAULT NULL,
  `descripcion` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `sensores`
--

INSERT INTO `sensores` (`id`, `nombre`, `tipo`, `descripcion`) VALUES
(2, 'Sensor de humedad', 'humedad_terreno', 'Sensor para medir la humedad del suelo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tiposcontrol`
--

CREATE TABLE `tiposcontrol` (
  `id` int NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `descripcion` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `tiposcontrol`
--

INSERT INTO `tiposcontrol` (`id`, `nombre`, `descripcion`) VALUES
(1, 'retiro manual', 'asas'),
(2, 'control biologico', 'Para las hortalizas');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tiposdesecho`
--

CREATE TABLE `tiposdesecho` (
  `id` int NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `descripcion` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `tiposdesecho`
--

INSERT INTO `tiposdesecho` (`id`, `nombre`, `descripcion`) VALUES
(1, 'Orgánico', 'Desechos biodegradables'),
(2, 'Inorgánico', 'Desechos no biodegradables');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tiposespecie`
--

CREATE TABLE `tiposespecie` (
  `id` int NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `descripcion` text NOT NULL,
  `img` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `tiposespecie`
--

INSERT INTO `tiposespecie` (`id`, `nombre`, `descripcion`, `img`) VALUES
(1, 'Frutal', 'Especies que producen frutos', NULL),
(2, 'Hortaliza', 'Especies cultivadas para consumo', NULL),
(4, 'Frutales', 'Especies que producen frutos', NULL),
(5, 'Frutales', 'Especies que producen frutos', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tiposplaga`
--

CREATE TABLE `tiposplaga` (
  `id` int NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `descripcion` text NOT NULL,
  `img` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `tiposplaga`
--

INSERT INTO `tiposplaga` (`id`, `nombre`, `descripcion`, `img`) VALUES
(1, 'insectos', 'asdasd', 'img'),
(3, 'Araña roja', 'rojita y muchas', 'uploads/0_529_arana-roja.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usoproductocontrol`
--

CREATE TABLE `usoproductocontrol` (
  `id` int NOT NULL,
  `fk_ProductosControl` int NOT NULL,
  `fk_Controles` int NOT NULL,
  `cantidadProducto` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usosherramientas`
--

CREATE TABLE `usosherramientas` (
  `id` int NOT NULL,
  `fk_Herramientas` int NOT NULL,
  `fk_Actividades` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `usosherramientas`
--

INSERT INTO `usosherramientas` (`id`, `fk_Herramientas`, `fk_Actividades`) VALUES
(2, 1, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usosproductos`
--

CREATE TABLE `usosproductos` (
  `id` int NOT NULL,
  `fk_Insumos` int NOT NULL,
  `fk_Actividades` int NOT NULL,
  `cantidadProducto` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `usosproductos`
--

INSERT INTO `usosproductos` (`id`, `fk_Insumos`, `fk_Actividades`, `cantidadProducto`) VALUES
(2, 1, 5, 20),
(3, 1, 5, 20);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `identificacion` bigint NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `apellidos` varchar(50) NOT NULL,
  `fechaNacimiento` date NOT NULL,
  `telefono` varchar(15) NOT NULL,
  `correoElectronico` varchar(200) NOT NULL,
  `passwordHash` varchar(60) NOT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT (0)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`identificacion`, `nombre`, `apellidos`, `fechaNacimiento`, `telefono`, `correoElectronico`, `passwordHash`, `admin`) VALUES
(123, 'luis', 'Pérez Gómez', '2000-01-01', '123456789', 'juan@example.com', '$2y$10$r1JCCFWT.OIYMaV73okJFOBFnipJhIjf2/KZQBwTpMUQSJ2TvWjNy', 0),
(1000000000, 'Pepe Poio', 'Poio Perez', '2005-02-06', '3101234123', 'ejemplo@gmail.com', '$2b$10$N2G.4daICzOJgQzIsnW.NOxHu5QPgfeef6Ki1tbKEO8rlGz2qE2oa', 0),
(1012345876, 'José Andrés', 'Torres Gómez', '1993-08-05', '3198765432', 'jose.torres@outlook.com', '$2b$10$zDjs2Rhr5Me1RIRVOho22.PEiyfXGhyjqqH8/97Z4ItNdwAqQEyM2', 0),
(1047384923, 'Carlos Alberto', 'Martínez Pérez', '1998-07-15', '3156541234', 'carlos.martinez@gmail.com', '$2b$10$GEBmV98qtkLVPzg1cD9MaO1Fd1fty8k78DNSQTWwJrQQxw3ra5OwG', 0),
(1067324819, 'Luis Eduardo', 'González Sánchez', '1995-05-30', '3125674321', 'luis.gonzalez@yahoo.com', '$2b$10$rragh/Cbg4eYcEy76SZZnO1Twi7L8DfexfUfkCieY8t0rowAYrPfS', 0),
(1070598678, 'Estefany Daniela', 'Parada Escalante', '2007-11-11', '3201236789', 'stefanny@gmail.com', '$2b$10$NuDI8gjzB5Ekc2n3RrEAQuaU36vCmAlevP2fGLpaWQsAK.DmMgpYe', 0),
(1078236459, 'Felipe Javier', 'Cabrera García', '2001-12-18', '3141236789', 'felipe.cabrera@hotmail.com', '$2b$10$J178o3sQVGNy4wH5kxS9UOQrWU0f7mXvBLyNifaEaQu.TuFSyF48G', 0),
(1079534351, 'Luis Alejandro', 'Bonilla Echeverri', '2005-02-06', '3202615357', 'alendroideyt@gmail.com', '$2b$10$BUVewugF4WT9tZKTClxwMeZaYgigr7R1i.3s3RayvkcB6VFKCC0o6', 1),
(1083869594, 'Sergio Augusto', 'García Murcia', '2005-01-20', '3134325678', 'augusto@gmail.com', '$2b$10$kCfnTZRiNjQc6ysXhEqtLuKjanXKwCJGsUxzj9n01PaO2ssyEWrRC', 0),
(1098753467, 'María Fernanda', 'Hernández Romero', '2000-11-10', '3134567890', 'maria.hernandez@gmail.com', '$2b$10$4qDl0CoijKZUzJhJNr0yo.kf/.avlWzDK1Hn7fo2nY7taFgalvqzy', 0),
(1129456781, 'Ana Lucía', 'Ramírez López', '2002-03-22', '3147896543', 'ana.ramirez@hotmail.com', '$2b$10$CdtlbTQie26DjZn/zJFR4e9hVXnoKTU7EQrsTtdyl0XKffbfvDMJC', 0),
(1135674928, 'Isabella Sofía', 'Pérez Ruiz', '2004-02-28', '3187456321', 'isabella.perez@gmail.com', '$2b$10$PNre9gUkOIHn0eJawTn7Ne8olrIRipl2d.tsmp400zqmEXlLCwpDO', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `id` int NOT NULL,
  `fk_Cosechas` int NOT NULL,
  `precioUnitario` int NOT NULL,
  `fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`id`, `fk_Cosechas`, `precioUnitario`, `fecha`) VALUES
(3, 3, 200, '2025-03-02');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `actividades`
--
ALTER TABLE `actividades`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_Cultivos` (`fk_Cultivos`),
  ADD KEY `fk_Usuarios` (`fk_Usuarios`);

--
-- Indices de la tabla `afecciones`
--
ALTER TABLE `afecciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_Plantaciones` (`fk_Plantaciones`),
  ADD KEY `fk_Plagas` (`fk_Plagas`);

--
-- Indices de la tabla `controles`
--
ALTER TABLE `controles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_Afecciones` (`fk_Afecciones`),
  ADD KEY `fk_TiposControl` (`fk_TiposControl`);

--
-- Indices de la tabla `cosechas`
--
ALTER TABLE `cosechas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_Cultivos` (`fk_Cultivos`);

--
-- Indices de la tabla `cultivos`
--
ALTER TABLE `cultivos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_Especies` (`fk_Especies`);

--
-- Indices de la tabla `desechos`
--
ALTER TABLE `desechos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_Cultivos` (`fk_Cultivos`),
  ADD KEY `fk_TiposDesecho` (`fk_TiposDesecho`);

--
-- Indices de la tabla `eras`
--
ALTER TABLE `eras`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_Lotes` (`fk_Lotes`);

--
-- Indices de la tabla `especies`
--
ALTER TABLE `especies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `esUna` (`fk_TiposEspecie`);

--
-- Indices de la tabla `herramientas`
--
ALTER TABLE `herramientas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_Lotes` (`fk_Lotes`);

--
-- Indices de la tabla `horasmensuales`
--
ALTER TABLE `horasmensuales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_Pasantes` (`fk_Pasantes`);

--
-- Indices de la tabla `insumos`
--
ALTER TABLE `insumos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `lotes`
--
ALTER TABLE `lotes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `mediciones`
--
ALTER TABLE `mediciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_Sensor` (`fk_Sensor`),
  ADD KEY `fk_Lote` (`fk_Lote`),
  ADD KEY `fk_Era` (`fk_Era`);

--
-- Indices de la tabla `pasantes`
--
ALTER TABLE `pasantes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_Usuarios` (`fk_Usuarios`);

--
-- Indices de la tabla `plagas`
--
ALTER TABLE `plagas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_TiposPlaga` (`fk_TiposPlaga`);

--
-- Indices de la tabla `plantaciones`
--
ALTER TABLE `plantaciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_Cultivos` (`fk_Cultivos`),
  ADD KEY `fk_Eras` (`fk_Eras`);

--
-- Indices de la tabla `productoscontrol`
--
ALTER TABLE `productoscontrol`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `semilleros`
--
ALTER TABLE `semilleros`
  ADD PRIMARY KEY (`id`),
  ADD KEY `esDe` (`fk_Especies`);

--
-- Indices de la tabla `sensores`
--
ALTER TABLE `sensores`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tiposcontrol`
--
ALTER TABLE `tiposcontrol`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tiposdesecho`
--
ALTER TABLE `tiposdesecho`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tiposespecie`
--
ALTER TABLE `tiposespecie`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tiposplaga`
--
ALTER TABLE `tiposplaga`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usoproductocontrol`
--
ALTER TABLE `usoproductocontrol`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_ProductosControl` (`fk_ProductosControl`),
  ADD KEY `fk_Controles` (`fk_Controles`);

--
-- Indices de la tabla `usosherramientas`
--
ALTER TABLE `usosherramientas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_Herramientas` (`fk_Herramientas`),
  ADD KEY `fk_Actividades` (`fk_Actividades`);

--
-- Indices de la tabla `usosproductos`
--
ALTER TABLE `usosproductos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_Insumos` (`fk_Insumos`),
  ADD KEY `fk_Actividades` (`fk_Actividades`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`identificacion`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_Cosechas` (`fk_Cosechas`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `actividades`
--
ALTER TABLE `actividades`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `afecciones`
--
ALTER TABLE `afecciones`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `controles`
--
ALTER TABLE `controles`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `cosechas`
--
ALTER TABLE `cosechas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `cultivos`
--
ALTER TABLE `cultivos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `desechos`
--
ALTER TABLE `desechos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `eras`
--
ALTER TABLE `eras`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `especies`
--
ALTER TABLE `especies`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `herramientas`
--
ALTER TABLE `herramientas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `horasmensuales`
--
ALTER TABLE `horasmensuales`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT de la tabla `insumos`
--
ALTER TABLE `insumos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `lotes`
--
ALTER TABLE `lotes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `mediciones`
--
ALTER TABLE `mediciones`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `pasantes`
--
ALTER TABLE `pasantes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `plagas`
--
ALTER TABLE `plagas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `plantaciones`
--
ALTER TABLE `plantaciones`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT de la tabla `productoscontrol`
--
ALTER TABLE `productoscontrol`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `semilleros`
--
ALTER TABLE `semilleros`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `sensores`
--
ALTER TABLE `sensores`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tiposcontrol`
--
ALTER TABLE `tiposcontrol`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tiposdesecho`
--
ALTER TABLE `tiposdesecho`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tiposespecie`
--
ALTER TABLE `tiposespecie`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `tiposplaga`
--
ALTER TABLE `tiposplaga`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usoproductocontrol`
--
ALTER TABLE `usoproductocontrol`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usosherramientas`
--
ALTER TABLE `usosherramientas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `usosproductos`
--
ALTER TABLE `usosproductos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `actividades`
--
ALTER TABLE `actividades`
  ADD CONSTRAINT `actividades_ibfk_1` FOREIGN KEY (`fk_Cultivos`) REFERENCES `cultivos` (`id`),
  ADD CONSTRAINT `actividades_ibfk_2` FOREIGN KEY (`fk_Usuarios`) REFERENCES `usuarios` (`identificacion`);

--
-- Filtros para la tabla `afecciones`
--
ALTER TABLE `afecciones`
  ADD CONSTRAINT `afecciones_ibfk_1` FOREIGN KEY (`fk_Plantaciones`) REFERENCES `plantaciones` (`id`),
  ADD CONSTRAINT `afecciones_ibfk_2` FOREIGN KEY (`fk_Plagas`) REFERENCES `plagas` (`id`);

--
-- Filtros para la tabla `controles`
--
ALTER TABLE `controles`
  ADD CONSTRAINT `controles_ibfk_1` FOREIGN KEY (`fk_Afecciones`) REFERENCES `afecciones` (`id`),
  ADD CONSTRAINT `controles_ibfk_2` FOREIGN KEY (`fk_TiposControl`) REFERENCES `tiposcontrol` (`id`);

--
-- Filtros para la tabla `cosechas`
--
ALTER TABLE `cosechas`
  ADD CONSTRAINT `cosechas_ibfk_1` FOREIGN KEY (`fk_Cultivos`) REFERENCES `cultivos` (`id`);

--
-- Filtros para la tabla `cultivos`
--
ALTER TABLE `cultivos`
  ADD CONSTRAINT `cultivos_ibfk_1` FOREIGN KEY (`fk_Especies`) REFERENCES `especies` (`id`);

--
-- Filtros para la tabla `desechos`
--
ALTER TABLE `desechos`
  ADD CONSTRAINT `desechos_ibfk_1` FOREIGN KEY (`fk_Cultivos`) REFERENCES `cultivos` (`id`),
  ADD CONSTRAINT `desechos_ibfk_2` FOREIGN KEY (`fk_TiposDesecho`) REFERENCES `tiposdesecho` (`id`);

--
-- Filtros para la tabla `eras`
--
ALTER TABLE `eras`
  ADD CONSTRAINT `eras_ibfk_1` FOREIGN KEY (`fk_Lotes`) REFERENCES `lotes` (`id`);

--
-- Filtros para la tabla `especies`
--
ALTER TABLE `especies`
  ADD CONSTRAINT `esUna` FOREIGN KEY (`fk_TiposEspecie`) REFERENCES `tiposespecie` (`id`);

--
-- Filtros para la tabla `herramientas`
--
ALTER TABLE `herramientas`
  ADD CONSTRAINT `herramientas_ibfk_1` FOREIGN KEY (`fk_Lotes`) REFERENCES `lotes` (`id`);

--
-- Filtros para la tabla `horasmensuales`
--
ALTER TABLE `horasmensuales`
  ADD CONSTRAINT `horasmensuales_ibfk_1` FOREIGN KEY (`fk_Pasantes`) REFERENCES `pasantes` (`id`);

--
-- Filtros para la tabla `mediciones`
--
ALTER TABLE `mediciones`
  ADD CONSTRAINT `mediciones_ibfk_1` FOREIGN KEY (`fk_Sensor`) REFERENCES `sensores` (`id`),
  ADD CONSTRAINT `mediciones_ibfk_2` FOREIGN KEY (`fk_Lote`) REFERENCES `lotes` (`id`),
  ADD CONSTRAINT `mediciones_ibfk_3` FOREIGN KEY (`fk_Era`) REFERENCES `eras` (`id`);

--
-- Filtros para la tabla `pasantes`
--
ALTER TABLE `pasantes`
  ADD CONSTRAINT `pasantes_ibfk_1` FOREIGN KEY (`fk_Usuarios`) REFERENCES `usuarios` (`identificacion`);

--
-- Filtros para la tabla `plagas`
--
ALTER TABLE `plagas`
  ADD CONSTRAINT `plagas_ibfk_1` FOREIGN KEY (`fk_TiposPlaga`) REFERENCES `tiposplaga` (`id`);

--
-- Filtros para la tabla `plantaciones`
--
ALTER TABLE `plantaciones`
  ADD CONSTRAINT `plantaciones_ibfk_1` FOREIGN KEY (`fk_Cultivos`) REFERENCES `cultivos` (`id`),
  ADD CONSTRAINT `plantaciones_ibfk_2` FOREIGN KEY (`fk_Eras`) REFERENCES `eras` (`id`);

--
-- Filtros para la tabla `semilleros`
--
ALTER TABLE `semilleros`
  ADD CONSTRAINT `esDe` FOREIGN KEY (`fk_Especies`) REFERENCES `especies` (`id`);

--
-- Filtros para la tabla `usoproductocontrol`
--
ALTER TABLE `usoproductocontrol`
  ADD CONSTRAINT `usoproductocontrol_ibfk_1` FOREIGN KEY (`fk_ProductosControl`) REFERENCES `productoscontrol` (`id`),
  ADD CONSTRAINT `usoproductocontrol_ibfk_2` FOREIGN KEY (`fk_Controles`) REFERENCES `controles` (`id`);

--
-- Filtros para la tabla `usosherramientas`
--
ALTER TABLE `usosherramientas`
  ADD CONSTRAINT `usosherramientas_ibfk_1` FOREIGN KEY (`fk_Herramientas`) REFERENCES `herramientas` (`id`),
  ADD CONSTRAINT `usosherramientas_ibfk_2` FOREIGN KEY (`fk_Actividades`) REFERENCES `actividades` (`id`);

--
-- Filtros para la tabla `usosproductos`
--
ALTER TABLE `usosproductos`
  ADD CONSTRAINT `usosproductos_ibfk_1` FOREIGN KEY (`fk_Insumos`) REFERENCES `insumos` (`id`),
  ADD CONSTRAINT `usosproductos_ibfk_2` FOREIGN KEY (`fk_Actividades`) REFERENCES `actividades` (`id`);

--
-- Filtros para la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD CONSTRAINT `ventas_ibfk_1` FOREIGN KEY (`fk_Cosechas`) REFERENCES `cosechas` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
