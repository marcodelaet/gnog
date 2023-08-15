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
    $columns = "(id) as uuid_full, code, name, description, is_active";
    $tableOrView    = "products";
    $orderBy        = "order by name";
  
    // filters
    $filters                = '';
    if(array_key_exists('search',$_REQUEST)){
        if($_REQUEST['search']!==''){
            $jocker         = $_REQUEST['search'];
            $filters        .= "AND search like '%$jocker%'";
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
                    if($filters != '')
                        $filters .= " AND ";
                    else
                        $filters .= " ( ";
                    $jocker         = explode("|||",$wherers[$i]);
                    $filters        .= " $jocker[0]='$jocker[1]'";
                }
            }
            $filters .= " ) ";
        }
    }


    $filtered= "WHERE is_active='Y'"; 
    if($filters != '')
        $filters = "$filtered AND ( $filters )";

    
    


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