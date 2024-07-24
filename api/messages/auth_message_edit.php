<?php
error_reporting(E_ALL);
ini_set('display_errors', 1); 

//REQUIRE GLOBAL conf
require_once('../../database/.config');

// REQUIRE conexion class
require_once('../../database/connect.database.php');

$DB = new MySQLDB($DATABASE_HOST,$DATABASE_USER,$DATABASE_PASSWORD,$DATABASE_NAME);

// call conexion instance
$con = $DB->connect();

// check authentication / local Storage
if(array_key_exists('auth_api',$_REQUEST)){

    $mtid = null;
    if(array_key_exists('mtid',$_REQUEST)){
        $mtid   = $_REQUEST['mtid'];
    }

    $columns    = "name,message_text,module_name,is_active,create_at,updated_at"
    $sett       = "updated_at=now()";
    // values to update
    if(array_key_exists('name',$_REQUEST)){
        if($_REQUEST['name']!==''){
            $sett .= ",name='".addslashes(urldecode($_REQUEST['name']))."'";
        }
    }
    if(array_key_exists('message_text',$_REQUEST)){
        if($_REQUEST['message_text']!==''){
            $sett .= ",message_text='".addslashes(urldecode($_REQUEST['message_text']))."'";
        }
    }
    if(array_key_exists('module_name',$_REQUEST)){
        if($_REQUEST['module_name']!==''){
            $sett .= ",module_name='".addslashes(urldecode($_REQUEST['module_name']))."'";
        }
    }

    header('Content-type: application/json');
    if(!is_null($mtid)){
        // Query creation
        $sql = "UPDATE messagetemplates SET $sett WHERE id='".$mtid."'";
        // INSERT data
        $rs = $DB->executeInstruction($sql);

        //echo $sql;

        // Response JSON 
        if($rs){
            echo json_encode(['status' => 'OK']);
        } else {
            echo json_encode(['status' => 'ERROR_SQL']);
        }
    } else {
        echo json_encode(['status' => 'ERROR_NOID']);
    }
}

//close connection
$DB->close();
?>