# VIEWS

# VIEW USERS
CREATE VIEW view_users AS (
	SELECT
	(id) AS UUID,
	username,
	user_language,
	email,
	level_account,
	user_type,
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

# VIEW GOALS
CREATE VIEW view_goals AS (
	SELECT
	u.username,
	u.level_account,
	u.user_type,
	u.token,
	(g.user_id) AS UUID,
	g.goal_amount,
	g.goal_month,
	g.goal_year,
	g.currency_id,
	(g.goal_amount / c.rate) * cusd.rate AS goal_USD,
	(g.goal_amount / c.rate) * cmxn.rate AS goal_MXN,
	(g.goal_amount / c.rate) * cbrl.rate AS goal_BRL,
	(g.goal_amount / c.rate) * ceur.rate AS goal_EUR
	FROM 
	goals g
	INNER JOIN users u 
	ON g.user_id = u.id
	INNER JOIN currencies c 
	ON c.id = g.currency_id
	INNER JOIN currencies cusd ON cusd.id = 'USD'
	INNER JOIN currencies cbrl ON cbrl.id = 'BRL'
	INNER JOIN currencies cmxn ON cmxn.id = 'MXN'
	INNER JOIN currencies ceur ON ceur.id = 'EUR'
);


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
	adv.making_banners,
	adv.executive_id,
	u.username,
	u.email,
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
	CASE WHEN ct.contact_email IS NOT NULL THEN 
		CONCAT((adv.id),adv.corporate_name,ct.contact_name,ct.contact_surname,ct.contact_email,'+',ct.phone_international_code,ct.phone_number) 
	ELSE
		CONCAT((adv.id),adv.corporate_name)
	END AS search
	FROM
	advertisers adv
	LEFT JOIN view_advertisercontacts ct ON ct.contact_client_id = adv.id
	LEFT JOIN users u ON adv.executive_id = u.id
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
	ct.id AS contact_provider_id,
	ct.contact_name,
	ct.contact_surname,
	ct.contact_email,
	ct.contact_position,
	ct.phone_international_code,
	ct.phone_prefix,
	ct.phone_number,
	u.username,
	u.user_language,
	u.user_type,
	u.account_locked,
	CONCAT('+',ct.phone_international_code,ct.phone_prefix,ct.phone_number) AS phone,
	pv.is_active,
	CONCAT((pv.id),CASE WHEN pd.name IS NULL THEN '' ELSE pd.name END,CASE WHEN sm.name IS NULL THEN '' ELSE sm.name END,pv.name,CASE WHEN pv.webpage_url IS NULL THEN '' ELSE pv.webpage_url END,CASE WHEN ct.contact_name IS NULL THEN '' ELSE ct.contact_name END,CASE WHEN ct.contact_surname IS NULL THEN '' ELSE ct.contact_surname END,CASE WHEN ct.contact_email IS NULL THEN '' ELSE ct.contact_email END,'+',CASE WHEN ct.phone_international_code  IS NULL THEN '' ELSE ct.phone_international_code END,CASE WHEN ct.phone_number IS NULL THEN '' ELSE ct.phone_number END) AS search 
	FROM 
	providers pv
	LEFT JOIN providersxproduct pp ON pp.provider_id = pv.id
	LEFT JOIN products pd ON pd.id = pp.product_id
	LEFT JOIN salemodels sm ON sm.id = pp.salemodel_id
	LEFT JOIN contacts ct ON (ct.module_name = 'provider' AND ct.is_active='Y') AND (ct.contact_client_id = pv.id)
	LEFT JOIN users u ON ct.contact_email = u.email
);


# VIEW BILLBOARDS
drop view view_billboards;

