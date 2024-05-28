
/***********************************
 GNOG DB ACCESS
 user: it_gnog
 pwd: GN0g&tM@rco2o22

secondary: it_gnog_reader
pwd: GN0gR&@d&r

123456: e10adc3949ba59abbe56e057f20f883e
***********************************/

CREATE DATABASE IF NOT EXISTS gnogcrm_db;

USE gnogcrm_db;

#SETTINGS
CREATE TABLE IF NOT EXISTS settings (
id VARCHAR(40) PRIMARY KEY NOT NULL,
setting_key VARCHAR(50) NOT NULL,
setting_value VARCHAR(200) NOT NULL,
setting_description TEXT,
is_active ENUM('N','Y') NOT NULL,
created_at DATETIME NOT NULL,
updated_at DATETIME NOT NULL
);

#INSERTING DEFAULT SETTINGS
INSERT INTO settings (id,setting_key, setting_value, setting_description, is_active, created_at, updated_at) 
VALUES 
(UUID(),'spreedsheet_file_location','./public/sheets/','Location where the spreedsheets are','Y',now(),now()),
(UUID(),'billboards_file_name','carteleras.xlsx','Spreedsheet contains all billboard locations, providers,values and codes','Y',now(),now());



# CURRENCIES
CREATE TABLE IF NOT EXISTS currencies (
id VARCHAR(3) PRIMARY KEY NOT NULL,
rate FLOAT NOT NULL,
orderby TINYINT,
is_active ENUM('N','Y') NOT NULL,
created_at DATETIME NOT NULL,
updated_at DATETIME NOT NULL
);

# OFFICES
CREATE TABLE IF NOT EXISTS offices (
id VARCHAR(40) PRIMARY KEY NOT NULL,
name VARCHAR(60) NOT NULL,
orderby TINYINT, 
is_active ENUM('N','Y') NOT NULL,
created_at DATETIME NOT NULL,
updated_at DATETIME NOT NULL
);

ALTER TABLE offices
ADD COLUMN orderby TINYINT AFTER name;

ALTER TABLE offices
ADD COLUMN icon_flag VARCHAR(30) AFTER orderby;


# INSERTING OFFICES
INSERT INTO 
offices 
(id, name, icon_flag, orderby, is_active,created_at,updated_at) 
VALUES 
(UUID(),'Mexico','flag_MEX.png',0,'Y',NOW(),NOW()),
(UUID(),'USA','flag_USA.png',1,'Y',NOW(),NOW()),
(UUID(),'Brasil','flag_BRA.png',2,'Y',NOW(),NOW());


INSERT INTO 
offices 
(id, name, icon_flag, orderby, is_active,created_at,updated_at) 
VALUES 
(UUID(),'Guatemala','flag_HON.png',3,'Y',NOW(),NOW());




# USERS
CREATE TABLE IF NOT EXISTS users (
id VARCHAR(40) PRIMARY KEY NOT NULL,
username VARCHAR(20) NOT NULL UNIQUE,
user_language VARCHAR(5) NOT NULL,
email VARCHAR(60) NOT NULL UNIQUE,
level_account INT NOT NULL,
user_type VARCHAR(20) NOT NULL,
mobile_international_code VARCHAR(3),
mobile_prefix VARCHAR(3),
mobile_number VARCHAR(12),
authentication_string VARCHAR(32) NOT NULL,
password_last_changed DATETIME,
token VARCHAR(250),
account_locked ENUM('N','Y') NOT NULL,
created_at DATETIME NOT NULL,
updated_at DATETIME NOT NULL
);

ALTER TABLE users
ADD COLUMN office_id VARCHAR(40) AFTER user_type;

# ADDING FK office
ALTER TABLE `users`
    ADD CONSTRAINT `fk_useroffice` 
	FOREIGN KEY (`office_id`)
    REFERENCES `offices` (`id`);


# INSERTING USER
INSERT INTO users (id, username, email,mobile_international_code, mobile_prefix,mobile_number,authentication_string,password_last_changed,account_locked,created_at,updated_at) VALUES (UUID(),'marcodelaet','it@gnog.com.br','55','11','11989348999','e10adc3949ba59abbe56e057f20f883e',NOW(),'N',NOW(),NOW());


# GOAL
CREATE TABLE IF NOT EXISTS `goals` (
id VARCHAR(40) PRIMARY KEY NOT NULL,
user_id VARCHAR(40) NOT NULL,
goal_month VARCHAR(2) NOT NULL,
goal_year VARCHAR(4) NOT NULL,
currency_id VARCHAR(3) NOT NULL,
goal_amount BIGINT NOT NULL,
created_at DATETIME NOT NULL,
updated_at DATETIME NOT NULL
);

# PROFILES
CREATE TABLE IF NOT EXISTS `profiles` (
id VARCHAR(40) PRIMARY KEY NOT NULL,
user_id VARCHAR(40),
photo VARCHAR(200),
country VARCHAR(3),
aboutme TEXT,
created_at DATETIME NOT NULL,
updated_at DATETIME NOT NULL
);

# TOKENS
CREATE TABLE IF NOT EXISTS `tokens` (
id VARCHAR(40) PRIMARY KEY NOT NULL,
user_id VARCHAR(40),
token VARCHAR(250),
expires TIMESTAMP NOT NULL,
module_name VARCHAR(20),
created_at DATETIME NOT NULL,
updated_at DATETIME NOT NULL
);

# drop table advertisers;

# ADVERTISERS
CREATE TABLE IF NOT EXISTS advertisers (
id VARCHAR(40) PRIMARY KEY NOT NULL,
corporate_name VARCHAR(40) NOT NULL UNIQUE,
address	TEXT NOT NULL,
making_banners ENUM('N','Y') NOT NULL,
is_agency ENUM('N','Y') NOT NULL,
is_active ENUM('N','Y') NOT NULL,
created_at DATETIME NOT NULL,
updated_at DATETIME NOT NULL
);

ALTER TABLE advertisers
ADD COLUMN making_banners ENUM('N','Y') NOT NULL AFTER address;

ALTER TABLE advertisers
ADD executive_id VARCHAR(40) NULL AFTER `id`; 

# ADDING FK executive_id
ALTER TABLE advertisers
    ADD CONSTRAINT FKexecutiveID 
	FOREIGN KEY (executive_id)
    REFERENCES users(id);


# CONTACTS
CREATE TABLE IF NOT EXISTS contacts (
id VARCHAR(40) PRIMARY KEY NOT NULL,
module_name VARCHAR(40) NOT NULL, # advertiser / provider
contact_name VARCHAR(20) NOT NULL,
contact_surname VARCHAR(20),
contact_email VARCHAR(60) NOT NULL UNIQUE,
contact_position VARCHAR(20),
contact_client_id VARCHAR(40),
phone_international_code VARCHAR(3),
phone_prefix VARCHAR(3),
phone_number VARCHAR(12),
is_active ENUM('N','Y') NOT NULL,
created_at DATETIME NOT NULL,
updated_at DATETIME NOT NULL
);

# PRODUCTS
CREATE TABLE IF NOT EXISTS products (
id VARCHAR(40) PRIMARY KEY NOT NULL,
code INT AUTO_INCREMENT UNIQUE KEY NOT NULL,
name VARCHAR(40) NOT NULL,
description TEXT,
is_digital ENUM('N','Y') NOT NULL,
is_active ENUM('N','Y') NOT NULL,
created_at DATETIME NOT NULL,
updated_at DATETIME NOT NULL
);

# INSERTING DATAS IN PRODUCTS TABLE
INSERT INTO products (id,NAME,DESCRIPTION,is_digital,is_active,created_at,updated_at) 
VALUES 
((UUID()),'Banner','Banner','Y','Y',NOW(),NOW()),
((UUID()),'Banner IAB','Banner IAB','Y','Y',NOW(),NOW()),
((UUID()),'Retargeting','Retargeting','Y','Y',NOW(),NOW()),
((UUID()),'Native Ads','Native Ads','Y','Y',NOW(),NOW()),
((UUID()),'Push Notification','Push Notification','Y','Y',NOW(),NOW()),
((UUID()),'Pre Installation App Telcel Android','Pre Installation App Telcel Android','Y','Y',NOW(),NOW()),
((UUID()),'App Opening Telcel Android','App Opening Telcel Android','Y','Y',NOW(),NOW()),
((UUID()),'Native Video','Native Video','Y','Y',NOW(),NOW()),
((UUID()),'Video','Video','Y','Y',NOW(),NOW()),
((UUID()),'Interactive Video','Interactive Video','Y','Y',NOW(),NOW()),
((UUID()),'Rich Media','Rich Media','Y','Y',NOW(),NOW()),
((UUID()),'SMS Telcel and Movistar','SMS Telcel and Movistar','Y','Y',NOW(),NOW()),
((UUID()),'Whatsapp Notification','Whatsapp Notification','Y','Y',NOW(),NOW()),
((UUID()),'Sponsored data Telcel','Sponsored data Telcel','Y','Y',NOW(),NOW()),
((UUID()),'Sponsored data Movistar','Sponsored data Movistar','Y','Y',NOW(),NOW()),
((UUID()),'Audio Ads','Audio Ads','Y','Y',NOW(),NOW()),
((UUID()),'Audio+ SMS','Audio+ SMS','Y','Y',NOW(),NOW()),
((UUID()),'Voice Blaster','Voice Blaster','Y','Y',NOW(),NOW()),
((UUID()),'HTML5 Mobile','HTML5 Mobile','Y','Y',NOW(),NOW()),
((UUID()),'Video Rewards','Video Rewards','Y','Y',NOW(),NOW()),
((UUID()),'E-mail Marketing','E-mail Marketing','Y','Y',NOW(),NOW()),
((UUID()),'FB Messenger Notification','FB Messenger Notification','Y','Y',NOW(),NOW()),
((UUID()),'Time Air','Time Air','Y','Y',NOW(),NOW()),
((UUID()),'Periodical','Periodical','N','Y',NOW(),NOW()),
((UUID()),'Magazines','Magazines','N','Y',NOW(),NOW()),
((UUID()),'Radio','Radio','N','Y',NOW(),NOW()),
((UUID()),'TV','TV','N','Y',NOW(),NOW()),
((UUID()),'GYM','GYM','N','Y',NOW(),NOW()),
((UUID()),'CENTROS COMERCIALES','CENTROS COMERCIALES','N','Y',NOW(),NOW()),
((UUID()),'OOH','OOH','N','Y',NOW(),NOW()),
((UUID()),'Programmatic','Programmatic','Y','Y',NOW(),NOW()),
((UUID()),'CINE','CINE','N','Y',NOW(),NOW());


#STATUSES
CREATE TABLE IF NOT EXISTS statuses (
id TINYINT PRIMARY KEY NOT NULL AUTO_INCREMENT,
NAME VARCHAR(40) NOT NULL,
percent TINYINT NOT NULL,
DESCRIPTION TEXT,
is_active ENUM('N','Y') NOT NULL,
created_at DATETIME NOT NULL,
updated_at DATETIME NOT NULL
);

# INSERTING DATAS IN STATUSES TABLE
INSERT INTO statuses (NAME,percent,DESCRIPTION,is_active,created_at,updated_at) 
VALUES 
('Lost',0,'Lost','Y',NOW(),NOW()),
('Sent',25,'Sent','Y',NOW(),NOW()),
('In negociation',50,'In negociation','Y',NOW(),NOW()),
('Advanced Negociation',75,'Advanced Negociation','Y',NOW(),NOW()),
('Verbal approval',90,'Verbal approval','Y',NOW(),NOW()),
('Approved',100,'Approved','Y',NOW(),NOW());


#SALE MODELS
CREATE TABLE IF NOT EXISTS salemodels (
id VARCHAR(40) PRIMARY KEY NOT NULL,
product_ids_rel VARCHAR(20),
NAME VARCHAR(40) NOT NULL,
DESCRIPTION TEXT,
is_digital ENUM('N','Y') NOT NULL,
is_active ENUM('N','Y') NOT NULL,
created_at DATETIME NOT NULL,
updated_at DATETIME NOT NULL
);


INSERT INTO proposalsxproducts (id, `proposal_id`,`product_id`,`salemodel_id`,`provider_id`,`state`,`price_int`,`currency`,`quantity`,`is_active`,`created_at`,`updated_at`) VALUES (UUID(), '896693aa-cffd-11ed-8d8c-008cfa5abdac','6d0ee56b-0177-11ee-983e-008cfa5abdac','a479be22-0177-11ee-983e-008cfa5abdac','cfeba179-a349-11ed-9584-008cfa5abdac','All',65000,'MXN',1,'Y',now(),now()) ;

