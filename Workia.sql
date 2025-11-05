-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 06-11-2025 a las 00:08:54
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `workia`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administrador`
--

CREATE TABLE `administrador` (
  `id_administrador` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `id_cliente` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`id_cliente`, `id_usuario`, `email`, `nombre`) VALUES
(7, 9, 'julioGonzales@gmail.com', 'Pablo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensajes`
--

CREATE TABLE `mensajes` (
  `id_mensaje` int(11) NOT NULL,
  `contenido` varchar(200) NOT NULL,
  `id_receptor` int(11) NOT NULL,
  `id_emisor` int(11) NOT NULL,
  `fecha` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `mensajes`
--

INSERT INTO `mensajes` (`id_mensaje`, `contenido`, `id_receptor`, `id_emisor`, `fecha`) VALUES
(1, 'Hola como estas', 8, 9, '2025-10-30 20:05:14'),
(2, 'Hola como estas', 7, 9, '2025-10-30 20:09:01'),
(3, 'hola todo bien?', 7, 9, '2025-10-30 20:09:16'),
(4, 'Hola todo bien y vos?', 9, 7, '2025-10-30 20:10:00'),
(5, 'Hola como estas', 7, 7, '2025-10-30 20:11:09'),
(6, 'Hola como estas', 7, 7, '2025-10-30 20:11:23'),
(7, 'Hola como estas', 7, 7, '2025-10-30 20:11:41');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proovedor`
--

CREATE TABLE `proovedor` (
  `id_proovedor` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `cantidad_servicios` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `proovedor`
--

INSERT INTO `proovedor` (`id_proovedor`, `id_usuario`, `nombre`, `email`, `cantidad_servicios`) VALUES
(1, 4, 'Julio', 'julioGonzales@gmail.com', 0),
(2, 6, 'Jugito', 'jidjie@awd.com', 0),
(3, 7, 'Martin', 'martinbuscher198@gmail.com', 0),
(4, 8, 'Pablo', 'pwbv2010@gmail.com', 0),
(5, 10, 'Martin', 'martinbuscher198@gmail.com', 0),
(6, 1, 'Martin', 'martinbuscher198@gmail.com', 0),
(7, 5, 'Pablo', 'jidjie@awd.com', 0),
(8, 6, 'Cereales', 'cereal@gmail.com', 0),
(9, 7, 'Martin', 'martinbuscher198@gmail.com', 0),
(10, 8, 'Pablo', 'pwbv2010@gmail.com', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `provee`
--

CREATE TABLE `provee` (
  `id_proovedor` int(11) NOT NULL,
  `id_servicio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `provee`
--

INSERT INTO `provee` (`id_proovedor`, `id_servicio`) VALUES
(3, 7),
(3, 8);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recibe`
--

CREATE TABLE `recibe` (
  `id_cliente` int(11) NOT NULL,
  `id_resena` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resena`
--

CREATE TABLE `resena` (
  `id_resena` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `id_servicio` int(11) NOT NULL,
  `calificacion` int(11) NOT NULL,
  `comentario` text DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `resena`
--

INSERT INTO `resena` (`id_resena`, `id_cliente`, `id_servicio`, `calificacion`, `comentario`, `fecha`) VALUES
(1, 7, 5, 3, 'Muy buen servicio', '2025-10-31 17:19:11'),
(2, 7, 5, 5, 'excelente servicio', '2025-10-31 17:21:24');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reserva`
--

CREATE TABLE `reserva` (
  `id_cliente` int(11) NOT NULL,
  `id_servicio` int(11) NOT NULL,
  `fecha_reserva` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `reserva`
--

INSERT INTO `reserva` (`id_cliente`, `id_servicio`, `fecha_reserva`) VALUES
(7, 7, '2025-10-31 11:20:10');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicio`
--

CREATE TABLE `servicio` (
  `id_servicio` int(11) NOT NULL,
  `id_cliente` int(11) DEFAULT NULL,
  `id_proovedor` int(11) DEFAULT NULL,
  `nombre_servicio` varchar(50) NOT NULL,
  `precio` varchar(50) NOT NULL,
  `imagen` varchar(255) NOT NULL,
  `descripcion` varchar(200) NOT NULL,
  `ciudad` varchar(255) NOT NULL,
  `departamento` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `servicio`
--

INSERT INTO `servicio` (`id_servicio`, `id_cliente`, `id_proovedor`, `nombre_servicio`, `precio`, `imagen`, `descripcion`, `ciudad`, `departamento`) VALUES
(5, NULL, 4, 'Cereales', '150', 'imagenes/cereales.jpg', 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Doloribus sit assumenda molestiae facilis ad corporis possimus quas pariatur at provident, nulla libero, error, amet nobis eum! Dolores maiore', '', ''),
(7, NULL, 3, 'Un jugo muy rico', '200', 'imagenes/jugoAdes.jpg', 'excelente servicio de crear jugos', '', ''),
(8, NULL, 3, 'Servicio espadas', '150', 'imagenes/espada.png', 'Es un servicio que se trata de crear espadas a tu gusto, medida, perzonalicacion, skin, todo lo que te imagen, exelente servicio de espadas!', 'Piedras blancas', 'Montevideo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `telefono`
--

CREATE TABLE `telefono` (
  `id_usuario` int(11) NOT NULL,
  `telefono` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `telefono`
--

INSERT INTO `telefono` (`id_usuario`, `telefono`) VALUES
(7, '92478413'),
(8, '92123345'),
(9, '09444443');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `tipo_usuario` varchar(50) NOT NULL,
  `fecha_registro` datetime NOT NULL,
  `contrasena` varchar(250) NOT NULL,
  `cv` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre`, `apellido`, `email`, `tipo_usuario`, `fecha_registro`, `contrasena`, `cv`) VALUES
(7, 'Martin', 'Buscher', 'martinbuscher198@gmail.com', 'proovedor', '2025-10-30 22:44:21', '$2y$10$JD6vohzHjQASlINZlDQeQu.IF0mnLkAtdWAm8hOcHLnvIbnS2BL1a', 'cvs/cv_7/MiCV.pdf'),
(8, 'Pablo', 'Buscher', 'pwbv2010@gmail.com', 'proovedor', '2025-10-30 22:54:01', '$2y$10$Nhrb1tmjjo.uyBh9K2IjLeV/KazmdV1KZN2t6WJaVQMn9RvQTcrGC', NULL),
(9, 'Pablo', 'Tegnalia', 'julioGonzales@gmail.com', 'cliente', '2025-10-30 23:15:07', '$2y$10$tRZa8.rXTQ5eEs30Ra2dBO7Ey0pF5G/vQbWZvbO7MdCJfPtBOTRJi', NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `administrador`
--
ALTER TABLE `administrador`
  ADD PRIMARY KEY (`id_administrador`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`id_cliente`),
  ADD KEY `fk_idUsuario_cliente` (`id_usuario`);

--
-- Indices de la tabla `mensajes`
--
ALTER TABLE `mensajes`
  ADD PRIMARY KEY (`id_mensaje`),
  ADD KEY `fk_emisor` (`id_emisor`),
  ADD KEY `fk_receptor` (`id_receptor`);

--
-- Indices de la tabla `proovedor`
--
ALTER TABLE `proovedor`
  ADD PRIMARY KEY (`id_proovedor`),
  ADD KEY `fk_idUsuario` (`id_usuario`);

--
-- Indices de la tabla `provee`
--
ALTER TABLE `provee`
  ADD PRIMARY KEY (`id_proovedor`,`id_servicio`),
  ADD KEY `id_servicio` (`id_servicio`);

--
-- Indices de la tabla `recibe`
--
ALTER TABLE `recibe`
  ADD PRIMARY KEY (`id_cliente`,`id_resena`),
  ADD KEY `id_resena` (`id_resena`);

--
-- Indices de la tabla `resena`
--
ALTER TABLE `resena`
  ADD PRIMARY KEY (`id_resena`),
  ADD KEY `id_cliente` (`id_cliente`),
  ADD KEY `id_servicio` (`id_servicio`);

--
-- Indices de la tabla `reserva`
--
ALTER TABLE `reserva`
  ADD PRIMARY KEY (`id_cliente`,`id_servicio`),
  ADD KEY `fk_idServicio_reserva` (`id_servicio`);

--
-- Indices de la tabla `servicio`
--
ALTER TABLE `servicio`
  ADD PRIMARY KEY (`id_servicio`),
  ADD KEY `fk_idCliente` (`id_cliente`),
  ADD KEY `fk_idProovedor` (`id_proovedor`);

--
-- Indices de la tabla `telefono`
--
ALTER TABLE `telefono`
  ADD PRIMARY KEY (`id_usuario`,`telefono`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `administrador`
--
ALTER TABLE `administrador`
  MODIFY `id_administrador` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `mensajes`
--
ALTER TABLE `mensajes`
  MODIFY `id_mensaje` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `proovedor`
--
ALTER TABLE `proovedor`
  MODIFY `id_proovedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `resena`
--
ALTER TABLE `resena`
  MODIFY `id_resena` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `servicio`
--
ALTER TABLE `servicio`
  MODIFY `id_servicio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `administrador`
--
ALTER TABLE `administrador`
  ADD CONSTRAINT `administrador_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);

--
-- Filtros para la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD CONSTRAINT `fk_idUsuario_cliente` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE;

--
-- Filtros para la tabla `mensajes`
--
ALTER TABLE `mensajes`
  ADD CONSTRAINT `fk_emisor` FOREIGN KEY (`id_emisor`) REFERENCES `usuarios` (`id_usuario`),
  ADD CONSTRAINT `fk_receptor` FOREIGN KEY (`id_receptor`) REFERENCES `usuarios` (`id_usuario`);

--
-- Filtros para la tabla `provee`
--
ALTER TABLE `provee`
  ADD CONSTRAINT `provee_ibfk_1` FOREIGN KEY (`id_proovedor`) REFERENCES `proovedor` (`id_proovedor`),
  ADD CONSTRAINT `provee_ibfk_2` FOREIGN KEY (`id_servicio`) REFERENCES `servicio` (`id_servicio`) ON DELETE CASCADE;

--
-- Filtros para la tabla `recibe`
--
ALTER TABLE `recibe`
  ADD CONSTRAINT `recibe_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id_cliente`),
  ADD CONSTRAINT `recibe_ibfk_2` FOREIGN KEY (`id_resena`) REFERENCES `resena` (`id_resena`);

--
-- Filtros para la tabla `resena`
--
ALTER TABLE `resena`
  ADD CONSTRAINT `resena_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id_cliente`) ON DELETE CASCADE,
  ADD CONSTRAINT `resena_ibfk_2` FOREIGN KEY (`id_servicio`) REFERENCES `servicio` (`id_servicio`) ON DELETE CASCADE;

--
-- Filtros para la tabla `reserva`
--
ALTER TABLE `reserva`
  ADD CONSTRAINT `fk_idCliente_reserva` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id_cliente`),
  ADD CONSTRAINT `fk_idServicio_reserva` FOREIGN KEY (`id_servicio`) REFERENCES `servicio` (`id_servicio`);

--
-- Filtros para la tabla `servicio`
--
ALTER TABLE `servicio`
  ADD CONSTRAINT `fk_idCliente` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id_cliente`),
  ADD CONSTRAINT `fk_idProovedor` FOREIGN KEY (`id_proovedor`) REFERENCES `proovedor` (`id_proovedor`);

--
-- Filtros para la tabla `telefono`
--
ALTER TABLE `telefono`
  ADD CONSTRAINT `fk_idUsuario_telefono` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
