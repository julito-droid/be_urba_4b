-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 17-07-2023 a las 22:51:28
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
-- Base de datos: `db_pagina_web`
--
DROP DATABASE IF EXISTS `db_pagina_web`;
CREATE DATABASE `db_pagina_web`;
USE `db_pagina_web`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `color`
--

CREATE TABLE `color` (
  `id_color` int(10) UNSIGNED NOT NULL,
  `color` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `color`
--

INSERT INTO `color` (`id_color`, `color`) VALUES
(1, 'blanco'),
(2, 'rojo'),
(3, 'negro'),
(4, 'rosado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compras`
--

CREATE TABLE `compras` (
  `id_compra` int(10) UNSIGNED NOT NULL,
  `fecha_compra` date DEFAULT NULL,
  `cantidad` int(10) DEFAULT NULL,
  `descripcion` varchar(100) DEFAULT NULL,
  `precio_und` decimal(10,2) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `id_proveedor` int(10) UNSIGNED DEFAULT NULL,
  `id_producto` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `compras`
--

INSERT INTO `compras` (`id_compra`, `fecha_compra`, `cantidad`, `descripcion`, `precio_und`, `total`, `id_proveedor`, `id_producto`) VALUES
(1, '2023-07-07', 10, 'Buzos blancos talla - M', 60000.00, 600000.00, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estados_pedido`
--

CREATE TABLE `estados_pedido` (
  `id_estado` int(10) UNSIGNED NOT NULL,
  `estado` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estados_pedido`
--

INSERT INTO `estados_pedido` (`id_estado`, `estado`) VALUES
(1, 'espera'),
(2, 'activo'),
(3, 'enviado'),
(4, 'entregado'),
(5, 'cancelado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id_pedido` int(10) UNSIGNED NOT NULL,
  `fecha` date DEFAULT NULL,
  `direccion` varchar(200) DEFAULT NULL,
  `id_estado` int(10) UNSIGNED DEFAULT NULL,
  `id_producto` int(10) UNSIGNED DEFAULT NULL,
  `usr__numero_identificacion` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`id_pedido`, `fecha`, `direccion`, `id_estado`, `id_producto`, `usr__numero_identificacion`) VALUES
(1, '2023-07-07', 'calle 6a #93d-13', 1, 2, 79452859),
(2, '2023-07-08', 'calle 2 #3-2', 2, 2, 1078457773),
(3, '2023-07-07', 'calle 3', 1, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id_producto` int(10) UNSIGNED NOT NULL,
  `cantidad` int(10) DEFAULT NULL,
  `id_tipo` int(10) UNSIGNED DEFAULT NULL,
  `id_talla` int(10) UNSIGNED DEFAULT NULL,
  `id_color` int(10) UNSIGNED DEFAULT NULL,
  `precio_und` decimal(50,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id_producto`, `cantidad`, `id_tipo`, `id_talla`, `id_color`, `precio_und`) VALUES
(1, 10, 1, 2, 1, 60000),
(2, 11, 2, 1, 1, 60000);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
  `id_proveedor` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `proveedores`
--

INSERT INTO `proveedores` (`id_proveedor`, `nombre`) VALUES
(1, 'Creaciones Geek');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tallas`
--

CREATE TABLE `tallas` (
  `id_talla` int(10) UNSIGNED NOT NULL,
  `talla` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tallas`
--

INSERT INTO `tallas` (`id_talla`, `talla`) VALUES
(1, 'S'),
(2, 'M'),
(3, 'L'),
(4, 'XL');

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
(1, 'ht6c0jnu6zh1yu4@outlook.com', 'Calle 1ra con Carrera 1ra', 3202614096, 'Admin', '', 'Centro PQR ', '', 4, ',hAqYB5F*Q=QW+h', '2023-07-13 02:16:53', '2023-07-13 02:16:53'),
(79452859, 'mgarzon07@gmail.com', 'Calle 6b #69c-41 Marsella', 3232810345, 'Mario', 'Enrique', 'Garzón', 'Gonzalez', 1, '12345678', '2023-07-08 21:13:20', '2023-07-08 21:14:07'),
(1078457773, 'juligiraldo1119@gmail.com', 'Calle 77b #123a-86 Torre 2 Apto 602', 3202614096, 'Juli', 'Andres', 'Giraldo', 'Velasquez', 2, '987654321', '2023-07-08 05:50:49', '2023-07-17 19:33:01');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_producto`
--

CREATE TABLE `tipo_producto` (
  `id_tipo` int(10) UNSIGNED NOT NULL,
  `tipo` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo_producto`
--

INSERT INTO `tipo_producto` (`id_tipo`, `tipo`) VALUES
(1, 'buzo'),
(2, 'camiseta');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `id_venta` int(10) UNSIGNED NOT NULL,
  `id_producto` int(10) UNSIGNED DEFAULT NULL,
  `fecha_venta` date DEFAULT NULL,
  `cantidad` int(10) DEFAULT NULL,
  `precio_total` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`id_venta`, `id_producto`, `fecha_venta`, `cantidad`, `precio_total`) VALUES
(1, 1, '2023-07-07', 2, 12000.00),
(2, 2, '2023-07-08', 2, 120000.00);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `color`
--
ALTER TABLE `color`
  ADD PRIMARY KEY (`id_color`);

--
-- Indices de la tabla `compras`
--
ALTER TABLE `compras`
  ADD PRIMARY KEY (`id_compra`),
  ADD KEY `id_proveedor` (`id_proveedor`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `estados_pedido`
--
ALTER TABLE `estados_pedido`
  ADD PRIMARY KEY (`id_estado`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id_pedido`),
  ADD KEY `id_estado` (`id_estado`),
  ADD KEY `id_producto` (`id_producto`),
  ADD KEY `usr__numero_identificacion` (`usr__numero_identificacion`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id_producto`),
  ADD KEY `id_tipo` (`id_tipo`),
  ADD KEY `id_talla` (`id_talla`),
  ADD KEY `id_color` (`id_color`);

--
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`id_proveedor`);

--
-- Indices de la tabla `tallas`
--
ALTER TABLE `tallas`
  ADD PRIMARY KEY (`id_talla`);

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
  ADD UNIQUE KEY `usr__correo_electronico` (`usr__correo_electronico`),
  ADD KEY `FK_UsuariosTiposusuario` (`usr__tipo_usuario`);

--
-- Indices de la tabla `tipo_producto`
--
ALTER TABLE `tipo_producto`
  ADD PRIMARY KEY (`id_tipo`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id_venta`),
  ADD KEY `id_producto` (`id_producto`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `color`
--
ALTER TABLE `color`
  MODIFY `id_color` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `compras`
--
ALTER TABLE `compras`
  MODIFY `id_compra` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `estados_pedido`
--
ALTER TABLE `estados_pedido`
  MODIFY `id_estado` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id_pedido` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id_producto` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `id_proveedor` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `tallas`
--
ALTER TABLE `tallas`
  MODIFY `id_talla` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
-- AUTO_INCREMENT de la tabla `tipo_producto`
--
ALTER TABLE `tipo_producto`
  MODIFY `id_tipo` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id_venta` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `compras`
--
ALTER TABLE `compras`
  ADD CONSTRAINT `compras_ibfk_1` FOREIGN KEY (`id_proveedor`) REFERENCES `proveedores` (`id_proveedor`),
  ADD CONSTRAINT `compras_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`);

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`id_tipo`) REFERENCES `tipo_producto` (`id_tipo`),
  ADD CONSTRAINT `productos_ibfk_2` FOREIGN KEY (`id_talla`) REFERENCES `tallas` (`id_talla`),
  ADD CONSTRAINT `productos_ibfk_3` FOREIGN KEY (`id_color`) REFERENCES `color` (`id_color`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
