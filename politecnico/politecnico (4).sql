-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 25-10-2023 a las 23:14:18
-- Versión del servidor: 8.0.31
-- Versión de PHP: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `politecnico`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumno`
--

DROP TABLE IF EXISTS `alumno`;
CREATE TABLE IF NOT EXISTS `alumno` (
  `idAlumno` int NOT NULL AUTO_INCREMENT,
  `nombre_alumno` varchar(45) DEFAULT NULL,
  `apellido_alumno` varchar(45) DEFAULT NULL,
  `dni_alumno` varchar(45) DEFAULT NULL,
  `celular` varchar(45) DEFAULT NULL,
  `estado` int NOT NULL,
  `legajo` int DEFAULT NULL,
  `edad` date DEFAULT NULL,
  `formacion-previa` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`idAlumno`)
) ENGINE=InnoDB AUTO_INCREMENT=472 DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `alumno`
--

INSERT INTO `alumno` (`idAlumno`, `nombre_alumno`, `apellido_alumno`, `dni_alumno`, `celular`, `estado`, `legajo`, `edad`, `formacion-previa`) VALUES
(37, 'Fátima Carolina', 'Aguirre', '', '', 1, NULL, NULL, NULL),
(38, 'Miriam Elizabet ', 'Aguirre', NULL, NULL, 1, NULL, NULL, NULL),
(39, 'Leandro', 'Almiron', NULL, NULL, 1, NULL, NULL, NULL),
(40, 'Andrea Stefani', 'Altamirano', NULL, NULL, 1, NULL, NULL, NULL),
(41, 'Sandra', 'Alvarez', NULL, NULL, 1, NULL, NULL, NULL),
(42, 'Carolina', 'Alvarez', NULL, NULL, 1, NULL, NULL, NULL),
(43, 'Romina Valeria ', 'Amarilla', NULL, NULL, 1, NULL, NULL, NULL),
(44, 'Silvia Noemí', 'Amarilla', NULL, NULL, 1, NULL, NULL, NULL),
(45, 'Nair Rocío Belén', 'Andruszyszyn', NULL, NULL, 1, NULL, NULL, NULL),
(46, 'Laura Monica', 'Anzuate', NULL, NULL, 1, NULL, NULL, NULL),
(47, 'Patricia Maria Itati', 'Aranda', NULL, NULL, 1, NULL, NULL, NULL),
(49, 'Adriana Elizabeth', 'Barrios', NULL, NULL, 1, NULL, NULL, NULL),
(50, 'Romina Isabel', 'Barrios', NULL, NULL, 1, NULL, NULL, NULL),
(51, 'Maria Laura ', 'Benedetti', NULL, NULL, 1, NULL, NULL, NULL),
(52, 'Sandra Lorena', 'Bonifacio', NULL, NULL, 1, NULL, NULL, NULL),
(53, 'Nicole Camila', 'Braga', NULL, NULL, 1, NULL, NULL, NULL),
(54, 'Joana Viviana', 'Britez', NULL, NULL, 1, NULL, NULL, NULL),
(55, 'Yanina', 'Britez', NULL, NULL, 1, NULL, NULL, NULL),
(56, 'Delia', 'Brizuela', NULL, NULL, 1, NULL, NULL, NULL),
(57, 'Jesica Belén ', 'Cabañas', NULL, NULL, 1, NULL, NULL, NULL),
(58, 'Marisel Elisabeth del Milagro', 'Caceres', NULL, NULL, 1, NULL, NULL, NULL),
(59, 'Roselida', 'Cancio', NULL, NULL, 1, NULL, NULL, NULL),
(60, 'Cecilia Mabel', 'Castaño', NULL, NULL, 1, NULL, NULL, NULL),
(61, 'Rocio Ailí', 'Correa', NULL, NULL, 1, NULL, NULL, NULL),
(62, 'Morena Ayelen', 'D\'ecclesüs', NULL, NULL, 1, NULL, NULL, NULL),
(63, 'Jeremias ', 'Del Valle', NULL, NULL, 1, NULL, NULL, NULL),
(64, 'Karen Ayelen', 'Diaz', NULL, NULL, 1, NULL, NULL, NULL),
(65, 'Daniela Antonia ', 'Dominguez', NULL, NULL, 1, NULL, NULL, NULL),
(66, 'Mirian Lorena', 'Duarte', NULL, NULL, 1, NULL, NULL, NULL),
(67, 'Gisela Estefanía', 'Fernandez', NULL, NULL, 1, NULL, NULL, NULL),
(68, 'Marcia Belen ', 'Fernandez', NULL, NULL, 1, NULL, NULL, NULL),
(69, 'Delia Isabel', 'Ferreira', NULL, NULL, 1, NULL, NULL, NULL),
(70, 'Blanca', 'Galeano', NULL, NULL, 1, NULL, NULL, NULL),
(71, 'Natalia', 'Gavilan', NULL, NULL, 1, NULL, NULL, NULL),
(72, 'Alberto Manuel ', 'Gomez', NULL, NULL, 1, NULL, NULL, NULL),
(73, 'Luisa Natalia ', 'Gomez', NULL, NULL, 1, NULL, NULL, NULL),
(74, 'Evelin Miriam', 'Gonzalez', NULL, NULL, 1, NULL, NULL, NULL),
(75, 'Vanesa Soledad ', 'Gonzalez', NULL, NULL, 1, NULL, NULL, NULL),
(76, 'María Marta', 'Servín', NULL, NULL, 1, NULL, NULL, NULL),
(77, 'Rocio Alejandra', 'Goras', NULL, NULL, 1, NULL, NULL, NULL),
(78, 'Fátima Melisa', 'Hagelin', NULL, NULL, 1, NULL, NULL, NULL),
(79, 'Carla Andrea', 'Herrera Avellaneda', NULL, NULL, 1, NULL, NULL, NULL),
(80, 'Lourde Lorena', 'Herrera Avellaneda', NULL, NULL, 1, NULL, NULL, NULL),
(81, 'Carolina', 'Ibarra', NULL, NULL, 1, NULL, NULL, NULL),
(82, 'Fabiana', 'Ifran', NULL, NULL, 1, NULL, NULL, NULL),
(83, 'Rocio', 'Insfran', NULL, NULL, 1, NULL, NULL, NULL),
(84, 'Susana Mariel', 'Kirchheim', NULL, NULL, 1, NULL, NULL, NULL),
(85, 'Cintia Carolina', 'Lencina', NULL, NULL, 1, NULL, NULL, NULL),
(86, 'Silvia Noemí', 'Lopez', NULL, NULL, 1, NULL, NULL, NULL),
(87, 'Oriana', 'Maciel', NULL, NULL, 1, NULL, NULL, NULL),
(88, 'Natalia Itati', 'Mieres', NULL, NULL, 1, NULL, NULL, NULL),
(89, 'Yesica Paola', 'Montenegro', NULL, NULL, 1, NULL, NULL, NULL),
(90, 'Juan Carlos', 'Nuñez', NULL, NULL, 1, NULL, NULL, NULL),
(91, 'Elsa Romina Rita', 'Palma', NULL, NULL, 1, NULL, NULL, NULL),
(92, 'Maria Isabel', 'Peralta', NULL, NULL, 1, NULL, NULL, NULL),
(93, 'Natalia', 'Peralta', NULL, NULL, 1, NULL, NULL, NULL),
(94, 'Cintia', 'Pereira', NULL, NULL, 1, NULL, NULL, NULL),
(95, 'Gladis Mariana', 'Pintos', NULL, NULL, 1, NULL, NULL, NULL),
(96, 'Analia Beatriz', 'Rodriguez', NULL, NULL, 1, NULL, NULL, NULL),
(97, 'Camila Antonella', 'Rodriguez', NULL, NULL, 1, NULL, NULL, NULL),
(98, 'Cintya Rafaela', 'Rojas', NULL, NULL, 1, NULL, NULL, NULL),
(99, 'Rocio', 'Roman', NULL, NULL, 1, NULL, NULL, NULL),
(100, 'Rosana Elizabeth', 'Rotela Brittos', NULL, NULL, 1, NULL, NULL, NULL),
(101, 'Brisa Romina Elizabeth', 'Rubidarte', NULL, NULL, 1, NULL, NULL, NULL),
(102, 'Maria del Carmen', 'Samaniego', NULL, NULL, 1, NULL, NULL, NULL),
(103, 'Micaela', 'Samaniego', NULL, NULL, 1, NULL, NULL, NULL),
(104, 'Andrea Elizabet', 'Sanchez', NULL, NULL, 1, NULL, NULL, NULL),
(105, 'Yamila Elizabeth', 'Saucedo Encina', NULL, NULL, 1, NULL, NULL, NULL),
(106, 'Claudia', 'Sienra', NULL, NULL, 1, NULL, NULL, NULL),
(107, 'Lucia del Carmen ', 'Sienra', NULL, NULL, 1, NULL, NULL, NULL),
(108, 'Daniela Elizabeth', 'Silva', NULL, NULL, 1, NULL, NULL, NULL),
(109, 'Graciela', 'Silva', NULL, NULL, 1, NULL, NULL, NULL),
(110, 'Norma Elizabet', 'Suarez', NULL, NULL, 1, NULL, NULL, NULL),
(111, 'Yesica Noemi', 'Trinidad', NULL, NULL, 1, NULL, NULL, NULL),
(112, 'Yuliana', 'Valenzuela', NULL, NULL, 1, NULL, NULL, NULL),
(113, 'Diana Beatriz', 'Vera', NULL, NULL, 1, NULL, NULL, NULL),
(114, 'Daina Belen', 'Villada', NULL, NULL, 1, NULL, NULL, NULL),
(115, 'Cristian', 'Woltrich', NULL, NULL, 1, NULL, NULL, NULL),
(116, 'Luz Mila Jana Nerea', 'Zaleski', NULL, NULL, 1, NULL, NULL, NULL),
(117, 'Emily Soledad', 'Zorrilla', NULL, NULL, 1, NULL, NULL, NULL),
(118, 'Maria Elizabeth A.', 'Aguirre', NULL, NULL, 1, NULL, NULL, NULL),
(119, 'Jimena Gisel', 'Alegre', NULL, NULL, 1, NULL, NULL, NULL),
(120, 'Nora Cristina ', 'Altamirano', NULL, NULL, 1, NULL, NULL, NULL),
(121, 'Candela Yanira', 'Amarilla', NULL, NULL, 1, NULL, NULL, NULL),
(122, 'Marina Gisel ', 'Antunez', NULL, NULL, 1, NULL, NULL, NULL),
(123, 'Esteban Gabriel', 'Arbelino', NULL, NULL, 1, NULL, NULL, NULL),
(124, 'Marcela Alejandra', 'Arbelino', NULL, NULL, 1, NULL, NULL, NULL),
(125, 'María José', 'Baez', NULL, NULL, 1, NULL, NULL, NULL),
(126, 'Dario Victor ', 'Balletbo', NULL, NULL, 1, NULL, NULL, NULL),
(127, 'Maria de los Angeles ', 'Bernal', NULL, NULL, 1, NULL, NULL, NULL),
(128, 'Silvana Beatriz', 'Contis', NULL, NULL, 1, NULL, NULL, NULL),
(129, 'Maria Florencia ', 'Fraticelli', NULL, NULL, 1, NULL, NULL, NULL),
(130, 'Adriana Veronica', 'Jaques', NULL, NULL, 1, NULL, NULL, NULL),
(131, 'Lidia Mabel ', 'Kubitz', NULL, NULL, 1, NULL, NULL, NULL),
(132, 'Marisa Paola ', 'Lopez', NULL, NULL, 1, NULL, NULL, NULL),
(133, 'Julio Cesar ', 'Pereira Riquelme', NULL, NULL, 1, NULL, NULL, NULL),
(134, 'Adriana Beatriz', 'Ramirez', NULL, NULL, 1, NULL, NULL, NULL),
(135, 'Maria Cecila', 'Rojas Yanes', NULL, NULL, 1, NULL, NULL, NULL),
(136, 'Olga Mabel', 'Samaniego', NULL, NULL, 1, NULL, NULL, NULL),
(137, 'Noelia Andrea', 'Santa Cruz', NULL, NULL, 1, NULL, NULL, NULL),
(138, 'Monica Paola', 'Sena', NULL, NULL, 1, NULL, NULL, NULL),
(139, 'Analia Soledad ', 'Vergara', NULL, NULL, 1, NULL, NULL, NULL),
(140, 'Brisa Milagros ', 'Vergara', NULL, NULL, 1, NULL, NULL, NULL),
(141, 'Karen Fabiana', 'Acosta', NULL, NULL, 1, NULL, NULL, NULL),
(142, 'Ana Itatí', 'Baez', NULL, NULL, 1, NULL, NULL, NULL),
(143, 'Mariana Vanesa ', 'Benitez', NULL, NULL, 1, NULL, NULL, NULL),
(144, 'Gladys Veronica', 'Bernal', NULL, NULL, 1, NULL, NULL, NULL),
(145, 'Carlos Emanuel', 'Britos', NULL, NULL, 1, NULL, NULL, NULL),
(146, 'Lautario Martin', 'Brunaga', NULL, NULL, 1, NULL, NULL, NULL),
(147, 'Carolina Pamela', 'Cabral', NULL, NULL, 1, NULL, NULL, NULL),
(148, 'Roberto Maximiliano', 'Carballo', NULL, NULL, 1, NULL, NULL, NULL),
(149, 'Patricia Mabel ', 'Castro', NULL, NULL, 1, NULL, NULL, NULL),
(150, 'Sofía Itatí', 'Correa', NULL, NULL, 1, NULL, NULL, NULL),
(151, 'Rocío Belén ', 'Da Silva', NULL, NULL, 1, NULL, NULL, NULL),
(152, 'Yanina', 'Da Silva', NULL, NULL, 1, NULL, NULL, NULL),
(153, 'Antonia Noemí', 'Davalos', NULL, NULL, 1, NULL, NULL, NULL),
(154, 'Nahuel Nicolas', 'Davalos Quintana', NULL, NULL, 1, NULL, NULL, NULL),
(155, 'Mariana Noemi ', 'Dos Santos', NULL, NULL, 1, NULL, NULL, NULL),
(156, 'Damaris Natalia', 'Duarte', NULL, NULL, 1, NULL, NULL, NULL),
(157, 'Rocio Soledad', 'Echeverria', NULL, NULL, 1, NULL, NULL, NULL),
(158, 'Janet Lucía', 'Ferreira', NULL, NULL, 1, NULL, NULL, NULL),
(159, 'Yanina Elizabet', 'Franco', NULL, NULL, 1, NULL, NULL, NULL),
(160, 'Leticia Raquel', 'Giraudi', NULL, NULL, 1, NULL, NULL, NULL),
(161, 'Lorena Mabel', 'Godoy', NULL, NULL, 1, NULL, NULL, NULL),
(162, 'Mariela Isabel', 'Gonzales', NULL, NULL, 1, NULL, NULL, NULL),
(163, 'Camila Soledad Belén', 'Ifran', NULL, NULL, 1, NULL, NULL, NULL),
(164, 'Andrea Vanesa', 'Lezcano', NULL, NULL, 1, NULL, NULL, NULL),
(165, 'Guillermo Javier', 'Martinez', NULL, NULL, 1, NULL, NULL, NULL),
(166, 'Miriam Vanessa', 'Mendoza', NULL, NULL, 1, NULL, NULL, NULL),
(167, 'Eliana Yamila', 'Nuñez', NULL, NULL, 1, NULL, NULL, NULL),
(168, 'Analia Evangelina', 'Oscare', NULL, NULL, 1, NULL, NULL, NULL),
(169, 'Andrea Liliana', 'Paiva', NULL, NULL, 1, NULL, NULL, NULL),
(170, 'Andrea Elizabeth', 'Paredes', NULL, NULL, 1, NULL, NULL, NULL),
(171, 'Fiorella Agustina', 'Perez', NULL, NULL, 1, NULL, NULL, NULL),
(172, 'Mendoza Vanina', 'Perez', NULL, NULL, 1, NULL, NULL, NULL),
(173, 'Evelin Elizabeth', 'Perick', NULL, NULL, 1, NULL, NULL, NULL),
(174, 'Marcelino Ezequiel', 'Pinto', NULL, NULL, 1, NULL, NULL, NULL),
(175, 'Irma Micaela', 'Quintana', NULL, NULL, 1, NULL, NULL, NULL),
(176, 'Dana Bárbara', 'Quiroga', NULL, NULL, 1, NULL, NULL, NULL),
(177, 'Maria Fermina', 'Rios', NULL, NULL, 1, NULL, NULL, NULL),
(178, 'Carmen Lurdes', 'Roberti', NULL, NULL, 1, NULL, NULL, NULL),
(179, 'Laura Noemí', 'Ruiz Diaz', NULL, NULL, 1, NULL, NULL, NULL),
(180, 'Noelia Vanesa', 'Ruiz', NULL, NULL, 1, NULL, NULL, NULL),
(181, 'Katherina Daiana', 'Samaniego', NULL, NULL, 1, NULL, NULL, NULL),
(182, 'Hugo Orlando', 'Sanchez', NULL, NULL, 1, NULL, NULL, NULL),
(183, 'Carolina Elizabet ', 'Silva', NULL, NULL, 1, NULL, NULL, NULL),
(184, 'Telma Cintia', 'Spíguel Piedrabuena', NULL, NULL, 1, NULL, NULL, NULL),
(185, 'Alejandro', 'Torres', NULL, NULL, 1, NULL, NULL, NULL),
(186, 'Axel', 'Benitez', NULL, NULL, 1, NULL, NULL, NULL),
(187, 'Erica', 'Meneses', NULL, NULL, 1, NULL, NULL, NULL),
(188, 'Veronica', 'Torres', NULL, NULL, 1, NULL, NULL, NULL),
(189, 'Carla', 'Boschetti', NULL, NULL, 1, NULL, NULL, NULL),
(190, 'Mirian', 'Alvarez', NULL, NULL, 1, NULL, NULL, NULL),
(191, 'Maria L.', 'Machado', NULL, NULL, 1, NULL, NULL, NULL),
(192, 'Natalia', 'Lopez', NULL, NULL, 1, NULL, NULL, NULL),
(193, 'Luz Marianela', 'Benitez', NULL, NULL, 1, NULL, NULL, NULL),
(194, 'Adriana Ines', 'Balgueret', NULL, NULL, 1, NULL, NULL, NULL),
(195, 'Milagros Macarena ', 'Benitez', NULL, NULL, 1, NULL, NULL, NULL),
(196, 'Maria Cristina ', 'Bernal', NULL, NULL, 1, NULL, NULL, NULL),
(197, 'Laura Silvana', 'Bogado', NULL, NULL, 1, NULL, NULL, NULL),
(198, 'Nicolas Inocencio', 'Gonzalez', NULL, NULL, 1, NULL, NULL, NULL),
(199, 'Marianela Soledad ', 'Leguizamon', NULL, NULL, 1, NULL, NULL, NULL),
(200, 'Agustin Ariel', 'Lopez', NULL, NULL, 1, NULL, NULL, NULL),
(201, 'Rolando Catriel', 'Morcillo', NULL, NULL, 1, NULL, NULL, NULL),
(202, 'Karina Elizabeth ', 'Ocampo', NULL, NULL, 1, NULL, NULL, NULL),
(203, 'Carina Fabiana ', 'Ponce', NULL, NULL, 1, NULL, NULL, NULL),
(204, 'Elizabet Judit', 'Ramirez', NULL, NULL, 1, NULL, NULL, NULL),
(205, 'Rosa Elvira ', 'Rojas', NULL, NULL, 1, NULL, NULL, NULL),
(206, 'Viviana Vanina', 'Rolon', NULL, NULL, 1, NULL, NULL, NULL),
(207, 'Tania Guadalupe', 'Saldaña', NULL, NULL, 1, NULL, NULL, NULL),
(208, 'Jesica Alejandra', 'Ahlgreen', NULL, NULL, 1, NULL, NULL, NULL),
(209, 'Anabela', 'Altamirano', NULL, NULL, 1, NULL, NULL, NULL),
(210, 'Maria Alejandra', 'Alvarez', NULL, NULL, 1, NULL, NULL, NULL),
(211, 'Sofia Guadalupe', 'Alvez', NULL, NULL, 1, NULL, NULL, NULL),
(212, 'Federico Rubén', 'Arroyo', NULL, NULL, 1, NULL, NULL, NULL),
(213, 'Delia Noemi', 'Bareiro', NULL, NULL, 1, NULL, NULL, NULL),
(214, 'Fatima Paulina', 'Basaraba', NULL, NULL, 1, NULL, NULL, NULL),
(215, 'Ludmila Desire', 'Benitez', NULL, NULL, 1, NULL, NULL, NULL),
(216, 'Ivana Raquel', 'Bordon', NULL, NULL, 1, NULL, NULL, NULL),
(217, 'Patricia Noemi', 'Busto', NULL, NULL, 1, NULL, NULL, NULL),
(218, 'Camila Belen', 'Caceres', NULL, NULL, 1, NULL, NULL, NULL),
(219, 'Maria De Los Angeles', 'Couto', NULL, NULL, 1, NULL, NULL, NULL),
(220, 'Yessica Nair', 'Duran', NULL, NULL, 1, NULL, NULL, NULL),
(221, 'Lucia Vanessa', 'Elizalde', NULL, NULL, 1, NULL, NULL, NULL),
(222, 'Magali', 'Ferreira De Morais', NULL, NULL, 1, NULL, NULL, NULL),
(223, 'Alejandra Elizabeth', 'Ferreyra', NULL, NULL, 1, NULL, NULL, NULL),
(224, 'Carol Magali', 'Figueredo', NULL, NULL, 1, NULL, NULL, NULL),
(225, 'Karina Isabel Noemi', 'Fleitas', NULL, NULL, 1, NULL, NULL, NULL),
(226, 'Ernestina Abril', 'Galarza', NULL, NULL, 1, NULL, NULL, NULL),
(227, 'Lujan Elizabeth', 'Gimenez', NULL, NULL, 1, NULL, NULL, NULL),
(228, 'Anabella Rosa', 'Gomez', NULL, NULL, 1, NULL, NULL, NULL),
(229, 'Daniela Del Carmen', 'González', NULL, NULL, 1, NULL, NULL, NULL),
(230, 'Ivana Silvina', 'Gonzalez', NULL, NULL, 1, NULL, NULL, NULL),
(231, 'Veronica Gisel', 'González', NULL, NULL, 1, NULL, NULL, NULL),
(232, 'Flora Andrea', 'Ifrán', NULL, NULL, 1, NULL, NULL, NULL),
(233, 'Kevin Eliezer', 'Ifran', NULL, NULL, 1, NULL, NULL, NULL),
(234, 'Yesica Pamela', 'Llanes', NULL, NULL, 1, NULL, NULL, NULL),
(235, 'Marlene Itati', 'Maidana', NULL, NULL, 1, NULL, NULL, NULL),
(236, 'Pablo Yoel', 'Ojeda', NULL, NULL, 1, NULL, NULL, NULL),
(237, 'Analia Elizabeth', 'Ramirez', NULL, NULL, 1, NULL, NULL, NULL),
(238, 'Elsa Ester', 'Reinaldo', NULL, NULL, 1, NULL, NULL, NULL),
(239, 'Estela', 'Reyes', NULL, NULL, 1, NULL, NULL, NULL),
(240, 'Cristian Ivan ', 'Rojas', NULL, NULL, 1, NULL, NULL, NULL),
(241, 'Romina Patricia', 'Romero', NULL, NULL, 1, NULL, NULL, NULL),
(242, 'Lorena Abril', 'Saldaña', NULL, NULL, 1, NULL, NULL, NULL),
(243, 'Romanela Madelen', 'Sarza', NULL, NULL, 1, NULL, NULL, NULL),
(244, 'Mercedes Vanesa', 'Solano', NULL, NULL, 1, NULL, NULL, NULL),
(245, 'Emilce Juliana', 'Tabarez', NULL, NULL, 1, NULL, NULL, NULL),
(246, 'Laura Leticia', 'Toledo', NULL, NULL, 1, NULL, NULL, NULL),
(247, 'Estela Marys', 'Valdiviezo', NULL, NULL, 1, NULL, NULL, NULL),
(248, 'Fernando', 'Vera', NULL, NULL, 1, NULL, NULL, NULL),
(249, 'Rosa Noemi', 'Vieira', NULL, NULL, 1, NULL, NULL, NULL),
(250, 'Lucia', 'Gonzalez', NULL, NULL, 1, NULL, NULL, NULL),
(251, 'Miranda', 'Calderon', NULL, NULL, 1, NULL, NULL, NULL),
(252, 'Nestor Fabian', 'Alvez', NULL, NULL, 1, NULL, NULL, NULL),
(253, 'Micaela ', 'Rocha Velozo', NULL, NULL, 1, NULL, NULL, NULL),
(254, 'Claudia Andrea ', 'Espindola', NULL, NULL, 1, NULL, NULL, NULL),
(255, 'Veronica', 'Piris', NULL, NULL, 1, NULL, NULL, NULL),
(256, 'Rita', 'Talavera', NULL, NULL, 1, NULL, NULL, NULL),
(257, 'Daniel', 'Oliveira', NULL, NULL, 1, NULL, NULL, NULL),
(258, 'Barbara', 'Fernandez', NULL, NULL, 1, NULL, NULL, NULL),
(259, 'Exequiel', 'Carrizo', NULL, NULL, 1, NULL, NULL, NULL),
(260, 'Ivana Soledad', 'Barrios', NULL, NULL, 1, NULL, NULL, NULL),
(261, 'Natalia', 'Castillo', NULL, NULL, 1, NULL, NULL, NULL),
(262, 'Norma', 'Arriola', NULL, NULL, 1, NULL, NULL, NULL),
(263, 'María Hilda', 'Aranda', NULL, NULL, 1, NULL, NULL, NULL),
(264, 'Aldana Sandra', 'De Olivera Alvez', NULL, NULL, 1, NULL, NULL, NULL),
(265, 'Patricia Soledad', 'Fernandez', NULL, NULL, 1, NULL, NULL, NULL),
(266, 'Ana Laura', 'Galeano', NULL, NULL, 1, NULL, NULL, NULL),
(267, 'Marcela Evelyn', 'Gomez Pereyra', NULL, NULL, 1, NULL, NULL, NULL),
(268, 'Yanina B.', 'Kociubczyk Moraiz', NULL, NULL, 1, NULL, NULL, NULL),
(269, 'Hector Ezequiel', 'Molina', NULL, NULL, 1, NULL, NULL, NULL),
(270, 'Romina Analia ', 'Ojeda', NULL, NULL, 1, NULL, NULL, NULL),
(271, 'Fabio Emmanuel', 'Quintana', NULL, NULL, 1, NULL, NULL, NULL),
(272, 'Andrea Carolina', 'Ruiz Diaz', NULL, NULL, 1, NULL, NULL, NULL),
(273, 'Mariana Yessica', 'Salvayot', NULL, NULL, 1, NULL, NULL, NULL),
(274, 'Anyelen Antonella', 'Santoro', NULL, NULL, 1, NULL, NULL, NULL),
(275, 'Micaela Nicol', 'Traico', NULL, NULL, 1, NULL, NULL, NULL),
(276, 'Matias Hernan', 'Ulrich', NULL, NULL, 1, NULL, NULL, NULL),
(277, 'Claudelina Elizabeth', 'Villalba', NULL, NULL, 1, NULL, NULL, NULL),
(278, 'Adriana Patricia', 'Alarcón', NULL, NULL, 1, NULL, NULL, NULL),
(279, 'Paula Andrea', 'Alarcon', NULL, NULL, 1, NULL, NULL, NULL),
(280, 'Hernan Lucas', 'Alvarez', NULL, NULL, 1, NULL, NULL, NULL),
(281, 'Eliana', 'Amarilla', NULL, NULL, 1, NULL, NULL, NULL),
(282, 'Marianela', 'Araujo Nair', NULL, NULL, 1, NULL, NULL, NULL),
(283, 'Valeria Maribel', 'Barrera', NULL, NULL, 1, NULL, NULL, NULL),
(284, 'Gisela Analía', 'Barrios', NULL, NULL, 1, NULL, NULL, NULL),
(285, 'Juan Ignacio', 'Campillo', NULL, NULL, 1, NULL, NULL, NULL),
(286, 'Maria Magdalena ', 'Caniza', NULL, NULL, 1, NULL, NULL, NULL),
(287, 'Carolina', 'Castillo', NULL, NULL, 1, NULL, NULL, NULL),
(288, 'Gimena Micaela ', 'Castillo', NULL, NULL, 1, NULL, NULL, NULL),
(289, 'Agostina Itatí ', 'Castillo Mariel', NULL, NULL, 1, NULL, NULL, NULL),
(290, 'Verónica Elizabeth', 'Castillo', NULL, NULL, 1, NULL, NULL, NULL),
(291, 'Ana Maria', 'Cayo', NULL, NULL, 1, NULL, NULL, NULL),
(292, 'Mayara Nazarena', 'Dos Santos', NULL, NULL, 1, NULL, NULL, NULL),
(293, 'Mara Elizabet', 'Galeano', NULL, NULL, 1, NULL, NULL, NULL),
(294, 'Mercedes Alejandra ', 'Garcia Paredes', NULL, NULL, 1, NULL, NULL, NULL),
(295, 'Rosa', 'Garcia', NULL, NULL, 1, NULL, NULL, NULL),
(296, 'Angelica Gladis', 'Gómez', NULL, NULL, 1, NULL, NULL, NULL),
(297, 'Florencia', 'Gomez', NULL, NULL, 1, NULL, NULL, NULL),
(298, 'Celina Beatriz', 'Gonzales', NULL, NULL, 1, NULL, NULL, NULL),
(299, 'Mirta Mabel', 'Jara', NULL, NULL, 1, NULL, NULL, NULL),
(300, 'Juana Milagro', 'Lara', NULL, NULL, 1, NULL, NULL, NULL),
(301, 'Nancy Elizabet', 'Ledezma', NULL, NULL, 1, NULL, NULL, NULL),
(302, 'Magali Magdalena', 'Lopez', NULL, NULL, 1, NULL, NULL, NULL),
(303, 'Nelida Raquel', 'Maidana', NULL, NULL, 1, NULL, NULL, NULL),
(304, 'Silvia Natalia', 'Martinez', NULL, NULL, 1, NULL, NULL, NULL),
(305, 'Carolina', 'Mieréz Lourdes', NULL, NULL, 1, NULL, NULL, NULL),
(306, 'Celia Elvia', 'Paredes', NULL, NULL, 1, NULL, NULL, NULL),
(307, 'Verónica', 'Pelinski', NULL, NULL, 1, NULL, NULL, NULL),
(308, 'Romina Eliana', 'Pereyra', NULL, NULL, 1, NULL, NULL, NULL),
(309, 'María Inés', 'Rivas', NULL, NULL, 1, NULL, NULL, NULL),
(310, 'Iris Marlene', 'Servian', NULL, NULL, 1, NULL, NULL, NULL),
(311, 'Ivana Soledad ', 'Slabcow', NULL, NULL, 1, NULL, NULL, NULL),
(312, 'Carla Nilda Judith', 'Suarez', NULL, NULL, 1, NULL, NULL, NULL),
(313, 'Leo', 'Svancara', NULL, NULL, 1, NULL, NULL, NULL),
(314, 'Noelia Elizabeth', 'Vera', NULL, NULL, 1, NULL, NULL, NULL),
(315, 'Ainara Analia', 'Aguilar', NULL, NULL, 1, NULL, NULL, NULL),
(316, 'Natalia Vanesa', 'Anker Nielsen', NULL, NULL, 1, NULL, NULL, NULL),
(317, 'Luis Cecilio', 'Arias', NULL, NULL, 1, NULL, NULL, NULL),
(318, 'Romina Elizabet', 'Brito', NULL, NULL, 1, NULL, NULL, NULL),
(319, 'Gabriela Leticia', 'Carena', NULL, NULL, 1, NULL, NULL, NULL),
(320, 'Victor Ariel', 'Castellano', NULL, NULL, 1, NULL, NULL, NULL),
(321, 'Diego Fabian', 'Centurion', NULL, NULL, 1, NULL, NULL, NULL),
(322, 'Romina Andrea', 'Cuenca', NULL, NULL, 1, NULL, NULL, NULL),
(323, 'Norberto Andres', 'Da rosa', NULL, NULL, 1, NULL, NULL, NULL),
(324, 'Jesica Itatia', 'Diaz', NULL, NULL, 1, NULL, NULL, NULL),
(325, 'Jara Denis W. S.', 'Dos Santos', NULL, NULL, 1, NULL, NULL, NULL),
(326, 'Erika Yohana', 'Duarte', NULL, NULL, 1, NULL, NULL, NULL),
(327, 'Mariana Maricel', 'Duarte', NULL, NULL, 1, NULL, NULL, NULL),
(328, 'Marianela Soledad', 'Enrrico', NULL, NULL, 1, NULL, NULL, NULL),
(329, 'Sara Rebeka', 'Figueroa', NULL, NULL, 1, NULL, NULL, NULL),
(330, 'Victor Hugo', 'Gallardo', NULL, NULL, 1, NULL, NULL, NULL),
(331, 'Karen Ayelen', 'Garcia', NULL, NULL, 1, NULL, NULL, NULL),
(332, 'Ramona Elisa', 'Gauto', NULL, NULL, 1, NULL, NULL, NULL),
(333, 'Patricia Graciela', 'Gonzalez', NULL, NULL, 1, NULL, NULL, NULL),
(334, 'Ruth Selene', 'Gonzalez', NULL, NULL, 1, NULL, NULL, NULL),
(335, 'Jorge German ', 'Hipólito', NULL, NULL, 1, NULL, NULL, NULL),
(336, 'Rita Ayelen ', 'Lopez', NULL, NULL, 1, NULL, NULL, NULL),
(337, 'Rafaela', 'Miranda', NULL, NULL, 1, NULL, NULL, NULL),
(338, 'Yanina Elizabet', 'Morel', NULL, NULL, 1, NULL, NULL, NULL),
(339, 'Claribel Haydee', 'Oviedo', NULL, NULL, 1, NULL, NULL, NULL),
(340, 'Silvia Vanesa', 'Pelinski', NULL, NULL, 1, NULL, NULL, NULL),
(341, 'Angela Ariana ', 'Pucheta', NULL, NULL, 1, NULL, NULL, NULL),
(342, 'Luciano', 'Quintana', NULL, NULL, 1, NULL, NULL, NULL),
(343, 'Mauricio Nahuel', 'Amarilla', NULL, NULL, 1, NULL, NULL, NULL),
(344, 'Marina Daniela Soledad', 'Arias', NULL, NULL, 1, NULL, NULL, NULL),
(345, 'Gabriela Viviana', 'Balbuena', NULL, NULL, 1, NULL, NULL, NULL),
(346, 'Alan Julian', 'Benitez', NULL, NULL, 1, NULL, NULL, NULL),
(347, 'María Itatí', 'Cabral', NULL, NULL, 1, NULL, NULL, NULL),
(348, 'Celeste Florencia', 'Cácerez', NULL, NULL, 1, NULL, NULL, NULL),
(349, 'Julia Carolina Itati', 'Cuello', NULL, NULL, 1, NULL, NULL, NULL),
(350, 'Lucia Veronica ', 'Da Rosa', NULL, NULL, 1, NULL, NULL, NULL),
(351, 'Lisa Pamela', 'Faviero', NULL, NULL, 1, NULL, NULL, NULL),
(352, 'Alejandro Nicasio', 'Gómez Nuñez', NULL, NULL, 1, NULL, NULL, NULL),
(353, 'Yesica Ingrid', 'Kivinski', NULL, NULL, 1, NULL, NULL, NULL),
(354, 'Laura Ines ', 'Lewinstzki', NULL, NULL, 1, NULL, NULL, NULL),
(355, 'María Manuela ', 'López', NULL, NULL, 1, NULL, NULL, NULL),
(356, 'Graciela Elizabet', 'Meza', NULL, NULL, 1, NULL, NULL, NULL),
(357, 'Rosa Carolina ', 'Meza', NULL, NULL, 1, NULL, NULL, NULL),
(358, 'Aldana Agustina', 'Miranda', NULL, NULL, 1, NULL, NULL, NULL),
(359, 'Rita Elizabeth', 'Nuñez', NULL, NULL, 1, NULL, NULL, NULL),
(360, 'Carla Talia Macarena', 'Pietrobelli', NULL, NULL, 1, NULL, NULL, NULL),
(361, 'Cecilia Elizabeth', 'Piñeyro', NULL, NULL, 1, NULL, NULL, NULL),
(362, 'María del Carmen', 'Quintana', NULL, NULL, 1, NULL, NULL, NULL),
(363, 'Tamara Gisel', 'Rivas', NULL, NULL, 1, NULL, NULL, NULL),
(364, 'Camila Leticia', 'Rodriguez', NULL, NULL, 1, NULL, NULL, NULL),
(365, 'Miryam Elizabeth', 'Romero', NULL, NULL, 1, NULL, NULL, NULL),
(366, 'Macarena', 'Salas', NULL, NULL, 1, NULL, NULL, NULL),
(367, 'Natalia Mirna', 'Scheuermann', NULL, NULL, 1, NULL, NULL, NULL),
(368, 'Gisela', 'Camargo', NULL, NULL, 1, NULL, NULL, NULL),
(369, 'Ursula Eliana', 'Gonzalez', NULL, NULL, 1, NULL, NULL, NULL),
(370, 'Martha Evelin ', 'Gonzalez', NULL, NULL, 1, NULL, NULL, NULL),
(371, 'Tamara Vanesa', 'Villalba', NULL, NULL, 1, NULL, NULL, NULL),
(372, 'Paulina', 'Figueredo', NULL, NULL, 1, NULL, NULL, NULL),
(373, 'Alejandra Yanina', 'Aguirre', NULL, NULL, 1, NULL, NULL, NULL),
(374, 'Adriana de los Angeles ', 'Bravo', NULL, NULL, 1, NULL, NULL, NULL),
(375, 'Julieta Itati', 'Carrizo Arce', NULL, NULL, 1, NULL, NULL, NULL),
(376, 'Mariela Mabel ', 'De Jesus', NULL, NULL, 1, NULL, NULL, NULL),
(377, 'Carla Rocio', 'Esquivel', NULL, NULL, 1, NULL, NULL, NULL),
(378, 'Laura Alejandra', 'Godoy', NULL, NULL, 1, NULL, NULL, NULL),
(379, 'Camila Ailen', 'Gomez Gonzalez', NULL, NULL, 1, NULL, NULL, NULL),
(380, 'Nicole Milagros', 'Guiñazu', NULL, NULL, 1, NULL, NULL, NULL),
(381, 'Cecilia Rosana ', 'Jauregul', NULL, NULL, 1, NULL, NULL, NULL),
(382, 'Esther Erika', 'Klevet', NULL, NULL, 1, NULL, NULL, NULL),
(383, 'Yonatan Jose ', 'Mareco', NULL, NULL, 1, NULL, NULL, NULL),
(384, 'Silvia Roxana', 'Mereles', NULL, NULL, 1, NULL, NULL, NULL),
(385, 'Gisel Noemi ', 'Olivera', NULL, NULL, 1, NULL, NULL, NULL),
(386, 'Luzmila Roxana ', 'Oviedo', NULL, NULL, 1, NULL, NULL, NULL),
(387, 'Cesar', 'Podetti', NULL, NULL, 1, NULL, NULL, NULL),
(388, 'Maria Cecilia', 'Ruiz', NULL, NULL, 1, NULL, NULL, NULL),
(389, 'Dominga Lujan', 'Toledo', NULL, NULL, 1, NULL, NULL, NULL),
(390, 'Graciela Elizabeth ', 'Torres', NULL, NULL, 1, NULL, NULL, NULL),
(391, 'Tania Micaela ', 'Vallejos', NULL, NULL, 1, NULL, NULL, NULL),
(392, 'Camila Eliana ', 'Villagra', NULL, NULL, 1, NULL, NULL, NULL),
(393, 'Eugenia Guadalupe ', 'Yeza', NULL, NULL, 1, NULL, NULL, NULL),
(394, 'Julio Martín', 'Antúnez Rodriguez', NULL, NULL, 1, NULL, NULL, NULL),
(395, 'Jose Martin', 'Araujo', NULL, NULL, 1, NULL, NULL, NULL),
(396, 'Elias Nahuel', 'Baez', NULL, NULL, 1, NULL, NULL, NULL),
(397, 'Rodrigo De Jesús', 'Bonifacio', NULL, NULL, 1, NULL, NULL, NULL),
(398, 'Karen  Macarena', 'Camargo', NULL, NULL, 1, NULL, NULL, NULL),
(399, 'Maximiliano Daniel', 'Candia', NULL, NULL, 1, NULL, NULL, NULL),
(400, 'Gregorio Enrique ', 'Carisimo', NULL, NULL, 1, NULL, NULL, NULL),
(401, 'Esteban Edgardo', 'Carlsson', NULL, NULL, 1, NULL, NULL, NULL),
(402, 'Lourdes Paola', 'Carranza Valenzuela', NULL, NULL, 1, NULL, NULL, NULL),
(403, 'Beatriz Ailen', 'Davalo Rey', NULL, NULL, 1, NULL, NULL, NULL),
(404, 'Johana Ayelen', 'Duarte', NULL, NULL, 1, NULL, NULL, NULL),
(405, 'Zamira Salomé', 'Ferreira', NULL, NULL, 1, NULL, NULL, NULL),
(406, 'Hernan Franco ', 'Godoy', NULL, NULL, 1, NULL, NULL, NULL),
(407, 'Valentina Guadalupe', 'Godoy', NULL, NULL, 1, NULL, NULL, NULL),
(408, 'Sebastian Alberto', 'Ibarra', NULL, NULL, 1, NULL, NULL, NULL),
(409, 'Maria Soledad', 'Lima', NULL, NULL, 1, NULL, NULL, NULL),
(410, 'Mariana Itati', 'Lopez', NULL, NULL, 1, NULL, NULL, NULL),
(411, 'Griselda', 'Lovera', NULL, NULL, 1, NULL, NULL, NULL),
(412, 'Raquel', 'Marques  De Araujo', NULL, NULL, 1, NULL, NULL, NULL),
(413, 'Adolfo Nicolás ', 'Mendoza', NULL, NULL, 1, NULL, NULL, NULL),
(414, 'Constanza Gabriela ', 'Millán', NULL, NULL, 1, NULL, NULL, NULL),
(415, 'Leonardo Alejandro', 'Negro Montiel', NULL, NULL, 1, NULL, NULL, NULL),
(416, 'Cintia Daniela ', 'Ocampo', NULL, NULL, 1, NULL, NULL, NULL),
(417, 'Margarita de los Angeles ', 'Ocampo', NULL, NULL, 1, NULL, NULL, NULL),
(418, 'Cristian Robert', 'Pereyra', NULL, NULL, 1, NULL, NULL, NULL),
(419, 'Susana Graciela', 'Prestes', NULL, NULL, 1, NULL, NULL, NULL),
(420, 'Daiana Gisel', 'Rodriguez', NULL, NULL, 1, NULL, NULL, NULL),
(421, 'Sergio Nicolas', 'Rodriguez', NULL, NULL, 1, NULL, NULL, NULL),
(422, 'Yamila Tamara ', 'Rodriguez', NULL, NULL, 1, NULL, NULL, NULL),
(423, 'Kiarema Maribel', 'Saldias Sanz', NULL, NULL, 1, NULL, NULL, NULL),
(424, 'Ariana Micaela', 'Obermeier,', NULL, NULL, 1, NULL, NULL, NULL),
(425, 'Cristian Adrian', 'Vargas,', NULL, NULL, 1, NULL, NULL, NULL),
(426, 'Romina Gisel', 'Silva,', NULL, NULL, 1, NULL, NULL, NULL),
(427, 'Ariel Orlando', 'Antunez', NULL, NULL, 1, NULL, NULL, NULL),
(428, 'Walter Ezequiel', 'Arrua Rios', NULL, NULL, 1, NULL, NULL, NULL),
(429, 'Romina Belen', 'Ayala', NULL, NULL, 1, NULL, NULL, NULL),
(430, 'Braian Gaton', 'Benitez', NULL, NULL, 1, NULL, NULL, NULL),
(431, 'Mercedes Fernanda', 'Benitez', NULL, NULL, 1, NULL, NULL, NULL),
(432, 'Laura Valeria', 'Cristaldo', NULL, NULL, 1, NULL, NULL, NULL),
(433, 'Luciano Emanuel', 'Ferreira', NULL, NULL, 1, NULL, NULL, NULL),
(434, 'Maria Ester', 'Garcia', NULL, NULL, 1, NULL, NULL, NULL),
(435, 'Ornella Magali ', 'Gauna', NULL, NULL, 1, NULL, NULL, NULL),
(436, 'Adriana Graciela', 'Gomez', NULL, NULL, 1, NULL, NULL, NULL),
(437, 'Laura Ludmila ', 'Gonzales', NULL, NULL, 1, NULL, NULL, NULL),
(438, 'Carlos Daniel', 'Leites', NULL, NULL, 1, NULL, NULL, NULL),
(439, 'Maria Leonela', 'Lucas', NULL, NULL, 1, NULL, NULL, NULL),
(440, 'Claudia Andrea ', 'Melgarejo', NULL, NULL, 1, NULL, NULL, NULL),
(441, 'Lusmila Ailen ', 'Melgarejo', NULL, NULL, 1, NULL, NULL, NULL),
(442, 'Matias Rodrigo', 'Puchot', NULL, NULL, 1, NULL, NULL, NULL),
(443, 'Eduardo Daniel ', 'Ramirez', NULL, NULL, 1, NULL, NULL, NULL),
(444, 'Gabriel Omar ', 'Ramirez', NULL, NULL, 1, NULL, NULL, NULL),
(445, 'Leonardo Agustin', 'Rivas', NULL, NULL, 1, NULL, NULL, NULL),
(446, ' Jose Ramon', 'Romero', NULL, NULL, 1, NULL, NULL, NULL),
(447, 'Carlos Saul', 'Sanabria', NULL, NULL, 1, NULL, NULL, NULL),
(448, 'María Celeste', 'Aliendro Malena', NULL, NULL, 1, NULL, NULL, NULL),
(449, 'Jairo Nelson', 'Arevalo', NULL, NULL, 1, NULL, NULL, NULL),
(450, 'Raúl', 'Arriola', NULL, NULL, 1, NULL, NULL, NULL),
(451, 'Lucas Agustín', 'Chiappe Gamarra', NULL, NULL, 1, NULL, NULL, NULL),
(452, 'Andrés Martín', 'Delgado', NULL, NULL, 1, NULL, NULL, NULL),
(453, 'Fabricio Nahuel', 'Escalante', NULL, NULL, 1, NULL, NULL, NULL),
(454, 'Nahuel Ezequiel', 'Goi', NULL, NULL, 1, NULL, NULL, NULL),
(455, 'Sebastian Maximiliano', 'Gonzalez', NULL, NULL, 1, NULL, NULL, NULL),
(456, 'Aldo Ernesto', 'Ibañez del Puerto', NULL, NULL, 1, NULL, NULL, NULL),
(457, 'Marcela Itati', 'Morais', NULL, NULL, 1, NULL, NULL, NULL),
(458, 'Alejandro Maximiliano', 'Ortíz', NULL, NULL, 1, NULL, NULL, NULL),
(459, 'Berenice Aylen ', 'Rodriguez', NULL, NULL, 1, NULL, NULL, NULL),
(460, 'Raul Armando', 'Sosa', NULL, NULL, 1, NULL, NULL, NULL),
(461, 'Rodrigo De Jesus ', 'Urbanski', NULL, NULL, 1, NULL, NULL, NULL),
(462, 'Santiago Adriel', 'Villalba Maza', NULL, NULL, 1, NULL, NULL, NULL),
(463, 'Carlos', 'Da Rosa', NULL, NULL, 1, NULL, NULL, NULL),
(464, 'Daiana', 'Fernandez,', NULL, NULL, 1, NULL, NULL, NULL),
(465, 'Dario Hernan', 'Alegre', NULL, NULL, 1, NULL, NULL, NULL),
(466, 'Sergio Joaquin ', 'Aquino', NULL, NULL, 1, NULL, NULL, NULL),
(467, 'Cesar Miguel', 'Basili Roberto', NULL, NULL, 1, NULL, NULL, NULL),
(468, 'David', 'Gonzalez', NULL, NULL, 1, NULL, NULL, NULL),
(469, 'Liliana Soledad', 'Sendra', NULL, NULL, 1, NULL, NULL, NULL),
(470, 'Lucas Ramon', 'Silva', NULL, NULL, 1, NULL, NULL, NULL),
(471, 'Juan Carlos', 'Sosa', NULL, NULL, 1, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asistencia`
--

