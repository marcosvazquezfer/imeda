-- phpMyAdmin SQL Dump
-- version 4.6.6deb4
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 16-12-2017 a las 01:56:01
-- Versión del servidor: 10.1.26-MariaDB-0+deb9u1
-- Versión de PHP: 7.0.19-1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `IUET32017`
--
CREATE DATABASE IF NOT EXISTS `IUET32017` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `IUET32017`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ACCION`
--

DROP TABLE IF EXISTS `ACCION`;
CREATE TABLE IF NOT EXISTS `ACCION` (
  `IdAccion` varchar(6) COLLATE latin1_spanish_ci NOT NULL,
  `NombreAccion` varchar(60) COLLATE latin1_spanish_ci NOT NULL,
  `DescripAccion` varchar(100) COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY (`IdAccion`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `ACCION`
--

INSERT INTO `ACCION` (`IdAccion`, `NombreAccion`, `DescripAccion`) VALUES
('1', 'ADD', 'Se añade un valor'),
('10', 'GENERARQA', 'Genera una nueva QA'),
('12', 'EVALUARCORRECTOR', 'Puede evaluar todos los trabajos que quiera'),
('2', 'DELETE', 'Se borra un valor'),
('3', 'EDIT', 'Se edita un valor'),
('4', 'SHOWCURRENT', 'Se muestra un valor en detalle'),
('5', 'SEARCH', 'Busca un valor'),
('6', 'ASIGNAR', 'Selecciona acciones con funcionalidad'),
('7', 'EVALUAR', 'Evalua historias de una entrega'),
('8', 'EVALUARQA', 'Evalua las QAs'),
('9', 'SHOWALL', 'Muestra todos los valores requeridos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ASIGNAC_QA`
--

