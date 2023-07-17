-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 12-07-2023 a las 23:08:23
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

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
-- Estructura de tabla para la tabla `tbl_estados_pedido`
--

CREATE TABLE `tbl_estados_pedido` (
  `t_est_ped__id_estados_pedido` int(11) NOT NULL,
  `t_est_ped__estados` enum('Cancelado','Creado','Recibido','Aprobado','Pagado','Recibido') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci COMMENT='Tabla en la cual se guardan los estados que cada pedido puede tener';

--
-- Volcado de datos para la tabla `tbl_estados_pedido`
--

INSERT INTO `tbl_estados_pedido` (`t_est_ped__id_estados_pedido`, `t_est_ped__estados`) VALUES
(1, 'Cancelado'),
(2, 'Creado'),
(3, 'Recibido'),
(4, 'Aprobado'),
(5, 'Pagado'),
(6, 'Recibido');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_pedidos`
--

CREATE TABLE `tbl_pedidos` (
  `ped__id_pedidos` bigint(20) NOT NULL,
  `ped__identificacion_cliente` bigint(20) NOT NULL,
  `ped__estado` int(11) NOT NULL,
  `ped__fecha_pedido` timestamp NOT NULL DEFAULT current_timestamp(),
  `ped__fecha_pedido_actualizado` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci COMMENT='Tabla en la cual se registran los productos';

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

--
-- Volcado de datos para la tabla `tbl_pqr`
--

INSERT INTO `tbl_pqr` (`pqr__id_pqr`, `pqr__identificacion_solicitante`, `pqr__tipo_pqr`, `pqr__puntuacion_calidad`, `pqr__fecha_pqr`, `pqr__descripcion`, `pqr__respondido`) VALUES
(1, 1078457773, 1, 4, '2023-07-10 21:02:45', 'Prueba', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_productos`
--

CREATE TABLE `tbl_productos` (
  `prdct__id_producto` int(11) NOT NULL,
  `prdct__nombre` varchar(256) NOT NULL,
  `prdct__descripcion` varchar(512) NOT NULL,
  `prdct__imagen` longblob NOT NULL,
  `prdct__precio` int(11) NOT NULL,
  `prdct__cantidad` int(11) NOT NULL,
  `prdct__fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `prdct__fecha_actualización` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci COMMENT='Tabla en la cual se guarda registro de cada producto';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_productos_pedido`
--

CREATE TABLE `tbl_productos_pedido` (
  `prdct_ped__id_producto_pedido` bigint(20) NOT NULL,
  `prdct_ped__nro_pedido` bigint(20) NOT NULL,
  `prdct_ped__producto` int(11) NOT NULL,
  `prdct_ped__cant_producto` int(11) NOT NULL,
  `prdct_ped__fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `prdct_ped__fecha_actualización` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci COMMENT='Indica los productos y la cantidad de cada uno por pedido';

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
(79452859, 'mgarzon07@gmail.com', 'Calle 6b #69c-41 Marsella', 3232810345, 'Mario', 'Enrique', 'Garzón', 'Gonzalez', 1, '12345678', '2023-07-08 16:13:20', '2023-07-08 16:14:07'),
(1078457773, 'juligiraldo1119@gmail.com', 'Calle 77b #123a-86 Torre 2 Apto 602', 3202614096, 'Julian', 'Andres', 'Giraldo', 'Velasquez', 1, 'w34srtf67uyh89', '2023-07-08 00:50:49', '2023-07-08 00:53:21'),
(1234567890, 'qwertyu@asdfgh.com', 'Calle Inexistente con Avenida Falsa', 3204982304, 'Usuario', 'Falso', 'Perez', 'Gonzales', 1, 'd5rfytguyhijokpl', '2023-07-10 21:44:06', '2023-07-10 21:44:06');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tbl_estados_pedido`
--
ALTER TABLE `tbl_estados_pedido`
  ADD PRIMARY KEY (`t_est_ped__id_estados_pedido`);

--
-- Indices de la tabla `tbl_pedidos`
--
ALTER TABLE `tbl_pedidos`
  ADD PRIMARY KEY (`ped__id_pedidos`),
  ADD KEY `FK_PedidosUsuarios` (`ped__identificacion_cliente`),
  ADD KEY `FK_PedidosEstadopedido` (`ped__estado`);

--
-- Indices de la tabla `tbl_pqr`
--
ALTER TABLE `tbl_pqr`
  ADD PRIMARY KEY (`pqr__id_pqr`),
  ADD KEY `FK_PqrTipospqr` (`pqr__tipo_pqr`),
  ADD KEY `FK_PqrUsuarios` (`pqr__identificacion_solicitante`);

--
-- Indices de la tabla `tbl_productos`
--
ALTER TABLE `tbl_productos`
  ADD PRIMARY KEY (`prdct__id_producto`);

--
-- Indices de la tabla `tbl_productos_pedido`
--
ALTER TABLE `tbl_productos_pedido`
  ADD PRIMARY KEY (`prdct_ped__id_producto_pedido`),
  ADD KEY `FK_ProductopedidoPedidos` (`prdct_ped__nro_pedido`),
  ADD KEY `FK_ProductopedidoProducto` (`prdct_ped__producto`);

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
-- AUTO_INCREMENT de la tabla `tbl_estados_pedido`
--
ALTER TABLE `tbl_estados_pedido`
  MODIFY `t_est_ped__id_estados_pedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `tbl_pedidos`
--
ALTER TABLE `tbl_pedidos`
  MODIFY `ped__id_pedidos` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tbl_pqr`
--
ALTER TABLE `tbl_pqr`
  MODIFY `pqr__id_pqr` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tbl_productos`
--
ALTER TABLE `tbl_productos`
  MODIFY `prdct__id_producto` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tbl_productos_pedido`
--
ALTER TABLE `tbl_productos_pedido`
  MODIFY `prdct_ped__id_producto_pedido` bigint(20) NOT NULL AUTO_INCREMENT;

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
-- Filtros para la tabla `tbl_pedidos`
--
ALTER TABLE `tbl_pedidos`
  ADD CONSTRAINT `tbl_pedidos_ibfk_1` FOREIGN KEY (`ped__estado`) REFERENCES `tbl_estados_pedido` (`t_est_ped__id_estados_pedido`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_pedidos_ibfk_2` FOREIGN KEY (`ped__identificacion_cliente`) REFERENCES `tbl_usuarios` (`usr__numero_identificacion`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tbl_pqr`
--
ALTER TABLE `tbl_pqr`
  ADD CONSTRAINT `tbl_pqr_ibfk_1` FOREIGN KEY (`pqr__identificacion_solicitante`) REFERENCES `tbl_usuarios` (`usr__numero_identificacion`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_pqr_ibfk_2` FOREIGN KEY (`pqr__tipo_pqr`) REFERENCES `tbl_tipos_pqr` (`t_pqr__id_tipos_pqr`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tbl_productos_pedido`
--
ALTER TABLE `tbl_productos_pedido`
  ADD CONSTRAINT `tbl_productos_pedido_ibfk_1` FOREIGN KEY (`prdct_ped__producto`) REFERENCES `tbl_productos` (`prdct__id_producto`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_productos_pedido_ibfk_2` FOREIGN KEY (`prdct_ped__nro_pedido`) REFERENCES `tbl_pedidos` (`ped__id_pedidos`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tbl_usuarios`
--
ALTER TABLE `tbl_usuarios`
  ADD CONSTRAINT `tbl_usuarios_ibfk_1` FOREIGN KEY (`usr__tipo_usuario`) REFERENCES `tbl_tipos_usuarios` (`t_usr__id_tipos_usuarios`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
