SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "-05:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `db_pagina_web`
--

DROP DATABASE IF EXISTS `db_pagina_web`;
CREATE DATABASE `db_pagina_web`;
USE `db_pagina_web`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_pqr`
--

CREATE TABLE `tbl_pqr` (
  `pqr__id_pqr` int(11) NOT NULL,
  `pqr__identificacion_solicitante` bigint(20) NOT NULL,
  `pqr__tipo_pqr` int(11) NOT NULL,
  `pqr__puntuacion_calidad` int(11) NOT NULL,
  `pqr__fecha_pqr` timestamp NOT NULL DEFAULT current_timestamp(),
  `pqr__descripcion` text NOT NULL,
  `pqr__respondido` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci COMMENT='Tabla en la cual se guardan los PQR';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_tipos_pqr`
--

CREATE TABLE `tbl_tipos_pqr` (
  `t_pqr__id_tipos_pqr` int(11) NOT NULL,
  `t_pqr__tipos_pqr` enum('Pregunta','Queja','Reclamo','Sugerencia') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci COMMENT='Tabla en la cual se muestran los tipos de PQR que hay';

--
-- Volcado de datos para la tabla `tbl_tipos_pqr`
--

INSERT INTO `tbl_tipos_pqr` (`t_pqr__id_tipos_pqr`, `t_pqr__tipos_pqr`) VALUES
(1, 'Pregunta'),
(2, 'Queja'),
(3, 'Reclamo'),
(4, 'Sugerencia');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_tipos_usuarios`
--

CREATE TABLE `tbl_tipos_usuarios` (
  `t_usr__id_tipos_usuarios` int(11) NOT NULL,
  `t_usr__tipos_usuarios` enum('Cliente','Vendedor','Asesor','Administrador') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci COMMENT='Tabla en la cual se guardan los roles de usuarios que pueden tener';

--
-- Volcado de datos para la tabla `tbl_tipos_usuarios`
--

INSERT INTO `tbl_tipos_usuarios` (`t_usr__id_tipos_usuarios`, `t_usr__tipos_usuarios`) VALUES
(1, 'Cliente'),
(2, 'Vendedor'),
(3, 'Asesor'),
(4, 'Administrador');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_usuarios`
--

CREATE TABLE `tbl_usuarios` (
  `usr__numero_identificacion` bigint(20) NOT NULL,
  `usr__correo_electronico` varchar(256) NOT NULL,
  `usr__direccion` varchar(256) NOT NULL,
  `usr__numero_celular` bigint(20) NOT NULL,
  `usr__nombre1` varchar(60) NOT NULL,
  `usr__nombre2` varchar(40) DEFAULT NULL,
  `usr__apellido1` varchar(60) NOT NULL,
  `usr__apellido2` varchar(50) DEFAULT NULL,
  `usr__tipo_usuario` int(11) NOT NULL,
  `usr__contrasena` varchar(64) NOT NULL,
  `usr__fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `usr__fecha_actualización` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci COMMENT='Tabla principal, en la cual se guarda el registro de los usuarios';

--
-- Volcado de datos para la tabla `tbl_usuarios`
--

INSERT INTO `tbl_usuarios` (`usr__numero_identificacion`, `usr__correo_electronico`, `usr__direccion`, `usr__numero_celular`, `usr__nombre1`, `usr__nombre2`, `usr__apellido1`, `usr__apellido2`, `usr__tipo_usuario`, `usr__contrasena`, `usr__fecha_creacion`, `usr__fecha_actualización`) VALUES
(1, 'ht6c0jnu6zh1yu4@outlook.com', 'Calle 1ra con Carrera 1ra', 3202614096, 'Admin', '', 'Centro PQR ', '', 4, ',hAqYB5F*Q=QW+h', '2023-07-12 21:16:53', '2023-07-12 21:16:53'),
(79452859, 'mgarzon07@gmail.com', 'Calle 6b #69c-41 Marsella', 3232810345, 'Mario', 'Enrique', 'Garzón', 'Gonzalez', 1, '12345678', '2023-07-08 16:13:20', '2023-07-08 16:14:07'),
(1078457773, 'juligiraldo1119@gmail.com', 'Calle 77b #123a-86 Torre 2 Apto 602', 3202614096, 'Julian', 'Andres', 'Giraldo', 'Velasquez', 1, 'w34srtf67uyh89', '2023-07-08 00:50:49', '2023-07-08 00:53:21');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tbl_pqr`
--
ALTER TABLE `tbl_pqr`
  ADD PRIMARY KEY (`pqr__id_pqr`),
  ADD KEY `FK_PqrTipospqr` (`pqr__tipo_pqr`),
  ADD KEY `FK_PqrUsuarios` (`pqr__identificacion_solicitante`);

--
-- Indices de la tabla `tbl_tipos_pqr`
--
ALTER TABLE `tbl_tipos_pqr`
  ADD PRIMARY KEY (`t_pqr__id_tipos_pqr`);

--
-- Indices de la tabla `tbl_tipos_usuarios`
--
ALTER TABLE `tbl_tipos_usuarios`
  ADD PRIMARY KEY (`t_usr__id_tipos_usuarios`);

--
-- Indices de la tabla `tbl_usuarios`
--
ALTER TABLE `tbl_usuarios`
  ADD PRIMARY KEY (`usr__numero_identificacion`),
  ADD KEY `FK_UsuariosTiposusuario` (`usr__tipo_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tbl_pqr`
--
ALTER TABLE `tbl_pqr`
  MODIFY `pqr__id_pqr` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tbl_tipos_pqr`
--
ALTER TABLE `tbl_tipos_pqr`
  MODIFY `t_pqr__id_tipos_pqr` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tbl_tipos_usuarios`
--
ALTER TABLE `tbl_tipos_usuarios`
  MODIFY `t_usr__id_tipos_usuarios` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `tbl_pqr`
--
ALTER TABLE `tbl_pqr`
  ADD CONSTRAINT `tbl_pqr_ibfk_1` FOREIGN KEY (`pqr__identificacion_solicitante`) REFERENCES `tbl_usuarios` (`usr__numero_identificacion`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_pqr_ibfk_2` FOREIGN KEY (`pqr__tipo_pqr`) REFERENCES `tbl_tipos_pqr` (`t_pqr__id_tipos_pqr`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tbl_usuarios`
--
ALTER TABLE `tbl_usuarios`
  ADD CONSTRAINT `tbl_usuarios_ibfk_1` FOREIGN KEY (`usr__tipo_usuario`) REFERENCES `tbl_tipos_usuarios` (`t_usr__id_tipos_usuarios`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