# INSERTING DATAS IN SALEMODELS TABLE
INSERT INTO salemodels (id,NAME,DESCRIPTION,is_digital,is_active,created_at,updated_at) 
VALUES 
((UUID()),'Newsletter','Newsletter','Y','Y',NOW(),NOW()),
((UUID()),'CPM','CPM','Y','Y',NOW(),NOW()),
((UUID()),'CPC','CPC','Y','Y',NOW(),NOW()),
((UUID()),'CPA/CPS','CPA/CPS','Y','Y',NOW(),NOW()),
((UUID()),'CPL','CPL','Y','Y',NOW(),NOW()),
((UUID()),'Instalation','Instalation','Y','Y',NOW(),NOW()),
((UUID()),'Opening','Opening','Y','Y',NOW(),NOW()),
((UUID()),'Message','Message','Y','Y',NOW(),NOW()),
((UUID()),'CPV','CPV','Y','Y',NOW(),NOW()),
((UUID()),'SMS','SMS','Y','Y',NOW(),NOW()),
((UUID()),'MB','MB','Y','Y',NOW(),NOW()),
((UUID()),'Notification','Notification','Y','Y',NOW(),NOW()),
((UUID()),'CPE','CPE','Y','Y',NOW(),NOW()),
((UUID()),'CPE + SMS','CPE + SMS','Y','Y',NOW(),NOW()),
((UUID()),'Simple page','Simple page','N','Y',NOW(),NOW()),
((UUID()),'Double page','Double page','N','Y',NOW(),NOW()),
((UUID()),'Front page','Front page','N','Y',NOW(),NOW()),
((UUID()),'Back cover','Back cover','N','Y',NOW(),NOW()),
((UUID()),'20 seconds Spot','20 seconds Spot','N','Y',NOW(),NOW()),
((UUID()),'30 seconds Spot','30 seconds Spot','N','Y',NOW(),NOW()),
((UUID()),'Comercial','Comercial','N','Y',NOW(),NOW()),
((UUID()),'Billboard','Billboard','N','Y',NOW(),NOW()),
((UUID()),'Mupie','Mupie','N','Y',NOW(),NOW()),
((UUID()),'Digital Screen','Digital Screen','N','Y',NOW(),NOW()),
((UUID()),'Cartelera','Cartelera','N','Y',NOW(),NOW()),
((UUID()),'Vallas Moviles','Vallas Moviles','N','Y',NOW(),NOW()),
((UUID()),'Vallas Fijas','Vallas Fijas','N','Y',NOW(),NOW()),
((UUID()),'Activacion en Calle','Activacion en Calle','N','Y',NOW(),NOW()),
((UUID()),'Kiosko','Kiosko','N','Y',NOW(),NOW()),
((UUID()),'Cartelera Digital','Cartelera Digital','N','Y',NOW(),NOW()),
((UUID()),'Publiandantes','Publiandantes','N','Y',NOW(),NOW()),
((UUID()),'Publicidad en bar','Publicidad en bar','N','Y',NOW(),NOW()),
((UUID()),'Bajo Puentes','Bajo Puentes','N','Y',NOW(),NOW()),
((UUID()),'Muro','Muro','N','Y',NOW(),NOW()),
((UUID()),'Restaurantes','Restaurantes','N','Y',NOW(),NOW()),
((UUID()),'Pendones','Pendones','N','Y',NOW(),NOW()),
((UUID()),'Vitral Escalera','Vitral Escalera','N','Y',NOW(),NOW()),
((UUID()),'Activacion','Activacion','N','Y',NOW(),NOW()),
((UUID()),'Pluma Estacionamiento','Pluma Estacionamiento','N','Y',NOW(),NOW()),
((UUID()),'Mampara','Mampara','N','Y',NOW(),NOW()),
((UUID()),'Mall Rack','Mall Rack','N','Y',NOW(),NOW()),
((UUID()),'Banner Caminadora','Banner Caminadora','N','Y',NOW(),NOW()),
((UUID()),'Espejo','Espejo','N','Y',NOW(),NOW()),
((UUID()),'Espejo en baños','Espejo en baños','N','Y',NOW(),NOW()),
((UUID()),'Activacion Gym','Activacion Gym','N','Y',NOW(),NOW()),
((UUID()),'Pantallas','Pantallas','N','Y',NOW(),NOW()),
((UUID()),'Producción','Producción','N','Y',NOW(),NOW());

SELECT * FROM `salemodels` WHERE is_digital = 'N' AND is_active = 'Y';

INSERT INTO salemodels (id,NAME,DESCRIPTION,is_digital,is_active,created_at,updated_at)  VALUES ((UUID()),'1/4 DE PAGINA','1/4 DE PAGINA','N','Y',NOW(),NOW());
INSERT INTO salemodels (id,NAME,DESCRIPTION,is_digital,is_active,created_at,updated_at)  VALUES ((UUID()),'2DA Y 3RA PAGINA DE FORROS ','2DA Y 3RA PAGINA DE FORROS ','N','Y',NOW(),NOW());
INSERT INTO salemodels (id,NAME,DESCRIPTION,is_digital,is_active,created_at,updated_at)  VALUES ((UUID()),'CINTILLO ','CINTILLO ','N','Y',NOW(),NOW());
INSERT INTO salemodels (id,NAME,DESCRIPTION,is_digital,is_active,created_at,updated_at)  VALUES ((UUID()),'ESQUELA ','ESQUELA ','N','Y',NOW(),NOW());
INSERT INTO salemodels (id,NAME,DESCRIPTION,is_digital,is_active,created_at,updated_at)  VALUES ((UUID()),'MEDIA PAGINA','MEDIA PAGINA','N','Y',NOW(),NOW());
INSERT INTO salemodels (id,NAME,DESCRIPTION,is_digital,is_active,created_at,updated_at)  VALUES ((UUID()),'PAGINA CENTRAL ','PAGINA CENTRAL ','N','Y',NOW(),NOW());
INSERT INTO salemodels (id,NAME,DESCRIPTION,is_digital,is_active,created_at,updated_at)  VALUES ((UUID()),'ROBA PAGINA','ROBA PAGINA','N','Y',NOW(),NOW());
INSERT INTO salemodels (id,NAME,DESCRIPTION,is_digital,is_active,created_at,updated_at)  VALUES ((UUID()),'10 seconds Spot','10 seconds Spot','N','Y',NOW(),NOW());
INSERT INTO salemodels (id,NAME,DESCRIPTION,is_digital,is_active,created_at,updated_at)  VALUES ((UUID()),'MENCION ','MENCION ','N','Y',NOW(),NOW());
INSERT INTO salemodels (id,NAME,DESCRIPTION,is_digital,is_active,created_at,updated_at)  VALUES ((UUID()),'ACCIONES VIRTUALES ','ACCIONES VIRTUALES ','N','Y',NOW(),NOW());
INSERT INTO salemodels (id,NAME,DESCRIPTION,is_digital,is_active,created_at,updated_at)  VALUES ((UUID()),'ACCIONES ESPECIALES ','ACCIONES ESPECIALES ','N','Y',NOW(),NOW());
INSERT INTO salemodels (id,NAME,DESCRIPTION,is_digital,is_active,created_at,updated_at)  VALUES ((UUID()),'CAPSULA','CAPSULA','N','Y',NOW(),NOW());
INSERT INTO salemodels (id,NAME,DESCRIPTION,is_digital,is_active,created_at,updated_at)  VALUES ((UUID()),'PATROCINIO ','PATROCINIO ','N','Y',NOW(),NOW());
INSERT INTO salemodels (id,NAME,DESCRIPTION,is_digital,is_active,created_at,updated_at)  VALUES ((UUID()),'SECCIONES ','SECCIONES ','N','Y',NOW(),NOW());
INSERT INTO salemodels (id,NAME,DESCRIPTION,is_digital,is_active,created_at,updated_at)  VALUES ((UUID()),'SPOT','SPOT','N','Y',NOW(),NOW());
INSERT INTO salemodels (id,NAME,DESCRIPTION,is_digital,is_active,created_at,updated_at)  VALUES ((UUID()),'ESPEJO INTERACTIVO','ESPEJO INTERACTIVO','N','Y',NOW(),NOW());
INSERT INTO salemodels (id,NAME,DESCRIPTION,is_digital,is_active,created_at,updated_at)  VALUES ((UUID()),'Pantalla Digital','Pantalla Digital','N','Y',NOW(),NOW());
INSERT INTO salemodels (id,NAME,DESCRIPTION,is_digital,is_active,created_at,updated_at)  VALUES ((UUID()),'VITRAL ','VITRAL ','N','Y',NOW(),NOW());
INSERT INTO salemodels (id,NAME,DESCRIPTION,is_digital,is_active,created_at,updated_at)  VALUES ((UUID()),'KIOSCO','KIOSCO','N','Y',NOW(),NOW());
INSERT INTO salemodels (id,NAME,DESCRIPTION,is_digital,is_active,created_at,updated_at)  VALUES ((UUID()),'MUPIS','MUPIS','N','Y',NOW(),NOW());
INSERT INTO salemodels (id,NAME,DESCRIPTION,is_digital,is_active,created_at,updated_at)  VALUES ((UUID()),'Valla Digital','Valla Digital','N','Y',NOW(),NOW());

UPDATE salemodels SET is_digital='N', product_ids_rel='24' WHERE LOWER(name) = LOWER('1/4 DE PAGINA');
UPDATE salemodels SET is_digital='N', product_ids_rel='25' WHERE LOWER(name) = LOWER('10 SECONDS SPOT');
UPDATE salemodels SET is_digital='N', product_ids_rel='25' WHERE LOWER(name) = LOWER('20 SECONDS SPOT');
UPDATE salemodels SET is_digital='N', product_ids_rel='24' WHERE LOWER(name) = LOWER('2DA Y 3RA PAGINA DE FORROS ');
UPDATE salemodels SET is_digital='N', product_ids_rel='25' WHERE LOWER(name) = LOWER('30 SECONDS SPOT');
UPDATE salemodels SET is_digital='N', product_ids_rel='26' WHERE LOWER(name) = LOWER('ACCIONES ESPECIALES ');
UPDATE salemodels SET is_digital='N', product_ids_rel='26' WHERE LOWER(name) = LOWER('ACCIONES VIRTUALES ');
UPDATE salemodels SET is_digital='N', product_ids_rel='27,28' WHERE LOWER(name) = LOWER('ACTIVACION ');
UPDATE salemodels SET is_digital='N', product_ids_rel='29' WHERE LOWER(name) = LOWER('ACTIVACION EN CALLE ');
UPDATE salemodels SET is_digital='N', product_ids_rel='29' WHERE LOWER(name) = LOWER('ARCO');
UPDATE salemodels SET is_digital='N', product_ids_rel='24' WHERE LOWER(name) = LOWER('BACK COVER');
UPDATE salemodels SET is_digital='N', product_ids_rel='29' WHERE LOWER(name) = LOWER('BAJO PUENTE');
UPDATE salemodels SET is_digital='N', product_ids_rel='27' WHERE LOWER(name) = LOWER('BANNER CAMINADORA ');
UPDATE salemodels SET is_digital='N', product_ids_rel='26' WHERE LOWER(name) = LOWER('CAPSULA');
UPDATE salemodels SET is_digital='N', product_ids_rel='29' WHERE LOWER(name) = LOWER('CARTELERA');
UPDATE salemodels SET is_digital='N', product_ids_rel='29' WHERE LOWER(name) = LOWER('CASETA');
UPDATE salemodels SET is_digital='N', product_ids_rel='24,26' WHERE LOWER(name) = LOWER('CINTILLO ');
UPDATE salemodels SET is_digital='N', product_ids_rel='29' WHERE LOWER(name) = LOWER('COLUMNA');
UPDATE salemodels SET is_digital='N', product_ids_rel='24' WHERE LOWER(name) = LOWER('DOUBLE PAGE');
UPDATE salemodels SET is_digital='N', product_ids_rel='27' WHERE LOWER(name) = LOWER('ESPEJO EN BAÑOS ');
UPDATE salemodels SET is_digital='N', product_ids_rel='27' WHERE LOWER(name) = LOWER('ESPEJO INTERACTIVO');
UPDATE salemodels SET is_digital='N', product_ids_rel='24' WHERE LOWER(name) = LOWER('ESQUELA ');
UPDATE salemodels SET is_digital='N', product_ids_rel='29' WHERE LOWER(name) = LOWER('ESTRUCTURA');
UPDATE salemodels SET is_digital='N', product_ids_rel='29' WHERE LOWER(name) = LOWER('ESTRUCTURA DE PISO');
UPDATE salemodels SET is_digital='N', product_ids_rel='24' WHERE LOWER(name) = LOWER('FRONT PAGE');
UPDATE salemodels SET is_digital='N', product_ids_rel='28' WHERE LOWER(name) = LOWER('MALL RACK');
UPDATE salemodels SET is_digital='N', product_ids_rel='28' WHERE LOWER(name) = LOWER('MAMPARA');
UPDATE salemodels SET is_digital='N', product_ids_rel='24' WHERE LOWER(name) = LOWER('MEDIA PAGINA');
UPDATE salemodels SET is_digital='N', product_ids_rel='25,26' WHERE LOWER(name) = LOWER('MENCION ');
INSERT INTO salemodels (id,product_ids_rel,NAME,DESCRIPTION,is_digital,is_active,created_at,updated_at)  VALUES ((UUID()),' 29','MULTIFUNCIONAL','MULTIFUNCIONAL','N','Y',NOW(),NOW());
UPDATE salemodels SET is_digital='N', product_ids_rel='29' WHERE LOWER(name) = LOWER('MUPI');
UPDATE salemodels SET is_digital='N', product_ids_rel='27,28,29' WHERE LOWER(name) = LOWER('MURO ');
UPDATE salemodels SET is_digital='N', product_ids_rel='24' WHERE LOWER(name) = LOWER('PAGINA CENTRAL ');
UPDATE salemodels SET is_digital='N', product_ids_rel='27,29' WHERE LOWER(name) = LOWER('PANTALLA');
UPDATE salemodels SET is_digital='N', product_ids_rel='29' WHERE LOWER(name) = LOWER('PARABUS');
UPDATE salemodels SET is_digital='N', product_ids_rel='25,26' WHERE LOWER(name) = LOWER('PATROCINIO ');
UPDATE salemodels SET is_digital='N', product_ids_rel='28' WHERE LOWER(name) = LOWER('PENDONES');
UPDATE salemodels SET is_digital='N', product_ids_rel='28' WHERE LOWER(name) = LOWER('PLUMA ESTACIONAMIENTO ');
UPDATE salemodels SET is_digital='N', product_ids_rel='29' WHERE LOWER(name) = LOWER('PUBLIANDANTES ');
UPDATE salemodels SET is_digital='N', product_ids_rel='29' WHERE LOWER(name) = LOWER('PUBLICIDAD EN BAR');
UPDATE salemodels SET is_digital='N', product_ids_rel='29' WHERE LOWER(name) = LOWER('PUENTE');
UPDATE salemodels SET is_digital='N', product_ids_rel='29' WHERE LOWER(name) = LOWER('PUENTE PEATONAL');
UPDATE salemodels SET is_digital='N', product_ids_rel='29' WHERE LOWER(name) = LOWER('PUENTE VEHICULAR');
UPDATE salemodels SET is_digital='N', product_ids_rel='29' WHERE LOWER(name) = LOWER('RELOJ DIGITAL');
UPDATE salemodels SET is_digital='N', product_ids_rel='29' WHERE LOWER(name) = LOWER('RESTAURANTES ');
UPDATE salemodels SET is_digital='N', product_ids_rel='24' WHERE LOWER(name) = LOWER('ROBA PAGINA');
INSERT INTO salemodels (id,product_ids_rel,NAME,DESCRIPTION,is_digital,is_active,created_at,updated_at)  VALUES ((UUID()),' 26','ROBA PANTALLA ','ROBA PANTALLA ','N','Y',NOW(),NOW());
UPDATE salemodels SET is_digital='N', product_ids_rel='26' WHERE LOWER(name) = LOWER('SECCIONES ');
UPDATE salemodels SET is_digital='N', product_ids_rel='24' WHERE LOWER(name) = LOWER('SIMPLE PAGE');
UPDATE salemodels SET is_digital='N', product_ids_rel='26' WHERE LOWER(name) = LOWER('SPOT');
INSERT INTO salemodels (id,product_ids_rel,NAME,DESCRIPTION,is_digital,is_active,created_at,updated_at)  VALUES ((UUID()),' 29','UNIPOLAR','UNIPOLAR','N','Y',NOW(),NOW());
UPDATE salemodels SET is_digital='N', product_ids_rel='29' WHERE LOWER(name) = LOWER('VALLA ');
UPDATE salemodels SET is_digital='N', product_ids_rel='29' WHERE LOWER(name) = LOWER('VALLA DIGITAL ');
UPDATE salemodels SET name='VALLA MOVIL',description='VALLA MOVIL', is_digital='N', product_ids_rel='29' WHERE LOWER(name) = LOWER('Vallas Moviles ');
UPDATE salemodels SET is_digital='N', product_ids_rel='28' WHERE LOWER(name) = LOWER('VITRAL ');
UPDATE salemodels SET is_digital='N', product_ids_rel='28' WHERE LOWER(name) = LOWER('VITRAL ESCALERA ');

