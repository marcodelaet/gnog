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
    if(array_key_exists('corporate_name',$_REQUEST)){
        if($_REQUEST['corporate_name']!==''){
            $sett .= ",corporate_name='".$_REQUEST['corporate_name']."'";
        }
    }
    if(array_key_exists('address',$_REQUEST)){
        if($_REQUEST['address']!==''){
            $sett .= ",address='".$_REQUEST['address']."'";
        }
    }
    if(array_key_exists('main_contact_name',$_REQUEST)){
        if($_REQUEST['main_contact_name']!==''){
            $sett .= ",main_contact_name='".$_REQUEST['main_contact_name']."'";
        }
    }
    if(array_key_exists('main_contact_surname',$_REQUEST)){
        if($_REQUEST['main_contact_surname']!==''){
            $sett .= ",main_contact_surname='".$_REQUEST['main_contact_surname']."'";
        }
    }
    if(array_key_exists('main_contact_email',$_REQUEST)){
        if($_REQUEST['main_contact_email']!==''){
            $sett .= ",main_contact_email='".$_REQUEST['main_contact_email']."'";
        }
    }
    if(array_key_exists('main_contact_position',$_REQUEST)){
        if($_REQUEST['main_contact_position']!==''){
            $sett .= ",main_contact_position='".$_REQUEST['main_contact_position']."'";
        }
    }
    if(array_key_exists('phone_ddi',$_REQUEST)){
        if($_REQUEST['phone_ddi']!==''){
            $sett .= ",phone_international_code='".$_REQUEST['phone_ddi']."'";
        }
    }
    if(array_key_exists('phone',$_REQUEST)){
        if($_REQUEST['phone']!==''){
            $sett .= ",phone_number='".$_REQUEST['phone']."'";
        }
    }

    // Query creation
    $sql = "UPDATE advertisers SET $sett WHERE id=('".$_REQUEST['tid']."')";
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