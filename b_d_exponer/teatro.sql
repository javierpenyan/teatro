-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 12-06-2022 a las 12:17:27
-- Versión del servidor: 10.4.22-MariaDB
-- Versión de PHP: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `teatro`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actores`
--

CREATE TABLE `actores` (
  `Id` int(11) NOT NULL,
  `nombre` varchar(300) NOT NULL,
  `apellidos` varchar(300) NOT NULL,
  `f_nacimiento` date NOT NULL,
  `curiosidades` varchar(1000) DEFAULT NULL,
  `telefono` varchar(300) NOT NULL,
  `correo` varchar(300) NOT NULL,
  `alias` varchar(300) NOT NULL,
  `contraseña` varchar(300) NOT NULL,
  `biografia` varchar(1000) DEFAULT NULL,
  `trabajos` varchar(1000) DEFAULT NULL,
  `foto` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `actores`
--

INSERT INTO `actores` (`Id`, `nombre`, `apellidos`, `f_nacimiento`, `curiosidades`, `telefono`, `correo`, `alias`, `contraseña`, `biografia`, `trabajos`, `foto`) VALUES
(23, 'Francisco Javier', 'Peña Navarrete', '2000-09-17', '          curiosidades\r\n          ', '622556688', 'j@gmail.com', 'Javi', 'b84d7f8d4fa7713e702ab0d9d2632d75', '                    Esta es mi biografía.', ' Estos son mis trabajos                   ', '/asset/imagenes/Francisco Javier_23.jpg'),
(24, 'Miguel', 'Gutierrez', '2001-01-01', '                  Curiosidad  ', '622111111', 'a@gmail.com', 'Guti', 'b84d7f8d4fa7713e702ab0d9d2632d75', NULL, NULL, '/asset/imagenes/Miguel_24.jpg'),
(25, 'Marcos', 'Naranjo', '2001-01-01', NULL, '633333333', 'm@gmail.com', 'Gomez', 'b84d7f8d4fa7713e702ab0d9d2632d75', NULL, NULL, '/asset/imagenes/Marcos_25.jpg'),
(27, 'Fernando ', 'Pérez Morón', '2005-01-01', NULL, '612336655', 'aa@gmail.com', 'Fer', 'b84d7f8d4fa7713e702ab0d9d2632d75', NULL, NULL, '/asset/imagenes/Fernando _27.jpg'),
(28, 'Antonio', 'Gonzalez Moya', '2020-01-01', 'Soy de Murcia', '688774455', 's@gmail.com', 'Tony', 'b84d7f8d4fa7713e702ab0d9d2632d75', 'Nací en Murcia', 'He trabajado en diferentes obras de teatro', '/asset/imagenes/Antonio_28.jpg'),
(29, 'Silvia', 'Navarrete Mazuecos', '2020-01-01', NULL, '665555522', 'q@gmail.com', 'Silvi', 'b84d7f8d4fa7713e702ab0d9d2632d75', NULL, NULL, '/asset/imagenes/Silvia_29.jpg'),
(30, 'Jessica', 'Molina', '2000-01-01', NULL, '611111111', 'h@gmail.com', 'Ortega', 'b84d7f8d4fa7713e702ab0d9d2632d75', NULL, NULL, '/asset/imagenes/Jessica_30.jpg'),
(31, 'Maria', 'Navarro Molina', '2000-01-01', NULL, '688996655', 'w@gmail.com', 'Mari', 'b84d7f8d4fa7713e702ab0d9d2632d75', NULL, NULL, '/asset/imagenes/Maria_31.jpg'),
(34, 'Miriam', 'Martinez', '2001-10-15', NULL, '665554455', 'miriam@gmail.com', 'Gomez', 'b84d7f8d4fa7713e702ab0d9d2632d75', NULL, NULL, '/asset/imagenes/Miriam_34.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `casting`
--

CREATE TABLE `casting` (
  `id` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `fecha_resolucion` date NOT NULL,
  `descripcion` varchar(300) NOT NULL,
  `obra` int(11) NOT NULL,
  `ciudad` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `casting`
--

INSERT INTO `casting` (`id`, `fecha`, `hora`, `fecha_resolucion`, `descripcion`, `obra`, `ciudad`) VALUES
(18, '2022-05-21', '11:00:00', '2022-08-18', 'Papel principal', 14, 'Nápoles'),
(21, '2022-05-12', '14:00:00', '2022-08-26', 'Papel de Amigo', 14, 'Córdoba'),
(23, '2022-06-23', '09:25:00', '2022-07-26', 'Papel de Simba', 18, 'Granada'),
(26, '2022-05-27', '12:53:00', '2022-07-02', 'Casting 3', 20, 'Granada'),
(27, '2022-05-26', '12:54:00', '2022-05-28', 'resolucion nueva 2', 17, 'Málaga'),
(28, '2022-06-17', '16:31:00', '2022-07-08', 'Papel malvado', 16, 'Múrcia'),
(30, '2022-06-02', '18:12:00', '2022-06-10', 'Papel Carmen', 21, 'Córdoba'),
(32, '2022-06-17', '18:39:00', '2022-07-23', 'Papel principal', 17, 'Mérida'),
(33, '2022-06-30', '16:20:00', '2022-07-08', 'Papel protagonista de la obra', 21, 'Málaga'),
(35, '2022-06-16', '16:42:00', '2022-06-18', 'papel de asesino', 26, 'Granada');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cita_actor`
--