DROP TABLE IF EXISTS `ASIGNAC_QA`;
CREATE TABLE IF NOT EXISTS `ASIGNAC_QA` (
  `IdTrabajo` varchar(6) COLLATE latin1_spanish_ci NOT NULL,
  `LoginEvaluador` varchar(9) COLLATE latin1_spanish_ci NOT NULL,
  `LoginEvaluado` varchar(9) COLLATE latin1_spanish_ci NOT NULL,
  `AliasEvaluado` varchar(6) COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY (`IdTrabajo`,`LoginEvaluador`,`AliasEvaluado`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ENTREGA`
--

DROP TABLE IF EXISTS `ENTREGA`;
CREATE TABLE IF NOT EXISTS `ENTREGA` (
  `login` varchar(9) COLLATE latin1_spanish_ci NOT NULL,
  `IdTrabajo` varchar(6) COLLATE latin1_spanish_ci NOT NULL,
  `Alias` varchar(9) COLLATE latin1_spanish_ci NOT NULL,
  `Horas` int(2) DEFAULT NULL,
  `Ruta` varchar(60) COLLATE latin1_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`login`,`IdTrabajo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `ENTREGA`
--

INSERT INTO `ENTREGA` (`login`, `IdTrabajo`, `Alias`, `Horas`, `Ruta`) VALUES
('felix', 'ET_2', 'qweqwe', 32, 'asdasd'),
('floro', 'ET_1', 'asdwcd', 22, 'sss');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `EVALUACION`
--

DROP TABLE IF EXISTS `EVALUACION`;
CREATE TABLE IF NOT EXISTS `EVALUACION` (
  `IdTrabajo` varchar(6) COLLATE latin1_spanish_ci NOT NULL,
  `LoginEvaluador` varchar(9) COLLATE latin1_spanish_ci NOT NULL,
  `AliasEvaluado` varchar(9) COLLATE latin1_spanish_ci NOT NULL,
  `IdHistoria` int(2) NOT NULL,
  `CorrectoA` tinyint(1) NOT NULL,
  `ComenIncorrectoA` varchar(300) COLLATE latin1_spanish_ci NOT NULL,
  `CorrectoP` tinyint(1) NOT NULL,
  `ComentIncorrectoP` varchar(300) COLLATE latin1_spanish_ci NOT NULL,
  `OK` tinyint(1) NOT NULL,
  PRIMARY KEY (`IdTrabajo`,`AliasEvaluado`,`LoginEvaluador`,`IdHistoria`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `EVALUACION`
--

INSERT INTO `EVALUACION` (`IdTrabajo`, `LoginEvaluador`, `AliasEvaluado`, `IdHistoria`, `CorrectoA`, `ComenIncorrectoA`, `CorrectoP`, `ComentIncorrectoP`, `OK`) VALUES
('ET_1', 'ana', 'asdwcd', 1, 0, '', 0, 'dasdasdasdasd', 1),
('ET_1', 'ana', 'asdwcd', 2, 0, '', 1, '', 1),
('ET_1', 'ana', 'asdwcd', 3, 0, '', 1, '', 1),
('ET_1', 'ana', 'asdwcd', 4, 0, '', 1, '', 1),
('ET_1', 'ana', 'asdwcd', 5, 0, '', 1, '', 0),
('ET_1', 'ana', 'asdwcd', 6, 0, '', 1, '', 0),
('ET_1', 'ana', 'asdwcd', 7, 0, '', 1, '', 0),
('ET_1', 'ana', 'asdwcd', 8, 0, '', 1, '', 1),
('ET_1', 'ana', 'asdwcd', 9, 0, '', 1, '', 0),
('ET_1', 'ana', 'asdwcd', 10, 0, '', 1, '', 0),
('ET_1', 'felix', 'asdwcd', 1, 1, '', 0, 'dasdasdasdasd', 0),
('ET_1', 'felix', 'asdwcd', 2, 1, '', 1, '', 0),
('ET_1', 'felix', 'asdwcd', 3, 0, 'prueba1', 1, '', 0),
('ET_1', 'felix', 'asdwcd', 4, 1, '', 1, '', 0),
('ET_1', 'felix', 'asdwcd', 5, 1, '', 1, '', 1),
('ET_1', 'felix', 'asdwcd', 6, 1, '', 1, '', 1),
('ET_1', 'felix', 'asdwcd', 7, 1, '', 1, '', 1),
('ET_1', 'felix', 'asdwcd', 8, 0, 'prueba2', 1, '', 1),
('ET_1', 'felix', 'asdwcd', 9, 1, '', 1, '', 0),
('ET_1', 'felix', 'asdwcd', 10, 1, '', 1, '', 0),
('ET_1', 'maria', 'asdwcd', 1, 0, '', 0, 'dasdasdasdasd', 0),
('ET_1', 'maria', 'asdwcd', 2, 0, '', 1, '', 1),
('ET_1', 'maria', 'asdwcd', 3, 0, '', 1, '', 0),
('ET_1', 'maria', 'asdwcd', 4, 0, '', 1, '', 1),
('ET_1', 'maria', 'asdwcd', 5, 0, '', 1, '', 0),
('ET_1', 'maria', 'asdwcd', 6, 0, '', 1, '', 1),
('ET_1', 'maria', 'asdwcd', 7, 0, '', 1, '', 0),
('ET_1', 'maria', 'asdwcd', 8, 0, '', 1, '', 1),
('ET_1', 'maria', 'asdwcd', 9, 0, '', 1, '', 1),
('ET_1', 'maria', 'asdwcd', 10, 0, '', 1, '', 1),
('ET_1', 'pedro', 'asdwcd', 1, 0, '', 0, 'dasdasdasdasd', 0),
('ET_1', 'pedro', 'asdwcd', 2, 0, '', 1, '', 1),
('ET_1', 'pedro', 'asdwcd', 3, 0, '', 1, '', 1),
('ET_1', 'pedro', 'asdwcd', 4, 0, '', 1, '', 1),
('ET_1', 'pedro', 'asdwcd', 5, 0, '', 1, '', 0),
('ET_1', 'pedro', 'asdwcd', 6, 0, '', 1, '', 1),
('ET_1', 'pedro', 'asdwcd', 7, 0, '', 1, '', 0),
('ET_1', 'pedro', 'asdwcd', 8, 0, '', 1, '', 0),
('ET_1', 'pedro', 'asdwcd', 9, 0, '', 1, '', 1),
('ET_1', 'pedro', 'asdwcd', 10, 0, '', 1, '', 1),
('ET_1', 'pepe', 'asdwcd', 1, 0, '', 0, 'dasdasdasdasd', 0),
('ET_1', 'pepe', 'asdwcd', 2, 0, '', 1, '', 1),
('ET_1', 'pepe', 'asdwcd', 3, 0, '', 1, '', 0),
('ET_1', 'pepe', 'asdwcd', 4, 0, '', 1, '', 1),
('ET_1', 'pepe', 'asdwcd', 5, 0, '', 1, '', 1),
('ET_1', 'pepe', 'asdwcd', 6, 0, '', 1, '', 0),
('ET_1', 'pepe', 'asdwcd', 7, 0, '', 1, '', 1),
('ET_1', 'pepe', 'asdwcd', 8, 0, '', 1, '', 1),
('ET_1', 'pepe', 'asdwcd', 9, 0, '', 1, '', 1),
('ET_1', 'pepe', 'asdwcd', 10, 0, '', 1, '', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `FUNCIONALIDAD`
--

DROP TABLE IF EXISTS `FUNCIONALIDAD`;
CREATE TABLE IF NOT EXISTS `FUNCIONALIDAD` (
  `IdFuncionalidad` varchar(6) COLLATE latin1_spanish_ci NOT NULL,
  `NombreFuncionalidad` varchar(60) COLLATE latin1_spanish_ci NOT NULL,
  `DescripFuncionalidad` varchar(100) COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY (`IdFuncionalidad`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `FUNCIONALIDAD`
--

INSERT INTO `FUNCIONALIDAD` (`IdFuncionalidad`, `NombreFuncionalidad`, `DescripFuncionalidad`) VALUES
('1', 'GRUPO', 'Gestion de grupos'),
('10', 'ENTREGA', 'Gestion de entregas'),
('11', 'ASIGNACIONQA', 'Gestion de Asignacion de los QAs'),
('2', 'ACCION', 'Gestion de acciones'),
('3', 'FUNCIONALIDAD', 'Gestion de funcionalidades'),
('4', 'USUARIO', 'Gestion de usuarios'),
('6', 'HISTORIA', 'Permite la gstion de historia para los trabajos'),
('7', 'PERMISO', 'Gestion de los permisos en la aplicacion'),
('8', 'TRABAJO', 'Gestion de trabajos'),
('9', 'EVALUACION', 'Gestion de evaluaciones');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `FUNC_ACCION`
--

DROP TABLE IF EXISTS `FUNC_ACCION`;
CREATE TABLE IF NOT EXISTS `FUNC_ACCION` (
  `IdFuncionalidad` varchar(6) COLLATE latin1_spanish_ci NOT NULL,
  `IdAccion` varchar(6) COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY (`IdFuncionalidad`,`IdAccion`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `FUNC_ACCION`
--

INSERT INTO `FUNC_ACCION` (`IdFuncionalidad`, `IdAccion`) VALUES
('1', '1'),
('1', '2'),
('1', '3'),
('1', '4'),
('1', '5'),
('1', '6'),
('1', '9'),
('10', '1'),
('10', '2'),
('10', '3'),
('10', '4'),
('10', '5'),
('10', '9'),
('11', '1'),
('11', '10'),
('11', '2'),
('11', '3'),
('11', '4'),
('11', '5'),
('11', '9'),
('2', '1'),
('2', '2'),
('2', '3'),
('2', '4'),
('2', '5'),
('2', '9'),
('3', '1'),
('3', '2'),
('3', '3'),
('3', '4'),
('3', '5'),
('3', '9'),
('4', '1'),
('4', '2'),
('4', '3'),
('4', '4'),
('4', '5'),
('4', '9'),
('6', '1'),
('6', '2'),
('6', '3'),
('6', '4'),
('6', '5'),
('6', '7'),
('6', '9'),
('7', '5'),
('7', '6'),
('7', '7'),
('7', '9'),
('8', '1'),
('8', '2'),
('8', '3'),
('8', '4'),
('8', '5'),
('8', '9'),
('9', '1'),
('9', '12'),
('9', '5'),
('9', '7'),
('9', '8'),
('9', '9');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `GRUPO`
--

DROP TABLE IF EXISTS `GRUPO`;
CREATE TABLE IF NOT EXISTS `GRUPO` (
  `IdGrupo` varchar(6) COLLATE latin1_spanish_ci NOT NULL,
  `NombreGrupo` varchar(60) COLLATE latin1_spanish_ci NOT NULL,
  `DescripGrupo` varchar(100) COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY (`IdGrupo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `GRUPO`
--

INSERT INTO `GRUPO` (`IdGrupo`, `NombreGrupo`, `DescripGrupo`) VALUES
('1', 'Administrador', 'Grupo de administradores que accederan a toda la aplicacion'),
('2', 'Estudiante', 'Conjunto de estudiantes que usaran la aplicacion'),
('3', 'Invitados', 'Usuarios no registrados en la aplicacion');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `HISTORIA`
--

DROP TABLE IF EXISTS `HISTORIA`;
CREATE TABLE IF NOT EXISTS `HISTORIA` (
  `IdTrabajo` varchar(6) COLLATE latin1_spanish_ci NOT NULL,
  `IdHistoria` int(2) NOT NULL,
  `TextoHistoria` varchar(300) COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY (`IdTrabajo`,`IdHistoria`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `HISTORIA`
--

INSERT INTO `HISTORIA` (`IdTrabajo`, `IdHistoria`, `TextoHistoria`) VALUES
('ET_1', 1, 'Puede ejecutarse y funciona la aplicación al abrir el directorio que la contiene desde el navegador O\r\n'),
('ET_1', 2, 'El diseño mantiene coherencia visual entre los elementos de la página O\r\n'),
('ET_1', 3, 'El diseño de los formularios es coherente entre los mismos\r\n'),
('ET_1', 4, 'El diseño de las tablas de muestra de datos es coherente entre las mismas\r\n'),
('ET_1', 5, 'La página mantiene la estructura de la presentación ante un redimensionamiento del navegador\r\n'),
('ET_1', 6, 'La página mantiene coherencia entre opciones (tiene siempre la misma opción para la misma acción)\r\n'),
('ET_1', 7, 'Los campos de formulario tienen el tamaño de control correcto para el atributo de la tabla que solicitan\r\n'),
('ET_1', 8, 'Los campos del formulario tiene el tamaño del dato solicitado correcto para el atributo de la tabla que solicitan\r\n'),
('ET_1', 9, 'Todas las acciones están representadas por iconos\r\n'),
('ET_1', 10, 'Los SHOWALL son claros y visualmente correctos\r\n'),
('ET_1', 20, 'asdasdasdasd'),
('ET_2', 1, 'El diseño sigue la estructura solicitada'),
('ET_2', 2, 'El diseño tiene todos los elementos solicitados'),
('ET_2', 3, 'El diseño mantiene coherencia visual entre los elementos de la página'),
('ET_2', 4, 'El diseño de los formularios es coherente entre los mismos'),
('ET_2', 5, 'El diseño de las tablas de muestra de datos es coherente entre las tablas'),
('ET_2', 6, 'La página mantiene la estructura de la presentación ante un redimensionamiento del navegador'),
('ET_2', 7, 'La página mantiene coherencia entre opciones (tiene siempre la misma opción para la misma acción)'),
('ET_2', 8, 'La página mantiene coherencia entre opciones (tiene siempre la misma opción para la misma acción)'),
('ET_2', 9, 'La página mantiene coherencia entre opciones (tiene siempre la misma opción para la misma acción)'),
('ET_2', 10, 'La página mantiene coherencia entre opciones (tiene siempre la misma opción para la misma acción)');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `NOTA_TRABAJO`
--

DROP TABLE IF EXISTS `NOTA_TRABAJO`;
CREATE TABLE IF NOT EXISTS `NOTA_TRABAJO` (
  `login` varchar(9) COLLATE latin1_spanish_ci NOT NULL,
  `IdTrabajo` varchar(6) COLLATE latin1_spanish_ci NOT NULL,
  `NotaTrabajo` decimal(4,2) NOT NULL,
  PRIMARY KEY (`login`,`IdTrabajo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `PERMISO`
--

DROP TABLE IF EXISTS `PERMISO`;
CREATE TABLE IF NOT EXISTS `PERMISO` (
  `IdGrupo` varchar(6) COLLATE latin1_spanish_ci NOT NULL,
  `IdFuncionalidad` varchar(6) COLLATE latin1_spanish_ci NOT NULL,
  `IdAccion` varchar(6) COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY (`IdGrupo`,`IdFuncionalidad`,`IdAccion`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `PERMISO`
--

INSERT INTO `PERMISO` (`IdGrupo`, `IdFuncionalidad`, `IdAccion`) VALUES
('1', '1', '1'),
('1', '1', '2'),
('1', '1', '3'),
('1', '1', '4'),
('1', '1', '5'),
('1', '1', '6'),
('1', '1', '9'),
('1', '10', '1'),
('1', '10', '2'),
('1', '10', '3'),
('1', '10', '4'),
('1', '10', '5'),
('1', '10', '9'),
('1', '11', '1'),
('1', '11', '10'),
('1', '11', '2'),
('1', '11', '3'),
('1', '11', '4'),
('1', '11', '5'),
('1', '11', '9'),
('1', '2', '1'),
('1', '2', '2'),
('1', '2', '3'),
('1', '2', '4'),
('1', '2', '5'),
('1', '2', '9'),
('1', '3', '1'),
('1', '3', '2'),
('1', '3', '3'),
('1', '3', '4'),
('1', '3', '5'),
('1', '3', '9'),
('1', '4', '1'),
('1', '4', '2'),
('1', '4', '3'),
('1', '4', '4'),
('1', '4', '5'),
('1', '4', '9'),
('1', '6', '1'),
('1', '6', '2'),
('1', '6', '3'),
('1', '6', '4'),
('1', '6', '5'),
('1', '6', '7'),
('1', '6', '9'),
('1', '7', '5'),
('1', '7', '6'),
('1', '7', '7'),
('1', '7', '9'),
('1', '8', '1'),
('1', '8', '2'),
('1', '8', '3'),
('1', '8', '4'),
('1', '8', '5'),
('1', '8', '9'),
('1', '9', '1'),
('1', '9', '12'),
('1', '9', '5'),
('1', '9', '7'),
('1', '9', '8'),
('1', '9', '9'),
('2', '9', '7'),
('2', '9', '9');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `TRABAJO`
--

DROP TABLE IF EXISTS `TRABAJO`;
CREATE TABLE IF NOT EXISTS `TRABAJO` (
  `IdTrabajo` varchar(6) COLLATE latin1_spanish_ci NOT NULL,
  `NombreTrabajo` varchar(60) COLLATE latin1_spanish_ci NOT NULL,
  `FechaIniTrabajo` date NOT NULL,
  `FechaFinTrabajo` date NOT NULL,
  `PorcentajeNota` decimal(2,0) NOT NULL,
  PRIMARY KEY (`IdTrabajo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `TRABAJO`
--

INSERT INTO `TRABAJO` (`IdTrabajo`, `NombreTrabajo`, `FechaIniTrabajo`, `FechaFinTrabajo`, `PorcentajeNota`) VALUES
('ET_1', 'Entrega1', '0000-00-00', '0000-00-00', '3'),
('ET_2', 'Entrega2', '2017-12-02', '2017-12-16', '10'),
('QA_1', 'QA 1', '2017-12-14', '2017-12-26', '8');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `USUARIO`
--

DROP TABLE IF EXISTS `USUARIO`;
CREATE TABLE IF NOT EXISTS `USUARIO` (
  `login` varchar(9) COLLATE latin1_spanish_ci NOT NULL,
  `password` varchar(128) COLLATE latin1_spanish_ci NOT NULL,
  `DNI` varchar(9) COLLATE latin1_spanish_ci NOT NULL,
  `Nombre` varchar(30) COLLATE latin1_spanish_ci NOT NULL,
  `Apellidos` varchar(50) COLLATE latin1_spanish_ci NOT NULL,
  `Correo` varchar(40) COLLATE latin1_spanish_ci NOT NULL,
  `Direccion` varchar(60) COLLATE latin1_spanish_ci NOT NULL,
  `Telefono` varchar(11) COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY (`login`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `USUARIO`
--

INSERT INTO `USUARIO` (`login`, `password`, `DNI`, `Nombre`, `Apellidos`, `Correo`, `Direccion`, `Telefono`) VALUES
('ana', '202cb962ac59075b964b07152d234b70', '87634512W', 'dsadasd', 'adsasd', 'asdasdasd@asd.acc', 'asdasd', '654987321'),
('felix', '202cb962ac59075b964b07152d234b70', '12312343A', 'asdasd', 'asdasdasasd', 'asdasdas@asda.cd', 'asdasdas', '654876123'),
('fernando', '202cb962ac59075b964b07152d234b70', '23412312F', 'asdasd', 'asdasdasdasd', 'asdasddas@asdasd.cdcas', 'asdasd', '654876654'),
('floro', '202cb962ac59075b964b07152d234b70', '44476299A', 'asdasdasd', 'assdasdasd', 'adasd@asdasd.cdcd', 'asdasdasd', '654321233'),
('jose', '202cb962ac59075b964b07152d234b70', '12343231D', 'asdas', 'asdasd', 'asddas@asd.cdc', 'asdasdasd', '654123123'),
('maria', '202cb962ac59075b964b07152d234b70', '12332132W', 'Laura', 'Perez', 'asdas@asda.cdc', 'asdasdasd', '654123123'),
('matias', '21232f297a57a5a743894a0e4a801fc3', '12312323E', 'asdasdasd', 'qasdasdasd', 'asdasdasd@asdasd.cdcd', '', '676123123'),
('pablo', '202cb962ac59075b964b07152d234b70', '67451232S', 'asdasdad', 'asdasdasd', 'asdasdasd@asdasd.cddc', 'asdasdasd', '658965234'),
('pedro', '202cb962ac59075b964b07152d234b70', '95175385E', 'aasdasd', 'asdasasd', 'asddas@assdas.cdc', 'asdasd', '654123123'),
('pepe', '202cb962ac59075b964b07152d234b70', '12334512A', 'asddasd', 'asdasdasd', 'asdasdasd@asdas.cdcd', 'asdad', '654123123');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `USU_GRUPO`
--

DROP TABLE IF EXISTS `USU_GRUPO`;
CREATE TABLE IF NOT EXISTS `USU_GRUPO` (
  `login` varchar(9) COLLATE latin1_spanish_ci NOT NULL,
  `IdGrupo` varchar(6) COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY (`login`,`IdGrupo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `USU_GRUPO`
--

INSERT INTO `USU_GRUPO` (`login`, `IdGrupo`) VALUES
('ana', '2'),
('felix', '2'),
('fernando', '2'),
('floro', '1'),
('jose', '2'),
('maria', '2'),
('pablo', '2'),
('pedro', '2'),
('pepe', '2');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