CREATE VIEW view_billboards AS 
(
	SELECT
	b.id as UUID,
	b.name_key as name,
	b.category as category,
	b.address as address,
	b.state as state,
	b.county as county,
	b.city as city,
	b.colony as colony,
	b.height / 100 as height,
	b.width / 100 as width,
	b.coordenates as coordenates,
	b.latitud as latitud,
	b.longitud as longitud,
	b.price_int as price_int,
	(b.price_int * 100) / 100 as price,
	b.cost_int as cost_int,
	(b.cost_int * 100) / 100 as cost,
	b.is_iluminated as is_iluminated,
	b.is_digital as is_digital,
	b.is_active as is_active,
	p.name as provider_name,
	sm.name as salemodel_name,
	sm.id as salemodel_id,
	vp.id as viewpoint_id,
	p.id as provider_id,
	vp.name as viewpoint_name,
	b.photo as photo,
    pb.proposalproduct_id as proposalproduct_id,
    pb.is_active as is_productbillboard_active,
	pb.cost_int as productbillboard_cost_int,
	pb.price_int as productbillboard_price_int,
	CONCAT(name_key,p.name,sm.name,vp.name,b.state,b.address) as search
	FROM billboards b
	INNER JOIN providers p ON b.provider_id = p.id
	INNER JOIN salemodels sm ON b.salemodel_id = sm.id
	INNER JOIN viewpoints vp ON b.viewpoint_id = vp.id
    LEFT JOIN productsxbillboards pb ON b.id = pb.billboard_id 
);