UPDATE salemodels SET is_active = 'N' WHERE (is_digital = 'N' AND (product_ids_rel ='' OR product_ids_rel IS NULL)) AND name <> 'Producción';

SELECT p.name as Producto, sm.name as `Modelo de venta`, sm.product_ids_rel as codigos FROM products p RIGHT JOIN salemodels sm ON p.code IN (sm.product_ids_rel) WHERE sm.is_digital = 'N' AND sm.is_active = 'Y' ORDER BY p.name, sm.name LIMIT 500

INSERT INTO productxsalemodels (id, product_id, salemodel_id, is_digital, is_active, created_at, updated_at) VALUES (id,'b896f4b6-cd6c-11ec-a3eb-008cfa5abdac','1/4 DE PAGINA','N','Y', now(), now())

INSERT INTO salemodels 
(id,product_ids_rel,NAME,DESCRIPTION,is_digital,is_active,created_at,updated_at)  
VALUES ((UUID()),'29','CAMIONES / URVAN','CAMIONES / URVAN','N','Y',NOW(),NOW()),
((UUID()),'28,29','ACCESORIOS','ACCESORIOS','N','Y',NOW(),NOW());

INSERT INTO salemodels 
(id,product_ids_rel,NAME,DESCRIPTION,is_digital,is_active,created_at,updated_at)  
VALUES ((UUID()),'27,28,29','INSTALACIÓN / DESINSTALACIÓN','INSTALACIÓN / DESINSTALACIÓN','N','Y',NOW(),NOW());

INSERT INTO salemodels 
(id,product_ids_rel,NAME,DESCRIPTION,is_digital,is_active,created_at,updated_at)  
VALUES (UUID(),'28,29','TAPIAL','TAPIAL','N','Y',NOW(),NOW());

INSERT INTO salemodels (id,product_ids_rel,NAME,DESCRIPTION,is_digital,is_active,created_at,updated_at) 
VALUES ((UUID()),'','Programmatic','Programmatic','Y','Y',NOW(),NOW()); 

UPDATE salemodels SET name='Camion Urvan' where name = 'CAMIONES / URVAN';

INSERT INTO salemodels 
(id,product_ids_rel,NAME,DESCRIPTION,is_digital,is_active,created_at,updated_at)  
VALUES ((UUID()),'28,29','Camion Integral','Camion Integral','N','Y',NOW(),NOW()),
((UUID()),'28,29','Camion Medio medallon','Camion Medio medallon','N','Y',NOW(),NOW()),
((UUID()),'28,29','Camion Medallon Completo','Camion Medallon Completo','N','Y',NOW(),NOW());

# PROVIDERS
CREATE TABLE IF NOT EXISTS providers (
id VARCHAR(40) PRIMARY KEY NOT NULL,
NAME VARCHAR(40) NOT NULL UNIQUE,
address	TEXT,
webpage_url VARCHAR(200),
is_active ENUM('N','Y') NOT NULL,
created_at DATETIME NOT NULL,
updated_at DATETIME NOT NULL
);

# PRODUCTXSALEMODELS
CREATE TABLE IF NOT EXISTS productxsalemodels (
id VARCHAR(40) PRIMARY KEY NOT NULL,
product_id VARCHAR(40) NOT NULL,
salemodel_id VARCHAR(40) NOT NULL,
is_active ENUM('N','Y') NOT NULL,
created_at DATETIME NOT NULL,
updated_at DATETIME NOT NULL
);

# ADDING FK product
ALTER TABLE productxsalemodels
    ADD CONSTRAINT FKproductID 
	FOREIGN KEY (product_id)
    REFERENCES products(id);

# ADDING FK salemodel
ALTER TABLE productxsalemodels
    ADD CONSTRAINT FKsalemodelID 
	FOREIGN KEY (salemodel_id)
    REFERENCES salemodels(id);

