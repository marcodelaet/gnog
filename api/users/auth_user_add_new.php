<?php
//REQUIRE GLOBAL conf
require_once('../../database/.config');

// REQUIRE conexion class
require_once('../../database/connect.database.php');

$DB = new MySQLDB($DATABASE_HOST,$DATABASE_USER,$DATABASE_PASSWORD,$DATABASE_NAME);

// call conexion instance
$con = $DB->connect();

// check authentication / local Storage
if(array_key_exists('auth_api',$_POST)){
    // check auth_api === local storage
    //if($localStorage == $_POST['auth_api']){}

    // values to insert
    $username               = $_POST['username']; 
    $email                  = $_POST['email'];
    $mobile_ddi             = "'000'";
    if(array_key_exists('mobile_international_code',$_POST)){
        if($_POST['mobile_international_code']!=='')
            $mobile_ddi         = "'".$_POST['mobile_international_code']."'";
    }
    $mobile                 = "'000'";
    if(array_key_exists('mobile_number',$_POST)){
        if($_POST['mobile_number']!=='')
            $mobile         = "'".$_POST['mobile_number']."'";
    }
    $office_id              = $_POST['office'];
    $authentication_string  = md5($_POST['password']);

    // Query creation
    $sql = "INSERT INTO users (id,username,email,level_account,user_type,user_language,office_id,mobile_international_code,mobile_number,authentication_string,account_locked,created_at,updated_at) VALUES ((UUID()),'$username','$email','20','user','esp','$office_id',$mobile_ddi,$mobile,'$authentication_string','N',now(),now())";
    // INSERT data
    //echo $sql;
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