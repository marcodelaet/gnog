
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


# CURRENCIES
CREATE TABLE IF NOT EXISTS currencies (
id VARCHAR(3) PRIMARY KEY NOT NULL UNIQUE,
rate FLOAT NOT NULL,
is_active ENUM('N','Y') NOT NULL,
created_at DATETIME NOT NULL,
updated_at DATETIME NOT NULL
);

# USERS
CREATE TABLE IF NOT EXISTS users (
id VARCHAR(40) PRIMARY KEY NOT NULL UNIQUE,
username VARCHAR(20) NOT NULL UNIQUE,
email VARCHAR(60) NOT NULL,
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
main_contact_name VARCHAR(20) NOT NULL,
main_contact_surname VARCHAR(20),
main_contact_email VARCHAR(60) NOT NULL,
main_contact_position VARCHAR(20) NOT NULL,
main_contact_client_id VARCHAR(40),
phone_international_code VARCHAR(3),
phone_prefix VARCHAR(3),
phone_number VARCHAR(12),
is_agency ENUM('N','Y') NOT NULL,
is_active ENUM('N','Y') NOT NULL,
created_at DATETIME NOT NULL,
updated_at DATETIME NOT NULL
);

# CONTACTS
CREATE TABLE IF NOT EXISTS contacts (
id VARCHAR(40) PRIMARY KEY NOT NULL UNIQUE,
advertiser_id VARCHAR(40),
provider_id VARCHAR(40),
main_contact_name VARCHAR(20) NOT NULL,
main_contact_surname VARCHAR(20),
main_contact_email VARCHAR(60) NOT NULL,
main_contact_position VARCHAR(20) NOT NULL,
main_contact_client_id VARCHAR(40),
phone_international_code VARCHAR(3),
phone_prefix VARCHAR(3),
phone_number VARCHAR(12),
is_active ENUM('N','Y') NOT NULL,
created_at DATETIME NOT NULL,
updated_at DATETIME NOT NULL
);

# drop view view_advertisers;

# VIEW ADVERTISERS
CREATE VIEW view_advertisers AS (
	SELECT
	(adv.id) AS UUID,
	adv.corporate_name,
	adv.address,
	adv.main_contact_name,
	adv.main_contact_surname,
	adv.main_contact_email,
	adv.main_contact_position,
	adv.main_contact_client_id,
	adv.phone_international_code,
	adv.phone_prefix,
	adv.phone_number,
	CONCAT('+',adv.phone_international_code,adv.phone_prefix,adv.phone_number) AS phone,
	adv.is_agency,
	adv.is_active,
	CONCAT((adv.id),adv.corporate_name,adv.main_contact_name,adv.main_contact_surname,adv.main_contact_email,'+',adv.phone_international_code,adv.phone_number) AS search
	FROM 
	advertisers adv
);

# PROVIDERS
CREATE TABLE IF NOT EXISTS providers (
id VARCHAR(40) PRIMARY KEY NOT NULL UNIQUE,
product_id VARCHAR(40) NOT NULL,
salemodel_id VARCHAR(40) NOT NULL,
product_price INTEGER NOT NULL,
currency VARCHAR(3) NOT NULL,
NAME VARCHAR(40) NOT NULL UNIQUE,
address	TEXT NOT NULL,
webpage_url VARCHAR(200) NOT NULL,
main_contact_name VARCHAR(20),
main_contact_surname VARCHAR(20),
main_contact_email VARCHAR(60) NOT NULL,
main_contact_position VARCHAR(20) NOT NULL,
phone_international_code VARCHAR(3),
phone_prefix VARCHAR(3),
phone_number VARCHAR(12),
is_active ENUM('N','Y') NOT NULL,
created_at DATETIME NOT NULL,
updated_at DATETIME NOT NULL
);

