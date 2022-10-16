/* Por defecto se crea el establecimiento 001 */
INSERT INTO `ml_establecimiento` VALUES ( NULL, '001', 'LOJA', '2577813', NULL, 1, company_id );

INSERT INTO `ml_storehouse` VALUES ( NULL, 'ALMACEN 1', 'ALMACEN 1', 1, 1, 0.00000, 0, company_id, NULL, NULL );

INSERT INTO `ml_department` VALUES ( NULL, 'DEPARTAMENTO A', '..', 'DEPARTAMENTO 1', 1, 1, '2015-01-01', company_id );

INSERT INTO `ml_product_category` VALUES ( NULL, 'SIN CLASIFICAR', 'GRUPO GLOBAL', 1, 0, 1, 0, company_id );

INSERT INTO `ml_marca` VALUES ( NULL, 'SIN MARCA', 'SIN MARCA', company_id );

INSERT INTO `ml_employment` VALUES (NULL, 'SIN ESPECIFICAR', 'SIN ESPECIFICACION', 1, '2015-01-01', 1, company_id);

INSERT INTO `ml_commission_type` VALUES (NULL, 'Vendedor', 1, NULL, company_id);

INSERT INTO `ml_bank_account` VALUES (NULL, 'AMERICAN EXPRESS', NULL, NULL, NULL, 0, NULL, 3, '01', NULL, company_id);
INSERT INTO `ml_bank_account` VALUES (NULL, 'DINERS CLUB', NULL, NULL, NULL, 0, NULL, 3, '02', NULL, company_id);
INSERT INTO `ml_bank_account` VALUES (NULL, 'MASTERCARD', NULL, NULL, NULL, 0, NULL, 3, '04', NULL, company_id);
INSERT INTO `ml_bank_account` VALUES (NULL, 'VISA', NULL, NULL, NULL, 0, NULL, 3, '05', NULL, company_id);
INSERT INTO `ml_bank_account` VALUES (NULL, 'OTRA TARJETA', NULL, NULL, NULL, 0, NULL, 3, '07', NULL, company_id);
INSERT INTO `ml_bank_account` VALUES (NULL, 'BANCO AMAZONAS', NULL, NULL, NULL, 0, NULL, 4, NULL, NULL, company_id);
INSERT INTO `ml_bank_account` VALUES (NULL, 'BANCO MACHALA', NULL, NULL, NULL, 0, NULL, 4, NULL, NULL, company_id);
INSERT INTO `ml_bank_account` VALUES (NULL, 'BANCO SOLIDARIO', NULL, NULL, NULL, 0, NULL, 4, NULL, NULL, company_id);
INSERT INTO `ml_bank_account` VALUES (NULL, 'PRODUBANCO', NULL, NULL, NULL, 0, NULL, 4, NULL, NULL, company_id);
INSERT INTO `ml_bank_account` VALUES (NULL, 'BANCO PICHINCHA', NULL, NULL, NULL, 0, NULL, 4, NULL, NULL, company_id);
INSERT INTO `ml_bank_account` VALUES (NULL, 'BANCO DE GUAYAQUIL', NULL, NULL, NULL, 0, NULL, 4, NULL, NULL, company_id);
INSERT INTO `ml_bank_account` VALUES (NULL, 'BANCO DE LOJA', NULL, NULL, NULL, 0, NULL, 4, NULL, NULL, company_id);
INSERT INTO `ml_bank_account` VALUES (NULL, 'BANCO BOLIBARIANO', NULL, NULL, NULL, 0, NULL, 4, NULL, NULL, company_id);
INSERT INTO `ml_bank_account` VALUES (NULL, 'BANCO DEL AUSTRO', NULL, NULL, NULL, 0, NULL, 4, NULL, NULL, company_id);
INSERT INTO `ml_bank_account` VALUES (NULL, 'BANCO INTERNACIONAL', NULL, NULL, NULL, 0, NULL, 4, NULL, NULL, company_id);
INSERT INTO `ml_bank_account` VALUES (NULL, 'CAJAS', NULL, NULL, NULL, 0, NULL, 5, NULL, NULL, company_id);

INSERT INTO `ml_accounting_period` VALUES (NULL, 'Ejercicio 2015', '2015-01-01', '2015-12-31', '2015', '2015-01-01', 1, 1, '2015', company_id);

INSERT INTO `ml_product_attr` VALUES (NULL, 'SERIAL DEL PRODUCTO', company_id);

INSERT INTO `ml_company_config` VALUES (NULL, company_id, 2, 'TICKET');
INSERT INTO `ml_company_config` VALUES (NULL, company_id, 1, '9999999999');
INSERT INTO `ml_company_config` VALUES (NULL, company_id, 3, '0');
INSERT INTO `ml_company_config` VALUES (NULL, company_id, 4, '12px');
INSERT INTO `ml_company_config` VALUES (NULL, company_id, 5, '0');
INSERT INTO `ml_company_config` VALUES (NULL, company_id, 6, '0');
INSERT INTO `ml_company_config` VALUES (NULL, company_id, 7, '3');
INSERT INTO `ml_company_config` VALUES (NULL, company_id, 8, '559');
INSERT INTO `ml_company_config` VALUES (NULL, company_id, 9, '786');

INSERT INTO `ml_client_category` VALUES (NULL, 'USUARIO FINAL', 'USUARIO FINAL', 0, 0, company_id);

INSERT INTO `ml_company_template` VALUES (NULL, 1, company_id, '0x42415345532044454C20434F4E545241544F');
INSERT INTO `ml_company_template` VALUES (NULL, 2, company_id, '0x42415345532044454C20434F4E545241544F');
INSERT INTO `ml_company_template` VALUES (NULL, 3, company_id, '0x42415345532044454C20434F4E545241544F');
INSERT INTO `ml_company_template` VALUES (NULL, 4, company_id, '0x42415345532044454C20434F4E545241544F');
INSERT INTO `ml_company_template` VALUES (NULL, 5, company_id, '0x42415345532044454C20434F4E545241544F');

INSERT INTO `ml_salepoint` VALUES (NULL, '001', '001', '02', '12341234', '2016-01-01', '2016-12-31', 0, 0, 0, NULL, 0, company_id);
