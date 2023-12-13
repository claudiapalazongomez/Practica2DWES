-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 05-12-2023 a las 16:46:10
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
-- Base de datos: `studium_dws_p2`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ninios`
--

CREATE TABLE `ninios` (
  `idNinio` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `apellidos` varchar(100) NOT NULL,
  `fechaNacimiento` date NOT NULL,
  `buenoMalo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `ninios`
--

INSERT INTO `ninios` (`idNinio`, `nombre`, `apellidos`, `fechaNacimiento`, `buenoMalo`) VALUES
(1, 'Alberto', 'Alcántara', '1994-10-13', 0),
(2, 'Beatriz', 'Bueno', '1982-04-18', 1),
(3, 'Carlos', 'Crepo', '1998-12-01', 1),
(4, 'Diana', 'Domínguez', '1987-09-02', 0),
(5, 'Emilio', 'Enamorado', '1996-08-12', 1),
(6, 'Francisca', 'Fernández', '1990-07-28', 1),
(7, 'Claudia', 'Palazón', '1998-08-30', 1),
(8, 'Alexander', 'Kimani', '1999-05-15', 1),
(9, 'Álvaro', 'Martín', '2001-04-18', 1),
(10, 'Ana', 'Gómez', '1992-09-07', 0),
(12, 'Raquel', 'Arias', '1998-07-25', 1),
(13, 'Miguel', 'Sánchez', '1999-03-09', 0),
(14, 'Guillermo', 'Dianez', '1996-12-12', 1),
(15, 'Daniel', 'Muñoz', '1995-02-28', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `idPedido` int(11) NOT NULL,
  `idRegaloFK` int(11) NOT NULL,
  `idNinioFK` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`idPedido`, `idRegaloFK`, `idNinioFK`) VALUES
(2, 1, 3),
(19, 1, 14),
(14, 3, 9),
(1, 4, 8),
(24, 4, 14),
(7, 5, 1),
(8, 6, 4),
(16, 6, 8),
(12, 7, 3),
(10, 8, 10),
(5, 8, 12),
(23, 9, 4),
(4, 9, 7),
(9, 10, 10),
(15, 10, 12),
(3, 11, 5),
(17, 11, 7),
(21, 11, 14),
(11, 12, 1),
(25, 12, 13),
(22, 13, 4),
(13, 13, 5),
(6, 13, 9),
(20, 13, 14),
(18, 15, 2),
(26, 17, 15);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `regalos`
--

CREATE TABLE `regalos` (
  `idRegalo` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `idReyFK` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `regalos`
--

INSERT INTO `regalos` (`idRegalo`, `nombre`, `precio`, `idReyFK`) VALUES
(1, 'Aula de ciencia: Robot Mini ERP', 159.95, 3),
(2, 'Carbón', 0.00, 1),
(3, 'Cochecito Classic', 99.95, 2),
(4, 'Consola PS4 1 TB', 349.90, 3),
(5, 'Lego Villa familiar modular', 64.99, 2),
(6, 'Magia Borrás Clásica 150 trucos con luz', 32.95, 1),
(7, 'Meccano Excavadora construcción', 30.99, 1),
(8, 'Nenuco Hace pompas', 29.95, 3),
(9, 'Peluche delfín rosa', 34.00, 2),
(10, 'Pequeordenador', 22.95, 3),
(11, 'Robot Coji', 69.95, 1),
(12, 'Telescopio astronómico terrestre', 72.00, 2),
(13, 'Twister', 17.95, 2),
(15, 'Monopoly', 27.95, 2),
(17, 'LEGO Harry Potter', 99.99, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reyes`
--

CREATE TABLE `reyes` (
  `idRey` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `reyes`
--

INSERT INTO `reyes` (`idRey`, `nombre`) VALUES
(1, 'Melchor'),
(2, 'Gaspar'),
(3, 'Baltasar');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `ninios`
--
ALTER TABLE `ninios`
  ADD PRIMARY KEY (`idNinio`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`idPedido`),
  ADD KEY `idRegaloFK` (`idRegaloFK`,`idNinioFK`),
  ADD KEY `idNinioFK` (`idNinioFK`);

--
-- Indices de la tabla `regalos`
--
ALTER TABLE `regalos`
  ADD PRIMARY KEY (`idRegalo`),
  ADD KEY `idReyFK` (`idReyFK`);

--
-- Indices de la tabla `reyes`
--
ALTER TABLE `reyes`
  ADD PRIMARY KEY (`idRey`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `ninios`
--
ALTER TABLE `ninios`
  MODIFY `idNinio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `idPedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `regalos`
--
ALTER TABLE `regalos`
  MODIFY `idRegalo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `reyes`
--
ALTER TABLE `reyes`
  MODIFY `idRey` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`idNinioFK`) REFERENCES `ninios` (`idNinio`),
  ADD CONSTRAINT `pedidos_ibfk_2` FOREIGN KEY (`idRegaloFK`) REFERENCES `regalos` (`idRegalo`);

--
-- Filtros para la tabla `regalos`
--
ALTER TABLE `regalos`
  ADD CONSTRAINT `regalos_ibfk_1` FOREIGN KEY (`idReyFK`) REFERENCES `reyes` (`idRey`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