# VIEW PROVIDERS
CREATE VIEW view_providers AS (
	SELECT
	(pv.id) AS UUID,
	(pv.product_id) AS product_id,
	pd.name AS product_name,
	(pv.salemodel_id) AS salemodel_id,
	sm.name AS salemodel_name,
	pv.product_price / 100 AS product_price,
	pv.currency,
	pv.name,
	pv.webpage_url,
	pv.address,
	pv.main_contact_name,
	pv.main_contact_surname,
	pv.main_contact_email,
	pv.main_contact_position,
	pv.phone_international_code,
	pv.phone_prefix,
	pv.phone_number,
	CONCAT('+',pv.phone_international_code,pv.phone_prefix,pv.phone_number) AS phone,
	pv.is_active,
	CONCAT((pv.id),pd.name,sm.name,pv.name,pv.webpage_url,pv.main_contact_name,pv.main_contact_surname,pv.main_contact_email,'+',pv.phone_international_code,pv.phone_number) AS search
	FROM 
	providers pv
	LEFT JOIN products pd ON pd.id = pv.product_id
	LEFT JOIN salemodels sm ON sm.id = pv.salemodel_id
);


# PRODUCTS
CREATE TABLE IF NOT EXISTS products (
id VARCHAR(40) PRIMARY KEY NOT NULL UNIQUE,
NAME VARCHAR(40) NOT NULL,
DESCRIPTION TEXT,
is_active ENUM('N','Y') NOT NULL,
created_at DATETIME NOT NULL,
updated_at DATETIME NOT NULL
);

# INSERTING DATAS IN PRODUCTS TABLE
INSERT INTO products (id,NAME,DESCRIPTION,is_active,created_at,updated_at) 
VALUES 
((UUID()),'Banner IAB','Banner IAB','Y',NOW(),NOW()),
((UUID()),'Retargeting','Retargeting','Y',NOW(),NOW()),
((UUID()),'Native Ads','Native Ads','Y',NOW(),NOW()),
((UUID()),'Push Notification','Push Notification','Y',NOW(),NOW()),
((UUID()),'Pre Installation App Telcel Android','Pre Installation App Telcel Android','Y',NOW(),NOW()),
((UUID()),'App Opening Telcel Android','App Opening Telcel Android','Y',NOW(),NOW()),
((UUID()),'Native Video','Native Video','Y',NOW(),NOW()),
((UUID()),'Video','Video','Y',NOW(),NOW()),
((UUID()),'Interactive Video','Interactive Video','Y',NOW(),NOW()),
((UUID()),'Rich Media','Rich Media','Y',NOW(),NOW()),
((UUID()),'SMS Telcel and Movistar','SMS Telcel and Movistar','Y',NOW(),NOW()),
((UUID()),'Whatsapp Notification','Whatsapp Notification','Y',NOW(),NOW()),
((UUID()),'Sponsored data Telcel','Sponsored data Telcel','Y',NOW(),NOW()),
((UUID()),'Sponsored data Movistar','Sponsored data Movistar','Y',NOW(),NOW()),
((UUID()),'Audio Ads','Audio Ads','Y',NOW(),NOW()),
((UUID()),'Audio+ SMS','Audio+ SMS','Y',NOW(),NOW()),
((UUID()),'Voice Blaster','Voice Blaster','Y',NOW(),NOW()),
((UUID()),'HTML5 Mobile','HTML5 Mobile','Y',NOW(),NOW()),
((UUID()),'Video Rewards','Video Rewards','Y',NOW(),NOW()),
((UUID()),'E-mail Marketing','E-mail Marketing','Y',NOW(),NOW()),
((UUID()),'FB Messenger Notification','FB Messenger Notification','Y',NOW(),NOW()),
((UUID()),'Time Air','Time Air','Y',NOW(),NOW()),
((UUID()),'Periodical','Periodical','Y',NOW(),NOW()),
((UUID()),'Magazines','Magazines','Y',NOW(),NOW()),
((UUID()),'Radio','Radio','Y',NOW(),NOW()),
((UUID()),'TV','TV','Y',NOW(),NOW()),
((UUID()),'OOH','OOH','Y',NOW(),NOW());

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
is_active ENUM('N','Y') NOT NULL,
created_at DATETIME NOT NULL,
updated_at DATETIME NOT NULL
);