CREATE TABLE `cita_actor` (
  `id` int(11) NOT NULL,
  `actor` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `motivo` varchar(300) NOT NULL,
  `hora` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `cita_actor`
--

INSERT INTO `cita_actor` (`id`, `actor`, `fecha`, `motivo`, `hora`) VALUES
(5, 23, '2022-05-26', 'Mi cita', '18:26:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cita_compañia`
--

CREATE TABLE `cita_compañia` (
  `id` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `motivo` varchar(300) NOT NULL,
  `compañia` int(11) NOT NULL,
  `hora` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `cita_compañia`
--

INSERT INTO `cita_compañia` (`id`, `fecha`, `motivo`, `compañia`, `hora`) VALUES
(1, '2022-05-30', 'Mi cita', 12, '19:49:00'),
(3, '2022-05-30', 'tengo cita con el medico', 13, '17:22:00'),
(4, '2022-06-13', 'cita con gato negro', 13, '16:36:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compañia`
--

CREATE TABLE `compañia` (
  `id` int(11) NOT NULL,
  `nombre` varchar(300) NOT NULL,
  `contraseña` varchar(300) NOT NULL,
  `foto` varchar(300) NOT NULL,
  `creacion` date NOT NULL,
  `telefono` varchar(300) NOT NULL,
  `correo` varchar(300) NOT NULL,
  `curiosidades` varchar(1000) NOT NULL,
  `trayectoria` varchar(1000) NOT NULL,
  `direccion` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `compañia`
--

INSERT INTO `compañia` (`id`, `nombre`, `contraseña`, `foto`, `creacion`, `telefono`, `correo`, `curiosidades`, `trayectoria`, `direccion`) VALUES
(12, 'El Gato Negro', 'b84d7f8d4fa7713e702ab0d9d2632d75', '/asset/imagenes/El Gato Negro_12.jpg', '1920-01-01', '958112244', 'a@gmail.com', '          Estas son las curiosidades de la compañía.                  ', '                           trayectoriaaaaa ', 'C/Verdiales 6 4j'),
(13, 'Teatro Clásico', 'cdb4b9bddb0263c99d3e042c0916d436', '/asset/imagenes/Teatro Clásico_13.png', '1935-01-01', '685566554', 'b@gmail.com', '', '', 'C/Murcia 18'),
(15, 'El Grito', 'b84d7f8d4fa7713e702ab0d9d2632d75', '/asset/imagenes/El Grito_15.png', '1985-01-01', '655448899', 'd@gmail.com', '', '', 'Av Constitución 5 5ºA'),
(16, 'TCS', 'b84d7f8d4fa7713e702ab0d9d2632d75', '/asset/imagenes/TCS_16.png', '2000-01-01', '633223322', 'e@gmail.com', '', '', 'C/Dr Olóriz 20'),
(17, 'Yera Teatro', 'b84d7f8d4fa7713e702ab0d9d2632d75', '/asset/imagenes/Yera Teatro_17.png', '2022-05-04', '695887744', 'yera@gmail.com', '', '', 'C/Murcia 18');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ensayo`
--

CREATE TABLE `ensayo` (
  `id` int(11) NOT NULL,
  `obra` int(11) NOT NULL,
  `actor` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `ensayo`
--

INSERT INTO `ensayo` (`id`, `obra`, `actor`, `fecha`, `hora`) VALUES
(2, 14, 23, '2022-05-29', '20:46:00'),
(3, 14, 23, '2022-05-09', '20:31:00'),
(5, 14, 29, '2022-06-01', '16:56:00'),
(6, 21, 28, '2022-05-30', '17:24:00'),
(7, 21, 30, '2022-06-13', '16:35:00'),
(10, 21, 23, '2022-06-13', '16:38:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fotos_actor`
--

CREATE TABLE `fotos_actor` (
  `id` int(11) NOT NULL,
  `url` varchar(300) NOT NULL,
  `actor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `fotos_actor`
--

INSERT INTO `fotos_actor` (`id`, `url`, `actor`) VALUES
(2, '/asset/imagenes/foto_2.png', 23),
(3, '/asset/imagenes/foto_3.jpg', 23),
(4, '/asset/imagenes/foto_4.jpg', 23),
(5, '/asset/imagenes/foto_5.jpg', 23),
(12, '/asset/imagenes/foto_12.jpg', 23),
(14, '/asset/imagenes/foto_14.jpg', 23),
(15, '/asset/imagenes/foto_15.jpg', 23),
(16, '/asset/imagenes/foto_16.jpg', 23),
(18, '/asset/imagenes/foto_18.jpg', 23),
(19, '/asset/imagenes/foto_19.jpg', 23),
(23, '/asset/imagenes/foto_23.jpg', 23);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `obra`
--

CREATE TABLE `obra` (
  `id` int(11) NOT NULL,
  `nombre` varchar(300) NOT NULL,
  `Descripcion` varchar(1000) NOT NULL,
  `fecha` date NOT NULL,
  `imagen` varchar(300) NOT NULL,
  `duracion` int(11) NOT NULL,
  `compañia` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `obra`
--

INSERT INTO `obra` (`id`, `nombre`, `Descripcion`, `fecha`, `imagen`, `duracion`, `compañia`) VALUES
(14, 'Romeo y Julietta', 'Una obra de Shackespeare', '2022-07-15', '/asset/imagenes/Romeo y Julietta_12.jpg', 120, 12),
(16, 'Hamiltone', 'Una obra Americana', '2022-08-19', '/asset/imagenes/Hamilton_16.jpg', 95, 12),
(17, 'Los miserables', 'Un musical basado en la revolución francesa', '2022-06-16', '/asset/imagenes/Los miserables_17.jpg', 90, 12),
(18, 'El Rey León', 'Obra recomendada para niños', '2022-07-16', '/asset/imagenes/El Rey León_18.jpg', 190, 12),
(19, 'Cats', 'Obra entretenida y muy recomendable', '2022-06-19', '/asset/imagenes/Cats_19.png', 90, 12),
(20, 'Cats 2019', 'Una obra animada muy entretenida', '2022-06-11', '/asset/imagenes/Cats_19.png', 150, 12),
(21, 'Carmen', 'Obra clásica del teatro español', '2022-09-06', '/asset/imagenes/Carmen_21.jpg', 85, 13),
(26, 'Bodas de sangre', 'Obra trágica', '2022-06-19', '/asset/imagenes/Bodas de sangre_13.jpg', 90, 13);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `participantes_casting`
--

CREATE TABLE `participantes_casting` (
  `actor` int(11) NOT NULL,
  `casting` int(11) NOT NULL,
  `resultado` int(11) DEFAULT NULL,
  `observaciones` varchar(1000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `participantes_casting`
--

INSERT INTO `participantes_casting` (`actor`, `casting`, `resultado`, `observaciones`) VALUES
(23, 18, 1, NULL),
(23, 21, NULL, NULL),
(23, 23, 1, NULL),
(23, 28, 1, NULL),
(25, 28, 1, NULL),
(34, 23, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `participantes_ensayo`
--

CREATE TABLE `participantes_ensayo` (
  `actor` int(11) NOT NULL,
  `ensayo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `participantes_ensayo`
--

INSERT INTO `participantes_ensayo` (`actor`, `ensayo`) VALUES
(23, 10),
(28, 6),
(29, 5),
(30, 7);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `participantes_obra`
--

CREATE TABLE `participantes_obra` (
  `obra` int(11) NOT NULL,
  `actor` int(11) NOT NULL,
  `papel` varchar(300) NOT NULL,
  `comentario` varchar(1000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `participantes_obra`
--

INSERT INTO `participantes_obra` (`obra`, `actor`, `papel`, `comentario`) VALUES
(16, 23, 'Papel malvado', ''),
(16, 24, 'Papel secundario', 'Papel secundario suyo'),
(16, 25, 'Papel malvado', ''),
(16, 29, 'Papel secundario', 'Papel secundario suyo'),
(17, 30, 'Papel secundario', 'Papel secundario suyo'),
(18, 23, 'Papel de Simba', ''),
(19, 23, 'Papel secundario', 'Papel secundario suyo'),
(21, 23, 'Papel secundario', 'Papel secundario suyo'),
(21, 29, 'Papel secundario', 'Papel secundario suyo'),
(26, 24, 'Principal', 'Actor principal de la obra'),
(26, 27, 'Papel secundario 3', 'Papel secundario 3 suyo'),
(26, 28, 'Papel secundario', 'Papel secundario suyo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reunion`
--

CREATE TABLE `reunion` (
  `id` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `lugar` varchar(300) NOT NULL,
  `actor` int(11) NOT NULL,
  `compañia` int(11) NOT NULL,
  `comentario` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `reunion`
--

INSERT INTO `reunion` (`id`, `fecha`, `hora`, `lugar`, `actor`, `compañia`, `comentario`) VALUES
(5, '2022-05-31', '19:23:00', 'Granada', 23, 12, 'No comet'),
(6, '2022-05-09', '20:30:00', 'Granada', 23, 12, 'Tengo reunion con Gato Negro'),
(8, '2022-05-31', '16:56:00', 'Granada', 25, 13, 'Tiene una reunión con la compañía'),
(11, '2022-06-13', '16:34:00', 'Granada', 30, 13, 'cita con la compañía');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `videos_actor`
--

CREATE TABLE `videos_actor` (
  `Id` int(11) NOT NULL,
  `url` varchar(300) NOT NULL,
  `actor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `videos_actor`
--

INSERT INTO `videos_actor` (`Id`, `url`, `actor`) VALUES
(48, 'https://www.youtube.com/embed/iP7xOCDGN5c', 24),
(49, 'https://www.youtube.com/embed/jrrYJkMumuk', 24),
(50, 'https://www.youtube.com/embed/m_kndVZskJ0', 23),
(51, 'https://www.youtube.com/embed/buuqQSDUVCQ', 23),
(52, 'https://www.youtube.com/embed/OISlvjMXrxw\" title=\"YouTube video player', 23),
(53, 'https://www.youtube.com/embed/FPMBV3rd_hI', 23);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `actores`
--
ALTER TABLE `actores`
  ADD PRIMARY KEY (`Id`);

--
-- Indices de la tabla `casting`
--
ALTER TABLE `casting`
  ADD PRIMARY KEY (`id`),
  ADD KEY `obra` (`obra`);

--
-- Indices de la tabla `cita_actor`
--
ALTER TABLE `cita_actor`
  ADD PRIMARY KEY (`id`),
  ADD KEY `actor` (`actor`);

--
-- Indices de la tabla `cita_compañia`
--
ALTER TABLE `cita_compañia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `compañia` (`compañia`);

--
-- Indices de la tabla `compañia`
--
ALTER TABLE `compañia`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ensayo`
--
ALTER TABLE `ensayo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `actor` (`actor`),
  ADD KEY `obra` (`obra`);

--
-- Indices de la tabla `fotos_actor`
--
ALTER TABLE `fotos_actor`
  ADD PRIMARY KEY (`id`),
  ADD KEY `actor` (`actor`);

--
-- Indices de la tabla `obra`
--
ALTER TABLE `obra`
  ADD PRIMARY KEY (`id`),
  ADD KEY `compañia` (`compañia`);

--
-- Indices de la tabla `participantes_casting`
--
ALTER TABLE `participantes_casting`
  ADD PRIMARY KEY (`actor`,`casting`),
  ADD KEY `casting` (`casting`);

--
-- Indices de la tabla `participantes_ensayo`
--
ALTER TABLE `participantes_ensayo`
  ADD PRIMARY KEY (`actor`,`ensayo`),
  ADD KEY `ensayo` (`ensayo`);

--
-- Indices de la tabla `participantes_obra`
--
ALTER TABLE `participantes_obra`
  ADD PRIMARY KEY (`obra`,`actor`),
  ADD KEY `actor` (`actor`);

--
-- Indices de la tabla `reunion`
--
ALTER TABLE `reunion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `actor` (`actor`),
  ADD KEY `compañia` (`compañia`);

--
-- Indices de la tabla `videos_actor`
--
ALTER TABLE `videos_actor`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `actor` (`actor`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `actores`
--
ALTER TABLE `actores`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT de la tabla `casting`
--
ALTER TABLE `casting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT de la tabla `cita_actor`
--
ALTER TABLE `cita_actor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `cita_compañia`
--
ALTER TABLE `cita_compañia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `compañia`
--
ALTER TABLE `compañia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `ensayo`
--
ALTER TABLE `ensayo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `fotos_actor`
--
ALTER TABLE `fotos_actor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `obra`
--
ALTER TABLE `obra`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `reunion`
--
ALTER TABLE `reunion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `videos_actor`
--
ALTER TABLE `videos_actor`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `casting`
--
ALTER TABLE `casting`
  ADD CONSTRAINT `casting_ibfk_1` FOREIGN KEY (`obra`) REFERENCES `obra` (`id`);

--
-- Filtros para la tabla `cita_actor`
--
ALTER TABLE `cita_actor`
  ADD CONSTRAINT `cita_actor_ibfk_1` FOREIGN KEY (`actor`) REFERENCES `actores` (`Id`);

--
-- Filtros para la tabla `cita_compañia`
--
ALTER TABLE `cita_compañia`
  ADD CONSTRAINT `cita_compañia_ibfk_1` FOREIGN KEY (`compañia`) REFERENCES `compañia` (`id`);

--
-- Filtros para la tabla `ensayo`
--
ALTER TABLE `ensayo`
  ADD CONSTRAINT `ensayo_ibfk_1` FOREIGN KEY (`actor`) REFERENCES `actores` (`Id`),
  ADD CONSTRAINT `ensayo_ibfk_2` FOREIGN KEY (`obra`) REFERENCES `obra` (`id`);

--
-- Filtros para la tabla `fotos_actor`
--
ALTER TABLE `fotos_actor`
  ADD CONSTRAINT `fotos_actor_ibfk_1` FOREIGN KEY (`actor`) REFERENCES `actores` (`Id`);

--
-- Filtros para la tabla `obra`
--
ALTER TABLE `obra`
  ADD CONSTRAINT `obra_ibfk_1` FOREIGN KEY (`compañia`) REFERENCES `compañia` (`id`);

--
-- Filtros para la tabla `participantes_casting`
--
ALTER TABLE `participantes_casting`
  ADD CONSTRAINT `participantes_casting_ibfk_1` FOREIGN KEY (`actor`) REFERENCES `actores` (`Id`),
  ADD CONSTRAINT `participantes_casting_ibfk_2` FOREIGN KEY (`casting`) REFERENCES `casting` (`id`);

--
-- Filtros para la tabla `participantes_ensayo`
--
ALTER TABLE `participantes_ensayo`
  ADD CONSTRAINT `participantes_ensayo_ibfk_1` FOREIGN KEY (`actor`) REFERENCES `actores` (`Id`),
  ADD CONSTRAINT `participantes_ensayo_ibfk_2` FOREIGN KEY (`ensayo`) REFERENCES `ensayo` (`id`);

--
-- Filtros para la tabla `participantes_obra`
--
ALTER TABLE `participantes_obra`
  ADD CONSTRAINT `participantes_obra_ibfk_1` FOREIGN KEY (`obra`) REFERENCES `obra` (`id`),
  ADD CONSTRAINT `participantes_obra_ibfk_2` FOREIGN KEY (`actor`) REFERENCES `actores` (`Id`);

--
-- Filtros para la tabla `reunion`
--
ALTER TABLE `reunion`
  ADD CONSTRAINT `reunion_ibfk_1` FOREIGN KEY (`actor`) REFERENCES `actores` (`Id`),
  ADD CONSTRAINT `reunion_ibfk_2` FOREIGN KEY (`compañia`) REFERENCES `compañia` (`id`);

--
-- Filtros para la tabla `videos_actor`
--
ALTER TABLE `videos_actor`
  ADD CONSTRAINT `videos_actor_ibfk_1` FOREIGN KEY (`actor`) REFERENCES `actores` (`Id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
