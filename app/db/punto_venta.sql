-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 21, 2025 at 04:08 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `punto_venta`
--
CREATE DATABASE IF NOT EXISTS `punto_venta` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `punto_venta`;

-- --------------------------------------------------------

--
-- Table structure for table `t_calculado`
--

DROP TABLE IF EXISTS `t_calculado`;
CREATE TABLE IF NOT EXISTS `t_calculado` (
  `calculado_id` int NOT NULL AUTO_INCREMENT,
  `calculado_fecha` date NOT NULL,
  `calculado_efectivo` float NOT NULL DEFAULT '0',
  `calculado_transferencia` float NOT NULL DEFAULT '0',
  `calculado_tarjeta` float NOT NULL DEFAULT '0',
  PRIMARY KEY (`calculado_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `t_compras`
--

DROP TABLE IF EXISTS `t_compras`;
CREATE TABLE IF NOT EXISTS `t_compras` (
  `comprar_id` int NOT NULL AUTO_INCREMENT,
  `comprar_fecha` date NOT NULL,
  `comprar_hora` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `comprar_provedor` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `comprar_usuario` varchar(100) NOT NULL,
  `comprar_total` float NOT NULL,
  PRIMARY KEY (`comprar_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `t_compras`
--

INSERT INTO `t_compras` (`comprar_id`, `comprar_fecha`, `comprar_hora`, `comprar_provedor`, `comprar_usuario`, `comprar_total`) VALUES
(1, '2025-05-17', '04:50:25 PM', 'Joshua Ochoa, Barcel', 'Misael', 200),
(2, '2025-05-17', '05:03:23 PM', 'Sin provedor', 'Misael', 525),
(3, '2025-05-17', '05:59:38 PM', 'Laura Méndez, Distribuidora El Sol', 'Misael', 300),
(4, '2025-05-17', '06:02:17 PM', 'Sin provedor', 'Misael', 240),
(5, '2025-05-17', '07:36:34 PM', 'Sin provedor', 'Misael', 300),
(6, '2025-05-19', '12:20:31 PM', 'Joshua Ochoa, Barcel', 'Misael', 120),
(7, '2025-05-20', '10:39:28 PM', 'Sin provedor', 'Misael', 200);

-- --------------------------------------------------------

--
-- Table structure for table `t_corte`
--

DROP TABLE IF EXISTS `t_corte`;
CREATE TABLE IF NOT EXISTS `t_corte` (
  `corte_id` int NOT NULL AUTO_INCREMENT,
  `corte_fecha` date NOT NULL,
  `corte_hora` varchar(100) NOT NULL,
  `corte_contado` float NOT NULL DEFAULT '0',
  `corte_calculado` float NOT NULL DEFAULT '0',
  `corte_diferencia` float NOT NULL DEFAULT '0',
  `corte_usuario` varchar(100) NOT NULL,
  PRIMARY KEY (`corte_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `t_corte`
--

INSERT INTO `t_corte` (`corte_id`, `corte_fecha`, `corte_hora`, `corte_contado`, `corte_calculado`, `corte_diferencia`, `corte_usuario`) VALUES
(5, '2025-05-13', '05:49:38 PM', 127, 127, 0, 'Misael'),
(7, '2025-05-17', '10:26:12 PM', 450, 450, 0, 'Misael');

-- --------------------------------------------------------

--
-- Table structure for table `t_lista_compras`
--

DROP TABLE IF EXISTS `t_lista_compras`;
CREATE TABLE IF NOT EXISTS `t_lista_compras` (
  `lista_id` int NOT NULL AUTO_INCREMENT,
  `lista_cantidad` int NOT NULL,
  `lista_codigo` varchar(100) NOT NULL,
  `lista_producto` varchar(100) NOT NULL,
  `lista_precio` float NOT NULL,
  `lista_total` float NOT NULL,
  `id_producto` int NOT NULL,
  PRIMARY KEY (`lista_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `t_productos`
--

DROP TABLE IF EXISTS `t_productos`;
CREATE TABLE IF NOT EXISTS `t_productos` (
  `producto_id` int NOT NULL AUTO_INCREMENT,
  `producto_codigo` varchar(200) NOT NULL,
  `producto_nombre` varchar(200) NOT NULL,
  `producto_uCompra` varchar(100) NOT NULL,
  `producto_uVenta` varchar(100) NOT NULL,
  `producto_uCantidad` int NOT NULL,
  `producto_pCompra` float NOT NULL,
  `producto_pCosto` float NOT NULL,
  `producto_precio` float NOT NULL,
  `producto_cantidad` float NOT NULL,
  `producto_cantidad_minima` int NOT NULL,
  `producto_cantidad_maxima` int NOT NULL,
  PRIMARY KEY (`producto_id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `t_productos`
--

INSERT INTO `t_productos` (`producto_id`, `producto_codigo`, `producto_nombre`, `producto_uCompra`, `producto_uVenta`, `producto_uCantidad`, `producto_pCompra`, `producto_pCosto`, `producto_precio`, `producto_cantidad`, `producto_cantidad_minima`, `producto_cantidad_maxima`) VALUES
(1, '500533001091', 'Agua purificada 500ml', '', '', 0, 0, 0, 10, 15, 2, 0),
(2, '501056326173', 'Pond\'s. Crema Humectante 400g', '', '', 0, 0, 0, 60, 19, 2, 0),
(3, '581041004222', 'Agua Bonafont 1L', '', '', 0, 0, 0, 15, 20, 2, 0),
(6, '501032601720', 'Bonyur Yoghurt para beber', '', '', 0, 0, 0, 18, 19, 2, 0),
(7, '503023836142', 'Vuala', '', '', 0, 0, 0, 18, 20, 2, 0),
(8, '501011111028', 'Rancheritos', '', '', 0, 0, 0, 17, 19, 5, 0),
(9, '20899087553', 'Nutret Barra rellena', '', '', 0, 0, 0, 13, 19, 2, 0),
(12, '501058648020', 'Nescafe Decaf 200g', '', '', 0, 0, 0, 70, 19, 2, 0),
(13, '500478018512', 'Doritos dinamita', '', '', 0, 0, 0, 18, 29, 2, 0),
(14, '75003104', 'Boing 500ml', 'CAJA', 'PZA', 27, 250, 9, 20, 26, 5, 50),
(15, '9733900006', 'Valentina salsa picante', '', '', 0, 0, 0, 25, 35, 2, 0),
(16, '75074968', 'Muibon roll', '', '', 0, 0, 0, 7, 44, 5, 0),
(18, '6972011067584', 'Perfume Blue Siduatian (azul)', '', '', 0, 0, 0, 20, 20, 2, 0),
(19, '0793573264107', 'Agua Skarch 1.5L ', '', '', 0, 0, 0, 15, 20, 2, 0),
(20, '7872571423556', 'Libreta Swing mix', '', '', 0, 0, 0, 20, 20, 10, 0),
(21, '7502307715012', 'Libreta Jocar c5', 'CAJA', 'PZA', 20, 200, 10, 20, 20, 5, 50);

-- --------------------------------------------------------

--
-- Table structure for table `t_provedores`
--

DROP TABLE IF EXISTS `t_provedores`;
CREATE TABLE IF NOT EXISTS `t_provedores` (
  `provedor_id` int NOT NULL AUTO_INCREMENT,
  `provedor_nombre` varchar(100) NOT NULL,
  `provedor_empresa` varchar(100) NOT NULL,
  `provedor_telefono` varchar(100) NOT NULL,
  `provedor_email` varchar(100) NOT NULL,
  `provedor_direccion` text NOT NULL,
  `provedor_rfc` varchar(100) NOT NULL,
  `provedor_pago` varchar(100) NOT NULL,
  PRIMARY KEY (`provedor_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `t_provedores`
--

INSERT INTO `t_provedores` (`provedor_id`, `provedor_nombre`, `provedor_empresa`, `provedor_telefono`, `provedor_email`, `provedor_direccion`, `provedor_rfc`, `provedor_pago`) VALUES
(1, 'Joshua Ochoa', 'Barcel', '5591055427', 'jossOchoa@gmail.com', 'Calle Hidalgo 56, Colonia Juárez, 06600, Ciudad de México, CDMX', 'DES890123KZ3', 'efectivo'),
(4, 'Laura Méndez', 'Distribuidora El Sol', '5551234567', 'ventas@elsol.com', 'Av. Principal 123, CDMX', 'SDFERWFER321', 'efectivo'),
(6, 'test', 'prueba', '5555555', 'test@gmail.com', 'AV principal ###', 'SDFERWFER321', 'efectivo');

-- --------------------------------------------------------

--
-- Table structure for table `t_usuarios`
--

DROP TABLE IF EXISTS `t_usuarios`;
CREATE TABLE IF NOT EXISTS `t_usuarios` (
  `usuario_id` int NOT NULL AUTO_INCREMENT,
  `usuario_usuario` varchar(50) NOT NULL,
  `usuario_apellidos` varchar(100) NOT NULL,
  `usuario_password` text NOT NULL,
  `usuario_correo` varchar(100) NOT NULL,
  PRIMARY KEY (`usuario_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `t_usuarios`
--

INSERT INTO `t_usuarios` (`usuario_id`, `usuario_usuario`, `usuario_apellidos`, `usuario_password`, `usuario_correo`) VALUES
(1, 'Misael', 'Juarez', '$2y$10$/q63/jlPzorONsa.sARYweskb/vglEb/Aezv3jlWnDz8G0WcBFW2u', 'misael2745@gmail.com'),
(2, 'karla', 'Guzman Gomez', '$2y$10$.nEySM2c0p49UV2dFqlQNO7ucV0Rad9ycMMmNXwq.heGE9W9XZSda', 'karla123@gmail.com'),
(3, 'Luis', 'Torres Puebla', '$2y$10$4IoP9g.XfeBpwoHwkxa9beXbP0B3KO8KdEA7mSKyvxI0qPnuq5f9a', 'luis1234@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `t_ventas`
--

DROP TABLE IF EXISTS `t_ventas`;
CREATE TABLE IF NOT EXISTS `t_ventas` (
  `venta_id` int NOT NULL AUTO_INCREMENT,
  `id_producto` int NOT NULL,
  `venta_cantidad` int NOT NULL,
  PRIMARY KEY (`venta_id`),
  UNIQUE KEY `id_producto` (`id_producto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `t_ventas`
--
ALTER TABLE `t_ventas`
  ADD CONSTRAINT `t_ventas_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `t_productos` (`producto_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
