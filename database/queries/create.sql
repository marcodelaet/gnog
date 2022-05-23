
/***********************************
 GNOG DB ACCESS
 user: it_gnog
 pwd: GN0g&tM@rco2o22

secondary: it_gnog_reader
pwd: GN0gR&@d&r

123456: e10adc3949ba59abbe56e057f20f883e
***********************************/

CREATE DATABASE IF NOT EXISTS gnogcrm_db;

SELECT LEFT(UUID,13) AS UUID, UUID AS uuid_full, product_id, product_name, salemodel_id, salemodel_name, product_price, currency, NAME, address, webpage_url, CONCAT(contact_name,' ', contact_surname,' (', contact_email,')') AS contact, contact_name, contact_surname, contact_email, contact_position, phone_international_code, phone_prefix, phone_number, CONCAT('+',phone_international_code,phone_number) AS phone, is_active FROM view_providers ORDER BY NAME;

USE gnogcrm_db;

# CURRENCIES
CREATE TABLE IF NOT EXISTS currencies (
id VARCHAR(3) PRIMARY KEY NOT NULL UNIQUE,
rate FLOAT NOT NULL,
orderby TINYINT,
is_active ENUM('N','Y') NOT NULL,
created_at DATETIME NOT NULL,
updated_at DATETIME NOT NULL
);

