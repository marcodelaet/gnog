<?php
//REQUIRE GLOBAL conf
require_once('../../database/.config');

// REQUIRE conexion class
require_once('../../database/connect.database.php');

$DB = new MySQLDB($DATABASE_HOST,$DATABASE_USER,$DATABASE_PASSWORD,$DATABASE_NAME);

// call conexion instance
$con = $DB->connect();

// check authentication / local Storage
if(array_key_exists('auth_api',$_GET)){
    // check auth_api === local storage
    //if($localStorage == $_REQUEST['auth_api']){}
    // setting query
    $columns = "id as uuid_full, name, icon_flag, orderby, is_active";
    $tableOrView    = "offices";
    $orderBy        = "order by name";

    if(array_key_exists('order',$_GET)){
        if($_GET['order']!='')
            $orderBy = "order by ".$_GET['order'];
    }
    
    // filters
    $filters                = '';
    if(array_key_exists('where',$_GET)){
        if($_GET['where']!==''){
            $jocker         = $_GET['where'];
            $filters        .= " AND ". str_replace("-","='",$jocker)."'";
        }
    }
    
    $filters = "WHERE is_active='Y' ".$filters;

    // Query creation
    $sql = "SELECT $columns FROM $tableOrView $filters $orderBy";
    // LIST data
    //echo $sql;
    $rs = $DB->getData($sql);
    $numRows = $DB->numRows($sql);

    // Response JSON
    header('Content-type: application/json'); 
    if($rs){
        echo json_encode(['response'=>'OK','data'=>$rs,'numRows'=>$numRows]);
    } else {
        echo json_encode(['response'=>'ERROR']);
    }
}

//close connection
$DB->close();
?>