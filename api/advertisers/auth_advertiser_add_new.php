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
    $corporate_name         = $_REQUEST['corporate_name'];
    $address                = $_REQUEST['address'];
    $main_contact_name      = $_REQUEST['main_contact_name'];
    $main_contact_surname   = $_REQUEST['main_contact_surname'];
    $main_contact_email     = $_REQUEST['main_contact_email'];
    $main_contact_position  = $_REQUEST['main_contact_position'];
    $phone_ddi             = "000";
    if(array_key_exists('phone_ddi',$_REQUEST)){
        if($_REQUEST['phone_ddi']!=='')
            $phone_ddi         = $_REQUEST['phone_ddi'];
    }
    $phone                 = "000";
    if(array_key_exists('phone',$_REQUEST)){
        if($_REQUEST['phone']!=='')
            $phone         = $_REQUEST['phone'];
    }

    // Query creation
    $sql = "INSERT INTO advertisers (id,is_agency,corporate_name,address,main_contact_name,main_contact_surname,main_contact_email,main_contact_position,phone_international_code,phone_number,is_active,created_at,updated_at) VALUES ((UUID()),'$agency','$corporate_name','$address','$main_contact_name','$main_contact_surname','$main_contact_email','$main_contact_position','$phone_ddi','$phone','Y',now(),now())";
    // INSERT data
    $rs = $DB->executeInstruction($sql);

  

    // Response JSON 
    if($rs){
        header('Content-type: application/json');
        echo json_encode(['status' => 'OK']);
    }
}

//close connection
$DB->close();
?>