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
    $columns        = "id,proposalproduct_id,billboard_id,price_int,is_active,created_at,updated_at";
    $tableOrView    = "productsxbillboards";
    
    $billboard_id       = '';
    if(array_key_exists('bid',$_REQUEST)){
        $billboard_id       = $_REQUEST['bid'];
    }
    $proposalproduct_id = '';
    if(array_key_exists('pppid',$_REQUEST)){
        $proposalproduct_id = $_REQUEST['pppid'];
    }
    $price              = '';
    if(array_key_exists('pc',$_REQUEST)){
        $price              = ((str_replace('.','',str_replace(',','',$_REQUEST['pc']))));
    }
    $provider_id        = '';
    if(array_key_exists('pid',$_REQUEST)){
        $provider_id        = $_REQUEST['pid'];
    }

    $values = "UUID(),'$proposalproduct_id','$billboard_id',$price,'Y',now(),now()";

    // Query creation
    $sql = "INSERT INTO $tableOrView ($columns) VALUES ($values)";
    // LIST data
    //echo $sql;

    $rs = $DB->executeInstruction($sql);
    // Response JSON 
    header('Content-type: application/json');
    if($rs){
        echo json_encode(["response" => "OK"]);
    } else {
        echo json_encode(["response" => "ERROR: $sql"]);
    }
}

//close connection
$DB->close();

?>