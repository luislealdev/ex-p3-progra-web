-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 01-05-2024 a las 02:31:27
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `Zoo`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Animal`
--

CREATE TABLE `Animal` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `edad` smallint(6) NOT NULL,
  `id_especie` smallint(6) NOT NULL,
  `id_habitad` smallint(6) NOT NULL,
  `animal` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `Animal`
--

INSERT INTO `Animal` (`id`, `edad`, `id_especie`, `id_habitad`, `animal`) VALUES
(1, 12, 1, 1, 'Leon de Celaya'),
(2, 13, 2, 2, 'Tigre de León'),
(3, 10, 4, 4, 'Simba'),
(4, 13, 4, 4, 'Nala'),
(5, 8, 4, 4, 'Mufasa'),
(6, 7, 4, 5, 'Sarabi'),
(7, 6, 5, 1, 'Shere Khan'),
(8, 5, 5, 2, 'Rajah'),
(9, 4, 5, 3, 'Hobbes'),
(10, 7, 6, 4, 'Melman'),
(11, 3, 6, 5, 'Girafarig'),
(12, 9, 7, 6, 'Dumbo'),
(13, 10, 7, 7, 'Horton');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Comida`
--

CREATE TABLE `Comida` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_animal` smallint(6) NOT NULL,
  `fecha` date NOT NULL,
  `cantidad` smallint(6) NOT NULL,
  `concepto` varchar(50) NOT NULL,
  `aplicado` tinyint(1) NOT NULL DEFAULT 0,
  `hora` char(5) NOT NULL,
  `id_empleado` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `Comida`
--

INSERT INTO `Comida` (`id`, `id_animal`, `fecha`, `cantidad`, `concepto`, `aplicado`, `hora`, `id_empleado`) VALUES
(11, 2, '2024-04-25', 50, 'Carne de Res', 0, '12:30', 2),
(12, 2, '2024-04-17', 20, 'Carne de Res', 1, '02:35', 2),
(13, 1, '2024-04-29', 2, 'Carne', 1, '08:00', 2),
(14, 2, '2024-04-29', 3, 'Pescado', 1, '08:30', 2),
(15, 3, '2024-04-29', 1, 'Hierba', 0, '09:00', 2),
(16, 4, '2024-04-29', 4, 'Frutas', 1, '10:00', 2),
(17, 5, '2024-04-29', 2, 'Insectos', 0, '10:30', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Empleado`
--

CREATE TABLE `Empleado` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `clave` varchar(30) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `direccion` varchar(100) NOT NULL,
  `telefono` varchar(10) NOT NULL,
  `apellido` varchar(30) NOT NULL,
  `id_tipo_empleado` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `Empleado`
--

INSERT INTO `Empleado` (`id`, `nombre`, `clave`, `correo`, `direccion`, `telefono`, `apellido`, `id_tipo_empleado`) VALUES
(1, 'Luis', '1234', 'luisrrleal@gmail.com', 'Santa Alicia 106A', '4121719136', 'Leal', 1),
(2, 'Rubén', '1234', 'ruben@gmail.com', 'Santa Alicia 106A', '4121719136', 'Rusiles', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Especie`
--

CREATE TABLE `Especie` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `especie` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `Especie`
--

INSERT INTO `Especie` (`id`, `especie`) VALUES
(1, 'Leones'),
(2, 'Tigress'),
(3, 'Aves'),
(4, 'León'),
(5, 'Tigre'),
(6, 'Jirafa'),
(7, 'Elefante');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Habitat`
--

CREATE TABLE `Habitat` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ubicacion` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `Habitat`
--

INSERT INTO `Habitat` (`id`, `ubicacion`) VALUES
(1, 'H13'),
(2, 'H2'),
(3, 'Sector A'),
(4, 'Sector B'),
(5, 'Sector C'),
(6, 'Sector D'),
(7, 'Sector E'),
(8, 'Sector F'),
(9, 'Sector G'),
(10, 'Sector H'),
(11, 'Sector I'),
(12, 'Sector J');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `TipoEmpleado`
--

CREATE TABLE `TipoEmpleado` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tipo_empleado` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `TipoEmpleado`
--

INSERT INTO `TipoEmpleado` (`id`, `tipo_empleado`) VALUES
(1, 'admin'),
(2, 'deliver');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `Animal`
--
ALTER TABLE `Animal`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indices de la tabla `Comida`
--
ALTER TABLE `Comida`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indices de la tabla `Empleado`
--
ALTER TABLE `Empleado`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indices de la tabla `Especie`
--
ALTER TABLE `Especie`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indices de la tabla `Habitat`
--
ALTER TABLE `Habitat`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indices de la tabla `TipoEmpleado`
--
ALTER TABLE `TipoEmpleado`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `Animal`
--
ALTER TABLE `Animal`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `Comida`
--
ALTER TABLE `Comida`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `Empleado`
--
ALTER TABLE `Empleado`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `Especie`
--
ALTER TABLE `Especie`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `Habitat`
--
ALTER TABLE `Habitat`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `TipoEmpleado`
--
ALTER TABLE `TipoEmpleado`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
