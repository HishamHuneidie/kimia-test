-- --------------------------------------------------------
-- Host:                         localhost
-- Versión del servidor:         10.4.11-MariaDB - mariadb.org binary distribution
-- SO del servidor:              Win64
-- HeidiSQL Versión:             11.1.0.6116
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Volcando estructura de base de datos para kimia_test_db
CREATE DATABASE IF NOT EXISTS `kimia_test_db` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `kimia_test_db`;

-- Volcando estructura para tabla kimia_test_db.doctrine_migration_versions
CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Volcando datos para la tabla kimia_test_db.doctrine_migration_versions: ~1 rows (aproximadamente)
/*!40000 ALTER TABLE `doctrine_migration_versions` DISABLE KEYS */;
REPLACE INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
	('DoctrineMigrations\\Version20210428201107', '2021-04-28 22:11:21', 2168);
/*!40000 ALTER TABLE `doctrine_migration_versions` ENABLE KEYS */;

-- Volcando estructura para tabla kimia_test_db.player
CREATE TABLE IF NOT EXISTS `player` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `team_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `position` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_98197A65296CD8AE` (`team_id`),
  CONSTRAINT `FK_98197A65296CD8AE` FOREIGN KEY (`team_id`) REFERENCES `team` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla kimia_test_db.player: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `player` DISABLE KEYS */;
REPLACE INTO `player` (`id`, `team_id`, `name`, `position`) VALUES
	(13, 3, 'Thibaut Courtois', 'forward'),
	(14, 3, 'Andriy Lunin', 'forward'),
	(15, 3, 'Raphael Varane', 'defending'),
	(16, 3, 'Ferland Mendy', 'midfield'),
	(17, 3, 'Marcelo	Marcelo', 'midfield'),
	(18, 3, 'Casemiro', 'midfield'),
	(19, 3, 'Federico Valverde', 'midfield'),
	(20, 1, 'Marc-Andre ter Stegen', 'forward'),
	(21, 1, 'Neto', 'forward'),
	(23, 1, 'Ronald Araujo', 'defending'),
	(24, 1, 'Clement Lenglet', 'defending'),
	(25, 1, 'Gerard Pique', 'defending'),
	(26, 1, 'Samuel Umtiti', 'defending'),
	(27, 1, 'Oscar Mingueza', 'defending'),
	(28, 1, 'Jordi Alba', 'defending');
/*!40000 ALTER TABLE `player` ENABLE KEYS */;

-- Volcando estructura para tabla kimia_test_db.team
CREATE TABLE IF NOT EXISTS `team` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hex_color` varchar(7) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla kimia_test_db.team: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `team` DISABLE KEYS */;
REPLACE INTO `team` (`id`, `name`, `hex_color`) VALUES
	(1, 'Barcelona', '#ff0000'),
	(3, 'Madrid', '#0000ff');
/*!40000 ALTER TABLE `team` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