DROP TABLE IF EXISTS `asistencia`;
CREATE TABLE IF NOT EXISTS `asistencia` (
  `idasistencia` int NOT NULL AUTO_INCREMENT,
  `presente` varchar(45) DEFAULT NULL,
  `tardanza` varchar(45) DEFAULT NULL,
  `falta_justificada` varchar(45) DEFAULT NULL,
  `ausente` varchar(45) DEFAULT NULL,
  `fecha` date NOT NULL,
  `inscripcion_asignatura_idinscripcion_asignatura` int DEFAULT NULL,
  `inscripcion_asignatura_alumno_idAlumno` int NOT NULL,
  `inscripcion_asignatura_carreras_idCarrera` int NOT NULL,
  PRIMARY KEY (`idasistencia`),
  KEY `fk_asistencia_inscripcion_asignatura1_idx` (`inscripcion_asignatura_idinscripcion_asignatura`,`inscripcion_asignatura_alumno_idAlumno`,`inscripcion_asignatura_carreras_idCarrera`)
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asistencia_profesor`
--

DROP TABLE IF EXISTS `asistencia_profesor`;
CREATE TABLE IF NOT EXISTS `asistencia_profesor` (
  `idasistencia_profesor` int NOT NULL AUTO_INCREMENT,
  `profesor_idProrfesor` int NOT NULL,
  `presente` varchar(45) NOT NULL,
  `ausente` varchar(45) NOT NULL,
  `fecha` date NOT NULL,
  PRIMARY KEY (`idasistencia_profesor`),
  KEY `fk_asistencia_profesor_profesor1_idx` (`profesor_idProrfesor`)
) ENGINE=InnoDB AUTO_INCREMENT=161 DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carreras`
--

DROP TABLE IF EXISTS `carreras`;
CREATE TABLE IF NOT EXISTS `carreras` (
  `idCarrera` int NOT NULL AUTO_INCREMENT,
  `nombre_carrera` varchar(90) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `profesor_idProrfesor` int NOT NULL,
  PRIMARY KEY (`idCarrera`),
  KEY `fk_materia_profesor1_idx` (`profesor_idProrfesor`)
) ENGINE=InnoDB AUTO_INCREMENT=5441520 DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `carreras`
--

INSERT INTO `carreras` (`idCarrera`, `nombre_carrera`, `profesor_idProrfesor`) VALUES
(8, 'Programacion_web', 47),
(14, 'Operador_de_herramientas_de_marketing_y_venta_digital', 24),
(15, 'instalador_y_administrador_de_redes_informaticas', 20),
(18, 'Tecnico_Superior_enfermeria(1er_Año_C-A)Prioridad', 13),
(19, 'Tecnico_Superior_enfermeria(1er_Año_C-B)Prioridad', 12),
(20, 'Tecnico_Superior_enfermeria(1er_Año_C-C)Prioridad', 12),
(27, 'Tecnico_Superior_acompañante_terapeutico(1er_Año_C-A)Prioridad', 26),
(31, 'Tecnico_Superior_acompañante_terapeutico(1er_Año_C-B)Prioridad', 12),
(32, 'Tecnico_Superior_acompañante_terapeutico(1er_Año_C-C)Prioridad', 12),
(33, 'Tecnico_Superior_enfermeria(2do_Año_C-A)Prioridad', 12),
(34, 'Tecnico_Superior_enfermeria(2do_Año_C-B)Prioridad', 12),
(35, 'Tecnico_Superior_enfermeria(2do_Año_C-C)Prioridad', 12),
(36, 'Tecnico_Superior_enfermeria(3er_Año_C-A)Prioridad', 12),
(37, 'Tecnico_Superior_enfermeria(3er_Año_C-B)Prioridad', 12),
(39, 'Tecnico_Superior_enfermeria(3er_Año_C-C)Prioridad', 12),
(40, 'Tecnico_Superior_acompañante_terapeutico(2do_Año_C-A)Prioridad', 12),
(41, 'Tecnico_Superior_acompañante_terapeutico(2do_Año_C-B)Prioridad', 12),
(42, 'Tecnico_Superior_acompañante_terapeutico(2do_Año_C-C)Prioridad', 12),
(43, 'Tecnico_Superior_acompañante_terapeutico(3er_Año_C-A)Prioridad', 12),
(44, 'Tecnico_Superior_acompañante_terapeutico(3er_Año_C-B)Prioridad', 12),
(45, 'Tecnico_Superior_acompañante_terapeutico(3er_Año_C-C)Prioridad', 12),
(46, 'Tecnico_Superior_automatizacion_robotica(1er_Año_C-A)Prioridad', 19),
(47, 'Tecnico_Superior_automatizacion_robotica(1er_Año_C-B)Prioridad', 12),
(48, 'Tecnico_Superior_automatizacion_robotica(1er_Año_C-C)Prioridad', 12),
(49, 'Tecnico_Superior_automatizacion_robotica(2do_Año_C-A)Prioridad', 12),
(50, 'Tecnico_Superior_automatizacion_robotica(2do_Año_C-B)Prioridad', 12),
(51, 'Tecnico_Superior_automatizacion_robotica(2do_Año_C-C)Prioridad', 12),
(52, 'Tecnico_Superior_automatizacion_robotica(3er_Año_C-A)Prioridad', 12),
(53, 'Tecnico_Superior_automatizacion_robotica(3er_Año_C-B)Prioridad', 12),
(54, 'Tecnico_Superior_automatizacion_robotica(3er_Año_C-C)Prioridad', 12),
(55, 'Tecnico_Superior_comercializacion_marketing(1er_Año_C-A)Prioridad', 13),
(56, 'Tecnico_Superior_comercializacion_marketing(1er_Año_C-B)Prioridad', 12),
(57, 'Tecnico_Superior_comercializacion_marketing(1er_Año_C-C)Prioridad', 12),
(58, 'Tecnico_Superior_comercializacion_marketing(2do_Año_C-A)Prioridad', 12),
(59, 'Tecnico_Superior_comercializacion_marketing(2do_Año_C-B)Prioridad', 12),
(60, 'Tecnico_Superior_comercializacion_marketing(2do_Año_C-C)Prioridad', 12),
(61, 'Tecnico_Superior_comercializacion_marketing(3er_Año_C-A)Prioridad', 12),
(62, 'Tecnico_Superior_comercializacion_marketing(3er_Año_C-B)Prioridad', 12),
(63, 'Tecnico_Superior_comercializacion_marketing(3er_Año_C-C)Prioridad', 12),
(94, 'Marketing_venta_digital', 16),
(494, 'Tecnico_Superior_acompañante_terapeutico(1er_Año_C-A)', 27),
(745, 'Tecnico_Superior_acompañante_terapeutico(1er_Año_C-A)', 30),
(848, 'Tecnico_Superior_acompañante_terapeutico(1er_Año_C-A)', 28),
(1514, 'Tecnico_Superior_enfermeria(1er_Año_C-A)', 39),
(1851, 'Tecnico_Superior_automatizacion_robotica(1er_Año_C-A)', 30),
(3525, 'Tecnico_Superior_comercializacion_marketing(1er_Año_C-A)', 39),
(4451, 'Tecnico_Superior_enfermeria(1er_Año_C-A)', 29),
(4694, 'Tecnico_Superior_acompañante_terapeutico(1er_Año_C-A)', 29),
(5151, 'Tecnico_Superior_enfermeria(1er_Año_C-A)', 31),
(5181, 'Tecnico_Superior_enfermeria(1er_Año_C-A)', 34),
(5451, 'Tecnico_Superior_comercializacion_marketing(1er_Año_C-A)', 16),
(6151, 'Tecnico_Superior_acompañante_terapeutico(1er_Año_C-A)', 37),
(8151, 'Tecnico_Superior_enfermeria(1er_Año_C-A)', 33),
(45151, 'Tecnico_Superior_enfermeria(1er_Año_C-A)', 25),
(46496, 'Tecnico_Superior_automatizacion_robotica(1er_Año_C-A)', 37),
(51518, 'Tecnico_Superior_automatizacion_robotica(1er_Año_C-A)', 22),
(61515, 'Tecnico_Superior_enfermeria(1er_Año_C-A)', 37),
(64651, 'Tecnico_Superior_enfermeria(1er_Año_C-A)', 26),
(81841, 'Tecnico_Superior_enfermeria(1er_Año_C-A)', 36),
(82684, 'Tecnico_Superior_automatizacion_robotica(1er_Año_C-A)', 23),
(215151, 'Tecnico_Superior_comercializacion_marketing(1er_Año_C-A)', 42),
(458454, 'Tecnico_Superior_acompañante_terapeutico(1er_Año_C-A)', 31),
(516185, 'Tecnico_Superior_comercializacion_marketing(1er_Año_C-A)', 18),
(541518, 'Tecnico_Superior_automatizacion_robotica(1er_Año_C-A)', 21),
(626151, 'Tecnico_Superior_enfermeria(1er_Año_C-A)', 27),
(665151, 'Tecnico_Superior_automatizacion_robotica(1er_Año_C-A)', 48),
(815122, 'Tecnico_Superior_comercializacion_marketing(1er_Año_C-A)', 21),
(5441519, 'Tecnico_Superior_automatizacion_robotica(1er_Año_C-A)', 38);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dias_no_laborables`
--

DROP TABLE IF EXISTS `dias_no_laborables`;
CREATE TABLE IF NOT EXISTS `dias_no_laborables` (
  `iddias_no_laborables` int NOT NULL AUTO_INCREMENT,
  `fecha` date NOT NULL,
  `motivo` varchar(100) NOT NULL,
  PRIMARY KEY (`iddias_no_laborables`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dias_semana`
--

DROP TABLE IF EXISTS `dias_semana`;
CREATE TABLE IF NOT EXISTS `dias_semana` (
  `idDias_semana` int NOT NULL AUTO_INCREMENT,
  `dias` varchar(45) NOT NULL,
  PRIMARY KEY (`idDias_semana`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `falta_justificada`
--

DROP TABLE IF EXISTS `falta_justificada`;
CREATE TABLE IF NOT EXISTS `falta_justificada` (
  `idfalta_justificada` int NOT NULL AUTO_INCREMENT,
  `fecha_F_J` date NOT NULL,
  `Motivo` varchar(100) NOT NULL,
  `profesor_idProrfesor` int NOT NULL,
  PRIMARY KEY (`idfalta_justificada`),
  KEY `fk_falta_justificada_profesor1_idx` (`profesor_idProrfesor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horarios`
--

DROP TABLE IF EXISTS `horarios`;
CREATE TABLE IF NOT EXISTS `horarios` (
  `idhorarios` int NOT NULL AUTO_INCREMENT,
  `profesor_idProrfesor` int NOT NULL,
  `dias_semana_idDias_semana` int NOT NULL,
  `hs_entrada` varchar(45) NOT NULL,
  `hs_salida` varchar(45) NOT NULL,
  PRIMARY KEY (`idhorarios`),
  KEY `fk_horarios_dias_semana1_idx` (`dias_semana_idDias_semana`),
  KEY `fk_horarios_profesor1_idx` (`profesor_idProrfesor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inasistencia`
--

DROP TABLE IF EXISTS `inasistencia`;
CREATE TABLE IF NOT EXISTS `inasistencia` (
  `idinasistencia` int NOT NULL AUTO_INCREMENT,
  `fecha` date NOT NULL,
  `profesor_idProrfesor` int NOT NULL,
  PRIMARY KEY (`idinasistencia`),
  KEY `fk_inasistencia_profesor1_idx` (`profesor_idProrfesor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inscripcion_asignatura`
--

DROP TABLE IF EXISTS `inscripcion_asignatura`;
CREATE TABLE IF NOT EXISTS `inscripcion_asignatura` (
  `idinscripcion_asignatura` int NOT NULL AUTO_INCREMENT,
  `alumno_idAlumno` int NOT NULL,
  `carreras_idCarrera` int NOT NULL,
  PRIMARY KEY (`idinscripcion_asignatura`,`alumno_idAlumno`,`carreras_idCarrera`),
  KEY `fk_inscripcion_asignatura_alumno1_idx` (`alumno_idAlumno`),
  KEY `fk_inscripcion_asignatura_carreras1_idx` (`carreras_idCarrera`)
) ENGINE=InnoDB AUTO_INCREMENT=225 DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `inscripcion_asignatura`
--

INSERT INTO `inscripcion_asignatura` (`idinscripcion_asignatura`, `alumno_idAlumno`, `carreras_idCarrera`) VALUES
(122, 37, 18),
(123, 38, 18),
(124, 39, 18),
(125, 40, 18),
(126, 41, 18),
(127, 42, 18),
(128, 43, 18),
(129, 44, 18),
(130, 45, 18),
(131, 46, 18),
(132, 47, 18),
(133, 49, 18),
(134, 50, 18),
(135, 51, 18),
(136, 52, 18),
(137, 53, 18),
(138, 54, 18),
(139, 55, 18),
(140, 56, 18),
(141, 57, 18),
(142, 58, 18),
(143, 59, 18),
(144, 60, 18),
(145, 61, 18),
(146, 62, 18),
(147, 63, 18),
(148, 64, 18),
(149, 65, 18),
(150, 66, 18),
(151, 67, 18),
(152, 68, 18),
(153, 69, 18),
(154, 70, 18),
(155, 71, 18),
(156, 72, 18),
(157, 73, 18),
(158, 74, 18),
(159, 75, 18),
(160, 76, 18),
(161, 77, 18),
(162, 78, 18),
(163, 79, 18),
(164, 80, 18),
(165, 81, 18),
(166, 82, 18),
(167, 83, 18),
(168, 84, 18),
(169, 85, 18),
(170, 86, 18),
(171, 87, 18),
(172, 88, 18),
(173, 89, 18),
(174, 90, 18),
(175, 91, 18),
(176, 92, 18),
(177, 93, 18),
(178, 94, 18),
(179, 95, 18),
(180, 96, 18),
(181, 97, 18),
(182, 98, 18),
(183, 99, 18),
(184, 100, 18),
(185, 101, 18),
(186, 102, 18),
(187, 103, 18),
(188, 104, 18),
(189, 105, 18),
(190, 106, 18),
(191, 107, 18),
(192, 108, 18),
(193, 109, 18),
(194, 110, 18),
(195, 111, 18),
(196, 112, 18),
(197, 113, 18),
(198, 114, 18),
(199, 115, 18),
(200, 116, 18),
(201, 117, 18),
(202, 118, 18),
(203, 119, 18),
(204, 120, 18),
(205, 121, 18),
(206, 122, 18),
(207, 123, 18),
(208, 124, 18),
(209, 125, 18),
(210, 126, 18),
(211, 127, 18),
(212, 128, 18),
(213, 129, 18),
(214, 130, 18),
(215, 131, 18),
(216, 132, 18),
(217, 133, 18),
(218, 134, 18),
(219, 135, 18),
(220, 136, 18),
(221, 137, 18),
(222, 138, 18),
(223, 139, 18),
(224, 140, 18);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `licencia`
--

DROP TABLE IF EXISTS `licencia`;
CREATE TABLE IF NOT EXISTS `licencia` (
  `idLicencia` int NOT NULL AUTO_INCREMENT,
  `profesor_idProrfesor` int NOT NULL,
  `Motivo` varchar(65) NOT NULL,
  `Estado` int NOT NULL,
  PRIMARY KEY (`idLicencia`),
  KEY `fk_Licencia_profesor1_idx` (`profesor_idProrfesor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `materias`
--

DROP TABLE IF EXISTS `materias`;
CREATE TABLE IF NOT EXISTS `materias` (
  `idMaterias` int NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(90) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `carreras_idCarrera` int NOT NULL,
  `profesor_idProrfesor` int NOT NULL,
  PRIMARY KEY (`idMaterias`),
  KEY `fk_materias_carreras1_idx` (`carreras_idCarrera`),
  KEY `fk_materias_profesor1_idx` (`profesor_idProrfesor`)
) ENGINE=InnoDB AUTO_INCREMENT=363 DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `materias`
--

INSERT INTO `materias` (`idMaterias`, `Nombre`, `carreras_idCarrera`, `profesor_idProrfesor`) VALUES
(28, 'Lengua Extranjera: Inglés Técnico I', 46, 12),
(29, 'Informática', 46, 12),
(30, 'Inclusión Educativa', 46, 12),
(31, 'Matemática', 46, 12),
(32, 'Electrónica', 46, 12),
(33, 'Sistemas de Representación Gráfica', 46, 12),
(34, 'Física', 46, 12),
(35, 'Práctica Profesionalizante I: Mecánica de la Robótica', 46, 12),
(36, 'Lengua Extranjera: Inglés Técnico I', 47, 12),
(37, 'Informática', 47, 12),
(38, 'Inclusión Educativa', 47, 12),
(39, 'Matemática', 47, 12),
(40, 'Electrónica', 47, 12),
(41, 'Sistemas de Representación Gráfica', 47, 12),
(42, 'Física', 47, 12),
(43, 'Práctica Profesionalizante I: Mecánica de la Robótica', 47, 12),
(44, 'Lengua Extranjera: Inglés Técnico I', 48, 12),
(45, 'Informática', 48, 12),
(46, 'Inclusión Educativa', 48, 12),
(47, 'Matemática', 48, 12),
(48, 'Electrónica', 48, 12),
(49, 'Sistemas de Representación Gráfica', 48, 12),
(50, 'Física', 48, 12),
(51, 'Práctica Profesionalizante I: Mecánica de la Robótica', 48, 12),
(92, '\r\nLengua Extranjera: Inglés Técnico II', 49, 12),
(93, 'Seguridad e Higiene', 49, 12),
(94, 'Programación', 49, 12),
(95, 'Álgebra', 49, 12),
(96, 'Equipos y Aparatos Eléctricos', 49, 12),
(97, 'Microcontroladores', 49, 12),
(98, 'Práctica Profesionalizante II: Control de Motores Eléctricos y Laboratorio de PLC\'S\r\n', 49, 12),
(99, 'Seminario: Laboratorio de Microcontroladores', 49, 12),
(100, '\r\nLengua Extranjera: Inglés Técnico II', 50, 12),
(101, 'Seguridad e Higiene', 50, 12),
(102, 'Programación', 50, 12),
(103, 'Álgebra', 50, 12),
(104, 'Equipos y Aparatos Eléctricos', 50, 12),
(105, 'Microcontroladores', 50, 12),
(106, 'Práctica Profesionalizante II: Control de Motores Eléctricos y Laboratorio de PLC\'S\r\n', 50, 12),
(107, 'Seminario: Laboratorio de Microcontroladores', 50, 12),
(108, '\r\nLengua Extranjera: Inglés Técnico II', 51, 12),
(109, 'Seguridad e Higiene', 51, 12),
(110, 'Programación', 51, 12),
(111, 'Álgebra', 51, 12),
(112, 'Equipos y Aparatos Eléctricos', 51, 12),
(113, 'Microcontroladores', 51, 12),
(114, 'Práctica Profesionalizante II: Control de Motores Eléctricos y Laboratorio de PLC\'S\r\n', 51, 12),
(115, 'Seminario: Laboratorio de Microcontroladores', 51, 12),
(116, 'Legislación y Ejercicio Profesional', 52, 12),
(117, 'Sistemas de Control', 52, 12),
(118, 'Automatismo', 52, 12),
(119, 'Robótica', 52, 12),
(120, 'Seminario: Laboratorio de Simulación', 52, 12),
(121, 'Práctica Profesionalizante III: Proyecto Final y Pasantía', 52, 12),
(122, 'Legislación y Ejercicio Profesional', 53, 12),
(123, 'Sistemas de Control', 53, 12),
(124, 'Automatismo', 53, 12),
(125, 'Robótica', 53, 12),
(126, 'Seminario: Laboratorio de Simulación', 53, 12),
(127, 'Práctica Profesionalizante III: Proyecto Final y Pasantía', 53, 12),
(128, 'Legislación y Ejercicio Profesional', 54, 12),
(129, 'Sistemas de Control', 54, 12),
(130, 'Automatismo', 54, 12),
(131, 'Robótica', 54, 12),
(132, 'Seminario: Laboratorio de Simulación', 54, 12),
(133, 'Práctica Profesionalizante III: Proyecto Final y Pasantía', 54, 12),
(134, 'Metodologías para el Desarrollo de Software', 8, 47),
(135, 'Interfaz Gráfica Web', 8, 47),
(136, 'Programación de Bases de Datos', 8, 47),
(137, 'Programación Web', 8, 47),
(138, 'Proyecto Integrador', 8, 47),
(139, 'EDI I', 18, 12),
(140, 'Comunicación en Salud', 18, 12),
(141, 'Lengua Extranjera: portugués', 18, 12),
(142, 'Anatomía y Fisiología', 18, 12),
(143, 'Salud Pública', 18, 12),
(144, 'Fisicoquímica', 18, 12),
(145, 'Ciencias Psicosociales', 18, 12),
(146, 'Nutrición', 18, 12),
(147, 'Fundamentos de la Enfermería', 18, 12),
(148, 'Práctica Profesionalizante I', 18, 12),
(149, 'Tecnología de la Información y la Comunicación', 18, 12),
(150, 'EDI I', 19, 12),
(151, 'Comunicación en Salud', 19, 12),
(152, 'Lengua Extranjera: portugués', 19, 12),
(153, 'Anatomía y Fisiología', 19, 12),
(154, 'Salud Pública', 19, 12),
(155, 'Fisicoquímica', 19, 12),
(156, 'Ciencias Psicosociales', 19, 12),
(157, 'Nutrición', 19, 12),
(158, 'Fundamentos de la Enfermería', 19, 12),
(159, 'Práctica Profesionalizante I', 19, 12),
(160, 'Tecnología de la Información y la Comunicación', 19, 12),
(161, 'EDI I', 20, 12),
(162, 'Comunicación en Salud', 20, 12),
(163, 'Lengua Extranjera: portugués', 20, 12),
(164, 'Anatomía y Fisiología', 20, 12),
(165, 'Salud Pública', 20, 12),
(166, 'Fisicoquímica', 20, 12),
(167, 'Ciencias Psicosociales', 20, 12),
(168, 'Nutrición', 20, 12),
(169, 'Fundamentos de la Enfermería', 20, 12),
(170, 'Práctica Profesionalizante I', 20, 12),
(171, 'Tecnología de la Información y la Comunicación', 20, 12),
(172, 'Lengua Extranjera: inglés', 33, 12),
(173, '\r\nEDI II', 33, 12),
(174, 'Microbiología y Parasitología', 33, 12),
(175, 'Cuidados de Enfermería a la Familia, al Niño y Adolescente', 33, 12),
(176, 'Cuidados de Enfermería Comunitaria', 33, 12),
(177, 'Farmacología', 33, 12),
(178, 'Práctica Profesionalizante II', 33, 12),
(179, 'Lengua Extranjera: inglés', 34, 12),
(180, '\r\nEDI II', 34, 12),
(181, 'Microbiología y Parasitología', 34, 12),
(182, 'Cuidados de Enfermería a la Familia, al Niño y Adolescente', 34, 12),
(183, 'Cuidados de Enfermería Comunitaria', 34, 12),
(184, 'Farmacología', 34, 12),
(185, 'Práctica Profesionalizante II', 34, 12),
(186, 'Lengua Extranjera: inglés', 35, 12),
(187, '\r\nEDI II', 35, 12),
(188, 'Microbiología y Parasitología', 35, 12),
(189, 'Cuidados de Enfermería a la Familia, al Niño y Adolescente', 35, 12),
(190, 'Cuidados de Enfermería Comunitaria', 35, 12),
(191, 'Farmacología', 35, 12),
(192, 'Práctica Profesionalizante II', 35, 12),
(193, 'Ética y Deontología', 36, 12),
(194, 'EDI III', 36, 12),
(195, 'Principios de la Administración en Enfermería', 36, 12),
(196, 'Metodología de la Investigación', 36, 12),
(197, 'Lengua Extranjera: Inglés Técnico', 36, 12),
(198, 'Cuidados en Enfermería a los Adultos y Ancianos', 36, 12),
(199, 'Cuidados de Enfermería en Salud Mental', 36, 12),
(200, 'Práctica Profesionalizante III', 36, 12),
(201, 'Residencia', 36, 12),
(202, 'Ética y Deontología', 37, 12),
(203, 'EDI III', 37, 12),
(204, 'Principios de la Administración en Enfermería', 37, 12),
(205, 'Metodología de la Investigación', 37, 12),
(206, 'Lengua Extranjera: Inglés Técnico', 37, 12),
(207, 'Cuidados en Enfermería a los Adultos y Ancianos', 37, 12),
(208, 'Cuidados de Enfermería en Salud Mental', 37, 12),
(209, 'Práctica Profesionalizante III', 37, 12),
(210, 'Residencia', 37, 12),
(211, 'Ética y Deontología', 39, 12),
(212, 'EDI III', 39, 12),
(213, 'Principios de la Administración en Enfermería', 39, 12),
(214, 'Metodología de la Investigación', 39, 12),
(215, 'Lengua Extranjera: Inglés Técnico', 39, 12),
(216, 'Cuidados en Enfermería a los Adultos y Ancianos', 39, 12),
(217, 'Cuidados de Enfermería en Salud Mental', 39, 12),
(218, 'Práctica Profesionalizante III', 39, 12),
(219, 'Residencia', 39, 12),
(220, '\r\nEconomía', 55, 12),
(221, '\r\nLengua Extranjera: Portugués', 55, 12),
(222, 'Matemática Financiera', 55, 12),
(223, '\r\nDerecho Comercial', 55, 12),
(224, 'Administración I', 55, 12),
(225, '\r\nContabilidad Básica', 55, 12),
(226, 'Seminario I: Informática Administrativa', 55, 12),
(227, 'Práctica Profesionalizante I: Análisis del Entorno Socioeconómico', 55, 12),
(228, '\r\nEconomía', 56, 12),
(229, '\r\nLengua Extranjera: Portugués', 56, 12),
(230, 'Matemática Financiera', 56, 12),
(231, '\r\nDerecho Comercial', 56, 12),
(232, 'Administración I', 56, 12),
(233, '\r\nContabilidad Básica', 56, 12),
(234, 'Seminario I: Informática Administrativa', 56, 12),
(235, 'Práctica Profesionalizante I: Análisis del Entorno Socioeconómico', 56, 12),
(236, '\r\nEconomía', 57, 12),
(237, '\r\nLengua Extranjera: Portugués', 57, 12),
(238, 'Matemática Financiera', 57, 12),
(239, '\r\nDerecho Comercial', 57, 12),
(240, 'Administración I', 57, 12),
(241, '\r\nContabilidad Básica', 57, 12),
(242, 'Seminario I: Informática Administrativa', 57, 12),
(243, 'Práctica Profesionalizante I: Análisis del Entorno Socioeconómico', 57, 12),
(244, 'Lengua Extranjera: Inglés I', 58, 12),
(245, 'Administración de Recursos Humanos', 58, 12),
(246, 'Estadística', 58, 12),
(247, 'Gestión Publicitaria', 58, 12),
(248, 'Contabilidad Superior', 58, 12),
(249, 'Marketing y Comercialización I', 58, 12),
(250, 'Seminario II: Comercio Electrónico', 58, 12),
(251, 'Práctica Profesionalizante II: Gestión y Administración de Proyectos', 58, 12),
(252, 'Lengua Extranjera: Inglés I', 59, 12),
(253, 'Administración de Recursos Humanos', 59, 12),
(254, 'Estadística', 59, 12),
(255, 'Gestión Publicitaria', 59, 12),
(256, 'Contabilidad Superior', 59, 12),
(257, 'Marketing y Comercialización I', 59, 12),
(258, 'Seminario II: Comercio Electrónico', 59, 12),
(259, 'Práctica Profesionalizante II: Gestión y Administración de Proyectos', 59, 12),
(260, 'Lengua Extranjera: Inglés I', 60, 12),
(261, 'Administración de Recursos Humanos', 60, 12),
(262, 'Estadística', 60, 12),
(263, 'Gestión Publicitaria', 60, 12),
(264, 'Contabilidad Superior', 60, 12),
(265, 'Marketing y Comercialización I', 60, 12),
(266, 'Seminario II: Comercio Electrónico', 60, 12),
(267, 'Práctica Profesionalizante II: Gestión y Administración de Proyectos', 60, 12),
(268, '\r\nLengua Extranjera: Inglés Técnico', 61, 12),
(269, '\r\nPolítica de Productos y Logística', 61, 12),
(270, 'Negociación', 61, 12),
(271, 'Marketing y Comercialización II', 61, 12),
(272, 'Seminario III: Investigación del Mercado', 61, 12),
(273, 'Práctica Profesionalizante III: Pasantia', 61, 12),
(274, '\r\nLengua Extranjera: Inglés Técnico', 62, 12),
(275, '\r\nPolítica de Productos y Logística', 62, 12),
(276, 'Negociación', 62, 12),
(277, 'Marketing y Comercialización II', 62, 12),
(278, 'Seminario III: Investigación del Mercado', 62, 12),
(279, 'Práctica Profesionalizante III: Pasantia', 62, 12),
(280, '\r\nLengua Extranjera: Inglés Técnico', 63, 12),
(281, '\r\nPolítica de Productos y Logística', 63, 12),
(282, 'Negociación', 63, 12),
(283, 'Marketing y Comercialización II', 63, 12),
(284, 'Seminario III: Investigación del Mercado', 63, 12),
(285, 'Práctica Profesionalizante III: Pasantia', 63, 12),
(286, 'Taller de Oralidad', 27, 12),
(287, 'Biología Humana', 27, 12),
(288, 'Introducción a la investigación en salud', 27, 12),
(289, 'Fundamentos de la Psicología general y de la intervención', 27, 12),
(290, '\r\nIntroducción al Campo de la Salud', 27, 12),
(291, 'Practicas Profesionalizantes I', 27, 12),
(292, 'Taller de Oralidad', 31, 12),
(293, 'Biología Humana', 31, 12),
(294, 'Introducción a la investigación en salud', 31, 12),
(295, 'Fundamentos de la Psicología general y de la intervención', 31, 12),
(296, '\r\nIntroducción al Campo de la Salud', 31, 12),
(297, 'Practicas Profesionalizantes I', 31, 12),
(298, 'Taller de Oralidad', 32, 12),
(299, 'Biología Humana', 32, 12),
(300, 'Introducción a la investigación en salud', 32, 12),
(301, 'Fundamentos de la Psicología general y de la intervención', 32, 12),
(302, '\r\nIntroducción al Campo de la Salud', 32, 12),
(303, 'Practicas Profesionalizantes I', 32, 12),
(304, 'Modalidades de Intervención en el Acompañante Terapéutico', 40, 12),
(305, 'Dinámica Grupal', 40, 12),
(306, 'Teoría Psicosocial y Comunitaria', 40, 12),
(307, 'Psicología Evolutiva', 40, 12),
(308, 'Psicopatología', 40, 12),
(309, 'Seminario I: Tecnología de la Información y la Comunicación', 40, 12),
(310, 'Práctica Profesionalizantes II', 40, 12),
(311, 'Seminario II: Sistemas Familiares', 40, 12),
(312, 'Seminario III: Trastornos crónicos y Degenerativos', 40, 12),
(313, 'Modalidades de Intervención en el Acompañante Terapéutico', 41, 12),
(314, 'Dinámica Grupal', 41, 12),
(315, 'Teoría Psicosocial y Comunitaria', 41, 12),
(316, 'Psicología Evolutiva', 41, 12),
(317, 'Psicopatología', 41, 12),
(318, 'Seminario I: Tecnología de la Información y la Comunicación', 41, 12),
(319, 'Práctica Profesionalizantes II', 41, 12),
(320, 'Seminario II: Sistemas Familiares', 41, 12),
(321, 'Seminario III: Trastornos crónicos y Degenerativos', 41, 12),
(322, 'Modalidades de Intervención en el Acompañante Terapéutico', 42, 12),
(323, 'Dinámica Grupal', 42, 12),
(324, 'Teoría Psicosocial y Comunitaria', 42, 12),
(325, 'Psicología Evolutiva', 42, 12),
(326, 'Psicopatología', 42, 12),
(327, 'Seminario I: Tecnología de la Información y la Comunicación', 42, 12),
(328, 'Práctica Profesionalizantes II', 42, 12),
(329, 'Seminario II: Sistemas Familiares', 42, 12),
(330, 'Seminario III: Trastornos crónicos y Degenerativos', 42, 12),
(331, '\r\nÉtica y Deontología Profesional', 43, 12),
(332, '\r\nCorrientes Psicológicas Contemporáneas', 43, 12),
(333, 'Principios Médicos y de Psicofarmacología', 43, 12),
(334, 'Acompañamiento Terapéutico en la Niñez y la Adolescencia', 43, 12),
(335, 'Acompañamiento Terapéutico del Adulto y Adulto Mayor', 43, 12),
(336, 'Práctica Profesionalizantes III', 43, 12),
(337, 'Seminario IV: Integración Escolar', 43, 12),
(338, '\r\nÉtica y Deontología Profesional', 44, 12),
(339, '\r\nCorrientes Psicológicas Contemporáneas', 44, 12),
(340, 'Principios Médicos y de Psicofarmacología', 44, 12),
(341, 'Acompañamiento Terapéutico en la Niñez y la Adolescencia', 44, 12),
(342, 'Acompañamiento Terapéutico del Adulto y Adulto Mayor', 44, 12),
(343, 'Práctica Profesionalizantes III', 44, 12),
(344, 'Seminario IV: Integración Escolar', 44, 12),
(345, '\r\nÉtica y Deontología Profesional', 45, 12),
(346, '\r\nCorrientes Psicológicas Contemporáneas', 45, 12),
(347, 'Principios Médicos y de Psicofarmacología', 45, 12),
(348, 'Acompañamiento Terapéutico en la Niñez y la Adolescencia', 45, 12),
(349, 'Acompañamiento Terapéutico del Adulto y Adulto Mayor', 45, 12),
(350, 'Práctica Profesionalizantes III', 45, 12),
(351, 'Seminario IV: Integración Escolar', 45, 12),
(353, 'Organización del Computador (128hr)', 15, 12),
(354, 'Tecnología de Redes (48hr)', 15, 12),
(355, '\r\nRelaciones Laborales y Orientación Profresional (24hr)', 15, 12),
(356, 'Mantenimiento e Instalación de Redes Informáticas (60hr)', 15, 12),
(357, 'Administración de Redes (100hr)', 15, 12),
(358, 'Herramientas en la Construcción de Estrategias de Marketing de Productos', 14, 12),
(359, 'Analítica Web', 14, 12),
(360, 'Contenidos Digitales', 14, 12),
(361, 'Marketing en Redes Sociales', 14, 12),
(362, 'Publicidad en Medios Digitales', 14, 12);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profesor`
--

DROP TABLE IF EXISTS `profesor`;
CREATE TABLE IF NOT EXISTS `profesor` (
  `idProrfesor` int NOT NULL AUTO_INCREMENT,
  `nombre_profe` varchar(45) NOT NULL,
  `apellido_profe` varchar(45) NOT NULL,
  `dni_profe` int DEFAULT NULL,
  `celular` varchar(20) NOT NULL,
  `email` varchar(90) DEFAULT NULL,
  `usuario` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `pass` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  PRIMARY KEY (`idProrfesor`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `profesor`
--

INSERT INTO `profesor` (`idProrfesor`, `nombre_profe`, `apellido_profe`, `dni_profe`, `celular`, `email`, `usuario`, `pass`) VALUES
(12, 'luciano', 'barros', 44621492, '3764820012', NULL, 'estraimor', '44621492'),
(13, 'Alejandro', 'Arroyo', 35694449, '3751609519', NULL, NULL, NULL),
(14, 'Florencia', 'Kramer', 39046717, '3764720388', NULL, NULL, NULL),
(15, 'Bruno', 'Micheloni', 34448144, '3764869944', NULL, NULL, NULL),
(16, 'Carlos', 'Priora', 26873246, '3764898565', NULL, NULL, NULL),
(17, 'Constanza', 'Logegaray', 31759209, '3764283674', NULL, NULL, NULL),
(18, 'Miriam', 'Dávalos', 32297782, '3764666837', NULL, NULL, NULL),
(19, 'Eleonora', 'Ziessmann', 32664226, '3743455036', NULL, NULL, NULL),
(20, 'Fabio', 'Mendez', 29596110, '3765117466', NULL, NULL, NULL),
(21, 'Florencia', 'Manzur', 36268903, '3764632494', NULL, NULL, NULL),
(22, 'Henry', 'Kotinski', 23189198, '3764394881', NULL, NULL, NULL),
(23, 'Juan Pablo', 'Kostlin', 92425130, '3764236333', NULL, NULL, NULL),
(24, 'Jimena', 'Acuña', 34895714, '3764865943', NULL, NULL, NULL),
(25, 'Angélica', 'Gularte', 30785038, '3764811380', NULL, NULL, NULL),
(26, 'Fabián', 'Paredes', 33425235, '3765038209', NULL, NULL, NULL),
(27, 'Griselda', 'Acuña', 29596110, '3764615010', NULL, NULL, NULL),
(28, 'Karen', 'Baukloh', 33074636, '3764547334', NULL, NULL, NULL),
(29, 'Mariela', 'Bustamante', 27999786, '3764732642', NULL, NULL, NULL),
(30, 'Santiago', 'Benedetto', 32178713, '3764214231', NULL, NULL, NULL),
(31, 'Silvana', 'Enciso', 39228890, '3764725369', NULL, NULL, NULL),
(32, 'Susana', 'Fretes', 26286277, '3764313514', NULL, NULL, NULL),
(33, 'Alejandra', 'Tiscornea', 28163146, '3764607181', NULL, NULL, NULL),
(34, 'Gabriela', 'Reyna', 29010066, '3764618620', NULL, NULL, NULL),
(35, 'Manuel', 'Salas', 33900308, '3764794055', NULL, NULL, NULL),
(36, 'Marianne Sol', 'Hummen', 39946806, '3758401676', NULL, NULL, NULL),
(37, 'Marina', 'Welchen', 36062526, '3765250572', NULL, NULL, NULL),
(38, 'Veronica', 'Neis', 41231164, '3743505218', NULL, NULL, NULL),
(39, 'Pamela', 'Rehbein', 37083505, '3764827833', NULL, NULL, NULL),
(40, 'Marina', 'Pulutranka', 26610153, '3764831632', NULL, NULL, NULL),
(41, 'Daiana', 'Martin', 41616406, '3764180162', NULL, NULL, NULL),
(42, 'Patricia', 'Monzón', 31133280, '3764204471', NULL, NULL, NULL),
(43, 'Silvina', 'Benitez', 33527555, '3751448625', NULL, NULL, NULL),
(44, 'Jorge', 'Torales', 29225162, '3751563538', NULL, NULL, NULL),
(45, 'Roberto', 'Mendoza', 36403771, '3743565210', NULL, NULL, NULL),
(46, 'Anibal', 'Arroyos', 24854401, '3743527081', NULL, NULL, NULL),
(47, 'Nestor Emanuel', 'Ruiz', 45452735, '3764510577', NULL, NULL, NULL),
(48, 'Pablo', 'Edelman', 30002479, '3764115834', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vacaciones`
--

DROP TABLE IF EXISTS `vacaciones`;
CREATE TABLE IF NOT EXISTS `vacaciones` (
  `idvacaciones` int NOT NULL,
  `fecha_ini` date NOT NULL,
  `fecha_fin` date NOT NULL,
  PRIMARY KEY (`idvacaciones`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `asistencia`
--
ALTER TABLE `asistencia`
  ADD CONSTRAINT `fk_asistencia_inscripcion_asignatura1` FOREIGN KEY (`inscripcion_asignatura_idinscripcion_asignatura`,`inscripcion_asignatura_alumno_idAlumno`,`inscripcion_asignatura_carreras_idCarrera`) REFERENCES `inscripcion_asignatura` (`idinscripcion_asignatura`, `alumno_idAlumno`, `carreras_idCarrera`);

--
-- Filtros para la tabla `asistencia_profesor`
--
ALTER TABLE `asistencia_profesor`
  ADD CONSTRAINT `fk_asistencia_profesor_profesor1` FOREIGN KEY (`profesor_idProrfesor`) REFERENCES `profesor` (`idProrfesor`);

--
-- Filtros para la tabla `carreras`
--
ALTER TABLE `carreras`
  ADD CONSTRAINT `fk_materia_profesor1` FOREIGN KEY (`profesor_idProrfesor`) REFERENCES `profesor` (`idProrfesor`);

--
-- Filtros para la tabla `falta_justificada`
--
ALTER TABLE `falta_justificada`
  ADD CONSTRAINT `fk_falta_justificada_profesor1` FOREIGN KEY (`profesor_idProrfesor`) REFERENCES `profesor` (`idProrfesor`);

--
-- Filtros para la tabla `horarios`
--
ALTER TABLE `horarios`
  ADD CONSTRAINT `fk_horarios_dias_semana1` FOREIGN KEY (`dias_semana_idDias_semana`) REFERENCES `dias_semana` (`idDias_semana`),
  ADD CONSTRAINT `fk_horarios_profesor1` FOREIGN KEY (`profesor_idProrfesor`) REFERENCES `profesor` (`idProrfesor`);

--
-- Filtros para la tabla `inasistencia`
--
ALTER TABLE `inasistencia`
  ADD CONSTRAINT `fk_inasistencia_profesor1` FOREIGN KEY (`profesor_idProrfesor`) REFERENCES `profesor` (`idProrfesor`);

--
-- Filtros para la tabla `inscripcion_asignatura`
--
ALTER TABLE `inscripcion_asignatura`
  ADD CONSTRAINT `fk_inscripcion_asignatura_alumno1` FOREIGN KEY (`alumno_idAlumno`) REFERENCES `alumno` (`idAlumno`),
  ADD CONSTRAINT `fk_inscripcion_asignatura_carreras1` FOREIGN KEY (`carreras_idCarrera`) REFERENCES `carreras` (`idCarrera`);

--
-- Filtros para la tabla `licencia`
--
ALTER TABLE `licencia`
  ADD CONSTRAINT `fk_Licencia_profesor1` FOREIGN KEY (`profesor_idProrfesor`) REFERENCES `profesor` (`idProrfesor`);

--
-- Filtros para la tabla `materias`
--
ALTER TABLE `materias`
  ADD CONSTRAINT `fk_materias_carreras1` FOREIGN KEY (`carreras_idCarrera`) REFERENCES `carreras` (`idCarrera`),
  ADD CONSTRAINT `fk_materias_profesor1` FOREIGN KEY (`profesor_idProrfesor`) REFERENCES `profesor` (`idProrfesor`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
