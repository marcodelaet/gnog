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
    $columns        = "CASE WHEN billboard_provider_name IS NULL THEN '0' ELSE COUNT(UUID) END AS numRows, salemodel_name, state";
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

    if(array_key_exists('pppid',$_REQUEST)){
        if($_REQUEST['pppid']!==''){
            if($filters != '')
                $filters .= " AND ";
            $uuid         = $_REQUEST['pppid'];
            $filters        .= " proposalproduct_id = '$uuid'";
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

    // Query creation
    $sql = "SELECT $columns FROM $tableOrView $filters";
    // LIST data
    //echo $sql;
    $rs = $DB->getData($sql);

    

  

    // Response JSON 
    if($rs){
        header('Content-type: application/json');
        echo json_encode(["response" => 'OK','data' => $rs]);
    }
}

//close connection
$DB->close();
?>