# USERS
CREATE TABLE IF NOT EXISTS users (
id VARCHAR(40) PRIMARY KEY NOT NULL UNIQUE,
username VARCHAR(20) NOT NULL UNIQUE,
email VARCHAR(60) NOT NULL,
level_account INT NOT NULL,
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


# VIEW USERS
CREATE VIEW view_users AS (
	SELECT
	(id) AS UUID,
	username,
	email,
	level_account,
	mobile_international_code,
	mobile_prefix,
	mobile_number,
	CONCAT('+',mobile_international_code,mobile_prefix,mobile_number) AS mobile,
	token,
	account_locked,
	CONCAT((id),username,email,'+',mobile_international_code,mobile_number) AS search
	FROM 
	users
);

# INSERTING USER
INSERT INTO users (id, username, email,mobile_international_code, mobile_prefix,mobile_number,authentication_string,password_last_changed,account_locked,created_at,updated_at) VALUES (UUID(),'marcodelaet','it@gnog.com.br','55','11','11989348999','e10adc3949ba59abbe56e057f20f883e',NOW(),'N',NOW(),NOW());


# GOAL
CREATE TABLE IF NOT EXISTS `goals` (
id VARCHAR(40) PRIMARY KEY NOT NULL UNIQUE,
user_id VARCHAR(40) NOT NULL,
goal_month VARCHAR(2) NOT NULL,
goal_year VARCHAR(4) NOT NULL,
currency_id VARCHAR(3) NOT NULL,
goal_amount BIGINT NOT NULL,
created_at DATETIME NOT NULL,
updated_at DATETIME NOT NULL
);

# VIEW GOALS
CREATE VIEW view_goals AS (
	SELECT
	u.username,
	(g.user_id) AS UUID,
	g.goal_amount,
	g.goal_month,
	g.goal_year,
	g.currency_id,
	(g.goal_amount / c.rate) AS goal_dolar
	
	FROM 
	goals g
	INNER JOIN users u 
	ON g.user_id = u.id
	INNER JOIN currencies c 
	ON c.id = g.currency_id
);

SELECT *, SUM(goal_amount) AS total_amount FROM view_goals WHERE goal_month = 4 GROUP BY goal_year;

# PROFILES
CREATE TABLE IF NOT EXISTS `profiles` (
id VARCHAR(40) PRIMARY KEY NOT NULL UNIQUE,
user_id VARCHAR(40),
photo VARCHAR(200),
country VARCHAR(3),
aboutme TEXT,
created_at DATETIME NOT NULL,
updated_at DATETIME NOT NULL
);

# TOKENS
CREATE TABLE IF NOT EXISTS `tokens` (
id VARCHAR(40) PRIMARY KEY NOT NULL UNIQUE,
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
id VARCHAR(40) PRIMARY KEY NOT NULL UNIQUE,
corporate_name VARCHAR(40) NOT NULL UNIQUE,
address	TEXT NOT NULL,
is_agency ENUM('N','Y') NOT NULL,
is_active ENUM('N','Y') NOT NULL,
created_at DATETIME NOT NULL,
updated_at DATETIME NOT NULL
);

# CONTACTS
CREATE TABLE IF NOT EXISTS contacts (
id VARCHAR(40) PRIMARY KEY NOT NULL UNIQUE,
module_name VARCHAR(40) NOT NULL, # advertiser / provider
contact_name VARCHAR(20) NOT NULL,
contact_surname VARCHAR(20),
contact_email VARCHAR(60) NOT NULL,
contact_position VARCHAR(20),
contact_client_id VARCHAR(40),
phone_international_code VARCHAR(3),
phone_prefix VARCHAR(3),
phone_number VARCHAR(12),
is_active ENUM('N','Y') NOT NULL,
created_at DATETIME NOT NULL,
updated_at DATETIME NOT NULL
);

# drop view view_advertisers;

# VIEW CONTACTS - ADVERTISER
CREATE VIEW view_advertisercontacts AS (
SELECT 
	id AS contact_id,
	contact_name,
	contact_surname,
	contact_email,
	contact_position,
	contact_client_id,
	phone_international_code,
	phone_prefix,
	phone_number
	FROM contacts
	WHERE module_name = 'advertiser' AND is_active='Y'
);

# VIEW CONTACTS - PROVIDER
CREATE VIEW view_providercontacts AS (
SELECT 
	id AS contact_id,
	contact_name,
	contact_surname,
	contact_email,
	contact_position,
	contact_client_id,
	phone_international_code,
	phone_prefix,
	phone_number
	FROM contacts
	WHERE module_name = 'provider' AND is_active='Y'
);

# VIEW ADVERTISERS
CREATE VIEW view_advertisers AS (
	SELECT
	(adv.id) AS UUID,
	ct.contact_id,
	adv.corporate_name,
	adv.address,
	ct.contact_name,
	ct.contact_surname,
	ct.contact_email,
	ct.contact_position,
	ct.contact_client_id,
	ct.phone_international_code,
	ct.phone_prefix,
	ct.phone_number,
	CONCAT('+',ct.phone_international_code,ct.phone_prefix,ct.phone_number) AS phone,
	adv.is_agency,
	adv.is_active,
	CONCAT((adv.id),adv.corporate_name,ct.contact_name,ct.contact_surname,ct.contact_email,'+',ct.phone_international_code,ct.phone_number) AS search
	FROM 
	advertisers adv
	LEFT JOIN view_advertisercontacts ct ON ct.contact_client_id = adv.id
);

SELECT * FROM view_advertisercontacts;

SELECT LEFT(UUID,13)AS UUID, UUID AS uuid_full, 
COUNT(contact_client_id) AS qty_contact, 
corporate_name, address, CONCAT(contact_name,' ',contact_surname,' (', contact_email,')') AS contact, contact_name, contact_surname, contact_email, contact_position, phone_international_code, phone_prefix, phone_number, is_agency, is_active, CONCAT('+',phone_international_code,phone_number) AS phone 
FROM view_advertisers 
#
GROUP BY UUID
ORDER BY corporate_name ;

SELECT * FROM view_advertisers;

# PRODUCTS
CREATE TABLE IF NOT EXISTS products (
id VARCHAR(40) PRIMARY KEY NOT NULL UNIQUE,
NAME VARCHAR(40) NOT NULL,
DESCRIPTION TEXT,
is_digital ENUM('N','Y') NOT NULL,
is_active ENUM('N','Y') NOT NULL,
created_at DATETIME NOT NULL,
updated_at DATETIME NOT NULL
);

# INSERTING DATAS IN PRODUCTS TABLE
INSERT INTO products (id,NAME,DESCRIPTION,is_digital,is_active,created_at,updated_at) 
VALUES 
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
((UUID()),'OOH','OOH','N','Y',NOW(),NOW());

#STATUSES
CREATE TABLE IF NOT EXISTS statuses (
id TINYINT PRIMARY KEY NOT NULL UNIQUE AUTO_INCREMENT,
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
id VARCHAR(40) PRIMARY KEY NOT NULL UNIQUE,
NAME VARCHAR(40) NOT NULL,
DESCRIPTION TEXT,
is_digital ENUM('N','Y') NOT NULL,
is_active ENUM('N','Y') NOT NULL,
created_at DATETIME NOT NULL,
updated_at DATETIME NOT NULL
);

# INSERTING DATAS IN SALEMODELS TABLE
INSERT INTO salemodels (id,NAME,DESCRIPTION,is_digital,is_active,created_at,updated_at) 
VALUES 
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
((UUID()),'Pantallas','Pantallas','N','Y',NOW(),NOW());

# PROVIDERS
CREATE TABLE IF NOT EXISTS providers (
id VARCHAR(40) PRIMARY KEY NOT NULL UNIQUE,
NAME VARCHAR(40) NOT NULL UNIQUE,
address	TEXT,
webpage_url VARCHAR(200),
is_active ENUM('N','Y') NOT NULL,
created_at DATETIME NOT NULL,
updated_at DATETIME NOT NULL
);


# PROVIDERSXPRODUCT
CREATE TABLE IF NOT EXISTS providersxproduct (
id VARCHAR(40) PRIMARY KEY NOT NULL UNIQUE,
provider_id VARCHAR(40) NOT NULL,
product_id VARCHAR(40) NOT NULL,
salemodel_id VARCHAR(40),
product_price INTEGER,
currency VARCHAR(3),
is_active ENUM('N','Y') NOT NULL,
created_at DATETIME NOT NULL,
updated_at DATETIME NOT NULL
);


# VIEW PROVIDERS
CREATE VIEW view_providers AS (
	SELECT
	(pv.id) AS UUID,
	(pp.product_id) AS product_id,
	pd.name AS product_name,
	(pp.salemodel_id) AS salemodel_id,
	sm.name AS salemodel_name,
	pp.product_price / 100 AS product_price,
	pp.product_price AS product_price_int,
	pp.currency,
	pv.name,
	pv.webpage_url,
	pv.address,
	ct.contact_id AS contact_provider_id,
	ct.contact_name,
	ct.contact_surname,
	ct.contact_email,
	ct.contact_position,
	ct.phone_international_code,
	ct.phone_prefix,
	ct.phone_number,
	CONCAT('+',ct.phone_international_code,ct.phone_prefix,ct.phone_number) AS phone,
	pv.is_active,
	CONCAT((pv.id),pd.name,sm.name,pv.name,pv.webpage_url,ct.contact_name,ct.contact_surname,ct.contact_email,'+',ct.phone_international_code,ct.phone_number) AS search
	FROM 
	providers pv
	LEFT JOIN providersxproduct pp ON pp.provider_id = pv.id
	LEFT JOIN products pd ON pd.id = pp.product_id
	LEFT JOIN salemodels sm ON sm.id = pp.salemodel_id
	LEFT JOIN ( 
	SELECT 
	id AS contact_id,
	contact_name,
	contact_surname,
	contact_email,
	contact_position,
	contact_client_id,
	phone_international_code,
	phone_prefix,
	phone_number
	FROM contacts
	WHERE module_name = 'provider' AND is_active='Y'
	) AS ct 
	ON ct.contact_client_id = pv.id
);

#PROPOSALS
CREATE TABLE IF NOT EXISTS proposals (
id VARCHAR(40) PRIMARY KEY NOT NULL UNIQUE,
user_id VARCHAR(40) NOT NULL,
advertiser_id VARCHAR(40) NOT NULL,
agency_id VARCHAR(40),
contact_id VARCHAR(40),
status_id TINYINT NOT NULL,
offer_name VARCHAR(40) NOT NULL,
DESCRIPTION TEXT NOT NULL,
start_date DATETIME NOT NULL,
stop_date DATETIME NOT NULL,
is_pixel  ENUM('N','Y') NOT NULL,
is_active ENUM('N','Y') NOT NULL,
created_at DATETIME NOT NULL,
updated_at DATETIME NOT NULL
);



# PROPOSALS x PRODUCTS
CREATE TABLE IF NOT EXISTS proposalsxproducts (
id VARCHAR(40) PRIMARY KEY NOT NULL UNIQUE,
proposal_id VARCHAR(40),
product_id VARCHAR(40),
salemodel_id VARCHAR(40),
provider_id VARCHAR(40),
price BIGINT,
currency VARCHAR(3) NOT NULL,
quantity INTEGER,
is_active ENUM('N','Y') NOT NULL,
created_at DATETIME NOT NULL,
updated_at DATETIME NOT NULL
);

SELECT UUID,offer_name FROM view_proposals WHERE offer_name = 'Nissan - INFINITI, prueba programmatic' AND client_id = 'd15b0b10-d2e8-11ec-ae10-6c0b8496fec0' AND DESCRIPTION = 'El objetivo de la marca es tráfico al sitio, sobre esto hay que cubrir un mínimo de 44,500 visitas al sitio por mes y descargas de KBAs ( Lead Book a Test Drive Visits, Lead, Request a Quote Visti, Download Visits, Dealers Search Visits)Los formatos que normalmente se activan son Display y Native.';


# VIEW PROPOSALS
CREATE VIEW view_proposals AS (
	SELECT
	(pps.id) AS UUID,
	(ppp.product_id) AS product_id,
	pd.name AS product_name,
	(ppp.salemodel_id) AS salemodel_id,
	sm.name AS salemodel_name,
	(ppp.provider_id) AS provider_id,
	pv.name AS provider_name,
	(pps.user_id) AS user_id,
	u.username,
	(pps.advertiser_id) AS client_id,
	adv.corporate_name AS client_name,
	(pps.agency_id) AS agency_id,
	age.corporate_name AS agency_name,
	pps.status_id,
	s.name AS status_name,
	s.percent AS status_percent,
	pps.offer_name,
	pps.description,
	pps.start_date,
	pps.stop_date,
	TIMESTAMPDIFF(MONTH, start_date, stop_date) + 1 AS month_diff_data, 
	ppp.price / 100 AS price,
	ppp.price AS price_int,
	ppp.currency,
	ppp.quantity,
	c.rate AS rate,
	c.id AS currency_c,
	(ppp.price * ppp.quantity) AS amount_int,
	(ppp.price * ppp.quantity) / 100 AS amount,
	((ppp.price * ppp.quantity) / c.rate) AS amount_dolar_int,
	((ppp.price * ppp.quantity) / c.rate) / 100 AS amount_dolar,
	((ppp.price * ppp.quantity) / (TIMESTAMPDIFF(MONTH, start_date, stop_date) + 1)) AS amount_per_month_int,
	((ppp.price * ppp.quantity) / (TIMESTAMPDIFF(MONTH, start_date, stop_date) + 1)) / 100 AS amount_per_month,
	(((ppp.price * ppp.quantity) / c.rate) / (TIMESTAMPDIFF(MONTH, start_date, stop_date) + 1)) AS amount_per_month_dolar_int,
	(((ppp.price * ppp.quantity) / c.rate) / (TIMESTAMPDIFF(MONTH, start_date, stop_date) + 1)) / 100 AS amount_per_month_dolar,
	pps.is_pixel,
	pps.is_active,
	CONCAT((pps.id),pd.name,sm.name,pv.name,u.username,adv.corporate_name,pps.offer_name,ppp.currency) AS search
	FROM 
	proposals pps
	LEFT JOIN proposalsxproducts ppp ON ppp.proposal_id = pps.id
	LEFT JOIN products pd ON pd.id = ppp.product_id
	LEFT JOIN salemodels sm ON sm.id = ppp.salemodel_id
	LEFT JOIN providers pv ON pv.id = ppp.provider_id
	LEFT JOIN currencies c ON c.id = ppp.currency
	INNER JOIN statuses s ON s.id = pps.status_id
	INNER JOIN users u ON u.id = pps.user_id
	INNER JOIN advertisers adv ON adv.id = pps.advertiser_id
	LEFT JOIN advertisers age ON age.id = pps.agency_id
);


SELECT TIMESTAMPDIFF(MONTH, start_date, stop_date) FROM view_proposals;

# MODULES
CREATE TABLE modules (
id VARCHAR(40) PRIMARY KEY NOT NULL UNIQUE,
NAME VARCHAR(20) NOT NULL,
is_active ENUM('N','Y') NOT NULL,
created_at DATETIME NOT NULL,
updated_at DATETIME NOT NULL
);

# LOG HISTORY
CREATE TABLE loghistory (
id VARCHAR(40) PRIMARY KEY NOT NULL UNIQUE,
user_id VARCHAR(40) NOT NULL,
module_name VARCHAR(20) NOT NULL,
DESCRIPTION TEXT NOT NULL,
user_token VARCHAR(250) NOT NULL,
form_token VARCHAR(250),
created_at DATETIME NOT NULL,
updated_at DATETIME NOT NULL
);


SELECT UUID,product_id,product_name,salemodel_id,salemodel_name,provider_id,provider_name,user_id,username,client_id,client_name,agency_id,agency_name,status_id,status_name,status_percent,offer_name,DESCRIPTION,start_date,stop_date,month_diff_data,SUM(amount) AS amount,SUM(amount_int) AS amount_int, SUM(amount_per_month) AS amount_per_month, SUM(amount_per_month_int) AS amount_per_month_int, currency,quantity,is_active FROM view_proposals WHERE user_id = '49381e2d-787b-11ec-81fa-6c0b8496fec0' AND (stop_date >= '2022-2-24' AND start_date <= '2022-2-24')  GROUP BY UUID;