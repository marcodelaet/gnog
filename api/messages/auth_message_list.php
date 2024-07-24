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
    
    // setting query
    $addColumn  = "";
    if(array_key_exists("addcolumn",$_REQUEST)){
        if($_REQUEST['addcolumn']!==''){
            $addColumn      = $_REQUEST["addcolumn"].",";
        }
    }

    $offSet         = 0;
    $numberOfRegistries = 25;
    $columns        = "uuid,name,message_text,message_text_esp,message_text_eng,message_text_ptbr,module_name,is_active,search";
    $tableOrView    = "view_messagetemplates";
    $orderBy        = "";
    $groupBy        = "";

    // page
    if(array_key_exists('p',$_REQUEST)){
        if($_REQUEST['p']!==''){
            $offSet        = intval($_REQUEST['p']) * $numberOfRegistries;
        }
    }
    $limit          = "limit $offSet, $numberOfRegistries";

    // order by
    if(array_key_exists('orderby',$_REQUEST)){
        if($_REQUEST['orderby']!==''){
            $ordered        = $_REQUEST['orderby'];
            $orderBy        = " ORDER BY $ordered";
        }
    }

    // group by
    if(array_key_exists('groupby',$_REQUEST)){
        if($_REQUEST['groupby']!==''){
            $grouped        = $_REQUEST['groupby'];
            $groupBy        = " ORDER BY $grouped";
        }
    }
    
    // filters
    $filters                = '';

    if(array_key_exists('search',$_REQUEST)){
        if($_REQUEST['search']!==''){
            if($filters != '')
                $filters .= " AND ";
            $jocker         = $_REQUEST['search'];
            $filters        .= " search like '%$jocker%'";
        }
    }
    
    if(array_key_exists('mtid',$_REQUEST)){
        if($_REQUEST['mtid']!==''){
            if($filters != '')
                $filters .= " AND ";
            $messagetemplate_id         = $_REQUEST['mtid'];
            $filters        .= " UUID = '$messagetemplate_id'";
        }
    }

    if($filters !== ''){
        $filters = "WHERE ".$filters;
    }

    // Query creation
    $sql = "SELECT $columns FROM $tableOrView $filters $groupBy $orderBy";
    $sqlPaged = "SELECT $columns FROM $tableOrView $filters $groupBy $orderBy $limit";
    // LIST data
    // echo $sql;
    $rs = $DB->getData($sqlPaged);
    $rsNumRows = $DB->numRows($sql);

    // Response JSON 
    $return = array('response'=>'error');
    header('Content-type: application/json');
    if($rs){
        if($rsNumRows > 0){
            $totalPages  = intval($rsNumRows / $numberOfRegistries)+1;
            $return = array("response" => "OK","data" => $rs, "rows" => $rsNumRows, "pages" => "$totalPages");
        }else{
            $return = array('response'=>'ZERO_RETURN');
        }
    }
    echo json_encode($return);
}

//close connection
$DB->close();
?>