# VIEW PROPOSALS
CREATE VIEW view_proposals AS (
	SELECT
	(pps.id) AS UUID,
	ppp.id as proposalproduct_id,
	(ppp.product_id) AS product_id,
	pd.name AS product_name,
	(ppp.salemodel_id) AS salemodel_id,
	pd.is_digital,
	sm.name AS salemodel_name,
	(ppp.provider_id) AS provider_id,
	pv.name AS provider_name,
    ppp.state AS state,
	ppp.city AS city,
    ppp.county AS county,
    ppp.colony AS colony,
	o.name AS office_name,
	o.icon_flag AS office_icon_flag,
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
	ppp.start_date AS start_date_for_product,
	ppp.stop_date AS stop_date_for_product,
	TIMESTAMPDIFF(MONTH, pps.start_date, pps.stop_date) + 1 AS month_diff_data, 
	CASE WHEN (ppp.start_date IS NULL ) THEN 1 ELSE (TIMESTAMPDIFF(MONTH, ppp.start_date, ppp.stop_date) + 1) END AS month_diff_data_for_product, 
	CASE WHEN ppp.is_active = 'Y' THEN ppp.price_int / 100 ELSE 0 END AS price,
	CASE WHEN ppp.is_active = 'Y' THEN ppp.price_int ELSE 0 END AS price_int,
	ppp.currency,
	CASE WHEN ppp.is_active = 'Y' THEN ppp.quantity ELSE 0 END as quantity,
	c.rate AS rate,
	c.id AS currency_c,
	CASE WHEN ppp.is_active = 'Y' THEN (ppp.price_int * ppp.quantity) ELSE 0 END AS amount_int,
	CASE WHEN ppp.is_active = 'Y' THEN (ppp.price_int * ppp.quantity) / 100 ELSE 0 END AS amount,
	CASE WHEN ppp.is_active = 'Y' THEN ((ppp.price_int * ppp.quantity) / (TIMESTAMPDIFF(MONTH, ppp.start_date, ppp.stop_date) + 1)) ELSE 0 END AS amount_per_month_int,
	CASE WHEN ppp.is_active = 'Y' THEN ((ppp.price_int * ppp.quantity) / (TIMESTAMPDIFF(MONTH, ppp.start_date, ppp.stop_date) + 1)) / 100 ELSE 0 END AS amount_per_month,
	CASE WHEN ppp.is_active = 'Y' THEN 
	CASE 
	WHEN c.id = 'USD' THEN
	(
		(ppp.price_int * ppp.quantity)
	) ELSE 
	(
		(((ppp.price_int * ppp.quantity) / c.rate) * cusd.rate)
	) END 
	ELSE 0 END 
	AS amount_USD_int,
	CASE WHEN ppp.is_active = 'Y' THEN 
	CASE
	WHEN c.id = 'USD' THEN
	(
		(ppp.price_int * ppp.quantity) / 100
	) ELSE 
	(
		(((ppp.price_int * ppp.quantity) / c.rate) * cusd.rate) / 100
	) END 
	ELSE 0 END 
	AS amount_USD,
	CASE WHEN ppp.is_active = 'Y' THEN 
	CASE
	WHEN c.id = 'USD' THEN
	(
		((ppp.price_int * ppp.quantity) / (TIMESTAMPDIFF(MONTH, ppp.start_date, ppp.stop_date) + 1))
	) ELSE 
	(
		((((ppp.price_int * ppp.quantity) / c.rate) * cusd.rate) / (TIMESTAMPDIFF(MONTH, ppp.start_date, ppp.stop_date) + 1))
	) END 
	ELSE 0 END
	AS amount_per_month_USD_int,
	CASE WHEN ppp.is_active = 'Y' THEN 
	CASE
	WHEN c.id = 'USD' THEN
	(
		((ppp.price_int * ppp.quantity) / (TIMESTAMPDIFF(MONTH, ppp.start_date, ppp.stop_date) + 1)) / 100
	) ELSE 
	(
		((((ppp.price_int * ppp.quantity) / c.rate) * cusd.rate) / (TIMESTAMPDIFF(MONTH, ppp.start_date, ppp.stop_date) + 1)) / 100
	) END 
	ELSE 0 END
	AS amount_per_month_USD,
	CASE WHEN ppp.is_active = 'Y' THEN 
	CASE
	WHEN c.id = 'MXN' THEN
	(
		(ppp.price_int * ppp.quantity)
	) ELSE 
	(
		(((ppp.price_int * ppp.quantity) / c.rate) * cmxn.rate)
	) END 
	ELSE 0 END 
	AS amount_MXN_int,
	CASE WHEN ppp.is_active = 'Y' THEN 
	CASE
	WHEN c.id = 'MXN' THEN
	(
		(ppp.price_int * ppp.quantity) / 100
	) ELSE 
	(
		(((ppp.price_int * ppp.quantity) / c.rate) * cmxn.rate) / 100
	) END 
	ELSE 0 END
	AS amount_MXN,
	CASE WHEN ppp.is_active = 'Y' THEN 
	CASE
	WHEN c.id = 'MXN' THEN
	(
		((ppp.price_int * ppp.quantity) / (TIMESTAMPDIFF(MONTH, ppp.start_date, ppp.stop_date) + 1))
	) ELSE 
	(
		((((ppp.price_int * ppp.quantity) / c.rate) * cmxn.rate) / (TIMESTAMPDIFF(MONTH, ppp.start_date, ppp.stop_date) + 1))
	) END 
	ELSE 0 END
	AS amount_per_month_MXN_int,
	CASE WHEN ppp.is_active = 'Y' THEN 
	CASE
	WHEN c.id = 'MXN' THEN
	(
		((ppp.price_int * ppp.quantity) / (TIMESTAMPDIFF(MONTH, ppp.start_date, ppp.stop_date) + 1)) / 100
	) ELSE 
	(
		((((ppp.price_int * ppp.quantity) / c.rate) * cmxn.rate) / (TIMESTAMPDIFF(MONTH, ppp.start_date, ppp.stop_date) + 1)) / 100
	) END 
	ELSE 0 END 
	AS amount_per_month_MXN,
	CASE WHEN ppp.is_active = 'Y' THEN 
	CASE
	WHEN c.id = 'BRL' THEN
	(
		(ppp.price_int * ppp.quantity)
	) ELSE 
	(
		(((ppp.price_int * ppp.quantity) / c.rate) * cbrl.rate)
	) END 
	ELSE 0 END
	AS amount_BRL_int,
	CASE WHEN ppp.is_active = 'Y' THEN 
	CASE
	WHEN c.id = 'BRL' THEN
	(
		(ppp.price_int * ppp.quantity) / 100
	) ELSE 
	(
		(((ppp.price_int * ppp.quantity) / c.rate) * cbrl.rate) / 100
	) END 
	ELSE 0 END
	AS amount_BRL,
	CASE WHEN ppp.is_active = 'Y' THEN 
	CASE
	WHEN c.id = 'BRL' THEN
	(
		((ppp.price_int * ppp.quantity) / (TIMESTAMPDIFF(MONTH, ppp.start_date, ppp.stop_date) + 1))
	) ELSE 
	(
		((((ppp.price_int * ppp.quantity) / c.rate) * cbrl.rate) / (TIMESTAMPDIFF(MONTH, ppp.start_date, ppp.stop_date) + 1))
	) END 
	ELSE 0 END
	AS amount_per_month_BRL_int,
	CASE WHEN ppp.is_active = 'Y' THEN 
	CASE
	WHEN c.id = 'BRL' THEN
	(
		((ppp.price_int * ppp.quantity) / (TIMESTAMPDIFF(MONTH, ppp.start_date, ppp.stop_date) + 1)) / 100
	) ELSE 
	(
		((((ppp.price_int * ppp.quantity) / c.rate) * cbrl.rate) / (TIMESTAMPDIFF(MONTH, ppp.start_date, ppp.stop_date) + 1)) / 100
	) END 
	ELSE 0 END
	AS amount_per_month_BRL,
	CASE WHEN ppp.is_active = 'Y' THEN 
	CASE
	WHEN c.id = 'EUR' THEN
	(
		(ppp.price_int * ppp.quantity)
	) ELSE 
	(
		(((ppp.price_int * ppp.quantity) / c.rate) * ceur.rate)
	) END  
	ELSE 0 END
	AS amount_EUR_int,
	CASE WHEN ppp.is_active = 'Y' THEN 
	CASE
	WHEN c.id = 'EUR' THEN
	(
		(ppp.price_int * ppp.quantity) / 100
	) ELSE 
	(
		(((ppp.price_int * ppp.quantity) / c.rate) * ceur.rate) / 100
	) END 
	ELSE 0 END
	AS amount_EUR,
	CASE WHEN ppp.is_active = 'Y' THEN 
	CASE
	WHEN c.id = 'EUR' THEN
	(
		((ppp.price_int * ppp.quantity) / (TIMESTAMPDIFF(MONTH, ppp.start_date, ppp.stop_date) + 1))
	) ELSE 
	(
		((((ppp.price_int * ppp.quantity) / c.rate) * ceur.rate) / (TIMESTAMPDIFF(MONTH, ppp.start_date, ppp.stop_date) + 1))
	) END 
	ELSE 0 END
	AS amount_per_month_EUR_int,
	CASE WHEN ppp.is_active = 'Y' THEN 
	CASE
	WHEN c.id = 'EUR' THEN
	(
		((ppp.price_int * ppp.quantity) / (TIMESTAMPDIFF(MONTH, ppp.start_date, ppp.stop_date) + 1)) / 100
	) ELSE 
	(
		((((ppp.price_int * ppp.quantity) / c.rate) * ceur.rate) / (TIMESTAMPDIFF(MONTH, ppp.start_date, ppp.stop_date) + 1)) / 100
	) END 
	ELSE 0 END
	AS amount_per_month_EUR,
	CASE WHEN ppp.is_active = 'Y' THEN 
	(ppp.cost_int) 
	ELSE 0 END 
	AS cost_int,
	CASE WHEN ppp.is_active = 'Y' THEN 
	(ppp.cost_int) / 100 
	ELSE 0 END 
	AS cost,
	CASE WHEN ppp.is_active = 'Y' THEN 
	(ppp.cost_int * ppp.quantity) 
	ELSE 0 END 
	AS cost_full_int,
	CASE WHEN ppp.is_active = 'Y' THEN 
	(ppp.cost_int * ppp.quantity) / 100 
	ELSE 0 END 
	AS cost_full,
	CASE WHEN ppp.is_active = 'Y' THEN 
	((ppp.cost_int * ppp.quantity) / (TIMESTAMPDIFF(MONTH, ppp.start_date, ppp.stop_date) + 1)) 
	ELSE 0 END 
	AS cost_per_month_int,
	CASE WHEN ppp.is_active = 'Y' THEN 
	((ppp.cost_int * ppp.quantity) / (TIMESTAMPDIFF(MONTH, ppp.start_date, ppp.stop_date) + 1)) / 100 
	ELSE 0 END
	AS cost_per_month,
	CASE WHEN ppp.is_active = 'Y' THEN 
	CASE 
	WHEN c.id = 'USD' THEN
	(
		(ppp.cost_int * ppp.quantity)
	) ELSE 
	(
		(((ppp.cost_int * ppp.quantity) / c.rate) * cusd.rate)
	) END 
	ELSE 0 END
	AS cost_USD_int,
	CASE WHEN ppp.is_active = 'Y' THEN 
	CASE
	WHEN c.id = 'USD' THEN
	(
		(ppp.cost_int * ppp.quantity) / 100
	) ELSE 
	(
		(((ppp.cost_int * ppp.quantity) / c.rate) * cusd.rate) / 100
	) END 
	ELSE 0 END
	AS cost_USD,
	CASE WHEN ppp.is_active = 'Y' THEN 
	CASE
	WHEN c.id = 'USD' THEN
	(
		((ppp.cost_int * ppp.quantity) / (TIMESTAMPDIFF(MONTH, ppp.start_date, ppp.stop_date) + 1))
	) ELSE 
	(
		((((ppp.cost_int * ppp.quantity) / c.rate) * cusd.rate) / (TIMESTAMPDIFF(MONTH, ppp.start_date, ppp.stop_date) + 1))
	) END 
	ELSE 0 END
	AS cost_per_month_USD_int,
	CASE WHEN ppp.is_active = 'Y' THEN 
	CASE
	WHEN c.id = 'USD' THEN
	(
		((ppp.cost_int * ppp.quantity) / (TIMESTAMPDIFF(MONTH, ppp.start_date, ppp.stop_date) + 1)) / 100
	) ELSE 
	(
		((((ppp.cost_int * ppp.quantity) / c.rate) * cusd.rate) / (TIMESTAMPDIFF(MONTH, ppp.start_date, ppp.stop_date) + 1)) / 100
	) END 
	ELSE 0 END
	AS cost_per_month_USD,
	CASE WHEN ppp.is_active = 'Y' THEN 
	CASE
	WHEN c.id = 'MXN' THEN
	(
		(ppp.cost_int * ppp.quantity)
	) ELSE 
	(
		(((ppp.cost_int * ppp.quantity) / c.rate) * cmxn.rate)
	) END 
	ELSE 0 END 
	AS cost_MXN_int,
	CASE WHEN ppp.is_active = 'Y' THEN 
	CASE
	WHEN c.id = 'MXN' THEN
	(
		(ppp.cost_int * ppp.quantity) / 100
	) ELSE 
	(
		(((ppp.cost_int * ppp.quantity) / c.rate) * cmxn.rate) / 100
	) END 
	ELSE 0 END
	AS cost_MXN,
	CASE WHEN ppp.is_active = 'Y' THEN 
	CASE
	WHEN c.id = 'MXN' THEN
	(
		((ppp.cost_int * ppp.quantity) / (TIMESTAMPDIFF(MONTH, ppp.start_date, ppp.stop_date) + 1))
	) ELSE 
	(
		((((ppp.cost_int * ppp.quantity) / c.rate) * cmxn.rate) / (TIMESTAMPDIFF(MONTH, ppp.start_date, ppp.stop_date) + 1))
	) END 
	ELSE 0 END
	AS cost_per_month_MXN_int,
	CASE WHEN ppp.is_active = 'Y' THEN 
	CASE
	WHEN c.id = 'MXN' THEN
	(
		((ppp.cost_int * ppp.quantity) / (TIMESTAMPDIFF(MONTH, ppp.start_date, ppp.stop_date) + 1)) / 100
	) ELSE 
	(
		((((ppp.cost_int * ppp.quantity) / c.rate) * cmxn.rate) / (TIMESTAMPDIFF(MONTH, ppp.start_date, ppp.stop_date) + 1)) / 100
	) END 
	ELSE 0 END
	AS cost_per_month_MXN,
	CASE WHEN ppp.is_active = 'Y' THEN 
	CASE
	WHEN c.id = 'BRL' THEN
	(
		(ppp.cost_int * ppp.quantity)
	) ELSE 
	(
		(((ppp.cost_int * ppp.quantity) / c.rate) * cbrl.rate)
	) END 
	ELSE 0 END
	AS cost_BRL_int,
	CASE WHEN ppp.is_active = 'Y' THEN 
	CASE
	WHEN c.id = 'BRL' THEN
	(
		(ppp.cost_int * ppp.quantity) / 100
	) ELSE 
	(
		(((ppp.cost_int * ppp.quantity) / c.rate) * cbrl.rate) / 100
	) END 
	ELSE 0 END
	AS cost_BRL,
	CASE WHEN ppp.is_active = 'Y' THEN 
	CASE
	WHEN c.id = 'BRL' THEN
	(
		((ppp.cost_int * ppp.quantity) / (TIMESTAMPDIFF(MONTH, ppp.start_date, ppp.stop_date) + 1))
	) ELSE 
	(
		((((ppp.cost_int * ppp.quantity) / c.rate) * cbrl.rate) / (TIMESTAMPDIFF(MONTH, ppp.start_date, ppp.stop_date) + 1))
	) END 
	ELSE 0 END
	AS cost_per_month_BRL_int,
	CASE WHEN ppp.is_active = 'Y' THEN 
	CASE
	WHEN c.id = 'BRL' THEN
	(
		((ppp.cost_int * ppp.quantity) / (TIMESTAMPDIFF(MONTH, ppp.start_date, ppp.stop_date) + 1)) / 100
	) ELSE 
	(
		((((ppp.cost_int * ppp.quantity) / c.rate) * cbrl.rate) / (TIMESTAMPDIFF(MONTH, ppp.start_date, ppp.stop_date) + 1)) / 100
	) END 
	ELSE 0 END
	AS cost_per_month_BRL,
	CASE WHEN ppp.is_active = 'Y' THEN 
	CASE
	WHEN c.id = 'EUR' THEN
	(
		(ppp.cost_int * ppp.quantity)
	) ELSE 
	(
		(((ppp.cost_int * ppp.quantity) / c.rate) * ceur.rate)
	) END 
	ELSE 0 END
	AS cost_EUR_int,
	CASE WHEN ppp.is_active = 'Y' THEN 
	CASE
	WHEN c.id = 'EUR' THEN
	(
		(ppp.cost_int * ppp.quantity) / 100
	) ELSE 
	(
		(((ppp.cost_int * ppp.quantity) / c.rate) * ceur.rate) / 100
	) END 
	ELSE 0 END
	AS cost_EUR,
	CASE WHEN ppp.is_active = 'Y' THEN 
	CASE
	WHEN c.id = 'EUR' THEN
	(
		((ppp.cost_int * ppp.quantity) / (TIMESTAMPDIFF(MONTH, ppp.start_date, ppp.stop_date) + 1))
	) ELSE 
	(
		((((ppp.cost_int * ppp.quantity) / c.rate) * ceur.rate) / (TIMESTAMPDIFF(MONTH, ppp.start_date, ppp.stop_date) + 1))
	) END 
	ELSE 0 END
	AS cost_per_month_EUR_int,
	CASE WHEN ppp.is_active = 'Y' THEN 
	CASE
	WHEN c.id = 'EUR' THEN
	(
		((ppp.cost_int * ppp.quantity) / (TIMESTAMPDIFF(MONTH, ppp.start_date, ppp.stop_date) + 1)) / 100
	) ELSE 
	(
		((((ppp.cost_int * ppp.quantity) / c.rate) * ceur.rate) / (TIMESTAMPDIFF(MONTH, ppp.start_date, ppp.stop_date) + 1)) / 100
	) END 
	ELSE 0 END
	AS cost_per_month_EUR,
	CASE WHEN (agency_id is not null and agency_id <> '') THEN 
	( 
		age.making_banners 
	) ELSE 
	( 
		adv.making_banners 
	) END AS making_banners,
	ppp.production_cost_int,
	(ppp.production_cost_int / 100) as production_cost, 
	ppp.notes,
	pps.is_taxable,
	pps.tax_percent_int,
	pps.is_pixel,
	pps.is_active,
	b.id as billboard_id,
	b.name_key as billboard_name,
	b.height as billboard_height,
	b.width as billboard_width,
	smb.name as billboard_salemodel_name,
	pvb.name as billboard_provider_name,
	vp.name as billboard_viewpoint_name,
	(b.cost_int / 100) as billboard_cost,
	b.cost_int as billboard_cost_int,
	b.state as billboard_state,
	b.city as billboard_city,
	b.county as billboard_county,
	b.colony as billboard_colony,
	(pb.price_int / 100) as billboard_price,
	pb.price_int as billboard_price_int,
	pb.is_active as is_proposalbillboard_active,
	pb.cost_int as productbillboard_cost_int,
	pb.price_int as productbillboard_price_int,
	ppp.is_active as is_proposalproduct_active,
	ppp.created_at as proposalproduct_created_at,
	ppp.updated_at as proposalproduct_updated_at,
	pps.created_at as proposal_created_at,
	pps.updated_at as proposal_updated_at,
	CASE WHEN g.user_id IS NOT NULL THEN 
		g.goal_month
	ELSE 
		0
	END 
	AS goal_month,
	CASE WHEN g.user_id IS NOT NULL THEN 
		g.goal_year
	ELSE 
		0
	END 
	AS goal_year,
	CASE WHEN g.user_id IS NOT NULL THEN 
		g.currency_id
	ELSE 
		0
	END 
	AS goal_currency,
	CASE WHEN g.user_id IS NOT NULL THEN 
		g.goal_amount
	ELSE 
		0
	END 
	AS goal_amount,
	CONCAT(
		pps.id,
		CASE WHEN pd.name IS NOT NULL THEN pd.name ELSE '' END,
		CASE WHEN sm.name IS NOT NULL THEN sm.name ELSE '' END,
		CASE WHEN pv.name IS NOT NULL THEN pv.name ELSE '' END,
		CASE WHEN u.username IS NOT NULL THEN u.username ELSE '' END,
		CASE WHEN adv.corporate_name IS NOT NULL THEN adv.corporate_name ELSE '' END,
		pps.offer_name,
		CASE WHEN ppp.currency IS NOT NULL THEN ppp.currency ELSE '' END
		) AS search
	FROM 
	proposals pps
	LEFT JOIN proposalsxproducts ppp ON ppp.proposal_id = pps.id
	LEFT JOIN products pd ON pd.id = ppp.product_id
	LEFT JOIN productsxbillboards pb ON pb.proposalproduct_id = ppp.id 
	LEFT JOIN salemodels sm ON sm.id = ppp.salemodel_id
	LEFT JOIN providers pv ON pv.id = ppp.provider_id
	LEFT JOIN billboards b ON b.id = pb.billboard_id
	LEFT JOIN viewpoints vp ON vp.id = b.viewpoint_id
	LEFT JOIN salemodels smb ON smb.id = b.salemodel_id
	LEFT JOIN providers pvb ON pvb.id = b.provider_id
	LEFT JOIN offices o ON pps.office_id = o.id
	INNER JOIN currencies c ON c.id = ppp.currency
	INNER JOIN currencies cusd ON cusd.id = 'USD'
	INNER JOIN currencies cmxn ON cmxn.id = 'MXN'
	INNER JOIN currencies cbrl ON cbrl.id = 'BRL'
	INNER JOIN currencies ceur ON ceur.id = 'EUR'
	INNER JOIN statuses s ON s.id = pps.status_id
	INNER JOIN users u ON u.id = pps.user_id
	INNER JOIN advertisers adv ON adv.id = pps.advertiser_id
	LEFT JOIN advertisers age ON age.id = pps.agency_id
	LEFT JOIN goals g ON g.user_id = u.id
);

