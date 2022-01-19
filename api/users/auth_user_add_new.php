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
    $username               = $_REQUEST['username']; 
    $email                  = $_REQUEST['email'];
    $mobile_ddi             = "'000'";
    if(array_key_exists('mobile_international_code',$_REQUEST)){
        if($_REQUEST['mobile_international_code']!=='')
            $mobile_ddi         = "'".$_REQUEST['mobile_international_code']."'";
    }
    $mobile                 = "'000'";
    if(array_key_exists('mobile_number',$_REQUEST)){
        if($_REQUEST['mobile_number']!=='')
            $mobile         = "'".$_REQUEST['mobile_number']."'";
    }
    $authentication_string  = md5($_REQUEST['password']);

    // Query creation
    $sql = "INSERT INTO users (id,username,email,mobile_international_code,mobile_number,authentication_string,account_locked,created_at,updated_at) VALUES ((UUID()),'$username','$email',$mobile_ddi,$mobile,'$authentication_string','N',now(),now())";
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