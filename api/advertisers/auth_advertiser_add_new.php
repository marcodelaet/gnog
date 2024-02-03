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

    // values to insert
    $agency                 = 'Y';
    if(array_key_exists('agency',$_REQUEST)){
        if($_REQUEST['agency']!=='')
            $agency         = $_REQUEST['agency'];
    }
    $making_banners         = 'Y';
    if(array_key_exists('making_banners',$_REQUEST)){
        if($_REQUEST['making_banners']!=='')
            $making_banners = $_REQUEST['making_banners'];
    }
    $corporate_name         = urldecode($_REQUEST['corporate_name']);
    $address                = urldecode($_REQUEST['address']);
    if($address == ''){
        $address = 'Sin dirección';
    }
    $executive_id           = 'NULL';
    if($_REQUEST['executive_id'] != '0'){
        $executive_id           = "'".$_REQUEST['executive_id']."'";
    } 


    $module     = "advertisers";
    $columns    = "id,executive_id,is_agency,making_banners,corporate_name,address,is_active,created_at,updated_at";
    $values     = "(UUID()),$executive_id,'$agency','$making_banners','$corporate_name','$address','Y',now(),now()";

    // Query creation
    $sql = "INSERT INTO $module ($columns) VALUES ($values)";

    
    // INSERT data
    $rs = $DB->executeInstruction($sql);

  

    // Response JSON 
    header('Content-type: application/json');
    if($rs){
        echo json_encode(['status' => 'OK']);
    }
}

//close connection
$DB->close();
?>