# VIEW INVOICES_FILES
CREATE VIEW view_invoices_files AS (
SELECT 
i.id as invoice_id,
i.provider_id as provider_id,
pv.name as provider_name,
i.invoice_number as invoice_number,
i.invoice_amount_int as invoice_amount_int,
i.invoice_amount_int / 100 as invoice_amount,
i.invoice_amount_paid_int as invoice_amount_paid_int,
i.invoice_amount_paid_int / 100 as invoice_amount_paid,
i.invoice_amount_currency as invoice_amount_currency,
i.invoice_last_payment_date as invoice_last_payment_date,
i.invoice_month as invoice_month,
i.invoice_year as invoice_year,
i.order_number as order_number,
i.proposalproduct_id as proposalproduct_id,
i.invoice_status as invoice_status,
i.is_active as invoice_is_active,
i.created_at as invoice_created_at,
i.updated_at as invoice_updated_at,
f.id as file_id,
f.file_location as file_location,
f.file_name as file_name,
f.file_type as file_type,
f.user_id as user_id,
u.email as user_email,
f.description as file_description,
f.is_active as file_is_active,
f.created_at as file_created_at,
f.updated_at as file_updated_at,
pp.proposal_id as proposal_id,
p.offer_name as offer_name,
pp.product_id as product_id,
pd.name as product_name,
pp.salemodel_id as salemodel_id,
sm.name as salemodel_name,
CONCAT(p.offer_name,'|',pd.name,'|',sm.name,'|',file_name,'|',pv.name,'|',i.invoice_number,'|',i.order_number,'|',i.invoice_status) as search
FROM 
invoices i
INNER JOIN files f ON f.invoice_id = i.id
INNER JOIN proposalsxproducts pp ON pp.id = i.proposalproduct_id
INNER JOIN proposals p ON p.id = pp.proposal_id
INNER JOIN providers pv ON pv.id = i.provider_id
INNER JOIN users u ON f.user_id = u.id
LEFT JOIN products pd ON pd.id = pp.product_id
LEFT JOIN salemodels sm ON sm.id = pp.salemodel_id
);

