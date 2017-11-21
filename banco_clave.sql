-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 07-11-2017 a las 04:12:05
-- Versión del servidor: 5.6.17
-- Versión de PHP: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `banco_clave`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `usr_user` varchar(200) COLLATE utf8_spanish2_ci NOT NULL,
  `nom_user` varchar(200) COLLATE utf8_spanish2_ci NOT NULL,
  `ape_user` varchar(200) COLLATE utf8_spanish2_ci NOT NULL,
  `pass_user` varchar(255) COLLATE utf8_spanish2_ci NOT NULL,
  `gen_user` varchar(1) COLLATE utf8_spanish2_ci NOT NULL,
  `nac_user` date NOT NULL,
  `ema_user` varchar(200) COLLATE utf8_spanish2_ci NOT NULL,
  `rol_user` varchar(1) COLLATE utf8_spanish2_ci NOT NULL,
  `sts_user` tinyint(1) NOT NULL,
  `tkn_user` varchar(400) COLLATE utf8_spanish2_ci NOT NULL,
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `usr_user` (`usr_user`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci AUTO_INCREMENT=45 ;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`id_user`, `usr_user`, `nom_user`, `ape_user`, `pass_user`, `gen_user`, `nac_user`, `ema_user`, `rol_user`, `sts_user`, `tkn_user`) VALUES
(1, 'rperaza', 'Roimer', 'Peraza', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'M', '1995-11-07', 'rperaza@dominio.com', '1', 1, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE1MTAwMjQxMzksImV4cCI6MTUxMDAyNTMzOSwiZGF0YSI6eyJpZCI6IjEiLCJuYW1lIjoiUm9pbWVyIiwibGFzdF9uYW1lIjoiUGVyYXphIiwidXNlciI6InJwZXJhemEiLCJnZW5kZXIiOiJNIiwiYmlydGhfZGF0ZSI6IjE5OTUtMTEtMDciLCJlbWFpbCI6InJwZXJhemFAZG9taW5pby5jb20iLCJyb2wiOiIxIiwiZXN0YXR1cyI6IjEifX0.rQbIwZAWeuQPweDuZJxafYINTM3Sl7hzHtWEvikZIGk'),
(39, 'jcolmenarez', 'Joiseph', 'Colmenarez', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'M', '1995-11-07', 'jcolmenarez@dominio.com', '2', 1, ''),
(44, 'eperdomo', 'Eimy', 'Palacio', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'F', '1995-11-07', 'epalacio@dominio.com', '1', 0, '');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