SELECT CONCAT("INSERT INTO productxsalemodels (id, product_id, salemodel_id,  is_active, created_at, updated_at) VALUES (UUID(),'",p.id,"','",sm.id,"','Y', now(), now());") as sqlProdSale FROM salemodels sm JOIN products p WHERE p.code='24' AND (TRIM(LOWER(sm.name))) = (TRIM(LOWER('1/4 DE PAGINA')));
SELECT CONCAT("INSERT INTO productxsalemodels (id, product_id, salemodel_id,  is_active, created_at, updated_at) VALUES (UUID(),'",p.id,"','",sm.id,"','Y', now(), now());") as sqlProdSale FROM salemodels sm JOIN products p WHERE p.code='25' AND (TRIM(LOWER(sm.name))) = (TRIM(LOWER('10 SECONDS SPOT')));
SELECT CONCAT("INSERT INTO productxsalemodels (id, product_id, salemodel_id,  is_active, created_at, updated_at) VALUES (UUID(),'",p.id,"','",sm.id,"','Y', now(), now());") as sqlProdSale FROM salemodels sm JOIN products p WHERE p.code='25' AND (TRIM(LOWER(sm.name))) = (TRIM(LOWER('20 SECONDS SPOT')));
SELECT CONCAT("INSERT INTO productxsalemodels (id, product_id, salemodel_id,  is_active, created_at, updated_at) VALUES (UUID(),'",p.id,"','",sm.id,"','Y', now(), now());") as sqlProdSale FROM salemodels sm JOIN products p WHERE p.code='24' AND (TRIM(LOWER(sm.name))) = (TRIM(LOWER('2DA Y 3RA PAGINA DE FORROS ')));
SELECT CONCAT("INSERT INTO productxsalemodels (id, product_id, salemodel_id,  is_active, created_at, updated_at) VALUES (UUID(),'",p.id,"','",sm.id,"','Y', now(), now());") as sqlProdSale FROM salemodels sm JOIN products p WHERE p.code='25' AND (TRIM(LOWER(sm.name))) = (TRIM(LOWER('30 SECONDS SPOT')));
SELECT CONCAT("INSERT INTO productxsalemodels (id, product_id, salemodel_id,  is_active, created_at, updated_at) VALUES (UUID(),'",p.id,"','",sm.id,"','Y', now(), now());") as sqlProdSale FROM salemodels sm JOIN products p WHERE p.code='26' AND (TRIM(LOWER(sm.name))) = (TRIM(LOWER('ACCIONES ESPECIALES ')));
SELECT CONCAT("INSERT INTO productxsalemodels (id, product_id, salemodel_id,  is_active, created_at, updated_at) VALUES (UUID(),'",p.id,"','",sm.id,"','Y', now(), now());") as sqlProdSale FROM salemodels sm JOIN products p WHERE p.code='26' AND (TRIM(LOWER(sm.name))) = (TRIM(LOWER('ACCIONES VIRTUALES ')));
SELECT CONCAT("INSERT INTO productxsalemodels (id, product_id, salemodel_id,  is_active, created_at, updated_at) VALUES (UUID(),'",p.id,"','",sm.id,"','Y', now(), now());") as sqlProdSale FROM salemodels sm JOIN products p WHERE p.code='27' AND (TRIM(LOWER(sm.name))) = (TRIM(LOWER('ACTIVACION ')));
SELECT CONCAT("INSERT INTO productxsalemodels (id, product_id, salemodel_id,  is_active, created_at, updated_at) VALUES (UUID(),'",p.id,"','",sm.id,"','Y', now(), now());") as sqlProdSale FROM salemodels sm JOIN products p WHERE p.code='28' AND (TRIM(LOWER(sm.name))) = (TRIM(LOWER('ACTIVACION ')));
SELECT CONCAT("INSERT INTO productxsalemodels (id, product_id, salemodel_id,  is_active, created_at, updated_at) VALUES (UUID(),'",p.id,"','",sm.id,"','Y', now(), now());") as sqlProdSale FROM salemodels sm JOIN products p WHERE p.code='29' AND (TRIM(LOWER(sm.name))) = (TRIM(LOWER('ACTIVACION EN CALLE ')));
SELECT CONCAT("INSERT INTO productxsalemodels (id, product_id, salemodel_id,  is_active, created_at, updated_at) VALUES (UUID(),'",p.id,"','",sm.id,"','Y', now(), now());") as sqlProdSale FROM salemodels sm JOIN products p WHERE p.code='29' AND (TRIM(LOWER(sm.name))) = (TRIM(LOWER('ARCO')));
SELECT CONCAT("INSERT INTO productxsalemodels (id, product_id, salemodel_id,  is_active, created_at, updated_at) VALUES (UUID(),'",p.id,"','",sm.id,"','Y', now(), now());") as sqlProdSale FROM salemodels sm JOIN products p WHERE p.code='24' AND (TRIM(LOWER(sm.name))) = (TRIM(LOWER('BACK COVER')));
SELECT CONCAT("INSERT INTO productxsalemodels (id, product_id, salemodel_id,  is_active, created_at, updated_at) VALUES (UUID(),'",p.id,"','",sm.id,"','Y', now(), now());") as sqlProdSale FROM salemodels sm JOIN products p WHERE p.code='29' AND (TRIM(LOWER(sm.name))) = (TRIM(LOWER('BAJO PUENTE')));
SELECT CONCAT("INSERT INTO productxsalemodels (id, product_id, salemodel_id,  is_active, created_at, updated_at) VALUES (UUID(),'",p.id,"','",sm.id,"','Y', now(), now());") as sqlProdSale FROM salemodels sm JOIN products p WHERE p.code='27' AND (TRIM(LOWER(sm.name))) = (TRIM(LOWER('BANNER CAMINADORA ')));
SELECT CONCAT("INSERT INTO productxsalemodels (id, product_id, salemodel_id,  is_active, created_at, updated_at) VALUES (UUID(),'",p.id,"','",sm.id,"','Y', now(), now());") as sqlProdSale FROM salemodels sm JOIN products p WHERE p.code='26' AND (TRIM(LOWER(sm.name))) = (TRIM(LOWER('CAPSULA')));
SELECT CONCAT("INSERT INTO productxsalemodels (id, product_id, salemodel_id,  is_active, created_at, updated_at) VALUES (UUID(),'",p.id,"','",sm.id,"','Y', now(), now());") as sqlProdSale FROM salemodels sm JOIN products p WHERE p.code='29' AND (TRIM(LOWER(sm.name))) = (TRIM(LOWER('CARTELERA')));
SELECT CONCAT("INSERT INTO productxsalemodels (id, product_id, salemodel_id,  is_active, created_at, updated_at) VALUES (UUID(),'",p.id,"','",sm.id,"','Y', now(), now());") as sqlProdSale FROM salemodels sm JOIN products p WHERE p.code='29' AND (TRIM(LOWER(sm.name))) = (TRIM(LOWER('CASETA')));
SELECT CONCAT("INSERT INTO productxsalemodels (id, product_id, salemodel_id,  is_active, created_at, updated_at) VALUES (UUID(),'",p.id,"','",sm.id,"','Y', now(), now());") as sqlProdSale FROM salemodels sm JOIN products p WHERE p.code='24' AND (TRIM(LOWER(sm.name))) = (TRIM(LOWER('CINTILLO ')));
SELECT CONCAT("INSERT INTO productxsalemodels (id, product_id, salemodel_id,  is_active, created_at, updated_at) VALUES (UUID(),'",p.id,"','",sm.id,"','Y', now(), now());") as sqlProdSale FROM salemodels sm JOIN products p WHERE p.code='26' AND (TRIM(LOWER(sm.name))) = (TRIM(LOWER('CINTILLO ')));
SELECT CONCAT("INSERT INTO productxsalemodels (id, product_id, salemodel_id,  is_active, created_at, updated_at) VALUES (UUID(),'",p.id,"','",sm.id,"','Y', now(), now());") as sqlProdSale FROM salemodels sm JOIN products p WHERE p.code='29' AND (TRIM(LOWER(sm.name))) = (TRIM(LOWER('COLUMNA')));
SELECT CONCAT("INSERT INTO productxsalemodels (id, product_id, salemodel_id,  is_active, created_at, updated_at) VALUES (UUID(),'",p.id,"','",sm.id,"','Y', now(), now());") as sqlProdSale FROM salemodels sm JOIN products p WHERE p.code='24' AND (TRIM(LOWER(sm.name))) = (TRIM(LOWER('DOUBLE PAGE')));
SELECT CONCAT("INSERT INTO productxsalemodels (id, product_id, salemodel_id,  is_active, created_at, updated_at) VALUES (UUID(),'",p.id,"','",sm.id,"','Y', now(), now());") as sqlProdSale FROM salemodels sm JOIN products p WHERE p.code='27' AND (TRIM(LOWER(sm.name))) = (TRIM(LOWER('ESPEJO EN BAÑOS ')));
SELECT CONCAT("INSERT INTO productxsalemodels (id, product_id, salemodel_id,  is_active, created_at, updated_at) VALUES (UUID(),'",p.id,"','",sm.id,"','Y', now(), now());") as sqlProdSale FROM salemodels sm JOIN products p WHERE p.code='27' AND (TRIM(LOWER(sm.name))) = (TRIM(LOWER('ESPEJO INTERACTIVO')));
SELECT CONCAT("INSERT INTO productxsalemodels (id, product_id, salemodel_id,  is_active, created_at, updated_at) VALUES (UUID(),'",p.id,"','",sm.id,"','Y', now(), now());") as sqlProdSale FROM salemodels sm JOIN products p WHERE p.code='24' AND (TRIM(LOWER(sm.name))) = (TRIM(LOWER('ESQUELA ')));
#INSERT INTO salemodels (id,product_ids_rel,NAME,DESCRIPTION,is_active,created_at,updated_at)  VALUES ((UUID()),' 29','ESTRUCTURA','ESTRUCTURA','Y',NOW(),NOW());
SELECT CONCAT("INSERT INTO productxsalemodels (id, product_id, salemodel_id,  is_active, created_at, updated_at) VALUES (UUID(),'",p.id,"','",sm.id,"','Y', now(), now());") as sqlProdSale FROM salemodels sm JOIN products p WHERE p.code='29' AND (TRIM(LOWER(sm.name))) = (TRIM(LOWER('ESTRUCTURA')));
#INSERT INTO salemodels (id,product_ids_rel,NAME,DESCRIPTION,is_active,created_at,updated_at)  VALUES ((UUID()),' 29','ESTRUCTURA DE PISO','ESTRUCTURA DE PISO','Y',NOW(),NOW());
SELECT CONCAT("INSERT INTO productxsalemodels (id, product_id, salemodel_id,  is_active, created_at, updated_at) VALUES (UUID(),'",p.id,"','",sm.id,"','Y', now(), now());") as sqlProdSale FROM salemodels sm JOIN products p WHERE p.code='29' AND (TRIM(LOWER(sm.name))) = (TRIM(LOWER('ESTRUCTURA DE PISO')));
SELECT CONCAT("INSERT INTO productxsalemodels (id, product_id, salemodel_id,  is_active, created_at, updated_at) VALUES (UUID(),'",p.id,"','",sm.id,"','Y', now(), now());") as sqlProdSale FROM salemodels sm JOIN products p WHERE p.code='24' AND (TRIM(LOWER(sm.name))) = (TRIM(LOWER('FRONT PAGE')));
SELECT CONCAT("INSERT INTO productxsalemodels (id, product_id, salemodel_id,  is_active, created_at, updated_at) VALUES (UUID(),'",p.id,"','",sm.id,"','Y', now(), now());") as sqlProdSale FROM salemodels sm JOIN products p WHERE p.code='28' AND (TRIM(LOWER(sm.name))) = (TRIM(LOWER('MALL RACK')));
SELECT CONCAT("INSERT INTO productxsalemodels (id, product_id, salemodel_id,  is_active, created_at, updated_at) VALUES (UUID(),'",p.id,"','",sm.id,"','Y', now(), now());") as sqlProdSale FROM salemodels sm JOIN products p WHERE p.code='28' AND (TRIM(LOWER(sm.name))) = (TRIM(LOWER('MAMPARA')));
SELECT CONCAT("INSERT INTO productxsalemodels (id, product_id, salemodel_id,  is_active, created_at, updated_at) VALUES (UUID(),'",p.id,"','",sm.id,"','Y', now(), now());") as sqlProdSale FROM salemodels sm JOIN products p WHERE p.code='24' AND (TRIM(LOWER(sm.name))) = (TRIM(LOWER('MEDIA PAGINA')));
SELECT CONCAT("INSERT INTO productxsalemodels (id, product_id, salemodel_id,  is_active, created_at, updated_at) VALUES (UUID(),'",p.id,"','",sm.id,"','Y', now(), now());") as sqlProdSale FROM salemodels sm JOIN products p WHERE p.code='25' AND (TRIM(LOWER(sm.name))) = (TRIM(LOWER('MENCION ')));
SELECT CONCAT("INSERT INTO productxsalemodels (id, product_id, salemodel_id,  is_active, created_at, updated_at) VALUES (UUID(),'",p.id,"','",sm.id,"','Y', now(), now());") as sqlProdSale FROM salemodels sm JOIN products p WHERE p.code='26' AND (TRIM(LOWER(sm.name))) = (TRIM(LOWER('MENCION ')));
SELECT CONCAT("INSERT INTO productxsalemodels (id, product_id, salemodel_id,  is_active, created_at, updated_at) VALUES (UUID(),'",p.id,"','",sm.id,"','Y', now(), now());") as sqlProdSale FROM salemodels sm JOIN products p WHERE p.code='29' AND (TRIM(LOWER(sm.name))) = (TRIM(LOWER('MULTIFUNCIONAL')));
SELECT CONCAT("INSERT INTO productxsalemodels (id, product_id, salemodel_id,  is_active, created_at, updated_at) VALUES (UUID(),'",p.id,"','",sm.id,"','Y', now(), now());") as sqlProdSale FROM salemodels sm JOIN products p WHERE p.code='29' AND (TRIM(LOWER(sm.name))) = (TRIM(LOWER('MUPI')));
SELECT CONCAT("INSERT INTO productxsalemodels (id, product_id, salemodel_id,  is_active, created_at, updated_at) VALUES (UUID(),'",p.id,"','",sm.id,"','Y', now(), now());") as sqlProdSale FROM salemodels sm JOIN products p WHERE p.code='27' AND (TRIM(LOWER(sm.name))) = (TRIM(LOWER('MURO ')));
SELECT CONCAT("INSERT INTO productxsalemodels (id, product_id, salemodel_id,  is_active, created_at, updated_at) VALUES (UUID(),'",p.id,"','",sm.id,"','Y', now(), now());") as sqlProdSale FROM salemodels sm JOIN products p WHERE p.code='28' AND (TRIM(LOWER(sm.name))) = (TRIM(LOWER('MURO ')));
SELECT CONCAT("INSERT INTO productxsalemodels (id, product_id, salemodel_id,  is_active, created_at, updated_at) VALUES (UUID(),'",p.id,"','",sm.id,"','Y', now(), now());") as sqlProdSale FROM salemodels sm JOIN products p WHERE p.code='29' AND (TRIM(LOWER(sm.name))) = (TRIM(LOWER('MURO ')));
SELECT CONCAT("INSERT INTO productxsalemodels (id, product_id, salemodel_id,  is_active, created_at, updated_at) VALUES (UUID(),'",p.id,"','",sm.id,"','Y', now(), now());") as sqlProdSale FROM salemodels sm JOIN products p WHERE p.code='24' AND (TRIM(LOWER(sm.name))) = (TRIM(LOWER('PAGINA CENTRAL ')));
SELECT CONCAT("INSERT INTO productxsalemodels (id, product_id, salemodel_id,  is_active, created_at, updated_at) VALUES (UUID(),'",p.id,"','",sm.id,"','Y', now(), now());") as sqlProdSale FROM salemodels sm JOIN products p WHERE p.code='27' AND (TRIM(LOWER(sm.name))) = (TRIM(LOWER('PANTALLA')));
SELECT CONCAT("INSERT INTO productxsalemodels (id, product_id, salemodel_id,  is_active, created_at, updated_at) VALUES (UUID(),'",p.id,"','",sm.id,"','Y', now(), now());") as sqlProdSale FROM salemodels sm JOIN products p WHERE p.code='29' AND (TRIM(LOWER(sm.name))) = (TRIM(LOWER('PANTALLA')));
SELECT CONCAT("INSERT INTO productxsalemodels (id, product_id, salemodel_id,  is_active, created_at, updated_at) VALUES (UUID(),'",p.id,"','",sm.id,"','Y', now(), now());") as sqlProdSale FROM salemodels sm JOIN products p WHERE p.code='29' AND (TRIM(LOWER(sm.name))) = (TRIM(LOWER('PARABUS')));
SELECT CONCAT("INSERT INTO productxsalemodels (id, product_id, salemodel_id,  is_active, created_at, updated_at) VALUES (UUID(),'",p.id,"','",sm.id,"','Y', now(), now());") as sqlProdSale FROM salemodels sm JOIN products p WHERE p.code='25' AND (TRIM(LOWER(sm.name))) = (TRIM(LOWER('PATROCINIO ')));
SELECT CONCAT("INSERT INTO productxsalemodels (id, product_id, salemodel_id,  is_active, created_at, updated_at) VALUES (UUID(),'",p.id,"','",sm.id,"','Y', now(), now());") as sqlProdSale FROM salemodels sm JOIN products p WHERE p.code='26' AND (TRIM(LOWER(sm.name))) = (TRIM(LOWER('PATROCINIO ')));
SELECT CONCAT("INSERT INTO productxsalemodels (id, product_id, salemodel_id,  is_active, created_at, updated_at) VALUES (UUID(),'",p.id,"','",sm.id,"','Y', now(), now());") as sqlProdSale FROM salemodels sm JOIN products p WHERE p.code='28' AND (TRIM(LOWER(sm.name))) = (TRIM(LOWER('PENDONES')));
SELECT CONCAT("INSERT INTO productxsalemodels (id, product_id, salemodel_id,  is_active, created_at, updated_at) VALUES (UUID(),'",p.id,"','",sm.id,"','Y', now(), now());") as sqlProdSale FROM salemodels sm JOIN products p WHERE p.code='28' AND (TRIM(LOWER(sm.name))) = (TRIM(LOWER('PLUMA ESTACIONAMIENTO ')));
SELECT CONCAT("INSERT INTO productxsalemodels (id, product_id, salemodel_id,  is_active, created_at, updated_at) VALUES (UUID(),'",p.id,"','",sm.id,"','Y', now(), now());") as sqlProdSale FROM salemodels sm JOIN products p WHERE p.code='29' AND (TRIM(LOWER(sm.name))) = (TRIM(LOWER('PUBLIANDANTES ')));
SELECT CONCAT("INSERT INTO productxsalemodels (id, product_id, salemodel_id,  is_active, created_at, updated_at) VALUES (UUID(),'",p.id,"','",sm.id,"','Y', now(), now());") as sqlProdSale FROM salemodels sm JOIN products p WHERE p.code='29' AND (TRIM(LOWER(sm.name))) = (TRIM(LOWER('PUBLICIDAD EN BAR')));
#INSERT INTO salemodels (id,product_ids_rel,NAME,DESCRIPTION,is_active,created_at,updated_at)  VALUES ((UUID()),' 29','PUENTE','PUENTE','Y',NOW(),NOW());
SELECT CONCAT("INSERT INTO productxsalemodels (id, product_id, salemodel_id,  is_active, created_at, updated_at) VALUES (UUID(),'",p.id,"','",sm.id,"','Y', now(), now());") as sqlProdSale FROM salemodels sm JOIN products p WHERE p.code='29' AND (TRIM(LOWER(sm.name))) = (TRIM(LOWER('PUENTE')));
SELECT CONCAT("INSERT INTO productxsalemodels (id, product_id, salemodel_id,  is_active, created_at, updated_at) VALUES (UUID(),'",p.id,"','",sm.id,"','Y', now(), now());") as sqlProdSale FROM salemodels sm JOIN products p WHERE p.code='29' AND (TRIM(LOWER(sm.name))) = (TRIM(LOWER('PUENTE PEATONAL')));
SELECT CONCAT("INSERT INTO productxsalemodels (id, product_id, salemodel_id,  is_active, created_at, updated_at) VALUES (UUID(),'",p.id,"','",sm.id,"','Y', now(), now());") as sqlProdSale FROM salemodels sm JOIN products p WHERE p.code='29' AND (TRIM(LOWER(sm.name))) = (TRIM(LOWER('PUENTE VEHICULAR')));
SELECT CONCAT("INSERT INTO productxsalemodels (id, product_id, salemodel_id,  is_active, created_at, updated_at) VALUES (UUID(),'",p.id,"','",sm.id,"','Y', now(), now());") as sqlProdSale FROM salemodels sm JOIN products p WHERE p.code='29' AND (TRIM(LOWER(sm.name))) = (TRIM(LOWER('RELOJ DIGITAL')));
SELECT CONCAT("INSERT INTO productxsalemodels (id, product_id, salemodel_id,  is_active, created_at, updated_at) VALUES (UUID(),'",p.id,"','",sm.id,"','Y', now(), now());") as sqlProdSale FROM salemodels sm JOIN products p WHERE p.code='29' AND (TRIM(LOWER(sm.name))) = (TRIM(LOWER('RESTAURANTES ')));
SELECT CONCAT("INSERT INTO productxsalemodels (id, product_id, salemodel_id,  is_active, created_at, updated_at) VALUES (UUID(),'",p.id,"','",sm.id,"','Y', now(), now());") as sqlProdSale FROM salemodels sm JOIN products p WHERE p.code='24' AND (TRIM(LOWER(sm.name))) = (TRIM(LOWER('ROBA PAGINA')));
SELECT CONCAT("INSERT INTO productxsalemodels (id, product_id, salemodel_id,  is_active, created_at, updated_at) VALUES (UUID(),'",p.id,"','",sm.id,"','Y', now(), now());") as sqlProdSale FROM salemodels sm JOIN products p WHERE p.code='26' AND (TRIM(LOWER(sm.name))) = (TRIM(LOWER('ROBA PANTALLA ')));
SELECT CONCAT("INSERT INTO productxsalemodels (id, product_id, salemodel_id,  is_active, created_at, updated_at) VALUES (UUID(),'",p.id,"','",sm.id,"','Y', now(), now());") as sqlProdSale FROM salemodels sm JOIN products p WHERE p.code='26' AND (TRIM(LOWER(sm.name))) = (TRIM(LOWER('SECCIONES ')));
SELECT CONCAT("INSERT INTO productxsalemodels (id, product_id, salemodel_id,  is_active, created_at, updated_at) VALUES (UUID(),'",p.id,"','",sm.id,"','Y', now(), now());") as sqlProdSale FROM salemodels sm JOIN products p WHERE p.code='24' AND (TRIM(LOWER(sm.name))) = (TRIM(LOWER('SIMPLE PAGE')));
SELECT CONCAT("INSERT INTO productxsalemodels (id, product_id, salemodel_id,  is_active, created_at, updated_at) VALUES (UUID(),'",p.id,"','",sm.id,"','Y', now(), now());") as sqlProdSale FROM salemodels sm JOIN products p WHERE p.code='26' AND (TRIM(LOWER(sm.name))) = (TRIM(LOWER('SPOT')));
SELECT CONCAT("INSERT INTO productxsalemodels (id, product_id, salemodel_id,  is_active, created_at, updated_at) VALUES (UUID(),'",p.id,"','",sm.id,"','Y', now(), now());") as sqlProdSale FROM salemodels sm JOIN products p WHERE p.code='29' AND (TRIM(LOWER(sm.name))) = (TRIM(LOWER('UNIPOLAR')));
SELECT CONCAT("INSERT INTO productxsalemodels (id, product_id, salemodel_id,  is_active, created_at, updated_at) VALUES (UUID(),'",p.id,"','",sm.id,"','Y', now(), now());") as sqlProdSale FROM salemodels sm JOIN products p WHERE p.code='29' AND (TRIM(LOWER(sm.name))) = (TRIM(LOWER('VALLA ')));
SELECT CONCAT("INSERT INTO productxsalemodels (id, product_id, salemodel_id,  is_active, created_at, updated_at) VALUES (UUID(),'",p.id,"','",sm.id,"','Y', now(), now());") as sqlProdSale FROM salemodels sm JOIN products p WHERE p.code='29' AND (TRIM(LOWER(sm.name))) = (TRIM(LOWER('VALLA DIGITAL ')));
SELECT CONCAT("INSERT INTO productxsalemodels (id, product_id, salemodel_id,  is_active, created_at, updated_at) VALUES (UUID(),'",p.id,"','",sm.id,"','Y', now(), now());") as sqlProdSale FROM salemodels sm JOIN products p WHERE p.code='29' AND (TRIM(LOWER(sm.name))) = (TRIM(LOWER('VALLA MOVIL ')));
SELECT CONCAT("INSERT INTO productxsalemodels (id, product_id, salemodel_id,  is_active, created_at, updated_at) VALUES (UUID(),'",p.id,"','",sm.id,"','Y', now(), now());") as sqlProdSale FROM salemodels sm JOIN products p WHERE p.code='28' AND (TRIM(LOWER(sm.name))) = (TRIM(LOWER('VITRAL ')));
SELECT CONCAT("INSERT INTO productxsalemodels (id, product_id, salemodel_id,  is_active, created_at, updated_at) VALUES (UUID(),'",p.id,"','",sm.id,"','Y', now(), now());") as sqlProdSale FROM salemodels sm JOIN products p WHERE p.code='28' AND (TRIM(LOWER(sm.name))) = (TRIM(LOWER('VITRAL ESCALERA ')));

