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
    
    $sett   = "updated_at=now()";
    // values to update
    if(array_key_exists('price_int',$_REQUEST)){
        if($_REQUEST['price_int']!==''){
            $sett .= ",price_int='".str_replace(' ','',$_REQUEST['price_int'])."'";
        }
    }
    if(array_key_exists('cost_int',$_REQUEST)){
        if($_REQUEST['cost_int']!==''){
            $sett .= ",cost_int='".str_replace(' ','',$_REQUEST['cost_int'])."'";
        }
    }
    // Query creation
    $sql = "UPDATE billboards SET $sett WHERE id='".$_REQUEST['bid']."'";
    // INSERT data
    $rs = $DB->executeInstruction($sql);

    //echo $sql;

    // Response JSON 
    if($rs){
        header('Content-type: application/json');
        echo json_encode(['status' => 'OK']);
    }
}

//close connection
$DB->close();
?>