-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 01-11-2017 a las 13:25:46
-- Versión del servidor: 5.7.17-log
-- Versión de PHP: 5.4.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `quiz`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `preguntas`
--

CREATE TABLE IF NOT EXISTS `preguntas` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `EMAIL` text NOT NULL,
  `PREGUNTA` varchar(200) NOT NULL,
  `RESPUESTA_C` text NOT NULL,
  `RESPUESTA_I1` text NOT NULL,
  `RESPUESTA_I2` text NOT NULL,
  `RESPUESTA_I3` text NOT NULL,
  `COMP` int(11) NOT NULL,
  `TEMA` text NOT NULL,
  `IMAGEN` text,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `PREGUNTA` (`PREGUNTA`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `EMAIL` varchar(100) NOT NULL,
  `NOMBRE` text NOT NULL,
  `NICK` varchar(100) NOT NULL,
  `PASS` text NOT NULL,
  `IMAGEN` text,
  PRIMARY KEY (`EMAIL`),
  UNIQUE KEY `NICK` (`NICK`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