SELECT CONCAT("DELETE FROM productxsalemodels WHERE product_id='",p.id,"' AND salemodel_id='",sm.id,"';") as sqlProdSale FROM salemodels sm JOIN products p WHERE p.code='27' AND (TRIM(LOWER(sm.name))) = (TRIM(LOWER('ACCESORIOS')));
SELECT CONCAT("INSERT INTO productxsalemodels (id, product_id, salemodel_id,  is_active, created_at, updated_at) VALUES (UUID(),'",p.id,"','",sm.id,"','Y', now(), now());") as sqlProdSale FROM salemodels sm JOIN products p WHERE p.code='28' AND (TRIM(LOWER(sm.name))) = (TRIM(LOWER('ACCESORIOS')));
SELECT CONCAT("INSERT INTO productxsalemodels (id, product_id, salemodel_id,  is_active, created_at, updated_at) VALUES (UUID(),'",p.id,"','",sm.id,"','Y', now(), now());") as sqlProdSale FROM salemodels sm JOIN products p WHERE p.code='29' AND (TRIM(LOWER(sm.name))) = (TRIM(LOWER('ACCESORIOS')));
SELECT CONCAT("INSERT INTO productxsalemodels (id, product_id, salemodel_id,  is_active, created_at, updated_at) VALUES (UUID(),'",p.id,"','",sm.id,"','Y', now(), now());") as sqlProdSale FROM salemodels sm JOIN products p WHERE p.code='29' AND (TRIM(LOWER(sm.name))) = (TRIM(LOWER('CAMIONES / URVAN')));
SELECT CONCAT("INSERT INTO productxsalemodels (id, product_id, salemodel_id,  is_active, created_at, updated_at) VALUES (UUID(),'",p.id,"','",sm.id,"','Y', now(), now());") as sqlProdSale FROM salemodels sm JOIN products p WHERE p.code='27' AND (TRIM(LOWER(sm.name))) = (TRIM(LOWER('INSTALACIÓN / DESINSTALACIÓN')));
SELECT CONCAT("INSERT INTO productxsalemodels (id, product_id, salemodel_id,  is_active, created_at, updated_at) VALUES (UUID(),'",p.id,"','",sm.id,"','Y', now(), now());") as sqlProdSale FROM salemodels sm JOIN products p WHERE p.code='28' AND (TRIM(LOWER(sm.name))) = (TRIM(LOWER('INSTALACIÓN / DESINSTALACIÓN')));
SELECT CONCAT("INSERT INTO productxsalemodels (id, product_id, salemodel_id,  is_active, created_at, updated_at) VALUES (UUID(),'",p.id,"','",sm.id,"','Y', now(), now());") as sqlProdSale FROM salemodels sm JOIN products p WHERE p.code='29' AND (TRIM(LOWER(sm.name))) = (TRIM(LOWER('INSTALACIÓN / DESINSTALACIÓN')));
SELECT CONCAT("INSERT INTO productxsalemodels (id, product_id, salemodel_id,  is_active, created_at, updated_at) VALUES (UUID(),'",p.id,"','",sm.id,"','Y', now(), now());") as sqlProdSale FROM salemodels sm JOIN products p WHERE p.code='28' AND (TRIM(LOWER(sm.name))) = (TRIM(LOWER('Camion Integral')));
SELECT CONCAT("INSERT INTO productxsalemodels (id, product_id, salemodel_id,  is_active, created_at, updated_at) VALUES (UUID(),'",p.id,"','",sm.id,"','Y', now(), now());") as sqlProdSale FROM salemodels sm JOIN products p WHERE p.code='29' AND (TRIM(LOWER(sm.name))) = (TRIM(LOWER('Camion Integral')));
SELECT CONCAT("INSERT INTO productxsalemodels (id, product_id, salemodel_id,  is_active, created_at, updated_at) VALUES (UUID(),'",p.id,"','",sm.id,"','Y', now(), now());") as sqlProdSale FROM salemodels sm JOIN products p WHERE p.code='28' AND (TRIM(LOWER(sm.name))) = (TRIM(LOWER('Camion Medallon Completo')));
SELECT CONCAT("INSERT INTO productxsalemodels (id, product_id, salemodel_id,  is_active, created_at, updated_at) VALUES (UUID(),'",p.id,"','",sm.id,"','Y', now(), now());") as sqlProdSale FROM salemodels sm JOIN products p WHERE p.code='29' AND (TRIM(LOWER(sm.name))) = (TRIM(LOWER('Camion Medallon Completo')));
SELECT CONCAT("INSERT INTO productxsalemodels (id, product_id, salemodel_id,  is_active, created_at, updated_at) VALUES (UUID(),'",p.id,"','",sm.id,"','Y', now(), now());") as sqlProdSale FROM salemodels sm JOIN products p WHERE p.code='28' AND (TRIM(LOWER(sm.name))) = (TRIM(LOWER('Camion Medio medallon')));
SELECT CONCAT("INSERT INTO productxsalemodels (id, product_id, salemodel_id,  is_active, created_at, updated_at) VALUES (UUID(),'",p.id,"','",sm.id,"','Y', now(), now());") as sqlProdSale FROM salemodels sm JOIN products p WHERE p.code='29' AND (TRIM(LOWER(sm.name))) = (TRIM(LOWER('Camion Medio medallon')));




# PROVIDERSXPRODUCT
CREATE TABLE IF NOT EXISTS providersxproduct (
id VARCHAR(40) PRIMARY KEY NOT NULL,
provider_id VARCHAR(40) NOT NULL,
product_id VARCHAR(40) NOT NULL,
salemodel_id VARCHAR(40),
product_price INTEGER,
currency VARCHAR(3),
is_active ENUM('N','Y') NOT NULL,
created_at DATETIME NOT NULL,
updated_at DATETIME NOT NULL
);

CREATE INDEX idx_email 
ON users (email(20));

CREATE INDEX idx_email 
ON contacts (contact_email(20));


#PROPOSALS
CREATE TABLE IF NOT EXISTS proposals (
id VARCHAR(40) PRIMARY KEY NOT NULL,
user_id VARCHAR(40) NOT NULL,
advertiser_id VARCHAR(40) NOT NULL,
agency_id VARCHAR(40),
contact_id VARCHAR(40),
status_id TINYINT NOT NULL,
offer_name VARCHAR(40) NOT NULL,
DESCRIPTION TEXT NOT NULL,
start_date DATETIME NOT NULL,
stop_date DATETIME NOT NULL,
is_taxable ENUM('N','Y') NOT NULL,
is_pixel ENUM('N','Y') NOT NULL,
is_active ENUM('N','Y') NOT NULL,
created_at DATETIME NOT NULL,
updated_at DATETIME NOT NULL
);

ALTER TABLE proposals
ADD COLUMN tax_percent_int TINYINT  AFTER is_taxable;

ALTER TABLE proposals
ADD COLUMN office_id VARCHAR(40) AFTER status_id;

# ADDING FK office
ALTER TABLE `proposals`
    ADD CONSTRAINT `fk_proposaloffice` 
	FOREIGN KEY (`office_id`)
    REFERENCES `offices` (`id`);

# ADDING FK contact
ALTER TABLE `proposals`
    ADD CONSTRAINT `fk_proposalcontact` 
	FOREIGN KEY (`contact_id`)
    REFERENCES `contacts` (`id`);

# ADDING FK agency
ALTER TABLE `proposals`
    ADD CONSTRAINT `fk_proposalagency` 
	FOREIGN KEY (`agency_id`)
    REFERENCES `advertisers` (`id`);

# ADDING FK advertiser
ALTER TABLE `proposals`
    ADD CONSTRAINT `fk_proposaladvertiser` 
	FOREIGN KEY (`advertiser_id`)
    REFERENCES `advertisers` (`id`);

# ADDING FK user
ALTER TABLE `proposals`
    ADD CONSTRAINT `fk_proposaluser` 
	FOREIGN KEY (`user_id`)
    REFERENCES `users` (`id`);

# ADDING FK statuses
ALTER TABLE `proposals`
    ADD CONSTRAINT `fk_proposalstatus` 
	FOREIGN KEY (`status_id`)
    REFERENCES `statuses` (`id`);

# VIEWPOINTS
CREATE TABLE IF NOT EXISTS viewpoints (
id VARCHAR(40) PRIMARY KEY NOT NULL,
name VARCHAR(40) NOT NULL,
is_active ENUM('N','Y') NOT NULL,
created_at DATETIME NOT NULL,
updated_at DATETIME NOT NULL
);

INSERT INTO viewpoints (id,name,is_active,created_at,updated_at) 
VALUES 
(UUID(),'Frontal','Y',NOW(),NOW()),
(UUID(),'Cruzada','Y',NOW(),NOW()),
(UUID(),'Natural','Y',NOW(),NOW());

# BILLBOARD
CREATE TABLE IF NOT EXISTS billboards (
id VARCHAR(40) PRIMARY KEY NOT NULL,
name_key VARCHAR(20) UNIQUE NOT NULL,
address TEXT,
state VARCHAR(60),
category VARCHAR(30) NOT NULL,
coordenates VARCHAR(40) NOT NULL,
latitud VARCHAR(40) NOT NULL,
longitud VARCHAR(40) NOT NULL,
price_int BIGINT NOT NULL,
cost_int BIGINT NOT NULL,
width INT NOT NULL,
height INT NOT NULL,
photo VARCHAR(200),
provider_id VARCHAR(40),
salemodel_id VARCHAR(40) NOT NULL,
viewpoint_id VARCHAR(40) NOT NULL,
is_iluminated ENUM('N','Y') NOT NULL,
is_digital ENUM('N','Y') NOT NULL,
is_active ENUM('N','Y') NOT NULL,
created_at DATETIME NOT NULL,
updated_at DATETIME NOT NULL,
INDEX name_key_index (name_key)
);

