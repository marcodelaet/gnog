<?php
/*
error_reporting(E_ALL);
ini_set('display_errors', 1); 
*/

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
    $addColumn  = "";
    if(array_key_exists("addcolumn",$_REQUEST)){
        if($_REQUEST['addcolumn']!==''){
            $addColumn      = $_REQUEST["addcolumn"].",";
        }
    }

    $offSet         = 0;
    $numberOfRegistries = 15;
    $columns        = "left(uuid,13) as uuid, uuid as uuid_full, product_id, product_name, $addColumn salemodel_id, salemodel_name, product_price, currency, name, address, webpage_url, concat(contact_name,' ', contact_surname,' (', contact_email,')') as contact, contact_name, contact_surname, contact_email, contact_position, phone_international_code, phone_prefix, phone_number, concat('+',phone_international_code,phone_number) as phone, is_active, concat(name,webpage_url,contact_name, contact_surname, contact_email,phone_international_code, phone_prefix, phone_number) as search";
    $tableOrView    = "view_providers";
    $orderBy        = "order by name";
    
    $groupBy        = "";

    // page
    if(array_key_exists('p',$_REQUEST)){
        if($_REQUEST['p']!==''){
            $offSet        = intval($_REQUEST['p']) * $numberOfRegistries;
        }
    }
    $limit          = "limit $offSet, $numberOfRegistries";

    if(array_key_exists('allRows',$_REQUEST)){
        if($_REQUEST['allRows']!=='0'){
            $limit = '';
            $numberOfRegistries = 10000000;
        }
    }

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
            $groupBy        = " GROUP BY $grouped";
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
    
    if(array_key_exists('where',$_GET)){
        if($_GET['where']!==''){
            if($filters != '')
                $filters .= " AND ";
            $jocker         = explode("-",$_GET['where']);
            $filters        .= " $jocker[0]='$jocker[1]'";
        }
    }
    if($filters !== ''){
        $filters = "WHERE ".$filters;
    }

    // Query creation
    $sql = "SELECT $columns FROM $tableOrView $filters $groupBy $orderBy";
    $sqlPaged = "SELECT $columns FROM $tableOrView $filters $groupBy $orderBy $limit";
    // LIST data
    //echo $sql;
    $rs = $DB->getData($sqlPaged);
    $rsNumRows = $DB->numRows($sql);

    // Response JSON
    header('Content-type: application/json'); 
    if($rsNumRows > 0){
        $totalPages  = intval($rsNumRows / $numberOfRegistries)+1;
        if($rs){
            echo json_encode(["response" => "OK","data" => $rs, "rows" => $rsNumRows, "pages" => "$totalPages"]);
        } else {
            echo json_encode(["response" => "ERROR"]);
        }  
    } else {
        echo json_encode(["response" => "ZERO_RETURN", "rows" => $rsNumRows, "pages" => "0"]);
    }
}

//close connection
$DB->close();
?>