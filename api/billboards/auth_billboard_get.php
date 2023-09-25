<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', true);
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
    $columns        = "left(uuid,13) as uuid, uuid as uuid_full, name, category, address, state, height, width, coordenates, latitud, longitud, price, cost, is_iluminated, is_digital, provider_name, salemodel_name, viewpoint_name, photo, is_active";
    $tableOrView    = "view_billboards";

    if(array_key_exists('cln',$_REQUEST)){
        $columns    = $_REQUEST['cln'];
    }

    // filters
    $uuid                   = '';

    $filters                = "is_active = 'Y'"; // always searching by actived lines
    if(array_key_exists('bid',$_REQUEST)){
        if($_REQUEST['bid']!==''){
            if($filters != '')
                $filters .= " AND ";
            $uuid         = $_REQUEST['bid'];
            $filters        .= " uuid = '$uuid'";
        }
    }

    if(array_key_exists('where',$_GET)){
        if($_GET['where']!==''){
            if($filters != '')
                $filters .= " AND ( ";
                
            $multiWhere = explode("*|*",$_GET['where']);
           // echo $multiWhere;
            for($m=0; $m< count($multiWhere); $m++){
                $wherers    = explode("***",$multiWhere[$m]);
                if($m > 0)
                    $filters .= " ) OR ( ";
                for($i=0; $i< count($wherers); $i++){
                    if(count($wherers) > 1){
                        if($filters != '')
                            $filters .= " AND ";
                        else
                            $filters .= " ( ";
                    }
                    $jocker         = explode("|||",$wherers[$i]);
                    $filters        .= " $jocker[0]='$jocker[1]'";
                }
            }
            $filters .= " ) ";
        }
    }

    
    if($filters !== ''){
        $filters = "WHERE ".$filters;
    }

    // Query creation
    $sql = "SELECT $columns FROM $tableOrView $filters";
    // LIST data
//    echo $sql;

    $rs = $DB->getData($sql);
    // Response JSON 
    header('Content-type: application/json');
    if($rs){
        echo json_encode(["response" => "OK","data" => $rs]);
    } else {
        echo json_encode(["response" => "ERROR"]);
    }
}

//close connection
$DB->close();

?>