INSERT INTO `setup` VALUES (1, 'SYSTEM_NAME', 'iKobra', NULL);
INSERT INTO `setup` VALUES (2, 'PASSWORDSALTMAIN', 'A3!1VGDDAifLJSRWI0p?gH:y', NULL);

INSERT INTO `company_status` VALUES (1, 'ACTIVA', NULL);
INSERT INTO `company_status` VALUES (2, 'DESACTIVADA', NULL);

INSERT INTO `reference_type` VALUES (1, 'GARANTE', NULL);
INSERT INTO `reference_type` VALUES (2, 'REFERENCIA PERSONAL', NULL);
INSERT INTO `reference_type` VALUES (3, 'DEUDOR', NULL);

INSERT INTO `role` VALUES (1, 'Oficial de Credito', NULL);
INSERT INTO `role` VALUES (2, 'Jefe de Agencia', NULL);
INSERT INTO `role` VALUES (3, 'Gerente General', NULL);
INSERT INTO `role` VALUES (100, 'Root', 'Super Usuario');

INSERT INTO `month` VALUES (1, 'ENERO');
INSERT INTO `month` VALUES (2, 'FEBRERO');
INSERT INTO `month` VALUES (3, 'MARZO');
INSERT INTO `month` VALUES (4, 'ABRIL');
INSERT INTO `month` VALUES (5, 'MAYO');
INSERT INTO `month` VALUES (6, 'JUNIO');
INSERT INTO `month` VALUES (7, 'JULIO');
INSERT INTO `month` VALUES (8, 'AGOSTO');
INSERT INTO `month` VALUES (9, 'SEPTIEMBRE');
INSERT INTO `month` VALUES (10, 'OCTUBRE');
INSERT INTO `month` VALUES (11, 'NOVIEMBRE');
INSERT INTO `month` VALUES (12, 'DICIEMBRE');

INSERT INTO `contact_type` VALUES (1, 'TELEFONO CASA');
INSERT INTO `contact_type` VALUES (2, 'CELULAR');
INSERT INTO `contact_type` VALUES (3, 'EMAIL');

INSERT INTO `comunication_type` VALUES (1, 'LLAMADA', 'com_call');
INSERT INTO `comunication_type` VALUES (2, 'MENSAJE', 'com_sms');
INSERT INTO `comunication_type` VALUES (3, 'WHATSAPP', 'com_whatsapp');
INSERT INTO `comunication_type` VALUES (4, 'EMAIL', 'com_email');
INSERT INTO `comunication_type` VALUES (5, 'VISITA', 'visita');

/* INSERT INTO `user` VALUES (1, 'gerencia@guayacansoft.com', '399d1d9883f1ad90f04d42c95c406e7d', NULL, 1, LAST_INSERT_ID();*/
INSERT INTO `oficial_credito` VALUES (NULL, '9999999999999', 'root', 'user', 'instalacion@gestcobra.com', '2577813', NULL, '399d1d9883f1ad90f04d42c95c406e7d', 1, NULL, 100,1,null);