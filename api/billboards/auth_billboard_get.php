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
    
    // setting query
    $columns        = "left(uuid,13) as uuid, uuid as uuid_full, name, category, address, state, height, width, coordenates, latitud, longitud, price, cost, is_iluminated, is_digital, provider_name, salemodel_name, viewpoint_name, photo, is_active";
    $tableOrView    = "view_billboards";

    // filters
    $uuid                   = '';

    $filters                = '';
    if(array_key_exists('bid',$_REQUEST)){
        if($_REQUEST['bid']!==''){
            if($filters != '')
                $filters .= " AND ";
            $uuid         = $_REQUEST['bid'];
            $filters        .= " uuid = '$uuid'";
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
    header('Content-type: application/json');
    if($rs){
        echo json_encode(["response" => "OK","data" => $rs]);
    } else {
        echo json_encode(["response" => "ERROR"]);
    }
}

//close connection
$DB->close();

?>