ALTER TABLE billboards
ADD COLUMN county VARCHAR(60) AFTER state;

ALTER TABLE billboards
ADD COLUMN colony VARCHAR(60) AFTER state;

ALTER TABLE billboards
ADD COLUMN city VARCHAR(60) AFTER state;

ALTER TABLE billboards 
CHANGE state state VARCHAR(60), 
CHANGE colony colony VARCHAR(60), 
CHANGE city city VARCHAR(60), 
CHANGE county county VARCHAR(60);


ALTER TABLE proposalsxproducts  
CHANGE state state VARCHAR(60), 
CHANGE colony colony VARCHAR(60), 
CHANGE city city VARCHAR(60), 
CHANGE county county VARCHAR(60);

ALTER TABLE `billboards` 
CHANGE `name_key` `name_key` VARCHAR(50) NOT NULL; 


# ADDING FK PROVIDER
ALTER TABLE `billboards`
    ADD CONSTRAINT `fk_provider` 
	FOREIGN KEY (`provider_id`)
    REFERENCES `providers` (`id`);

# ADDING FK SALE MODEL
ALTER TABLE `billboards`
    ADD CONSTRAINT `fk_salemodel` 
	FOREIGN KEY (`salemodel_id`)
    REFERENCES `salemodels` (`id`);

# ADDING FK VIEWPOINT
ALTER TABLE `billboards`
    ADD CONSTRAINT `fk_viewpoint` 
	FOREIGN KEY (`viewpoint_id`)
    REFERENCES `viewpoints` (`id`);


INSERT INTO billboards (id,name_key,address,state,category,coordenates,latitud,longitud,price_int,cost_int,width,height,photo,
provider_id,salemodel_id,viewpoint_id,is_iluminated, is_digital, is_active, created_at, updated_at) 
VALUES
(UUID(),'key','address','state','category','coordenates','latitud','longitud',price_int,cost_int,width,height,'photo',provider_id,salemodel_id,viewpoint_id,'is_iluminated','is_digital','Y',now(),now());

/*
     [i]['Tipo'] 			- product_id
     [i]['Clave'] 			- name_key 
     [i]['Dirección']		- address
     [i]['Estado']			- state
     [i]['Vista']			- viewpoint_id
     [i]['Base']			- width
     [i]['Alto']			- height
     [i]['Iluminación']		- is_iluminated
     [i]['Latitud']			- latitud
     [i]['Longitud']		- longitud
     [i]['Tarifa Publicada']- price
     [i]['Categoría (NSE)']	- category
     [i]['Renta']			- cost_int
     [i]['Proveedor']		- provider_id
*/


# PROPOSALS x PRODUCTS
CREATE TABLE IF NOT EXISTS proposalsxproducts (
id VARCHAR(40) PRIMARY KEY NOT NULL,
proposal_id VARCHAR(40),
product_id VARCHAR(40),
salemodel_id VARCHAR(40),
provider_id VARCHAR(40),
state VARCHAR(60),
price_int BIGINT,
currency VARCHAR(3) NOT NULL,
quantity INTEGER,
is_active ENUM('N','Y') NOT NULL,
created_at DATETIME NOT NULL,
updated_at DATETIME NOT NULL
);

#ADDING FIELD notes
ALTER TABLE proposalsxproducts
	ADD column notes TEXT AFTER quantity;


#ADDING FIELD county
ALTER TABLE proposalsxproducts
	ADD column county VARCHAR(60) AFTER state;

#ADDING FIELD city
ALTER TABLE proposalsxproducts
	ADD column city VARCHAR(60) AFTER state;

#ADDING FIELD colony
ALTER TABLE proposalsxproducts
	ADD column colony VARCHAR(60) AFTER state;

#ADDING FIELD production_cost_int
ALTER TABLE proposalsxproducts
	ADD column production_cost_int INTEGER AFTER price_int;

#ADDING FIELDS start_date and stop_date
ALTER TABLE proposalsxproducts 
	ADD start_date DATE NULL DEFAULT NULL AFTER quantity, 
	ADD stop_date DATE NULL DEFAULT NULL AFTER start_date; 

#ADDING FIELD cost_int
ALTER TABLE `proposalsxproducts` 
	ADD `cost_int` BIGINT NULL AFTER `county`; 


# ADDING FK PPPROPOSAL
ALTER TABLE `proposalsxproducts`
    ADD CONSTRAINT `fk_ppproposal_id` 
	FOREIGN KEY (`proposal_id`)
    REFERENCES `proposals` (`id`);

# ADDING FK PPPRODUCT
ALTER TABLE `proposalsxproducts`
    ADD CONSTRAINT `fk_ppproduct_id` 
	FOREIGN KEY (`product_id`)
    REFERENCES `products` (`id`);

# ADDING FK PPSALEMODEL
ALTER TABLE `proposalsxproducts`
    ADD CONSTRAINT `fk_ppsalemodel_id` 
	FOREIGN KEY (`salemodel_id`)
    REFERENCES `salemodels` (`id`);

# ADDING FK PPPROVIDER
ALTER TABLE `proposalsxproducts`
    ADD CONSTRAINT `fk_ppprovider_id` 
	FOREIGN KEY (`provider_id`)
    REFERENCES `providers` (`id`);


# PRODUCTS x BILLBOARDS
CREATE TABLE IF NOT EXISTS productsxbillboards (
id VARCHAR(40) PRIMARY KEY NOT NULL,
proposalproduct_id VARCHAR(40),
billboard_id VARCHAR(40),
price_int BIGINT,
is_active ENUM('N','Y') NOT NULL,
created_at DATETIME NOT NULL,
updated_at DATETIME NOT NULL
);

# ADDING cost_int
ALTER TABLE `productsxbillboards` ADD `cost_int` BIGINT NULL AFTER `billboard_id`; 

# ADDING FK PROPOSALPRODUCT
ALTER TABLE productsxbillboards
    ADD CONSTRAINT fk_proposalproduct_productsxbillboards
	FOREIGN KEY (proposalproduct_id)
    REFERENCES proposalsxproducts (id);

# ADDING FK PROPOSALPRODUCT
ALTER TABLE productsxbillboards
    ADD CONSTRAINT fk_billboard_productsxbillboards 
	FOREIGN KEY (billboard_id)
    REFERENCES billboards (id);



# MODULES
CREATE TABLE modules (
id VARCHAR(40) PRIMARY KEY NOT NULL,
name VARCHAR(20) NOT NULL,
is_active ENUM('N','Y') NOT NULL,
created_at DATETIME NOT NULL,
updated_at DATETIME NOT NULL
);

# LOG HISTORY
CREATE TABLE loghistory (
id VARCHAR(40) PRIMARY KEY NOT NULL,
user_id VARCHAR(40) NOT NULL,
module_name VARCHAR(20) NOT NULL,
description_en TEXT NOT NULL,
description_es TEXT,
description_ptbr TEXT,
user_token VARCHAR(250) NOT NULL,
form_token VARCHAR(250),
created_at DATETIME NOT NULL,
updated_at DATETIME NOT NULL
);

# ADDING FK LOGHISTORYUSER
ALTER TABLE loghistory
    ADD CONSTRAINT fk_loggedaction_user_id
	FOREIGN KEY (user_id)
    REFERENCES users (id);



# TRANSLATES
CREATE TABLE translates (
id VARCHAR(40) PRIMARY KEY NOT NULL,
code_str VARCHAR(40) NOT NULL,
text_eng TEXT NOT NULL,
text_esp TEXT,
text_ptbr TEXT,
is_active ENUM('N','Y') NOT NULL,
created_at DATETIME NOT NULL,
updated_at DATETIME NOT NULL
);

INSERT INTO translates 
(id, code_str, text_eng, text_esp, text_ptbr, is_active, created_at, updated_at)
VALUES
(UUID(), 'only_admin', 'Only admin can select executive', 'Solamente gerentes pueden seleccionar ejecutivos', 'Apenas Administradores podem selecionar Executivos', 'Y', NOW(), NOW()),
(UUID(), 'offer_campaign', 'Offer / Campaign', 'Oferta / Campaña', 'Oferta / Campanha', 'Y', NOW(), NOW()),
(UUID(), 'advertiser', 'Advertiser', 'Cliente', 'Anunciante', 'Y', NOW(), NOW()),
(UUID(), 'assign_executive', 'Assign Executive', 'Ejecutivo', 'Executivo', 'Y', NOW(), NOW()),
(UUID(), 'amount', 'Amount', 'Monto', 'Valor total', 'Y', NOW(), NOW()),
(UUID(), 'monthly', 'Monthly', 'Mensual', 'Mensal', 'Y', NOW(), NOW()),
(UUID(), 'status', 'Status', 'Status', 'Status', 'Y', NOW(), NOW()),
(UUID(), 'settings', 'Settings', 'Configuraciones', 'configurações', 'Y', NOW(), NOW()),
(UUID(), 'list_of_proposals', 'List of Proposals / Goals', 'Lista de propuestas / Metas', 'Lista de propostas / Metas', 'Y', NOW(), NOW()),
(UUID(), 'goals_of_month', 'Goal of the month', 'Metas / Mes:', 'Metas / Mês', 'Y', NOW(), NOW()),
(UUID(), 'total_reached', 'Total Reached', 'Total Alcanzado', 'Total Alcançado', 'Y', NOW(), NOW()),
(UUID(), 'reached', 'Reached', 'Alcanzado', 'Alcançado', 'Y', NOW(), NOW()),
(UUID(), 'dashboard', 'Dashboard', 'Dashboard', 'Dashboard', 'Y', NOW(), NOW()),
(UUID(), 'proposals', 'Proposals', 'Propuestas', 'Propostas', 'Y', NOW(), NOW()),
(UUID(), 'providers', 'Provider', 'Proveedor', 'Provedor', 'Y', NOW(), NOW()),
(UUID(), 'provider', 'Providers', 'Proveedores', 'Provedores', 'Y', NOW(), NOW()),
(UUID(), 'advertisers', 'Advertisers', 'Clientes', 'Anunciantes', 'Y', NOW(), NOW()),
(UUID(), 'user_settings', 'User Settings', 'Configuraciones', 'Configurações', 'Y', NOW(), NOW()),
(UUID(), 'profile', 'Profile', 'Perfil', 'Perfil', 'Y', NOW(), NOW()),
(UUID(), 'change_password', 'Change Password', 'Cambiar contraseña', 'Mudar Senha', 'Y', NOW(), NOW()),
(UUID(), 'users', 'Users', 'Usuários', 'Usuários', 'Y', NOW(), NOW()),
(UUID(), 'logout', 'Logout', 'Salir', 'Sair', 'Y', NOW(), NOW()),
(UUID(), 'lost', 'Lost', 'Perdido', 'Perdido', 'Y', NOW(), NOW()),
(UUID(), 'sent', 'Sent', 'Enviada', 'Enviada', 'Y', NOW(), NOW()),
(UUID(), 'in_negociation', 'In negociation', 'en negociación', 'Em negociação', 'Y', NOW(), NOW()),
(UUID(), 'advanced negociation', 'Advanced negociation', 'Negociación avanzada', 'Negociação Avançada', 'Y', NOW(), NOW()),
(UUID(), 'verbal approval', 'Verbal approval', 'Aprobación verbal', 'Aprovação verbal', 'Y', NOW(), NOW()),
(UUID(), 'approved', 'Approved', 'Aprobado', 'Aprovado', 'Y', NOW(), NOW()),
(UUID(), 'executive', 'Executive', 'Ejecutivo', 'Executivo', 'Y', NOW(), NOW()),
(UUID(), 'january', 'January', 'Enero', 'Janeiro', 'Y', NOW(), NOW()),
(UUID(), 'february', 'February', 'Febrero', 'Fevereiro', 'Y', NOW(), NOW()),
(UUID(), 'march', 'March', 'Marzo', 'Março', 'Y', NOW(), NOW()),
(UUID(), 'april', 'April', 'Abril', 'Abril', 'Y', NOW(), NOW()),
(UUID(), 'may', 'May', 'Mayo', 'Maio', 'Y', NOW(), NOW()),
(UUID(), 'june', 'June', 'Junio', 'Junho', 'Y', NOW(), NOW()),
(UUID(), 'july', 'July', 'Julio', 'Julho', 'Y', NOW(), NOW()),
(UUID(), 'august', 'August', 'Agosto', 'Agosto', 'Y', NOW(), NOW()),
(UUID(), 'september', 'September', 'Septiembre', 'Setembro', 'Y', NOW(), NOW()),
(UUID(), 'octuber', 'Octuber', 'Octubre', 'Outubro', 'Y', NOW(), NOW()),
(UUID(), 'november', 'November', 'Noviembre', 'Novembro', 'Y', NOW(), NOW()),
(UUID(), 'december', 'December', 'Diciembre', 'Dezembro', 'Y', NOW(), NOW()),
(UUID(), 'client', 'Client', 'Cliente', 'Cliente', 'Y', NOW(), NOW()),
(UUID(), 'agency', 'Agency', 'Agencia', 'Agência', 'Y', NOW(), NOW()),
(UUID(), 'offer_name', 'Offer Name', 'Nombre de la campaña', 'Nome da Campanha', 'Y', NOW(), NOW()),
(UUID(), 'description', 'Description', 'Descripción', 'Descrição', 'Y', NOW(), NOW()),
(UUID(), 'start_date', 'Start date', 'Fecha início', 'Data inicial', 'Y', NOW(), NOW()),
(UUID(), 'stop_date', 'Stop date', 'Fecha final', 'Data final', 'Y', NOW(), NOW()),
(UUID(), 'products', 'Products', 'Productos', 'Produtos', 'Y', NOW(), NOW()),
(UUID(), 'product', 'Product', 'Producto', 'Produto', 'Y', NOW(), NOW()),
(UUID(), 'sale_model', 'Sale model', 'Modelo de venta', 'Modelo de venda', 'Y', NOW(), NOW()),
(UUID(), 'digital_product', 'Digital Product', 'Producto Digital', 'Produto Digital', 'Y', NOW(), NOW()),
(UUID(), 'currency', 'Currency', 'Moneda', 'Moeda', 'Y', NOW(), NOW()),
(UUID(), 'unit_price', 'Unit Price', 'Precio Unitario', 'Preço Unitário', 'Y', NOW(), NOW()),
(UUID(), 'quantity', 'Quantity', 'Cantidad', 'Quantidade', 'Y', NOW(), NOW()),
(UUID(), 'total', 'Total', 'Total', 'Total', 'Y', NOW(), NOW()),
(UUID(), 'save', 'save', 'guardar', 'salvar', 'Y', NOW(), NOW()),
(UUID(), 'pixel_required', 'Pixel required', 'Píxel requerido', 'Pixel requerido', 'Y', NOW(), NOW()),
(UUID(), 'proposal', 'Proposal', 'Propuesta', 'Proposta', 'Y', NOW(), NOW()),
(UUID(), 'new', 'New', 'Generando', 'Gerando', 'Y', NOW(), NOW()),
(UUID(), 'please_select', 'Please, select ', 'Por favor, seleccione ', 'Por favor, escolha ', 'Y', NOW(), NOW()),
(UUID(), 'offer_campaign', 'Offer / Campaign', 'Oferta / Campaña', 'Campanha', 'Y', NOW(), NOW());

