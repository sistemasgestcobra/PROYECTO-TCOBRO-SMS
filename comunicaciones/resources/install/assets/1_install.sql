/*
Navicat MySQL Data Transfer

Source Server         : tcobro
Source Server Version : 50550
Source Host           : guayacansoft.com:3306
Source Database       : tcobro_db1

Target Server Type    : MYSQL
Target Server Version : 50550
File Encoding         : 65001

Date: 2016-07-17 22:32:33
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for abono
-- ----------------------------
DROP TABLE IF EXISTS `abono`;
CREATE TABLE `abono` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `credit_detail_id` int(11) NOT NULL,
  `amount` double NOT NULL,
  `date_abono` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_abono_credit_detail1_idx` (`credit_detail_id`),
  CONSTRAINT `fk_abono_credit_detail1` FOREIGN KEY (`credit_detail_id`) REFERENCES `credit_detail` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=96 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Table structure for client_referencias
-- ----------------------------
DROP TABLE IF EXISTS `client_referencias`;
CREATE TABLE `client_referencias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_code` varchar(45) COLLATE utf8_bin DEFAULT NULL,
  `person_id` int(11) NOT NULL,
  `reference_type_id` int(11) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `credit_detail_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_client_referencias_person1_idx` (`person_id`),
  KEY `fk_client_referencias_reference_type1_idx` (`reference_type_id`),
  KEY `fk_client_referencias_credit_detail1_idx` (`credit_detail_id`),
  CONSTRAINT `fk_client_referencias_credit_detail1` FOREIGN KEY (`credit_detail_id`) REFERENCES `credit_detail` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_client_referencias_person1` FOREIGN KEY (`person_id`) REFERENCES `person` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_client_referencias_reference_type1` FOREIGN KEY (`reference_type_id`) REFERENCES `reference_type` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3472 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Table structure for company
-- ----------------------------
DROP TABLE IF EXISTS `company`;
CREATE TABLE `company` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_comercial` varchar(100) COLLATE utf8_bin NOT NULL,
  `direccion` varchar(256) COLLATE utf8_bin DEFAULT NULL,
  `email` varchar(45) COLLATE utf8_bin DEFAULT NULL,
  `telefono` varchar(45) COLLATE utf8_bin DEFAULT NULL,
  `logo` varchar(45) COLLATE utf8_bin DEFAULT NULL,
  `company_status_id` int(11) NOT NULL DEFAULT '1',
  `curr_date` date NOT NULL,
  `ruc` varchar(13) COLLATE utf8_bin DEFAULT NULL,
  `razon_social` varchar(128) COLLATE utf8_bin DEFAULT NULL,
  `representante_legal` varchar(125) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_company_company_status1_idx` (`company_status_id`),
  CONSTRAINT `fk_company_company_status1` FOREIGN KEY (`company_status_id`) REFERENCES `company_status` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Table structure for company_status
-- ----------------------------
DROP TABLE IF EXISTS `company_status`;
CREATE TABLE `company_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_status` varchar(45) COLLATE utf8_bin NOT NULL,
  `status_description` varchar(45) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Table structure for comunication
-- ----------------------------
DROP TABLE IF EXISTS `comunication`;
CREATE TABLE `comunication` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(45) COLLATE utf8_bin NOT NULL COMMENT 'Identifica si es sms, email, whatsapp, llamada',
  `status` int(1) NOT NULL,
  `cost` double DEFAULT NULL COMMENT 'El email o numero de telefono al q se aplico la comunicacion',
  `contact` varchar(45) COLLATE utf8_bin NOT NULL,
  `curr_date` date NOT NULL,
  `curr_time` time NOT NULL,
  `user_id` int(11) NOT NULL,
  `network` varchar(50) COLLATE utf8_bin DEFAULT 'null',
  `comunication_type_id` int(11) NOT NULL,
  `client_referencias_id` int(11) NOT NULL,
  `notification_format_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_comunication_oficial_credito1_idx` (`user_id`),
  KEY `fk_comunication_comunication_type1_idx` (`comunication_type_id`),
  KEY `fk_comunication_client_referencias1_idx` (`client_referencias_id`),
  KEY `fk_comunication_notification_format1_idx` (`notification_format_id`),
  CONSTRAINT `fk_comunication_client_referencias1` FOREIGN KEY (`client_referencias_id`) REFERENCES `client_referencias` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_comunication_comunication_type1` FOREIGN KEY (`comunication_type_id`) REFERENCES `comunication_type` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_comunication_notification_format1` FOREIGN KEY (`notification_format_id`) REFERENCES `notification_format` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_comunication_oficial_credito1` FOREIGN KEY (`user_id`) REFERENCES `oficial_credito` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2322 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Table structure for comunication_type
-- ----------------------------
DROP TABLE IF EXISTS `comunication_type`;
CREATE TABLE `comunication_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `comunication_name` varchar(45) COLLATE utf8_bin DEFAULT NULL,
  `comunication_code` varchar(45) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Table structure for contact
-- ----------------------------
DROP TABLE IF EXISTS `contact`;
CREATE TABLE `contact` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `contact_value` varchar(100) COLLATE utf8_bin NOT NULL,
  `description` varchar(45) COLLATE utf8_bin DEFAULT NULL,
  `person_id` int(11) NOT NULL,
  `contact_type_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_phone_contact_person1_idx` (`person_id`),
  KEY `fk_contact_contact_type1_idx` (`contact_type_id`),
  CONSTRAINT `fk_contact_contact_type1` FOREIGN KEY (`contact_type_id`) REFERENCES `contact_type` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_phone_contact_person1` FOREIGN KEY (`person_id`) REFERENCES `person` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=5431 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Table structure for contact_type
-- ----------------------------
DROP TABLE IF EXISTS `contact_type`;
CREATE TABLE `contact_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `contact_name` varchar(45) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Table structure for credit_detail
-- ----------------------------
DROP TABLE IF EXISTS `credit_detail`;
CREATE TABLE `credit_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nro_cuotas` int(11) NOT NULL,
  `nro_pagare` varchar(45) COLLATE utf8_bin NOT NULL COMMENT 'puede ser numero de pagare o numero de factura, por eso es mejor dejarle como varchar',
  `deuda_inicial` double NOT NULL,
  `saldo_actual` double NOT NULL,
  `adjudicacion_date` date NOT NULL,
  `credito_type_id` int(11) NOT NULL,
  `curr_date` date NOT NULL COMMENT 'Esta fecha se va modificando con cada actualizacion',
  `cuotas_pagadas` varchar(45) COLLATE utf8_bin DEFAULT NULL,
  `cuotas_mora` varchar(45) COLLATE utf8_bin DEFAULT NULL,
  `dias_mora` int(11) DEFAULT NULL,
  `total_cuotas_vencidas` double NOT NULL,
  `company_id` int(11) NOT NULL,
  `credit_status_id` int(11) DEFAULT NULL,
  `plazo_original` varchar(45) COLLATE utf8_bin DEFAULT NULL,
  `last_pay_date` date DEFAULT NULL,
  `updated_month_id` int(11) DEFAULT NULL,
  `updated_year` varchar(4) COLLATE utf8_bin DEFAULT NULL,
  `oficial_credito_id` int(11) NOT NULL COMMENT 'El oficial de credito ademas de relacionarse al cliente, tambien va relacionado directamente al detalle del credito ya que puede darse el caso de que se le cambie el oficial al cliente por alguna razon',
  `load_date` date NOT NULL COMMENT 'Fecha en que se crea el registro',
  `oficina_company_id` int(11) NOT NULL COMMENT 'Debido a que puede darse el caso de que el oficial se cambie de agencia, entonces se registra en el credito tambien directamente el id de la oficina',
  PRIMARY KEY (`id`),
  KEY `fk_credit_detail_credito_type1_idx` (`credito_type_id`),
  KEY `fk_credit_detail_company1_idx` (`company_id`),
  KEY `fk_credit_detail_credit_status1_idx` (`credit_status_id`),
  KEY `fk_credit_detail_month1_idx` (`updated_month_id`),
  KEY `fk_credit_detail_oficial_credito1_idx` (`oficial_credito_id`),
  KEY `fk_credit_detail_oficina_company1_idx` (`oficina_company_id`),
  CONSTRAINT `fk_credit_detail_company1` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_credit_detail_credito_type1` FOREIGN KEY (`credito_type_id`) REFERENCES `credito_type` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_credit_detail_credit_status1` FOREIGN KEY (`credit_status_id`) REFERENCES `credit_status` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_credit_detail_month1` FOREIGN KEY (`updated_month_id`) REFERENCES `month` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_credit_detail_oficial_credito1` FOREIGN KEY (`oficial_credito_id`) REFERENCES `oficial_credito` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_credit_detail_oficina_company1` FOREIGN KEY (`oficina_company_id`) REFERENCES `oficina_company` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=5801 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Table structure for credit_hist
-- ----------------------------
DROP TABLE IF EXISTS `credit_hist`;
CREATE TABLE `credit_hist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `credit_detail_id` int(11) NOT NULL,
  `hist_date` date NOT NULL,
  `hist_time` time NOT NULL,
  `detail` varchar(500) COLLATE utf8_bin DEFAULT NULL,
  `credit_status_id` int(11) NOT NULL,
  `compromiso_pago_date` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_credit_hist_credit_detail1_idx` (`credit_detail_id`),
  KEY `fk_credit_hist_credit_status1_idx` (`credit_status_id`),
  CONSTRAINT `fk_credit_hist_credit_detail1` FOREIGN KEY (`credit_detail_id`) REFERENCES `credit_detail` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_credit_hist_credit_status1` FOREIGN KEY (`credit_status_id`) REFERENCES `credit_status` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1464 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Table structure for credit_status
-- ----------------------------
DROP TABLE IF EXISTS `credit_status`;
CREATE TABLE `credit_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status_name` varchar(25) COLLATE utf8_bin NOT NULL,
  `color` varchar(7) COLLATE utf8_bin NOT NULL DEFAULT '#000000',
  `background` varchar(7) COLLATE utf8_bin DEFAULT '#ffffff',
  `company_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_credit_status_company1_idx` (`company_id`),
  CONSTRAINT `fk_credit_status_company1` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Table structure for credito_type
-- ----------------------------
DROP TABLE IF EXISTS `credito_type`;
CREATE TABLE `credito_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) COLLATE utf8_bin NOT NULL,
  `company_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_credito_type_company1_idx` (`company_id`),
  CONSTRAINT `fk_credito_type_company1` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Table structure for month
-- ----------------------------
DROP TABLE IF EXISTS `month`;
CREATE TABLE `month` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `month_name` varchar(25) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Table structure for notification_format
-- ----------------------------
DROP TABLE IF EXISTS `notification_format`;
CREATE TABLE `notification_format` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `format` blob,
  `description` varchar(45) COLLATE utf8_bin DEFAULT NULL,
  `type` varchar(20) COLLATE utf8_bin DEFAULT NULL COMMENT 'NOTIFICATION = textos grandes\nMESSAGE = msj texto corto',
  `company_id` int(11) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `fk_notification_format_company1_idx` (`company_id`),
  CONSTRAINT `fk_notification_format_company1` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Table structure for oficial_credito
-- ----------------------------
DROP TABLE IF EXISTS `oficial_credito`;
CREATE TABLE `oficial_credito` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cedula` varchar(13) COLLATE utf8_bin DEFAULT NULL,
  `firstname` varchar(45) COLLATE utf8_bin NOT NULL,
  `lastname` varchar(45) COLLATE utf8_bin DEFAULT NULL,
  `email` varchar(45) COLLATE utf8_bin DEFAULT NULL,
  `telefono` varchar(45) COLLATE utf8_bin DEFAULT NULL,
  `oficina_company_id` int(11) DEFAULT NULL,
  `password` varchar(45) COLLATE utf8_bin DEFAULT NULL,
  `root` int(1) NOT NULL DEFAULT '0',
  `company_id` int(11) DEFAULT NULL,
  `role_id` int(11) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `profile_image` varchar(45) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_oficial_credito_oficina_company1_idx` (`oficina_company_id`),
  KEY `fk_oficial_credito_company1_idx` (`company_id`),
  KEY `fk_oficial_credito_role1_idx` (`role_id`),
  CONSTRAINT `fk_oficial_credito_company1` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_oficial_credito_oficina_company1` FOREIGN KEY (`oficina_company_id`) REFERENCES `oficina_company` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_oficial_credito_role1` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=687 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Table structure for oficina_company
-- ----------------------------
DROP TABLE IF EXISTS `oficina_company`;
CREATE TABLE `oficina_company` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) COLLATE utf8_bin NOT NULL,
  `direccion` varchar(256) COLLATE utf8_bin DEFAULT NULL,
  `company_id` int(11) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `fk_oficina_company_company1_idx` (`company_id`),
  CONSTRAINT `fk_oficina_company_company1` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=387 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Table structure for person
-- ----------------------------
DROP TABLE IF EXISTS `person`;
CREATE TABLE `person` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(45) COLLATE utf8_bin DEFAULT NULL,
  `firstname` varchar(45) COLLATE utf8_bin NOT NULL,
  `lastname` varchar(45) COLLATE utf8_bin DEFAULT NULL,
  `personal_address` varchar(256) COLLATE utf8_bin DEFAULT NULL,
  `work_address` varchar(256) COLLATE utf8_bin DEFAULT NULL,
  `address_ref` varchar(128) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6424 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Table structure for reference_type
-- ----------------------------
DROP TABLE IF EXISTS `reference_type`;
CREATE TABLE `reference_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `reference_name` varchar(45) COLLATE utf8_bin NOT NULL,
  `reference_desc` varchar(45) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Table structure for role
-- ----------------------------
DROP TABLE IF EXISTS `role`;
CREATE TABLE `role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(25) COLLATE utf8_bin DEFAULT NULL,
  `role_desc` varchar(45) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Table structure for sessions
-- ----------------------------
DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions` (
  `session_id` varchar(40) COLLATE utf8_bin NOT NULL,
  `ip_address` varchar(45) COLLATE utf8_bin NOT NULL,
  `user_agent` varchar(120) COLLATE utf8_bin NOT NULL,
  `last_activity` int(10) NOT NULL,
  `user_data` text COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Table structure for setup
-- ----------------------------
DROP TABLE IF EXISTS `setup`;
CREATE TABLE `setup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `variable` varchar(45) COLLATE utf8_bin DEFAULT NULL,
  `valor` varchar(45) COLLATE utf8_bin DEFAULT NULL,
  `detail` varchar(45) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
