<?php

// ini_set('error_reporting', E_ALL);
// ini_set('display_errors', true);

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

    $cost_int = 0;
    if(array_key_exists('cst',$_REQUEST))
        $cost_int = $_REQUEST['cst'];
    // update locked Status
    $sett   = "updated_at=now(),production_cost_int=$cost_int";

    // Query creation
    $sql = "UPDATE proposalsxproducts SET $sett WHERE id='".$_REQUEST['pppid']."'";
    //echo $sql;
    // UPDATE data
    $rs = $DB->executeInstruction($sql);


    // Response JSON 
    if($rs){
        header('Content-type: application/json');
        echo json_encode(['response' => 'OK']);
    }
}

//close connection
$DB->close();
?>