# VIEW CREATION_USER_PROVIDER
CREATE VIEW view_full_profiles_data AS (
SELECT 
c.id as contact_id,
c.module_name as contact_module_name,
c.contact_email as contact_email,
c.contact_client_id as contact_client_id,
p.id as provider_id,
a.id as advertiser_id,
c.contact_name as contact_name,
c.contact_surname as contact_surname,
c.contact_position as contact_position,
c.is_active as contact_is_active,
p.name as provider_name,
a.corporate_name as advertiser_name,
p.is_active as provider_is_active,
a.is_active as advertiser_is_active,
u.username as username, 
u.user_language as user_language, 
u.email as user_email, 
u.level_account as user_level_account, 
u.user_type as user_type,
u.mobile_international_code as user_international_code, 
u.mobile_number as user_mobile_number, 
u.authentication_string as authentication_string,
c.phone_international_code as contact_international_code,
c.phone_number as contact_phone_number,
u.token as user_token, 
u.account_locked as user_locked_status,
pf.photo as profile_photo,
pf.aboutme as profile_aboutme,
pf.country as profile_country,
u.id as user_id
FROM 
contacts c 
LEFT JOIN providers p ON (p.id = c.contact_client_id AND c.module_name = 'provider')
LEFT JOIN advertisers a ON (a.id = c.contact_client_id AND c.module_name = 'advertiser')
LEFT JOIN users u ON c.contact_email = u.email
LEFT JOIN profiles pf ON pf.user_id = u.id
);
