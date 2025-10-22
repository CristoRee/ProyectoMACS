-- phpMyAdmin SQL Dump
-- version 5.2.1deb3
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 22-10-2025 a las 17:15:40
-- Versión del servidor: 10.11.13-MariaDB-0ubuntu0.24.04.1
-- Versión de PHP: 8.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `basemacs`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Acciones_Reparacion`
--

CREATE TABLE `Acciones_Reparacion` (
  `id_accion` int(11) NOT NULL,
  `descripcion_accion` text NOT NULL,
  `fecha_hora` datetime NOT NULL DEFAULT current_timestamp(),
  `id_ticket` int(11) NOT NULL,
  `id_tecnico` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Conversaciones`
--

CREATE TABLE `Conversaciones` (
  `id_conversacion` int(11) NOT NULL,
  `id_ticket` int(11) DEFAULT NULL,
  `tipo` enum('TICKET','PRIVADA') NOT NULL DEFAULT 'TICKET',
  `id_participante1` int(11) DEFAULT NULL,
  `id_participante2` int(11) DEFAULT NULL,
  `fecha_creacion` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `Conversaciones`
--

INSERT INTO `Conversaciones` (`id_conversacion`, `id_ticket`, `tipo`, `id_participante1`, `id_participante2`, `fecha_creacion`) VALUES
(3, 3, 'TICKET', NULL, NULL, '2025-10-22 00:54:27'),
(4, 3, 'PRIVADA', 4, 1, '2025-10-22 01:09:55'),
(5, NULL, 'PRIVADA', 4, 1, '2025-10-22 01:18:27');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Estados`
--

CREATE TABLE `Estados` (
  `id_estado` int(11) NOT NULL,
  `nombre_estado` varchar(100) NOT NULL,
  `notificar_cliente` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `Estados`
--

INSERT INTO `Estados` (`id_estado`, `nombre_estado`, `notificar_cliente`) VALUES
(1, 'Ingresado', 0),
(2, 'En diagnóstico', 0),
(3, 'Esperando aprobación', 0),
(4, 'En espera de repuestos', 0),
(5, 'En reparación', 0),
(6, 'Listo para retirar', 0),
(7, 'Finalizado', 0),
(8, 'Cancelado', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Fotos_Ticket`
--

CREATE TABLE `Fotos_Ticket` (
  `id_foto` int(11) NOT NULL,
  `url_imagen` varchar(255) NOT NULL,
  `id_ticket` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Historial`
--

CREATE TABLE `Historial` (
  `id_historial` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `id_ticket` int(11) DEFAULT NULL,
  `accion` varchar(255) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `Historial`
--

INSERT INTO `Historial` (`id_historial`, `id_usuario`, `id_ticket`, `accion`, `fecha`) VALUES
(1, 1, NULL, 'El usuario \'ant\' inició sesión.', '2025-10-22 00:21:56'),
(2, NULL, NULL, 'Se registró un nuevo usuario: \'basicuser\'.', '2025-10-22 00:27:05'),
(3, 2, NULL, 'El usuario \'basicuser\' inició sesión.', '2025-10-22 00:27:14'),
(4, 1, NULL, 'El usuario \'ant\' cerró sesión.', '2025-10-22 00:33:48'),
(5, NULL, NULL, 'Se registró un nuevo usuario: \'ho\'.', '2025-10-22 00:34:07'),
(6, 3, NULL, 'El usuario \'ho\' inició sesión.', '2025-10-22 00:34:12'),
(7, 3, NULL, 'El usuario \'ho\' cerró sesión.', '2025-10-22 00:35:55'),
(8, 1, NULL, 'El usuario \'ant\' inició sesión.', '2025-10-22 00:35:58'),
(9, 1, NULL, 'El usuario \'ant\' cerró sesión.', '2025-10-22 00:46:05'),
(10, NULL, NULL, 'Se registró un nuevo usuario: \'ang\'.', '2025-10-22 00:46:22'),
(11, 4, NULL, 'El usuario \'ang\' inició sesión.', '2025-10-22 00:46:34'),
(12, 4, NULL, 'El usuario \'ang\' cerró sesión.', '2025-10-22 00:47:20'),
(13, 1, NULL, 'El usuario \'ant\' inició sesión.', '2025-10-22 00:47:24'),
(14, NULL, NULL, 'Se registró un nuevo usuario: \'cris\'.', '2025-10-22 00:50:08'),
(15, 5, NULL, 'El usuario \'cris\' inició sesión.', '2025-10-22 00:50:14'),
(16, 1, NULL, 'El admin \'ant\' actualizó el perfil del usuario #4.', '2025-10-22 00:50:25'),
(17, 1, 3, 'El admin \'ant\' asignó el ticket #3 al técnico \'ang\'.', '2025-10-22 00:50:59'),
(18, 1, NULL, 'El usuario \'ant\' cerró sesión.', '2025-10-22 00:51:12'),
(19, 4, NULL, 'El usuario \'ang\' inició sesión.', '2025-10-22 00:51:15'),
(20, 4, 3, 'El usuario \'ang\' cambió el estado del ticket #3 de \'Ingresado\' a \'En diagnóstico\'.', '2025-10-22 00:59:31'),
(21, 4, NULL, 'El usuario \'ang\' cerró sesión.', '2025-10-22 01:09:27'),
(22, 1, NULL, 'El usuario \'ant\' inició sesión.', '2025-10-22 01:09:30'),
(23, 1, NULL, 'El usuario \'ant\' cerró sesión.', '2025-10-22 01:10:10'),
(24, 1, NULL, 'El usuario \'ant\' inició sesión.', '2025-10-22 01:10:14'),
(25, 1, NULL, 'El usuario \'ant\' cerró sesión.', '2025-10-22 01:10:36'),
(26, 4, NULL, 'El usuario \'ang\' inició sesión.', '2025-10-22 01:10:41'),
(27, 4, NULL, 'El usuario \'ang\' cerró sesión.', '2025-10-22 01:12:44'),
(28, 1, NULL, 'El usuario \'ant\' inició sesión.', '2025-10-22 01:12:47'),
(29, 1, NULL, 'El usuario \'ant\' cerró sesión.', '2025-10-22 01:15:20'),
(30, 4, NULL, 'El usuario \'ang\' inició sesión.', '2025-10-22 01:15:25'),
(31, 4, NULL, 'El usuario \'ang\' cerró sesión.', '2025-10-22 01:17:20'),
(32, 1, NULL, 'El usuario \'ant\' inició sesión.', '2025-10-22 01:17:25'),
(33, 1, NULL, 'El usuario \'ant\' cerró sesión.', '2025-10-22 01:20:36'),
(34, 4, NULL, 'El usuario \'ang\' inició sesión.', '2025-10-22 01:20:40'),
(35, 1, NULL, 'El usuario \'ant\' inició sesión.', '2025-10-22 01:22:17'),
(36, 4, NULL, 'El usuario \'ang\' actualizó su foto de perfil.', '2025-10-22 01:34:13'),
(37, 4, NULL, 'El usuario \'ang\' cerró sesión.', '2025-10-22 01:34:25'),
(38, 4, NULL, 'El usuario \'ang\' inició sesión.', '2025-10-22 01:34:29'),
(39, 4, NULL, 'El usuario \'ang\' cerró sesión.', '2025-10-22 01:34:38'),
(40, 1, NULL, 'El usuario \'ant\' inició sesión.', '2025-10-22 01:34:43'),
(41, 1, NULL, 'El usuario \'ant\' actualizó su foto de perfil.', '2025-10-22 01:36:01'),
(42, 1, NULL, 'El usuario \'ant\' cerró sesión.', '2025-10-22 01:39:23'),
(43, 1, NULL, 'El usuario \'ant\' inició sesión.', '2025-10-22 01:40:20'),
(44, 5, NULL, 'El usuario \'cris\' inició sesión.', '2025-10-22 01:53:22'),
(45, 1, NULL, 'El usuario \'ant\' cerró sesión.', '2025-10-22 01:59:18'),
(46, 4, NULL, 'El usuario \'ang\' inició sesión.', '2025-10-22 01:59:25'),
(47, 4, NULL, 'El usuario \'ang\' cerró sesión.', '2025-10-22 02:18:39'),
(48, 1, NULL, 'El usuario \'ant\' inició sesión.', '2025-10-22 02:18:43'),
(49, 1, NULL, 'El usuario \'ant\' cerró sesión.', '2025-10-22 02:19:06'),
(50, 4, NULL, 'El usuario \'ang\' inició sesión.', '2025-10-22 02:19:12'),
(51, 4, NULL, 'El usuario \'ang\' cerró sesión.', '2025-10-22 02:35:36'),
(52, 1, NULL, 'El usuario \'ant\' inició sesión.', '2025-10-22 02:35:40'),
(53, 1, NULL, 'El usuario \'ant\' cerró sesión.', '2025-10-22 02:40:48'),
(54, 4, NULL, 'El usuario \'ang\' inició sesión.', '2025-10-22 02:40:52'),
(55, 4, NULL, 'El usuario \'ang\' cerró sesión.', '2025-10-22 02:42:30'),
(56, 1, NULL, 'El usuario \'ant\' inició sesión.', '2025-10-22 02:42:36'),
(57, 1, NULL, 'El usuario \'ant\' inició sesión.', '2025-10-22 16:02:48'),
(58, 1, NULL, 'El admin \'ant\' actualizó el perfil del usuario #2.', '2025-10-22 16:03:11'),
(59, 1, NULL, 'El admin \'ant\' actualizó el perfil del usuario #2.', '2025-10-22 16:03:25'),
(60, 1, NULL, 'El usuario \'ant\' cerró sesión.', '2025-10-22 16:11:07'),
(61, 4, NULL, 'El usuario \'ang\' inició sesión.', '2025-10-22 16:11:11'),
(62, 4, 3, 'El usuario \'ang\' cambió el estado del ticket #3 de \'En diagnóstico\' a \'Esperando aprobación\'.', '2025-10-22 16:20:00'),
(63, 4, 3, 'El usuario \'ang\' cambió el estado del ticket #3 de \'Esperando aprobación\' a \'Listo para retirar\'.', '2025-10-22 16:38:34'),
(64, 4, 3, 'El usuario \'ang\' cambió el estado del ticket #3 de \'Listo para retirar\' a \'En espera de repuestos\'.', '2025-10-22 16:38:40'),
(65, 4, NULL, 'El usuario \'ang\' cerró sesión.', '2025-10-22 16:55:15'),
(66, 1, NULL, 'El usuario \'ant\' inició sesión.', '2025-10-22 16:55:19'),
(67, 1, NULL, 'El usuario \'ant\' cerró sesión.', '2025-10-22 16:58:15'),
(68, 4, NULL, 'El usuario \'ang\' inició sesión.', '2025-10-22 16:58:19'),
(69, 1, NULL, 'El usuario \'ant\' inició sesión.', '2025-10-22 17:04:46');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Mensajes`
--

CREATE TABLE `Mensajes` (
  `id_mensaje` int(11) NOT NULL,
  `id_conversacion` int(11) NOT NULL,
  `id_emisor` int(11) NOT NULL,
  `id_receptor` int(11) NOT NULL,
  `contenido` text NOT NULL,
  `fecha_envio` timestamp NULL DEFAULT current_timestamp(),
  `leido` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `Mensajes`
--

INSERT INTO `Mensajes` (`id_mensaje`, `id_conversacion`, `id_emisor`, `id_receptor`, `contenido`, `fecha_envio`, `leido`) VALUES
(2, 3, 4, 5, 'sos un inutil', '2025-10-22 00:54:35', 1),
(3, 3, 4, 5, 'sal', '2025-10-22 00:59:06', 1),
(4, 3, 4, 5, 'lin', '2025-10-22 00:59:10', 1),
(5, 3, 4, 5, 'gor', '2025-10-22 00:59:39', 1),
(6, 3, 4, 5, 'fresco', '2025-10-22 01:00:39', 1),
(7, 3, 4, 5, 'kor', '2025-10-22 01:01:16', 1),
(8, 3, 4, 5, 'ekjie', '2025-10-22 01:01:18', 1),
(9, 3, 4, 5, 'hiiye', '2025-10-22 01:01:19', 1),
(10, 3, 4, 5, 'weu9e9wy98ye', '2025-10-22 01:01:21', 1),
(11, 3, 4, 5, 'sos un inutl', '2025-10-22 01:06:01', 1),
(12, 4, 1, 4, 've el error', '2025-10-22 01:10:02', 0),
(13, 4, 1, 4, 'ta', '2025-10-22 01:10:25', 0),
(14, 4, 1, 4, 'sos', '2025-10-22 01:15:11', 0),
(15, 5, 4, 1, 'Hola admin, soy el técnico ang', '2025-10-22 01:18:48', 1),
(16, 5, 1, 4, 'hole', '2025-10-22 01:19:25', 1),
(17, 5, 1, 4, 'hole', '2025-10-22 01:19:30', 1),
(18, 5, 1, 4, 'hoel', '2025-10-22 01:19:33', 1),
(19, 5, 4, 1, 'sos un loco', '2025-10-22 01:20:53', 1),
(20, 5, 1, 4, 'Que pasa', '2025-10-22 01:22:29', 1),
(21, 5, 1, 4, 'Ke pasa', '2025-10-22 01:22:35', 1),
(22, 5, 1, 4, 'N', '2025-10-22 01:22:49', 1),
(23, 5, 1, 4, 'Kaksks', '2025-10-22 01:22:54', 1),
(24, 5, 1, 4, 'Alo', '2025-10-22 01:23:48', 1),
(25, 5, 1, 4, 'Cuanto tiempo', '2025-10-22 01:24:04', 1),
(26, 5, 1, 4, 'Estas', '2025-10-22 01:26:57', 1),
(27, 3, 5, 4, 'kkkkk', '2025-10-22 01:53:37', 1),
(28, 5, 1, 4, 'hole', '2025-10-22 01:58:44', 1),
(29, 5, 1, 4, 'Como estas ', '2025-10-22 01:58:56', 1),
(30, 5, 4, 1, 'bien', '2025-10-22 01:59:36', 1),
(31, 5, 4, 1, 'que raro sos', '2025-10-22 02:02:15', 1),
(32, 5, 1, 4, 'Si', '2025-10-22 02:02:44', 1),
(33, 5, 1, 4, 'Zoy raro', '2025-10-22 02:02:50', 1),
(34, 5, 1, 4, 'Que divertido', '2025-10-22 02:03:02', 1),
(35, 5, 4, 1, 'a', '2025-10-22 02:03:09', 1),
(36, 5, 1, 4, 'Me encanta ', '2025-10-22 02:03:16', 1),
(37, 3, 4, 5, 'ea', '2025-10-22 02:14:38', 0),
(38, 5, 4, 1, 'sos', '2025-10-22 02:16:40', 1),
(39, 5, 1, 4, 'Ke', '2025-10-22 02:19:18', 1),
(40, 5, 4, 1, 'loco', '2025-10-22 02:19:25', 1),
(41, 5, 4, 1, 'ja', '2025-10-22 02:32:11', 1),
(42, 5, 1, 4, 'Je', '2025-10-22 02:32:48', 1),
(43, 5, 4, 1, 'tas loca', '2025-10-22 02:33:03', 1),
(44, 5, 1, 4, 'Xor', '2025-10-22 02:33:15', 1),
(45, 5, 1, 4, 'es', '2025-10-22 02:36:18', 1),
(46, 5, 1, 4, 'kere', '2025-10-22 02:36:23', 1),
(47, 5, 1, 4, 'Dodo', '2025-10-22 02:38:27', 1),
(48, 5, 1, 4, 'dado', '2025-10-22 02:40:33', 1),
(49, 5, 1, 4, 'ganas', '2025-10-22 02:40:37', 1),
(50, 5, 4, 1, 'kekio', '2025-10-22 02:41:06', 1),
(51, 5, 1, 4, 'Roste', '2025-10-22 02:41:16', 1),
(52, 5, 1, 4, 'Hola', '2025-10-22 17:05:03', 1),
(53, 5, 1, 4, 'Como esta la cosas', '2025-10-22 17:05:20', 1),
(54, 5, 4, 1, 'bien', '2025-10-22 17:05:34', 1),
(55, 5, 4, 1, 'estad', '2025-10-22 17:07:30', 1),
(56, 5, 1, 4, 'Todo bien', '2025-10-22 17:07:39', 1),
(57, 5, 4, 1, 'sos es', '2025-10-22 17:11:20', 1),
(58, 5, 1, 4, 'Que manera', '2025-10-22 17:11:43', 1),
(59, 5, 1, 4, 'Qur bien ', '2025-10-22 17:11:50', 1),
(60, 5, 4, 1, 'si me soprendiste', '2025-10-22 17:11:56', 1),
(61, 5, 1, 4, 'Pero ts', '2025-10-22 17:12:04', 1),
(62, 5, 1, 4, 'Ay maneras de areglaro', '2025-10-22 17:12:14', 1),
(63, 5, 4, 1, 'si gracias', '2025-10-22 17:12:22', 1),
(64, 5, 1, 4, 'Vamos Aya ', '2025-10-22 17:12:48', 1),
(65, 5, 4, 1, 'si luis', '2025-10-22 17:12:59', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Productos`
--

CREATE TABLE `Productos` (
  `id_producto` int(11) NOT NULL,
  `tipo_producto` varchar(100) DEFAULT NULL,
  `marca` varchar(100) DEFAULT NULL,
  `modelo` varchar(100) DEFAULT NULL,
  `numero_serie` varchar(255) DEFAULT NULL,
  `id_cliente` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `Productos`
--

INSERT INTO `Productos` (`id_producto`, `tipo_producto`, `marca`, `modelo`, `numero_serie`, `id_cliente`) VALUES
(1, 'Tablet', 'sin marca', 'sin modelo', NULL, 2),
(2, 'Computadora', 'sos ', 'sos', NULL, 4),
(3, 'Laptop', 'HP', '21', NULL, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Repuestos`
--

CREATE TABLE `Repuestos` (
  `id_repuesto` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `precio` decimal(10,2) NOT NULL,
  `imagen` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `Repuestos`
--

INSERT INTO `Repuestos` (`id_repuesto`, `nombre`, `descripcion`, `stock`, `precio`, `imagen`) VALUES
(2, 'ssd', '', 1, 22.00, 'uploads/piezas/68f90b1d8c566.jpeg'),
(3, 'm.2', '', 1, 200.00, 'uploads/piezas/68f90b3cafc04.jpeg'),
(4, 'pantalla', '', 20, 2000.00, 'uploads/piezas/68f90d1a088e9.jpeg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Roles`
--

CREATE TABLE `Roles` (
  `id_rol` int(11) NOT NULL,
  `nombre_rol` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `Roles`
--

INSERT INTO `Roles` (`id_rol`, `nombre_rol`) VALUES
(1, 'Administrador'),
(3, 'Cliente'),
(2, 'Técnico');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Tickets`
--

CREATE TABLE `Tickets` (
  `id_ticket` int(11) NOT NULL,
  `descripcion_problema` text NOT NULL,
  `diagnostico_tecnico` text DEFAULT NULL,
  `fecha_ingreso` datetime NOT NULL DEFAULT current_timestamp(),
  `fecha_finalizacion` datetime DEFAULT NULL,
  `id_cliente` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `id_tecnico_asignado` int(11) DEFAULT NULL,
  `id_estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `Tickets`
--

INSERT INTO `Tickets` (`id_ticket`, `descripcion_problema`, `diagnostico_tecnico`, `fecha_ingreso`, `fecha_finalizacion`, `id_cliente`, `id_producto`, `id_tecnico_asignado`, `id_estado`) VALUES
(2, 's0s', NULL, '2025-10-21 21:46:49', NULL, 4, 2, NULL, 1),
(3, 'No arranca', NULL, '2025-10-21 21:50:45', NULL, 5, 3, 4, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Ticket_Usa_Repuesto`
--

CREATE TABLE `Ticket_Usa_Repuesto` (
  `cantidad_usada` int(11) NOT NULL DEFAULT 1,
  `id_ticket` int(11) NOT NULL,
  `id_repuesto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `Ticket_Usa_Repuesto`
--

INSERT INTO `Ticket_Usa_Repuesto` (`cantidad_usada`, `id_ticket`, `id_repuesto`) VALUES
(1, 3, 3),
(1, 3, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Usuarios`
--

CREATE TABLE `Usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nombre_usuario` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `telefono` varchar(50) DEFAULT NULL,
  `especializacion` varchar(255) DEFAULT NULL,
  `foto_perfil` varchar(255) DEFAULT NULL,
  `id_rol` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `Usuarios`
--

INSERT INTO `Usuarios` (`id_usuario`, `nombre_usuario`, `email`, `password_hash`, `telefono`, `especializacion`, `foto_perfil`, `id_rol`) VALUES
(1, 'ant', 'hre@hhe.com', '$2y$10$4kW6/s.9Yy.lf4LIJmA6bue7ZWnQ.HbZJ4sKoRwJJvJkME441t5FO', NULL, NULL, 'uploads/perfiles/user_1_68f835015da55.png', 1),
(2, 'basicuser', 'basicuser@gmail.com', '$2y$10$HVzLVaeXSZs/PoxgLLdJ..emLqXSAISK/WpKvAoh4yBUwk1tWw3n2', '', NULL, NULL, 3),
(3, 'ho', 'hee@eee.com', '$2y$10$o1zaYh8.y2mb07DQt4Az9uDzEMUKmjOj.fhTs5xKuNE6ABWWrEC32', NULL, NULL, NULL, 3),
(4, 'ang', 'ang33@12.com', '$2y$10$LbV14YgB6Y3nqc92HY3Ya..s8AJA0Dg.4gzEFmmDoEMrrnSTuzTLe', '', NULL, 'uploads/perfiles/user_4_68f83495aa82e.png', 2),
(5, 'cris', 'cris@hotmail.com', '$2y$10$.NQXyiDuR/DkmHOAc4mg3eORRABXwmFX/X0G.HTWMmIpOThTqBtEe', NULL, NULL, NULL, 3);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `Acciones_Reparacion`
--
ALTER TABLE `Acciones_Reparacion`
  ADD PRIMARY KEY (`id_accion`),
  ADD KEY `id_ticket` (`id_ticket`),
  ADD KEY `id_tecnico` (`id_tecnico`);

--
-- Indices de la tabla `Conversaciones`
--
ALTER TABLE `Conversaciones`
  ADD PRIMARY KEY (`id_conversacion`),
  ADD UNIQUE KEY `idx_ticket_tipo` (`id_ticket`,`tipo`),
  ADD KEY `fk_participante1_idx` (`id_participante1`),
  ADD KEY `fk_participante2_idx` (`id_participante2`);

--
-- Indices de la tabla `Estados`
--
ALTER TABLE `Estados`
  ADD PRIMARY KEY (`id_estado`),
  ADD UNIQUE KEY `nombre_estado` (`nombre_estado`);

--
-- Indices de la tabla `Fotos_Ticket`
--
ALTER TABLE `Fotos_Ticket`
  ADD PRIMARY KEY (`id_foto`),
  ADD KEY `id_ticket` (`id_ticket`);

--
-- Indices de la tabla `Historial`
--
ALTER TABLE `Historial`
  ADD PRIMARY KEY (`id_historial`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_ticket` (`id_ticket`);

--
-- Indices de la tabla `Mensajes`
--
ALTER TABLE `Mensajes`
  ADD PRIMARY KEY (`id_mensaje`),
  ADD KEY `id_conversacion` (`id_conversacion`),
  ADD KEY `id_emisor` (`id_emisor`),
  ADD KEY `id_receptor` (`id_receptor`);

--
-- Indices de la tabla `Productos`
--
ALTER TABLE `Productos`
  ADD PRIMARY KEY (`id_producto`),
  ADD UNIQUE KEY `numero_serie` (`numero_serie`),
  ADD KEY `id_cliente` (`id_cliente`);

--
-- Indices de la tabla `Repuestos`
--
ALTER TABLE `Repuestos`
  ADD PRIMARY KEY (`id_repuesto`);

--
-- Indices de la tabla `Roles`
--
ALTER TABLE `Roles`
  ADD PRIMARY KEY (`id_rol`),
  ADD UNIQUE KEY `nombre_rol` (`nombre_rol`);

--
-- Indices de la tabla `Tickets`
--
ALTER TABLE `Tickets`
  ADD PRIMARY KEY (`id_ticket`),
  ADD KEY `id_cliente` (`id_cliente`),
  ADD KEY `id_producto` (`id_producto`),
  ADD KEY `id_tecnico_asignado` (`id_tecnico_asignado`),
  ADD KEY `id_estado` (`id_estado`);

--
-- Indices de la tabla `Ticket_Usa_Repuesto`
--
ALTER TABLE `Ticket_Usa_Repuesto`
  ADD PRIMARY KEY (`id_ticket`,`id_repuesto`),
  ADD KEY `id_repuesto` (`id_repuesto`);

--
-- Indices de la tabla `Usuarios`
--
ALTER TABLE `Usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `id_rol` (`id_rol`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `Acciones_Reparacion`
--
ALTER TABLE `Acciones_Reparacion`
  MODIFY `id_accion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `Conversaciones`
--
ALTER TABLE `Conversaciones`
  MODIFY `id_conversacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `Estados`
--
ALTER TABLE `Estados`
  MODIFY `id_estado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `Fotos_Ticket`
--
ALTER TABLE `Fotos_Ticket`
  MODIFY `id_foto` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `Historial`
--
ALTER TABLE `Historial`
  MODIFY `id_historial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT de la tabla `Mensajes`
--
ALTER TABLE `Mensajes`
  MODIFY `id_mensaje` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT de la tabla `Productos`
--
ALTER TABLE `Productos`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `Repuestos`
--
ALTER TABLE `Repuestos`
  MODIFY `id_repuesto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `Roles`
--
ALTER TABLE `Roles`
  MODIFY `id_rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `Tickets`
--
ALTER TABLE `Tickets`
  MODIFY `id_ticket` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `Usuarios`
--
ALTER TABLE `Usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `Acciones_Reparacion`
--
ALTER TABLE `Acciones_Reparacion`
  ADD CONSTRAINT `Acciones_Reparacion_ibfk_1` FOREIGN KEY (`id_ticket`) REFERENCES `Tickets` (`id_ticket`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Acciones_Reparacion_ibfk_2` FOREIGN KEY (`id_tecnico`) REFERENCES `Usuarios` (`id_usuario`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `Conversaciones`
--
ALTER TABLE `Conversaciones`
  ADD CONSTRAINT `fk_conversacion_ticket` FOREIGN KEY (`id_ticket`) REFERENCES `Tickets` (`id_ticket`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_participante1` FOREIGN KEY (`id_participante1`) REFERENCES `Usuarios` (`id_usuario`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_participante2` FOREIGN KEY (`id_participante2`) REFERENCES `Usuarios` (`id_usuario`) ON DELETE SET NULL;

--
-- Filtros para la tabla `Fotos_Ticket`
--
ALTER TABLE `Fotos_Ticket`
  ADD CONSTRAINT `Fotos_Ticket_ibfk_1` FOREIGN KEY (`id_ticket`) REFERENCES `Tickets` (`id_ticket`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `Historial`
--
ALTER TABLE `Historial`
  ADD CONSTRAINT `Historial_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `Usuarios` (`id_usuario`) ON DELETE SET NULL,
  ADD CONSTRAINT `Historial_ibfk_2` FOREIGN KEY (`id_ticket`) REFERENCES `Tickets` (`id_ticket`) ON DELETE CASCADE;

--
-- Filtros para la tabla `Mensajes`
--
ALTER TABLE `Mensajes`
  ADD CONSTRAINT `Mensajes_ibfk_1` FOREIGN KEY (`id_conversacion`) REFERENCES `Conversaciones` (`id_conversacion`) ON DELETE CASCADE,
  ADD CONSTRAINT `Mensajes_ibfk_2` FOREIGN KEY (`id_emisor`) REFERENCES `Usuarios` (`id_usuario`) ON DELETE CASCADE,
  ADD CONSTRAINT `Mensajes_ibfk_3` FOREIGN KEY (`id_receptor`) REFERENCES `Usuarios` (`id_usuario`) ON DELETE CASCADE;

--
-- Filtros para la tabla `Productos`
--
ALTER TABLE `Productos`
  ADD CONSTRAINT `Productos_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `Usuarios` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `Tickets`
--
ALTER TABLE `Tickets`
  ADD CONSTRAINT `Tickets_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `Usuarios` (`id_usuario`) ON UPDATE CASCADE,
  ADD CONSTRAINT `Tickets_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `Productos` (`id_producto`) ON UPDATE CASCADE,
  ADD CONSTRAINT `Tickets_ibfk_3` FOREIGN KEY (`id_tecnico_asignado`) REFERENCES `Usuarios` (`id_usuario`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `Tickets_ibfk_4` FOREIGN KEY (`id_estado`) REFERENCES `Estados` (`id_estado`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `Ticket_Usa_Repuesto`
--
ALTER TABLE `Ticket_Usa_Repuesto`
  ADD CONSTRAINT `Ticket_Usa_Repuesto_ibfk_1` FOREIGN KEY (`id_ticket`) REFERENCES `Tickets` (`id_ticket`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Ticket_Usa_Repuesto_ibfk_2` FOREIGN KEY (`id_repuesto`) REFERENCES `Repuestos` (`id_repuesto`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `Usuarios`
--
ALTER TABLE `Usuarios`
  ADD CONSTRAINT `Usuarios_ibfk_1` FOREIGN KEY (`id_rol`) REFERENCES `Roles` (`id_rol`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
