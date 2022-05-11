CREATE DATABASE  IF NOT EXISTS `newway` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `newway`;
-- MySQL dump 10.13  Distrib 8.0.21, for Win64 (x86_64)
--
-- Host: localhost    Database: newway
-- ------------------------------------------------------
-- Server version	8.0.21

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `categorias`
--

DROP TABLE IF EXISTS `categorias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categorias` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `descripcion` varchar(250) DEFAULT NULL,
  `estado` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cliente`
--

DROP TABLE IF EXISTS `cliente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cliente` (
  `id_cliente` varchar(15) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido1` varchar(50) NOT NULL,
  `apellido2` varchar(50) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `fecha_nacimiento` varchar(15) DEFAULT NULL,
  `subscrito` tinyint(1) NOT NULL DEFAULT '0',
  `invitado` tinyint(1) NOT NULL,
  `registrado` date NOT NULL COMMENT 'Fecha en la que se registró',
  `ultima_visita` datetime DEFAULT NULL,
  `genero` char(1) DEFAULT NULL COMMENT 'Puede ser H/M/O de otro',
  PRIMARY KEY (`id_cliente`),
  UNIQUE KEY `email_UNIQUE` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cod_descuentos`
--

DROP TABLE IF EXISTS `cod_descuentos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cod_descuentos` (
  `id_codigo` varchar(15) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `descripcion` varchar(200) DEFAULT NULL,
  `codigo` varchar(30) NOT NULL,
  `estado` tinyint(1) NOT NULL,
  `cliente` varchar(15) DEFAULT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `gasto_minimo` double DEFAULT (0),
  `usos_totales` int DEFAULT (1),
  `usos_totales_clientes` int DEFAULT (0),
  `tipo_descuento` varchar(20) NOT NULL,
  `valor_descuento` double NOT NULL,
  `excluir_prod_rebajados` tinyint(1) DEFAULT (0),
  PRIMARY KEY (`id_codigo`),
  KEY `cliente` (`cliente`),
  CONSTRAINT `cod_descuentos_ibfk_1` FOREIGN KEY (`cliente`) REFERENCES `cliente` (`id_cliente`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `colores`
--

DROP TABLE IF EXISTS `colores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `colores` (
  `id` int NOT NULL AUTO_INCREMENT,
  `codigo_hex` varchar(8) NOT NULL,
  `nombre` varchar(25) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `direccion`
--

DROP TABLE IF EXISTS `direccion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `direccion` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_cliente` varchar(15) NOT NULL,
  `nif` varchar(10) DEFAULT NULL,
  `razon_social` varchar(100) DEFAULT NULL,
  `es_empresa` tinyint(1) NOT NULL,
  `direccion` varchar(100) NOT NULL,
  `direccion2` varchar(25) DEFAULT NULL,
  `codigo_postal` int NOT NULL,
  `provincia` varchar(50) NOT NULL,
  `localidad` varchar(50) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_cliente` (`id_cliente`),
  CONSTRAINT `direccion_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id_cliente`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `estadopedido`
--

DROP TABLE IF EXISTS `estadopedido`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `estadopedido` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `factura`
--

DROP TABLE IF EXISTS `factura`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `factura` (
  `id_factura` int NOT NULL AUTO_INCREMENT,
  `factura` mediumblob NOT NULL,
  `id_pedido` int NOT NULL,
  PRIMARY KEY (`id_factura`),
  KEY `id_pedido` (`id_pedido`),
  CONSTRAINT `factura_ibfk_1` FOREIGN KEY (`id_pedido`) REFERENCES `pedidos` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `factura_rectificativa`
--

DROP TABLE IF EXISTS `factura_rectificativa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `factura_rectificativa` (
  `id_factura_rec` int NOT NULL AUTO_INCREMENT,
  `factura` mediumblob NOT NULL,
  `id_pedido` int NOT NULL,
  PRIMARY KEY (`id_factura_rec`),
  KEY `id_pedido` (`id_pedido`),
  CONSTRAINT `factura_rectificativa_ibfk_1` FOREIGN KEY (`id_pedido`) REFERENCES `pedidos` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `genero`
--

DROP TABLE IF EXISTS `genero`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `genero` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `imagenes`
--

DROP TABLE IF EXISTS `imagenes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `imagenes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `alt` varchar(100) DEFAULT NULL,
  `img` mediumblob NOT NULL,
  `tipo` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `imagenesproductos`
--

DROP TABLE IF EXISTS `imagenesproductos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `imagenesproductos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `img` mediumblob NOT NULL,
  `tipo` varchar(100) NOT NULL,
  `referencia` varchar(15) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `referencia` (`referencia`),
  CONSTRAINT `imagenesproductos_ibfk_1` FOREIGN KEY (`referencia`) REFERENCES `productos` (`referencia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `listadeseos`
--

DROP TABLE IF EXISTS `listadeseos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `listadeseos` (
  `id_cliente` varchar(15) NOT NULL,
  `ref_producto` varchar(15) NOT NULL,
  PRIMARY KEY (`id_cliente`,`ref_producto`),
  KEY `ref_producto` (`ref_producto`),
  CONSTRAINT `listadeseos_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id_cliente`),
  CONSTRAINT `listadeseos_ibfk_2` FOREIGN KEY (`ref_producto`) REFERENCES `productos` (`referencia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `marcas`
--

DROP TABLE IF EXISTS `marcas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `marcas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(25) NOT NULL,
  `descripcion` varchar(250) DEFAULT NULL,
  `contacto` varchar(50) DEFAULT NULL,
  `estado` tinyint NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `noticias`
--

DROP TABLE IF EXISTS `noticias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `noticias` (
  `id` int NOT NULL AUTO_INCREMENT,
  `titulo` varchar(100) NOT NULL,
  `autor` int NOT NULL,
  `fecha` date NOT NULL,
  `contenido` varchar(5000) NOT NULL,
  `img_destacada` blob NOT NULL,
  PRIMARY KEY (`id`),
  KEY `autor` (`autor`),
  CONSTRAINT `noticias_ibfk_1` FOREIGN KEY (`autor`) REFERENCES `usuario` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pedidos`
--

DROP TABLE IF EXISTS `pedidos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pedidos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `ref_pedido` varchar(15) NOT NULL,
  `cliente` varchar(15) NOT NULL,
  `importe` double NOT NULL,
  `estado_pedido` int NOT NULL,
  `fecha` datetime NOT NULL,
  `observaciones` varchar(250) DEFAULT NULL,
  `metodo_pago` varchar(20) NOT NULL,
  `cod_descuento` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cliente` (`cliente`),
  KEY `estado_pedido` (`estado_pedido`),
  KEY `cod_descuento` (`cod_descuento`),
  CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`cliente`) REFERENCES `cliente` (`id_cliente`),
  CONSTRAINT `pedidos_ibfk_2` FOREIGN KEY (`estado_pedido`) REFERENCES `estadopedido` (`id`),
  CONSTRAINT `pedidos_ibfk_3` FOREIGN KEY (`cod_descuento`) REFERENCES `cod_descuentos` (`id_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `permisos`
--

DROP TABLE IF EXISTS `permisos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `permisos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(30) NOT NULL,
  `descripcion` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `producto_review`
--

DROP TABLE IF EXISTS `producto_review`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `producto_review` (
  `id_review` int NOT NULL AUTO_INCREMENT,
  `titulo` varchar(100) NOT NULL,
  `puntuacion` double NOT NULL,
  `producto` varchar(15) NOT NULL,
  `cliente` varchar(15) NOT NULL,
  `descripcion` varchar(500) NOT NULL,
  PRIMARY KEY (`id_review`),
  KEY `producto` (`producto`),
  KEY `cliente` (`cliente`),
  CONSTRAINT `producto_review_ibfk_1` FOREIGN KEY (`producto`) REFERENCES `productos` (`referencia`),
  CONSTRAINT `producto_review_ibfk_2` FOREIGN KEY (`cliente`) REFERENCES `cliente` (`id_cliente`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `productos`
--

DROP TABLE IF EXISTS `productos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `productos` (
  `referencia` varchar(15) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `resumen` varchar(300) NOT NULL,
  `estado` tinyint(1) NOT NULL,
  `caracteristicas` varchar(500) NOT NULL,
  `marca` int NOT NULL,
  `color` int DEFAULT NULL,
  `subcategoria` int NOT NULL,
  `precio` double NOT NULL,
  `iva` double NOT NULL,
  `fecha_creacion` date NOT NULL,
  `genero` int NOT NULL,
  PRIMARY KEY (`referencia`),
  KEY `marca` (`marca`),
  KEY `subcategoria` (`subcategoria`),
  KEY `genero` (`genero`),
  KEY `productos_ibfk_5` (`color`),
  CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`marca`) REFERENCES `marcas` (`id`),
  CONSTRAINT `productos_ibfk_3` FOREIGN KEY (`subcategoria`) REFERENCES `subcategorias` (`id`),
  CONSTRAINT `productos_ibfk_4` FOREIGN KEY (`genero`) REFERENCES `genero` (`id`),
  CONSTRAINT `productos_ibfk_5` FOREIGN KEY (`color`) REFERENCES `colores` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `productospedidos`
--

DROP TABLE IF EXISTS `productospedidos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `productospedidos` (
  `id_pedido` int NOT NULL,
  `ref_producto` varchar(15) NOT NULL,
  `cantidad` int NOT NULL,
  PRIMARY KEY (`id_pedido`,`ref_producto`),
  KEY `ref_producto` (`ref_producto`),
  CONSTRAINT `productospedidos_ibfk_1` FOREIGN KEY (`id_pedido`) REFERENCES `pedidos` (`id`),
  CONSTRAINT `productospedidos_ibfk_2` FOREIGN KEY (`ref_producto`) REFERENCES `productos` (`referencia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `productosrelacionados`
--

DROP TABLE IF EXISTS `productosrelacionados`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `productosrelacionados` (
  `ref_producto` varchar(15) NOT NULL,
  `ref_producto_rel` varchar(15) NOT NULL,
  PRIMARY KEY (`ref_producto`,`ref_producto_rel`),
  KEY `ref_producto_rel` (`ref_producto_rel`),
  CONSTRAINT `productosrelacionados_ibfk_1` FOREIGN KEY (`ref_producto`) REFERENCES `productos` (`referencia`),
  CONSTRAINT `productosrelacionados_ibfk_2` FOREIGN KEY (`ref_producto_rel`) REFERENCES `productos` (`referencia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `reglascomerciales`
--

DROP TABLE IF EXISTS `reglascomerciales`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reglascomerciales` (
  `id_regla` varchar(15) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `grupo` varchar(20) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `tipo_reduccion` varchar(20) NOT NULL,
  `reduccion` double NOT NULL,
  `tasas_incluidas` varchar(10) NOT NULL,
  PRIMARY KEY (`id_regla`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `reglascomerciales_cond`
--

DROP TABLE IF EXISTS `reglascomerciales_cond`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reglascomerciales_cond` (
  `id_regla` varchar(15) NOT NULL,
  `tipo` varchar(20) NOT NULL,
  `valor` varchar(50) NOT NULL,
  PRIMARY KEY (`id_regla`,`tipo`,`valor`),
  CONSTRAINT `reglascomerciales_cond_ibfk_1` FOREIGN KEY (`id_regla`) REFERENCES `reglascomerciales` (`id_regla`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `subcategorias`
--

DROP TABLE IF EXISTS `subcategorias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `subcategorias` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `descripcion` varchar(250) DEFAULT NULL,
  `estado` tinyint(1) NOT NULL,
  `id_categoria` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_categoria` (`id_categoria`),
  CONSTRAINT `subcategorias_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tallas`
--

DROP TABLE IF EXISTS `tallas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tallas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `talla` varchar(5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tallasproductos`
--

DROP TABLE IF EXISTS `tallasproductos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tallasproductos` (
  `ref_producto` varchar(15) NOT NULL,
  `id_talla` int NOT NULL,
  `cantidad` int NOT NULL,
  `stock_minimo` int DEFAULT NULL,
  PRIMARY KEY (`ref_producto`,`id_talla`),
  KEY `id_talla` (`id_talla`),
  CONSTRAINT `tallasproductos_ibfk_1` FOREIGN KEY (`ref_producto`) REFERENCES `productos` (`referencia`),
  CONSTRAINT `tallasproductos_ibfk_2` FOREIGN KEY (`id_talla`) REFERENCES `tallas` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuario` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `apellidos` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `permiso` int NOT NULL,
  `password` varchar(255) NOT NULL,
  `userKey` varchar(15) NOT NULL,
  `foto_usuario` blob,
  `puesto` varchar(45) DEFAULT NULL,
  `tipo_foto` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `userKey_UNIQUE` (`userKey`),
  UNIQUE KEY `email_UNIQUE` (`email`),
  KEY `permiso` (`permiso`),
  CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`permiso`) REFERENCES `permisos` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-05-11 10:12:01
