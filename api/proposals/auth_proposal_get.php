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
    $columns        = "UUID,is_proposalbillboard_active,proposalproduct_id,product_id,product_name,salemodel_id,salemodel_name,provider_id,provider_name,user_id,username,client_id,client_name,agency_id,agency_name,status_id,status_name,status_percent,offer_name,description,start_date,stop_date,currency_c,billboard_state,billboard_name,billboard_height,billboard_width,state,billboard_state,billboard_cost,billboard_cost_int,billboard_price,billboard_price_int,billboard_id, billboard_provider_name,billboard_salemodel_name,billboard_viewpoint_name,amount,quantity,is_active";
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

    // Query creation
    $sql = "SELECT $columns FROM $tableOrView $filters $orderBy";
    // LIST data
    //echo $sql;
    $rs = $DB->getData($sql);

    // Response JSON 
    if($rs){
        header('Content-type: application/json');
        echo json_encode(['data'=>$rs, $sql]);
    }
}

//close connection
$DB->close();
?>