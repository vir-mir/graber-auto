
SET FOREIGN_KEY_CHECKS=0;

DROP DATABASE IF EXISTS `graber_auto`;

CREATE DATABASE `graber_auto`
    CHARACTER SET 'utf8'
    COLLATE 'utf8_general_ci';

USE `graber_auto`;

#
# Structure for the `code_details` table : 
#

DROP TABLE IF EXISTS `code_details`;

CREATE TABLE `code_details` (
  `code` varchar(50) NOT NULL,
  PRIMARY KEY (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Structure for the `data_exist` table : 
#

DROP TABLE IF EXISTS `data_exist`;

CREATE TABLE `data_exist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(50) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `descr` text,
  `count` int(11) DEFAULT NULL,
  `price` decimal(18,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Structure for the `proxy` table : 
#

DROP TABLE IF EXISTS `proxy`;

CREATE TABLE `proxy` (
  `proxy` varchar(255) NOT NULL,
  `is_cur_day` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`proxy`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Data for the `code_details` table  (LIMIT 0,500)
#

INSERT INTO `code_details` (`code`) VALUES 
  ('0101-046'),
  ('0120-335'),
  ('0125-710'),
  ('0125-ACA25LL'),
  ('0125-ACA25LR'),
  ('0125-ACA25UP'),
  ('0125-ACU15LR'),
  ('0182-ZZE150MF'),
  ('0220-333'),
  ('0220-J31'),
  ('0282-C11XFRM'),
  ('0282-J10F'),
  ('0282-R51F'),
  ('0282-R51R'),
  ('0282-S50F'),
  ('0410-KB4A47'),
  ('0420-CU'),
  ('0420-CY'),
  ('0422-CW8'),
  ('0424-CSRH'),
  ('0482-V75R'),
  ('0525-MZ6'),
  ('0582-CX7R'),
  ('0782-GVJBMF'),
  ('1101-AVT200R'),
  ('159-671'),
  ('17-0119'),
  ('17702D'),
  ('1882-ZAFF'),
  ('2101-CAX'),
  ('2182-FOCMF'),
  ('29-0067'),
  ('2DUF053N'),
  ('30983'),
  ('32-0308'),
  ('32072'),
  ('3DACF041D-3DR'),
  ('44-0013'),
  ('46-0009'),
  ('57-71085-SX'),
  ('713 6787 90'),
  ('805631'),
  ('841628'),
  ('952 755 L'),
  ('961521'),
  ('961560'),
  ('962522'),
  ('972617'),
  ('981199'),
  ('981706'),
  ('991750'),
  ('ABJ0111'),
  ('ADN186113'),
  ('BZAB-015'),
  ('CH0401R'),
  ('CH0902R'),
  ('CHAB-006Z'),
  ('CHAB-AVT200R'),
  ('DAC40740042'),
  ('DAC4074W-3CS80'),
  ('DAC42800045M-KIT'),
  ('DAC4280W-9CS40'),
  ('DAC43800040M'),
  ('DAC47880055-KIT'),
  ('FDAB-CAX'),
  ('G6-1205'),
  ('HA 810 105'),
  ('HAB-120'),
  ('HO0501R'),
  ('J4942011'),
  ('J4942511'),
  ('J4952011'),
  ('MT-KB4A47'),
  ('MZAB-065'),
  ('MZAB-066'),
  ('MZAB-MZ3B'),
  ('MZM-3RH'),
  ('NAB-015'),
  ('NAB-134'),
  ('NAB-J10B'),
  ('NI-BJ-4926'),
  ('NI-BJ-4954'),
  ('NI0221RP'),
  ('NOS-001'),
  ('NOS-P12'),
  ('R141.75'),
  ('R152.62'),
  ('R153.53'),
  ('R168.73'),
  ('R169.68'),
  ('R173.27'),
  ('R177.32'),
  ('RE0301R'),
  ('RNAB-M2'),
  ('SB-3842'),
  ('SB-4942'),
  ('SB-7872'),
  ('SBN-282'),
  ('SZ0112R'),
  ('SZAB-030'),
  ('T24C04WB'),
  ('T24ZE121T'),
  ('TAB-024'),
  ('TAB-045'),
  ('TAB-046'),
  ('TC1989'),
  ('TO0134R'),
  ('TO0135R'),
  ('TO0136R'),
  ('VKBA 3651'),
  ('VKBA 6831'),
  ('VKBA 6871'),
  ('VKBA 6996 '),
  ('VW6001R'),
  ('VWAB-003'),
  ('VWCB-TOUAR');
COMMIT;

