<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', true);

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

    // setting query
    $columns        = "left(uuid,13) as uuid, uuid as uuid_full, username, account_locked, product_id, product_name, salemodel_id, salemodel_name, product_price, currency, name, address, webpage_url, contact_provider_id, concat(contact_name,' ', contact_surname,' (', contact_email,')') as contact, contact_name, contact_surname, contact_email, contact_position, phone_international_code, phone_prefix, phone_number, concat('+',phone_international_code,phone_number) as phone, is_active";
    $tableOrView    = "view_providers";

    // filters
    $uuid                   = '';

    $filters                = '';
    if(array_key_exists('pid',$_REQUEST)){
        if($_REQUEST['pid']!==''){
            if($filters != '')
                $filters .= " AND ";
            $uuid         = $_REQUEST['pid'];
            $filters        .= " uuid = '$uuid'";
        }
    }
   
    if($filters !== ''){
        $filters = "WHERE ".$filters;
    }



    // Query creation
    $sql = "SELECT $columns FROM $tableOrView $filters";
    // LIST data
   // echo $sql;
    $rs = $DB->getData($sql);

    

  

    // Response JSON 
    if($rs){
        header('Content-type: application/json');
        echo json_encode($rs);
    }
}

//close connection
$DB->close();
?>