# ************************************************************
# Sequel Pro SQL dump
# Versión 4499
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: localhost (MySQL 5.5.42)
# Base de datos: foro
# Tiempo de Generación: 2015-12-04 09:21:50 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Volcado de tabla mensaje
# ------------------------------------------------------------

DROP TABLE IF EXISTS `mensaje`;

CREATE TABLE `mensaje` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `usuarioID` int(11) NOT NULL,
  `temaID` int(11) NOT NULL,
  `opinion` text COLLATE utf8_spanish_ci NOT NULL,
  `fechahora` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`),
  KEY `mensaje_ibfk_1` (`usuarioID`),
  KEY `mensaje_ibfk_2` (`temaID`),
  CONSTRAINT `mensaje_ibfk_2` FOREIGN KEY (`temaID`) REFERENCES `tema` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `mensaje_ibfk_1` FOREIGN KEY (`usuarioID`) REFERENCES `usuario` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

LOCK TABLES `mensaje` WRITE;
/*!40000 ALTER TABLE `mensaje` DISABLE KEYS */;

INSERT INTO `mensaje` (`ID`, `usuarioID`, `temaID`, `opinion`, `fechahora`)
VALUES
	(3,2,3,'Cambiando este mensaje.\r\nUn saludo.','2015-12-03 18:07:04');

/*!40000 ALTER TABLE `mensaje` ENABLE KEYS */;
UNLOCK TABLES;


# Volcado de tabla tema
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tema`;

CREATE TABLE `tema` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `usuarioID` int(11) NOT NULL,
  `titulo` text COLLATE utf8_spanish_ci NOT NULL,
  `fechahora` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`),
  KEY `tema_ibfk_1` (`usuarioID`),
  CONSTRAINT `tema_ibfk_1` FOREIGN KEY (`usuarioID`) REFERENCES `usuario` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

LOCK TABLES `tema` WRITE;
/*!40000 ALTER TABLE `tema` DISABLE KEYS */;

INSERT INTO `tema` (`ID`, `usuarioID`, `titulo`, `fechahora`)
VALUES
	(2,2,'Nuevo hola','2015-12-03 17:38:14'),
	(3,2,'Probando','2015-12-03 16:22:42');

/*!40000 ALTER TABLE `tema` ENABLE KEYS */;
UNLOCK TABLES;


# Volcado de tabla usuario
# ------------------------------------------------------------

DROP TABLE IF EXISTS `usuario`;

CREATE TABLE `usuario` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(15) COLLATE utf8_spanish_ci NOT NULL,
  `pass` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `tipo` varchar(15) COLLATE utf8_spanish_ci NOT NULL,
  `mail` varchar(120) COLLATE utf8_spanish_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `usuario` (`usuario`),
  UNIQUE KEY `mail` (`mail`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;

INSERT INTO `usuario` (`ID`, `usuario`, `pass`, `tipo`, `mail`)
VALUES
	(1,'Admin','$2y$10$iKeh9JTnowomnTvXvMW5ouH6Rtf7WhyvyN4oi1Sps1uLlVG/qFlKe','administrador','admin@miforo.com'),
	(2,'usertest','$2y$10$STRC6naCKRxO3cL1ovdU5eGqGPlT/23y1tV4T57rN5C8.aujFcdS6','usuario','testuser@user.us'),
	(11,'Myugen','$2y$10$TgqmlNDcEyx/Jcz2BciHie1.GJ7n8SetNiT0SgPUisCbw/NoFEeSK','usuario','miguelcabsan@gmail.com'),
	(12,'pepe','$2y$10$JVt3ZK1umYjO3Fg0Jk/vzeHuDbbZeiX4uV42TmapZ.D30yopyq2v.','usuario','pepe_elmonstro@fufufufu.com'),
	(14,'hashtest','$2y$10$FKdwoh8kYEAZTwDp6P2eAejyWOhaLbTcgzToliQh93PLatjjaDjYq','usuario','hashtest@hash.ha');

/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
