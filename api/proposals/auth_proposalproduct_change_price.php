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

    $price_int = 0;
    if(array_key_exists('npc',$_REQUEST))
        $price_int = $_REQUEST['npc'];
    // update locked Status
    $sett   = "updated_at=now(),price_int=$price_int";

    // Query creation
    $sql = "UPDATE productsxbillboards SET $sett WHERE proposalproduct_id='".$_REQUEST['pppid']."' AND billboard_id='".$_REQUEST['pbid']."'";
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