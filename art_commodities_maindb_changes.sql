-- Adminer 4.6.1 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `tbl_role_submodule`;
CREATE TABLE `tbl_role_submodule` (
  `role_id` int(11) NOT NULL,
  `submodule_id` int(11) NOT NULL,
  KEY `role_id` (`role_id`),
  KEY `submodule_id` (`submodule_id`),
  CONSTRAINT `tbl_role_submodule_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `tbl_role` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tbl_role_submodule_ibfk_3` FOREIGN KEY (`submodule_id`) REFERENCES `tbl_submodule` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `tbl_role_submodule` (`role_id`, `submodule_id`) VALUES
(1,	1),
(2,	2),
(3,	2),
(3,	3),
(2,	2),
(2,	4),
(1,	6),
(1,	7),
(1,	8),
(1,	9),
(1,	10),
(1,	11),
(1,	12),
(1,	13),
(1,	14),
(1,	15),
(1,	16),
(1,	17),
(1,	18),
(1,	20),
(1,	21),
(1,	22),
(1,	23),
(1,	24),
(1,	25),
(1,	26),
(1,	27),
(1,	28);

DROP TABLE IF EXISTS `tbl_submodule`;
CREATE TABLE `tbl_submodule` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `module_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `module_id` (`module_id`),
  CONSTRAINT `tbl_submodule_ibfk_1` FOREIGN KEY (`module_id`) REFERENCES `tbl_submodule` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `tbl_submodule` (`id`, `name`, `module_id`) VALUES
(1,	'county',	1),
(2,	'reports',	2),
(3,	'assign',	2),
(4,	'reporting rates',	2),
(5,	'allocation',	2),
(6,	'subcounty',	1),
(7,	'line',	1),
(8,	'drug',	1),
(9,	'facility',	1),
(10,	'category',	1),
(11,	'partner',	1),
(12,	'generic',	1),
(13,	'regimen',	1),
(14,	'service',	1),
(15,	'purpose',	1),
(16,	'status',	1),
(17,	'dose',	1),
(18,	'change_reason',	1),
(20,	'formulation',	1),
(21,	'install',	1),
(22,	'backup',	1),
(23,	'user',	1),
(24,	'dhis_elements',	1),
(25,	'role',	1),
(26,	'module',	1),
(27,	'submodule',	1),
(28,	'role_submodule',	1);

-- 2018-06-18 10:27:21
