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
    if(array_key_exists('agency',$_REQUEST)){
        if($_REQUEST['agency']!==''){
            $sett .= ",is_agency='".$_REQUEST['agency']."'";
        }
    }
    if(array_key_exists('making_banners',$_REQUEST)){
        if($_REQUEST['making_banners']!==''){
            $sett .= ",making_banners='".$_REQUEST['making_banners']."'";
        }
    }

    if(array_key_exists('corporate_name',$_REQUEST)){
        if($_REQUEST['corporate_name']!==''){
            $sett .= ",corporate_name='".addslashes(urldecode($_REQUEST['corporate_name']))."'";
        }
    }
    if(array_key_exists('address',$_REQUEST)){
        if($_REQUEST['address']!==''){
            $sett .= ",address='".addslashes(urldecode($_REQUEST['address']))."'";
        }
    }
    if(array_key_exists('executive_id',$_REQUEST)){
        if($_REQUEST['executive_id']!==''){
            $sett .= ",executive_id='".$_REQUEST['executive_id']."'";
        }
    }

    // Query creation
    $sql = "UPDATE advertisers SET $sett WHERE id=('".$_REQUEST['aid']."')";
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