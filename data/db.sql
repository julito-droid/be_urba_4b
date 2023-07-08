SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "-05:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `be_urban_4b`
--

DROP DATABASE IF EXISTS `be_urban_4b`;
CREATE DATABASE `be_urban_4b`;
USE `be_urban_4b`;

-- --------------------------------------------------------


--
-- Estructura de tabla para la tabla `tbl_pedidos`
--

CREATE TABLE `tbl_pedidos` (
  `ped__id_pedidos` bigint NOT NULL AUTO_INCREMENT,
  `ped__identificacion_cliente` bigint NOT NULL,
  `ped__estado` int NOT NULL,
  `ped__fecha_pedido` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ped__fecha_pedido_actualizado` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`ped__id_pedidos`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Tabla en la cual se registran los productos';


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_pqr`
--

CREATE TABLE `tbl_pqr` (
  `pqr__id_pqr` int NOT NULL AUTO_INCREMENT,
  `pqr__identificacion_solicitante` bigint NOT NULL,
  `pqr__tipo_pqr` int NOT NULL,
  `pqr__puntuacion_calidad` int NOT NULL,
  `pqr__fecha_pqr` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `pqr__descripcion` text NOT NULL,
  PRIMARY KEY (`pqr__id_pqr`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Tabla en la cual se guardan los PQR';


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_productos`
--

CREATE TABLE `tbl_productos` (
  `prdct__id_producto` int NOT NULL AUTO_INCREMENT,
  `prdct__nombre` varchar(256) NOT NULL,
  `prdct__descripcion` varchar(512) NOT NULL,
  `prdct__imagen` longblob NOT NULL,
  `prdct__precio` int NOT NULL,
  `prdct__cantidad` int NOT NULL,
  `prdct__fecha_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `prdct__fecha_actualización` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`prdct__id_producto`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Tabla en la cual se guarda registro de cada producto';


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_productos_pedido`
--

CREATE TABLE `tbl_productos_pedido` (
  `prdct_ped__id_producto_pedido` bigint NOT NULL AUTO_INCREMENT,
  `prdct_ped__nro_pedido` bigint NOT NULL,
  `prdct_ped__producto` int NOT NULL,
  `prdct_ped__cant_producto` int NOT NULL,
  `prdct_ped__fecha_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `prdct_ped__fecha_actualización` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`prdct_ped__id_producto_pedido`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Indica los productos y la cantidad de cada uno por pedido';


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_tipos_pqr`
--

CREATE TABLE `tbl_tipos_pqr` (
  `t_pqr__id_tipos_pqr` int NOT NULL AUTO_INCREMENT,
  `t_pqr__tipos_pqr` enum('Pregunta','Queja','Reclamo','Sugerencia') NOT NULL,
  PRIMARY KEY (`t_pqr__id_tipos_pqr`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Tabla en la cual se muestran los tipos de PQR que hay';

--
-- Volcado de datos para la tabla `tbl_tipos_pqr`
--

INSERT INTO `tbl_tipos_pqr` (`t_pqr__tipos_pqr`) VALUES
('Pregunta'),
('Queja'),
('Reclamo'),
('Sugerencia');


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_estados_pedido`
--

CREATE TABLE `tbl_estados_pedido` (
  `t_est_ped__id_estados_pedido` int NOT NULL AUTO_INCREMENT,
  `t_est_ped__estados` enum('Cancelado','Creado','Recibido','Aprobado', 'Pagado', 'Recibido') NOT NULL,
  PRIMARY KEY (`t_est_ped__id_estados_pedido`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Tabla en la cual se guardan los estados que cada pedido puede tener';

--
-- Volcado de datos para la tabla `tbl_tipos_pqr`
--

INSERT INTO `tbl_estados_pedido` (`t_est_ped__estados`) VALUES
('Cancelado'),
('Creado'),
('Recibido'),
('Aprobado'),
('Pagado'),
('Recibido');


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_tipos_usuarios`
--

CREATE TABLE `tbl_tipos_usuarios` (
  `t_usr__id_tipos_usuarios` int NOT NULL AUTO_INCREMENT,
  `t_usr__tipos_usuarios` enum('Cliente','Vendedor','Asesor','Administrador') NOT NULL,
  PRIMARY KEY (`t_usr__id_tipos_usuarios`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Tabla en la cual se guardan los roles de usuarios que pueden tener';

--
-- Volcado de datos para la tabla `tbl_tipos_usuarios`
--

INSERT INTO `tbl_tipos_usuarios` (`t_usr__tipos_usuarios`) VALUES
('Cliente'),
('Vendedor'),
('Asesor'),
('Administrador');


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_usuarios`
--

CREATE TABLE `tbl_usuarios` (
  `usr__numero_identificacion` bigint NOT NULL,
  `usr__correo_electronico` varchar(256) NOT NULL,
  `usr__direccion` varchar(256) NOT NULL,
  `usr__numero_celular` bigint NOT NULL,
  `usr__nombre1` varchar(60) NOT NULL,
  `usr__nombre2` varchar(40) DEFAULT NULL,
  `usr__apellido1` varchar(60) NOT NULL,
  `usr__apellido2` varchar(50) DEFAULT NULL,
  `usr__tipo_usuario` int NOT NULL,
  `usr__contrasena` varchar(64) NOT NULL,
  `usr__fecha_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `usr__fecha_actualización` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`usr__numero_identificacion`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Tabla principal, en la cual se guarda el registro de los usuarios';



ALTER TABLE `tbl_pedidos` 
  ADD INDEX FK_PedidosUsuarios (`ped__identificacion_cliente`),
  ADD INDEX FK_PedidosEstadopedido (`ped__estado`);

ALTER TABLE `tbl_pqr` 
  ADD INDEX FK_PqrTipospqr (`pqr__tipo_pqr`),
  ADD INDEX FK_PqrUsuarios (`pqr__identificacion_solicitante`);

ALTER TABLE `tbl_productos_pedido` 
  ADD INDEX FK_ProductopedidoPedidos (`prdct_ped__nro_pedido`),
  ADD INDEX FK_ProductopedidoProducto (`prdct_ped__producto`);

ALTER TABLE `tbl_usuarios` 
  ADD INDEX FK_UsuariosTiposusuario (`usr__tipo_usuario`);

--
-- Indices foráneos para tablas volcadas
--

--
-- Indice foráneo de la tabla `tbl_pedidos`
--
ALTER TABLE `tbl_pedidos`
  ADD FOREIGN KEY (`ped__identificacion_cliente`) REFERENCES `tbl_usuarios`(`usr__numero_identificacion`),
  ADD FOREIGN KEY (`ped__estado`) REFERENCES `tbl_estados_pedido`(`t_usr__id_tipos_usuarios`);

--
-- Indices foráneos de la tabla `tbl_pqr`
--
ALTER TABLE `tbl_pqr`
  ADD FOREIGN KEY (`pqr__tipo_pqr`) REFERENCES `tbl_tipos_pqr`(`t_pqr__id_tipos_pqr`),
  ADD FOREIGN KEY (`pqr__identificacion_solicitante`) REFERENCES `tbl_usuarios`(`usr__numero_identificacion`);

--
-- Indices foráneos de la tabla `tbl_productos_pedido`
--
ALTER TABLE `tbl_productos_pedido`
  ADD FOREIGN KEY (`prdct_ped__nro_pedido`) REFERENCES `tbl_pedidos`(`ped__id_pedidos`),
  ADD FOREIGN KEY (`prdct_ped__producto`) REFERENCES `tbl_productos`(`prdct__id_producto`);

--
-- Indice foráneo de la tabla `tbl_usuarios`
--
ALTER TABLE `tbl_usuarios`
  ADD FOREIGN KEY (`usr__tipo_usuario`) REFERENCES `tbl_tipos_usuarios`(`t_usr__id_tipos_usuarios`);

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

  