# INSERTING DATAS IN SALEMODELS TABLE
INSERT INTO salemodels (id,NAME,DESCRIPTION,is_active,created_at,updated_at) 
VALUES 
((UUID()),'CPM','CPM','Y',NOW(),NOW()),
((UUID()),'CPC','CPC','Y',NOW(),NOW()),
((UUID()),'CPA/CPS','CPA/CPS','Y',NOW(),NOW()),
((UUID()),'CPL','CPL','Y',NOW(),NOW()),
((UUID()),'Instalation','Instalation','Y',NOW(),NOW()),
((UUID()),'Opening','Opening','Y',NOW(),NOW()),
((UUID()),'Message','Message','Y',NOW(),NOW()),
((UUID()),'CPV','CPV','Y',NOW(),NOW()),
((UUID()),'SMS','SMS','Y',NOW(),NOW()),
((UUID()),'MB','MB','Y',NOW(),NOW()),
((UUID()),'Notification','Notification','Y',NOW(),NOW()),
((UUID()),'CPE','CPE','Y',NOW(),NOW()),
((UUID()),'CPE + SMS','CPE + SMS','Y',NOW(),NOW()),
((UUID()),'Simple page','Simple page','Y',NOW(),NOW()),
((UUID()),'Double page','Double page','Y',NOW(),NOW()),
((UUID()),'Front page','Front page','Y',NOW(),NOW()),
((UUID()),'Back cover','Back cover','Y',NOW(),NOW()),
((UUID()),'20 seconds Spot','20 seconds Spot','Y',NOW(),NOW()),
((UUID()),'30 seconds Spot','30 seconds Spot','Y',NOW(),NOW()),
((UUID()),'Comercial','Comercial','Y',NOW(),NOW()),
((UUID()),'Billboard','Billboard','Y',NOW(),NOW()),
((UUID()),'Mupie','Mupie','Y',NOW(),NOW()),
((UUID()),'Digital Screen','Digital Screen','Y',NOW(),NOW());

#PROPOSALS
CREATE TABLE IF NOT EXISTS proposals (
id VARCHAR(40) PRIMARY KEY NOT NULL UNIQUE,
user_id VARCHAR(40) NOT NULL,
advertiser_id VARCHAR(40) NOT NULL,
agency_id VARCHAR(40),
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
price INTEGER,
currency VARCHAR(3) NOT NULL,
quantity INTEGER,
is_active ENUM('N','Y') NOT NULL,
created_at DATETIME NOT NULL,
updated_at DATETIME NOT NULL
);


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
	ppp.price / 100 AS price,
	ppp.currency,
	ppp.quantity,
	(ppp.price * ppp.quantity) / 100 AS amount,
	pps.is_pixel,
	pps.is_active,
	CONCAT((pps.id),pd.name,sm.name,pv.name,u.username,adv.corporate_name,pps.offer_name,ppp.currency) AS search
	FROM 
	proposals pps
	LEFT JOIN proposalsxproducts ppp ON ppp.proposal_id = pps.id
	LEFT JOIN products pd ON pd.id = ppp.product_id
	LEFT JOIN salemodels sm ON sm.id = ppp.salemodel_id
	LEFT JOIN providers pv ON pv.id = ppp.provider_id
	INNER JOIN statuses s ON s.id = pps.status_id
	INNER JOIN users u ON u.id = pps.user_id
	INNER JOIN advertisers adv ON adv.id = pps.advertiser_id
	LEFT JOIN advertisers age ON age.id = pps.agency_id
	
);

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

SELECT (id) AS UUID, username, email FROM users WHERE account_locked='N' AND ( (username = 'marcodelaet' OR email = 'marcodelaet')  AND  authentication_string = '81dc9bdb52d04dc20036dbd8313ed055')