INSERT INTO translates 
(id, code_str, text_eng, text_esp, text_ptbr, is_active, created_at, updated_at)
VALUES
(UUID(), 'values_in', 'values in', 'montos en', 'valores em', 'Y', NOW(), NOW());

INSERT INTO translates 
(id, code_str, text_eng, text_esp, text_ptbr, is_active, created_at, updated_at)
VALUES
(UUID(), 'unit', 'unit', 'unitario', 'unitário', 'Y', NOW(), NOW());


INSERT INTO translates 
(id, code_str, text_eng, text_esp, text_ptbr, is_active, created_at, updated_at)
VALUES
(UUID(), 'margin', 'margin', 'utilidad', 'margem', 'Y', NOW(), NOW());


INSERT INTO translates 
(id, code_str, text_eng, text_esp, text_ptbr, is_active, created_at, updated_at)
VALUES
(UUID(), 'add', 'New', 'Añadir', 'Adicionar', 'Y', NOW(), NOW());

INSERT INTO translates 
(id, code_str, text_eng, text_esp, text_ptbr, is_active, created_at, updated_at)
VALUES
(UUID(), 'no_keys', 'no keys', 'sin claves', 'sem chaves', 'Y', NOW(), NOW());

INSERT INTO translates 
(id, code_str, text_eng, text_esp, text_ptbr, is_active, created_at, updated_at)
VALUES
(UUID(), 'remove', 'remove', 'quitar', 'excluir', 'Y', NOW(), NOW());

INSERT INTO translates 
(id, code_str, text_eng, text_esp, text_ptbr, is_active, created_at, updated_at)
VALUES
(UUID(), 'to_remove', 'to remove', 'quitar', 'excluir', 'Y', NOW(), NOW());

INSERT INTO translates 
(id, code_str, text_eng, text_esp, text_ptbr, is_active, created_at, updated_at)
VALUES
(UUID(), 'confirm', 'confirm', 'confirma', 'confirma', 'Y', NOW(), NOW());

INSERT INTO translates 
(id, code_str, text_eng, text_esp, text_ptbr, is_active, created_at, updated_at)
VALUES
(UUID(), 'to_confirm', 'to confirm', 'confirmar', 'confirmar', 'Y', NOW(), NOW());

INSERT INTO translates 
(id, code_str, text_eng, text_esp, text_ptbr, is_active, created_at, updated_at)
VALUES
(UUID(), 'on_the_list', 'on the list', 'en la lista', 'na listagem', 'Y', NOW(), NOW());

INSERT INTO translates 
(id, code_str, text_eng, text_esp, text_ptbr, is_active, created_at, updated_at)
VALUES
(UUID(), 'from_the_state_of', 'from the state of', 'del estado de', 'do estado de', 'Y', NOW(), NOW());

INSERT INTO translates 
(id, code_str, text_eng, text_esp, text_ptbr, is_active, created_at, updated_at)
VALUES
(UUID(), 'changes', 'changes', 'cambios', 'alterações', 'Y', NOW(), NOW());

INSERT INTO translates 
(id, code_str, text_eng, text_esp, text_ptbr, is_active, created_at, updated_at)
VALUES
(UUID(), 'list_of', 'list of', 'lista de', 'lista de', 'Y', NOW(), NOW()),
(UUID(), 'of_the_week', 'of the week', 'de la semana', 'da semana', 'Y', NOW(), NOW());


INSERT INTO translates 
(id, code_str, text_eng, text_esp, text_ptbr, is_active, created_at, updated_at)
VALUES
(UUID(), 'active', 'active', 'activo', 'ativo', 'Y', NOW(), NOW());

INSERT INTO translates 
(id, code_str, text_eng, text_esp, text_ptbr, is_active, created_at, updated_at)
VALUES
(UUID(), 'a_v_m', 'an', 'un', 'um', 'Y', NOW(), NOW()),
(UUID(), 'a_v_f', 'an', 'una', 'uma', 'Y', NOW(), NOW()),
(UUID(), 'a_m', 'a', 'un', 'um', 'Y', NOW(), NOW()),
(UUID(), 'a_f', 'a', 'una', 'uma', 'Y', NOW(), NOW());


INSERT INTO translates 
(id, code_str, text_eng, text_esp, text_ptbr, is_active, created_at, updated_at)
VALUES
(UUID(), 'do_you_want', 'do you want', 'quieres', 'gostaria', 'Y', NOW(), NOW()),
(UUID(), 'to_the_m', 'to the', 'para el', 'para o', 'Y', NOW(), NOW()),
(UUID(), 'to_the_f', 'to the', 'para la', 'para a', 'Y', NOW(), NOW());

INSERT INTO translates 
(id, code_str, text_eng, text_esp, text_ptbr, is_active, created_at, updated_at)
VALUES
(UUID(), 'no_address_information', 'no address information', 'no se ha proporcionado ninguna dirección', 'Nenhum endereço informado', 'Y', NOW(), NOW());


INSERT INTO translates 
(id, code_str, text_eng, text_esp, text_ptbr, is_active, created_at, updated_at)
VALUES
(UUID(), 'from_the_list', 'from the list', 'del listado', 'da listagem', 'Y', NOW(), NOW());

INSERT INTO translates 
(id, code_str, text_eng, text_esp, text_ptbr, is_active, created_at, updated_at)
VALUES
(UUID(), 'annual', 'annual', 'anual', 'anual', 'Y', NOW(), NOW());

INSERT INTO translates 
(id, code_str, text_eng, text_esp, text_ptbr, is_active, created_at, updated_at)
VALUES
(UUID(), 'goal', 'goal', 'meta', 'meta', 'Y', NOW(), NOW());



INSERT INTO translates 
(id, code_str, text_eng, text_esp, text_ptbr, is_active, created_at, updated_at)
VALUES
(UUID(), 'continue', 'continue', 'continuar', 'continuar', 'Y', NOW(), NOW());


INSERT INTO translates 
(id, code_str, text_eng, text_esp, text_ptbr, is_active, created_at, updated_at)
VALUES
(UUID(), 'billboard', 'Billboard', 'Cartelera', 'Painel', 'Y', NOW(), NOW());

INSERT INTO translates 
(id, code_str, text_eng, text_esp, text_ptbr, is_active, created_at, updated_at)
VALUES
(UUID(), 'production', 'Production', 'Producción', 'Produção', 'Y', NOW(), NOW());


INSERT INTO translates 
(id, code_str, text_eng, text_esp, text_ptbr, is_active, created_at, updated_at)
VALUES
(UUID(), 'dimensions', 'Dimensions', 'Dimensiones', 'Dimensões', 'Y', NOW(), NOW()),
(UUID(), 'viewpoint', 'View', 'Vista', 'Visão', 'Y', NOW(), NOW()),
(UUID(), 'key', 'Key', 'Clave', 'Chave', 'Y', NOW(), NOW());

INSERT INTO translates 
(id, code_str, text_eng, text_esp, text_ptbr, is_active, created_at, updated_at)
VALUES
(UUID(), 'state', 'State', 'Estado', 'UF', 'Y', NOW(), NOW());

INSERT INTO translates 
(id, code_str, text_eng, text_esp, text_ptbr, is_active, created_at, updated_at)
VALUES
(UUID(), 'upload', 'Upload Invoices', 'Ingressar Facturas', 'Upload de Invoices', 'Y', NOW(), NOW()),
(UUID(), 'upload_files', 'Upload Files', 'Subir Archivos', 'Upload de Arquivos', 'Y', NOW(), NOW()),
(UUID(), 'month', 'Month', 'Mês', 'Mês', 'Y', NOW(), NOW()),
(UUID(), 'search', 'Search', 'Buscar', 'Buscar', 'Y', NOW(), NOW()),
(UUID(), 'payed_at', 'Payed at', 'Fecha de pago', 'Data de Pagamento', 'Y', NOW(), NOW());


INSERT INTO translates 
(id, code_str, text_eng, text_esp, text_ptbr, is_active, created_at, updated_at)
VALUES
(UUID(), 'choose', 'Choose', 'Elejir', 'Escolha', 'Y', NOW(), NOW()),
(UUID(), 'invoice_file', 'Invoice file', 'archivo de Facturas', 'arquivo de Fatura', 'Y', NOW(), NOW()),
(UUID(), 'po_file', 'Purchase Order file', 'archivo de Orden de Compra', 'arquivo de Ordem de Compra', 'Y', NOW(), NOW()),
(UUID(), 'report_file', 'Report file', 'archivo de Report', 'arquivo de Relatório', 'Y', NOW(), NOW()),
(UUID(), 'presentation_file', 'Presentation file', 'archivo de Presentación', 'arquivo de Apresentação', 'Y', NOW(), NOW()),
(UUID(), 'username', 'User Name', 'Nombre del usuario', 'Usuario', 'Y', NOW(), NOW()),
(UUID(), 'email', 'E-Mail', 'Correo', 'Email', 'Y', NOW(), NOW()),
(UUID(), 'mobile_number', 'Mobile Number', 'Teléfono Mobile', 'Celular', 'Y', NOW(), NOW()),
(UUID(), 'password', 'Password', 'Contraseña', 'Senha', 'Y', NOW(), NOW()),
(UUID(), 'retype', 'Retype', 'Volver a escribir', 'Redigite', 'Y', NOW(), NOW()),
(UUID(), 'areacode', 'Area Code', 'Código de AREA', 'Código de Área', 'Y', NOW(), NOW()),
(UUID(), 'number', 'Number', 'Numero', 'Numero', 'Y', NOW(), NOW()),
(UUID(), 'user', 'User', 'Usuario', 'Usuário', 'Y', NOW(), NOW()),
(UUID(), 'offer', 'Offer', 'Campaña', 'Campanha', 'Y', NOW(), NOW()),
(UUID(), 'phone_number', 'Phone Number', 'Teléfono', 'Telefone', 'Y', NOW(), NOW()),
(UUID(), 'product', 'Product', 'Producto', 'Produto', 'Y', NOW(), NOW()),
(UUID(), 'any_to_select', 'Any', 'No hay', 'Nenhum', 'Y', NOW(), NOW()),
(UUID(), 'to_select', 'enable to select', 'disponible para seleccionar', 'disponível para selecionar', 'Y', NOW(), NOW()),
(UUID(), 'files', 'Files', 'Archivos', 'Arquivos', 'Y', NOW(), NOW()),
(UUID(), 'invoices', 'Invoices', 'Facturas', 'Faturas', 'Y', NOW(), NOW()),
(UUID(), 'invoice_number', 'Invoice Number', 'N&ordm; factura', 'N&ordm; fatura', 'Y', NOW(), NOW()),
(UUID(), 'po_number', 'P.O. Number', 'N&ordm; Orden de Compra', 'N&ordm; P.O.', 'Y', NOW(), NOW()),
(UUID(), 'invoice', 'Invoice', 'Factura', 'Fatura', 'Y', NOW(), NOW()),
(UUID(), 'po', 'P.O.', 'Orden de compra', 'Ordem de compra', 'Y', NOW(), NOW()),
(UUID(), 'report', 'Report file', 'Archivo de Report', 'Relatório', 'Y', NOW(), NOW()),
(UUID(), 'presentation', 'Presentation', 'Presentación', 'Apresentação', 'Y', NOW(), NOW()),
(UUID(), 'xml', 'XML file', 'Archivo XML', 'Arquivo XML', 'Y', NOW(), NOW()),
(UUID(), 'invoice_created_at', 'Sent date', 'Fecha del ingresso', 'Data de envio', 'Y', NOW(), NOW()),
(UUID(), 'payed_amount', 'Amount payed', 'Monto pagado', 'Total pago', 'Y', NOW(), NOW()),
(UUID(), 'xml_file', 'XML file (Only for MEX)', 'archivo XML (Solo para MEX)', 'arquivo XML (Apenas para MEX)', 'Y', NOW(), NOW()),
(UUID(), 'year', 'Year', 'Año', 'Ano', 'Y', NOW(), NOW());


