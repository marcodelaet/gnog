<?php


ini_set('error_reporting', E_ALL);
ini_set('display_errors', true);

//REQUIRE GLOBAL conf
require_once('../../database/.config');

// REQUIRE conexion class
require_once('../../database/connect.database.php');

// Loading SendMail class
require('../../assets/lib/SendMail.php');

// Creating a new instance to SendMail class
$SendGNogMail = new SendMail();

$from_name     = 'GNog Media - Providers';
$from_email    = 'nocontestar@gnogmedia.com';
//$to_name       = 'Lorena Saitta, Christian Nolasco, Fernando Nogueira, Marco De Laet, Estephanie Torres, Amanda Gómes Morales, Juan Jose';
//$to_email      = 'lorena@gnogmedia.com, finanzas@gnog.com.mx, fernando@gnog.com.mx, it@gnog.com.br, estephanie@gnog.com.mx, amanda@gnog.com.mx, juan@gnog.com.mx';
$signFilePath  = 'platform_CRM.png';

if(!isset($DB)){
    $DB = new MySQLDB($DATABASE_HOST,$DATABASE_USER,$DATABASE_PASSWORD,$DATABASE_NAME);

    // call conexion instance
    $con = $DB->connect();
}

// REQUIRE utils functions
require_once('../../assets/lib/translation.php');

// check authentication / local Storage
if(array_key_exists('auth_api',$_REQUEST)){
    // check auth_api === local storage
    //if($localStorage == $_REQUEST['auth_api']){}
    $user_token = $_REQUEST['auth_api'];
    $auth_api   = $_REQUEST['auth_api'];

    $user_id    = $_REQUEST['uid']; 
    $newDate  = '0';
    if(array_key_exists('newDate',$_REQUEST))
        $newDate = $_REQUEST['newDate'];

    $oldDate  = '0';
    if(array_key_exists('oldDate',$_REQUEST))
        $oldDate = $_REQUEST['oldDate'];

    $proposalId = '0';
    if(array_key_exists('ppid',$_REQUEST))
        $proposalId = $_REQUEST['ppid'];
    
    // update Stop Date
    if(($newDate != '0') && ($proposalId != '0')){
        $sett   = "updated_at=now(),stop_date='$newDate 00:00:00'";
    }
        

    // Query creation
    $sql = "UPDATE proposals SET $sett WHERE id='".$proposalId."'";
    //echo $sql;
    // UPDATE data
    $rs = $DB->executeInstruction($sql);

    // Response JSON 
    if($rs){
        $description_en     = "Changed Stop Date from $oldDate to $newDate";
        $description_es     = "Cambio de la fecha final de $oldDate para $newDate";
        $description_ptbr   = "Alteração da Data final de $oldDate para $newDate";
        // setting history log
        setHistory($user_id,'proposals',$proposalId,$description_en,$description_es,$description_ptbr,$user_token,$auth_api,'text');

        header('Content-type: application/json');
        echo json_encode(['response' => 'OK']);
    }
}

//close connection
$DB->close();
?>