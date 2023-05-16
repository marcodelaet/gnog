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
    $columns        = "left(uuid,13) as uuid, uuid as uuid_full, offer_name, product_name, salemodel_name, CONCAT(offer_name,' - ', product_name, ' / ' , salemodel_name) as product_full_name, proposalproduct_id, product_id, salemodel_id, is_active";
    $tableOrView    = "view_proposals";

    // filters
    $uuid                   = '';

    $filters                = '';
    if(array_key_exists('pid',$_REQUEST)){
        if($_REQUEST['pid']!==''){
            if($filters != '')
                $filters .= " AND ";
            $pid         = $_REQUEST['pid'];
            $filters        .= " provider_id = '$pid'";
        }
    }
   
    if($filters !== ''){
        $filters = "WHERE is_active='Y' AND ".$filters;
    }



    // Query creation
    $sql = "SELECT $columns FROM $tableOrView $filters";
    // LIST data
    //echo $sql;
    $rs = $DB->getData($sql);
    $numRows = $DB->numRows($sql);

    

  

    // Response JSON 
    header('Content-type: application/json');
    if($numRows > 0){
        if($rs){
            echo json_encode(['result'=>'OK','data'=>$rs,'numRows'=>$numRows]);
        }    
    } else {
        echo json_encode(['result'=>'ZERO_RETURN','numRows'=>$numRows]);
    }
}

//close connection
$DB->close();
?>