INSERT INTO translates 
(id, code_str, text_eng, text_esp, text_ptbr, is_active, created_at, updated_at)
VALUES
(UUID(), 'waiting_approval', 'Waiting for approval', 'A la espera de aprobación', 'Aguardando aprovação', 'Y', NOW(), NOW()),
(UUID(), 'send_user_crt_url_to', 'Send user creation link to', 'Enviar la liga de creación del usuario para', 'Enviar link de criação de usuário para', 'Y', NOW(), NOW()),
(UUID(), 'copy_user_crt_url', 'Copy user creation link', 'Copiar liga de creación del usuario', 'Copiar link de criação de usuário', 'Y', NOW(), NOW()),
(UUID(), 'copied_to_clipboard', 'copied to clipboard', 'copiado al portapapeles', 'copiado para a área de transferência', 'Y', NOW(), NOW()),
(UUID(), 'deny_files', 'deny files', 'negar archivos', 'negar arquivos', 'Y', NOW(), NOW()),
(UUID(), 'approve_files', 'approve files', 'aprobar archivos', 'aprovar arquivos', 'Y', NOW(), NOW()),
(UUID(), 'send_message', 'Send message', 'Enviar mensaje', 'Enviar mensagem', 'Y', NOW(), NOW()),
(UUID(), 'close', 'Close', 'Cerrar', 'Fechar', 'Y', NOW(), NOW()),
(UUID(), 'motive', 'Motive', 'Motivo', 'Motivo', 'Y', NOW(), NOW()),
(UUID(), 'save_without_payment', 'Save without pay', 'grabar sin pago', 'Gravar sem pagar', 'Y', NOW(), NOW()),
(UUID(), 'approval_only', 'approval only', 'solo aprobacción', 'apenas aprovação', 'Y', NOW(), NOW()),
(UUID(), 'payment_date', 'Payment date', 'Fecha de pago', 'Data de pagamento', 'Y', NOW(), NOW()),
(UUID(), 'pay_invoice', 'pay invoice', 'pagar factura', 'pagar fatura', 'Y', NOW(), NOW()),
(UUID(), 'pay', 'pay', 'pagar', 'pagar', 'Y', NOW(), NOW()),
(UUID(), 'paid', 'paid', 'pagada', 'paga', 'Y', NOW(), NOW()),
(UUID(), 'parcial_paid', 'parcial paid', 'pagada parcial', 'paga parcialmente', 'Y', NOW(), NOW()),
(UUID(), 'invoice_approved', 'Invoice approved', 'factura aprobada', 'fatura aprovada', 'Y', NOW(), NOW()),
(UUID(), 'invoice_amount', 'invoice amount', 'monto de la factura', 'valor da fatura', 'Y', NOW(), NOW()),
(UUID(), 'approval_denied', 'approval denied', 'aprobación negada', 'aprovação negada', 'Y', NOW(), NOW()),
(UUID(), 'no_id_information', 'no ID information', 'no hay información del ID', 'sem informação de ID', 'Y', NOW(), NOW()),
(UUID(), 'no_user_information', 'no user information', 'no hay información del usuario', 'sem informação de usuário', 'Y', NOW(), NOW()),
(UUID(), 'no_token_information', 'no token information', 'no hay información de la clave del usuario', 'sem informação de token de usuário', 'Y', NOW(), NOW()),
(UUID(), 'no_newstatus_information', 'no new status information', 'no hay información del nuevo status', 'sem informação de novo status', 'Y', NOW(), NOW()),
(UUID(), 'no_status_information', 'no status information', 'no hay información del status', 'sem informação de status', 'Y', NOW(), NOW()),
(UUID(), 'no_motive_information', 'motive must be a string with more than 20 characters', 'el motivo hay de tener 20 caracteres o más', 'motivo precisa ter 20 caracteres ou mais', 'Y', NOW(), NOW()),
(UUID(), 'no_currency_information', 'no currency information', 'no hay información de la moneda', 'sem informação de moeda', 'Y', NOW(), NOW()),
(UUID(), 'no_paidamount_information', 'no paid amount information', 'no hay información del monto pagado', 'sem informação do valor pago', 'Y', NOW(), NOW()),
(UUID(), 'no_paymentdate_information', 'no payment date information', 'no hay información de la fecha de pago', 'sem informação da data de pagamento', 'Y', NOW(), NOW()),


INSERT INTO translates 
(id, code_str, text_eng, text_esp, text_ptbr, is_active, created_at, updated_at)
VALUES
(UUID(), 'offer_period', 'Offer period', 'Periodo de la campaña', 'Período da campanha', 'Y', NOW(), NOW()),
(UUID(), 'yyyy/mm/dd', 'yyyy/mm/dd', 'aaaa/mm/dd', 'aaaa/mm/dd', 'Y', NOW(), NOW()),
(UUID(), 'format', 'format', 'formato', 'formato', 'Y', NOW(), NOW()),
(UUID(), 'from_invoice', 'from invoice', 'de la factura', 'da fatura', 'Y', NOW(), NOW());

INSERT INTO translates 
(id, code_str, text_eng, text_esp, text_ptbr, is_active, created_at, updated_at)
VALUES
(UUID(), 'gnog_office', 'In GNog Office of', 'En Oficina GNog de', 'Em Escritório GNog de', 'Y', NOW(), NOW());

INSERT INTO translates 
(id, code_str, text_eng, text_esp, text_ptbr, is_active, created_at, updated_at)
VALUES
(UUID(), 'on_map', 'on map', 'en el mapa', 'no mapa', 'Y', NOW(), NOW()),
(UUID(), 'add+', 'add', 'añadir', 'adicionar', 'Y', NOW(), NOW());

INSERT INTO translates 
(id, code_str, text_eng, text_esp, text_ptbr, is_active, created_at, updated_at)
VALUES
(UUID(), 'finanzas', 'financial', 'financiero', 'financeiro', 'Y', NOW(), NOW()),
(UUID(), 'language', 'language', 'idioma', 'idioma', 'Y', NOW(), NOW()),
(UUID(), 'user_type', 'user type', 'tipo de usuario', 'tipo de usuário', 'Y', NOW(), NOW());

INSERT INTO translates 
(id, code_str, text_eng, text_esp, text_ptbr, is_active, created_at, updated_at)
VALUES
(UUID(), 'message', 'message', 'mensaje', 'mensagem', 'Y', NOW(), NOW());

INSERT INTO translates 
(id, code_str, text_eng, text_esp, text_ptbr, is_active, created_at, updated_at)
VALUES
(UUID(), '0_proposals', 'Providers is not working in anyone proposal', 'Proveedor no estás trabajando en ninguna propuesta', 'Provedor não está trabalhando em nenhuma proposta', 'Y', NOW(), NOW());

INSERT INTO translates 
(id, code_str, text_eng, text_esp, text_ptbr, is_active, created_at, updated_at)
VALUES
(UUID(), 'is_taxable', 'is taxable', 'taxable', 'com taxas', 'Y', NOW(), NOW()),
(UUID(), 'corporate_name', 'corporate name', 'nombre corporativo', 'Razão Social', 'Y', NOW(), NOW()),
(UUID(), 'is_agency', 'is agency', 'es agencia', 'é agência', 'Y', NOW(), NOW()),
(UUID(), 'making_banners', 'making banners', 'hace impressiones', 'faz impressões', 'Y', NOW(), NOW());

INSERT INTO translates 
(id, code_str, text_eng, text_esp, text_ptbr, is_active, created_at, updated_at)
VALUES
(UUID(), 'address', 'address', 'dirección', 'endereço', 'Y', NOW(), NOW());

INSERT INTO translates 
(id, code_str, text_eng, text_esp, text_ptbr, is_active, created_at, updated_at)
VALUES
(UUID(), 'contact', 'contact', 'contacto', 'contato', 'Y', NOW(), NOW()),
(UUID(), 'city', 'city', 'ciudad', 'cidade', 'Y', NOW(), NOW()),
(UUID(), 'county', 'county', 'alcaldía / municipio', 'município', 'Y', NOW(), NOW()),
(UUID(), 'colony', 'colony', 'colonia', 'colonia', 'Y', NOW(), NOW());

INSERT INTO translates 
(id, code_str, text_eng, text_esp, text_ptbr, is_active, created_at, updated_at)
VALUES
(UUID(), 'all_places', 'all', 'todo', 'tudo', 'Y', NOW(), NOW());


INSERT INTO translates 
(id, code_str, text_eng, text_esp, text_ptbr, is_active, created_at, updated_at)
VALUES
(UUID(), 'edit', 'edit', 'editar', 'editar', 'Y', NOW(), NOW());

INSERT INTO translates 
(id, code_str, text_eng, text_esp, text_ptbr, is_active, created_at, updated_at)
VALUES
(UUID(), 'change', 'change', 'cambiar', 'trocar', 'Y', NOW(), NOW());


INSERT INTO translates 
(id, code_str, text_eng, text_esp, text_ptbr, is_active, created_at, updated_at)
VALUES
(UUID(), 'category', 'category', 'categoria', 'categoria', 'Y', NOW(), NOW()),
(UUID(), 'coordenates', 'coordenates', 'coordenadas', 'coordenadas', 'Y', NOW(), NOW()),
(UUID(), 'is_iluminated', 'is iluminated', 'es iluminado', 'é iluminado', 'Y', NOW(), NOW()),
(UUID(), 'webpage', 'webpage (URL)', 'liga (URL)', 'link (URL)', 'Y', NOW(), NOW());

INSERT INTO translates 
(id, code_str, text_eng, text_esp, text_ptbr, is_active, created_at, updated_at)
VALUES
(UUID(), 'price', 'price', 'precio', 'preço', 'Y', NOW(), NOW()),
(UUID(), 'cost', 'cost', 'costo', 'custo', 'Y', NOW(), NOW());

INSERT INTO translates 
(id, code_str, text_eng, text_esp, text_ptbr, is_active, created_at, updated_at)
VALUES
(UUID(), 'is_not_iluminated', 'is not iluminated', 'no hay iluminación', 'sem iluminação', 'Y', NOW(), NOW());


INSERT INTO translates 
(id, code_str, text_eng, text_esp, text_ptbr, is_active, created_at, updated_at)
VALUES
(UUID(), 'is_not_digital', 'is not digital', 'no es digital', 'não é digital', 'Y', NOW(), NOW()),
(UUID(), 'is_digital', 'is digital', 'es digital', 'é digital', 'Y', NOW(), NOW());

INSERT INTO translates 
(id, code_str, text_eng, text_esp, text_ptbr, is_active, created_at, updated_at)
VALUES
(UUID(), 'all', 'all', 'todos', 'todos', 'Y', NOW(), NOW());

INSERT INTO translates 
(id, code_str, text_eng, text_esp, text_ptbr, is_active, created_at, updated_at)
VALUES
(UUID(), '0_results', 'no results found', 'no hay resultados', 'Sem resultados', 'Y', NOW(), NOW());

INSERT INTO translates 
(id, code_str, text_eng, text_esp, text_ptbr, is_active, created_at, updated_at)
VALUES
(UUID(), 'name_of_m', 'name of', 'nombre del', 'nome do', 'Y', NOW(), NOW()),
(UUID(), 'name_of_f', 'name of', 'nombre del la', 'nome da', 'Y', NOW(), NOW()),
(UUID(), 'name', 'name', 'nombre', 'nome', 'Y', NOW(), NOW());


INSERT INTO translates 
(id, code_str, text_eng, text_esp, text_ptbr, is_active, created_at, updated_at)
VALUES
(UUID(), 'unique_date', 'unique event', 'evento unico', 'evento único', 'Y', NOW(), NOW());

INSERT INTO translates 
(id, code_str, text_eng, text_esp, text_ptbr, is_active, created_at, updated_at)
VALUES
(UUID(), 'fill', 'fill', 'complete', 'preencha', 'Y', NOW(), NOW()),
(UUID(), 'first', 'first', 'primero', 'primeiro', 'Y', NOW(), NOW());

INSERT INTO translates 
(id, code_str, text_eng, text_esp, text_ptbr, is_active, created_at, updated_at)
VALUES
(UUID(), 'event_date', 'event date', 'fecha del evento', 'data do evento', 'Y', NOW(), NOW());


# FILES
CREATE TABLE IF NOT EXISTS files (
id VARCHAR(40) PRIMARY KEY NOT NULL,
file_location VARCHAR(240) NOT NULL,
file_name VARCHAR(240) NOT NULL,
file_type VARCHAR(40) NOT NULL,
invoice_id VARCHAR(40),
user_id VARCHAR(40) NOT NULL,
description TEXT,
is_active ENUM('N','Y') NOT NULL,
created_at DATETIME NOT NULL,
updated_at DATETIME NOT NULL
);

# INVOICES
CREATE TABLE IF NOT EXISTS invoices (
id VARCHAR(40) PRIMARY KEY NOT NULL,
provider_id VARCHAR(40) NOT NULL,
invoice_number VARCHAR(40) NOT NULL,
invoice_amount_int INTEGER NOT NULL,
invoice_amount_paid_int INTEGER,
invoice_amount_currency VARCHAR(3),
invoice_last_payment_date DATE,
invoice_month VARCHAR(2) NOT NULL,
invoice_year VARCHAR(4) NOT NULL,
order_number VARCHAR(40),
proposalproduct_id VARCHAR(40),
invoice_status VARCHAR(200),
is_active ENUM('N','Y') NOT NULL,
created_at DATETIME NOT NULL,
updated_at DATETIME NOT NULL
);

# ADDING FK USER
ALTER TABLE files
    ADD CONSTRAINT fk_user 
	FOREIGN KEY (user_id)
    REFERENCES users (id);

# ADDING FK INVOICE
ALTER TABLE files
    ADD CONSTRAINT fk_invoice 
	FOREIGN KEY (invoice_id)
    REFERENCES invoices (id);


# ADDING FK CURRENCY
ALTER TABLE invoices
    ADD CONSTRAINT fk_currency 
	FOREIGN KEY (invoice_amount_currency)
    REFERENCES currencies (id);

# ADDING FK PROPOSALPRODUCT
ALTER TABLE invoices
    ADD CONSTRAINT fk_proposalproduct 
	FOREIGN KEY (proposalproduct_id)
    REFERENCES proposalsxproducts (id);

# ADDING FK PROVIDER
ALTER TABLE invoices
    ADD CONSTRAINT fk_providerInvoice 
	FOREIGN KEY (provider_id)
    REFERENCES providers (id);

