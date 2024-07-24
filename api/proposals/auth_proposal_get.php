<?php
//REQUIRE GLOBAL conf
require_once('../../database/.config');

// REQUIRE conexion class
require_once('../../database/connect.database.php');

$DB = new MySQLDB($DATABASE_HOST,$DATABASE_USER,$DATABASE_PASSWORD,$DATABASE_NAME);

// call conexion instance
$con = $DB->connect();

// check authentication / local Storage
if(array_key_exists('auth_api',$_REQUEST)){
    // check auth_api === local storage
    //if($localStorage == $_REQUEST['auth_api']){}

    // User Group
    $group          = 'admin';

    // setting query
    $columns        = "UUID,is_digital, notes, advertiser_contact_email, advertiser_contact_name, advertiser_contact_surname, productbillboard_cost_int,(productbillboard_cost_int/100) as productbillboard_cost,productbillboard_price_int,is_proposalproduct_active,(productbillboard_price_int/100) as productbillboard_price,making_banners,production_cost,production_cost_int,is_proposalbillboard_active,proposalproduct_id,start_date_for_product,cost_int,cost,price_int,price,amount_int,amount,stop_date_for_product,is_taxable,tax_percent_int,product_id,product_name,salemodel_id,salemodel_name,provider_id,provider_name,user_id,username,client_id,client_name,agency_id,agency_name,status_id,status_name,status_percent,offer_name,description,start_date,stop_date,currency_c,billboard_state,billboard_city,billboard_county,billboard_colony,billboard_name,billboard_height,billboard_width,state,city,county,colony,billboard_cost,billboard_cost_int,billboard_price,billboard_price_int,billboard_id, billboard_provider_name,billboard_salemodel_name,billboard_viewpoint_name,amount,quantity,is_active";
    $tableOrView    = "view_proposals";

    // filters
    $uuid                   = '';

    $filters                = '';
    if($group !== 'admin'){
        $filters .= " user_id = '".$_COOKIE['uuid']."' ";
    }

    if(array_key_exists('tid',$_REQUEST)){
        if($_REQUEST['tid']!==''){
            if($filters != '')
                $filters .= " AND ";
            $uuid         = $_REQUEST['tid'];
            $filters        .= " uuid = '$uuid'";
        }
    }

    if(array_key_exists('ppid',$_REQUEST)){
        if($_REQUEST['ppid']!==''){
            if($filters != '')
                $filters .= " AND ";
            $uuid         = $_REQUEST['ppid'];
            $filters        .= " uuid = '$uuid'";
        }
    }

    if(array_key_exists('pppid',$_REQUEST)){
        if($_REQUEST['pppid']!==''){
            if($filters != '')
                $filters .= " AND ";
            $pppid         = $_REQUEST['pppid'];
            $filters        .= " proposalproduct_id = '$pppid'";
        }
    }


    if(array_key_exists('name',$_REQUEST)){
        if($_REQUEST['name']!==''){
            if($filters != '')
                $filters .= " AND ";
            $name         = $_REQUEST['name'];
            $filters        .= " offer_name = '$name' ";
        }
    }
   
    if(array_key_exists('advertiser_id',$_REQUEST)){
        if($_REQUEST['advertiser_id']!==''){
            if($filters != '')
                $filters .= " AND ";
            $advertiser_id  = $_REQUEST['advertiser_id'];
            $filters        .= " client_id = '$advertiser_id' ";
        }
    }

    if(array_key_exists('product_is_active',$_REQUEST)){
        if($_REQUEST['product_is_active']!==''){
            if($filters != '')
                $filters .= " AND ";
            $product_active  = $_REQUEST['product_is_active'];
            $filters        .= " is_proposalproduct_active = '$product_active' ";
        }
    }

    if($filters !== ''){
        $filters = "WHERE ".$filters;
    }

    $orderBy        = "order by provider_name ASC, proposalproduct_id ASC";
    // order by
    if(array_key_exists('orderby',$_REQUEST)){
        if($_REQUEST['orderby']!==''){
            $ordered        = $_REQUEST['orderby'];
            $orderBy        = " ORDER BY $ordered";
        }
    }

    $groupby    = ' ';
    if(array_key_exists('groupby',$_REQUEST)){
        $groupby = " GROUP BY ".$_REQUEST['groupby'];
    }


    // Query creation
    $sql = "SELECT $columns FROM $tableOrView $filters $groupby $orderBy";
    // LIST data
    //echo $sql;
    $rs = $DB->getData($sql);

    // Response JSON 
    if($rs){
        header('Content-type: application/json');
        echo json_encode(['data'=>$rs]);
    }
        
}

//close connection
$DB->close();
?>