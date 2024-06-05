<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', true);

//echo "TESTE";

//REQUIRE GLOBAL conf
require_once('../../database/.config');

// REQUIRE conexion class
require_once('../../database/connect.database.php');

$DB = new MySQLDB($DATABASE_HOST,$DATABASE_USER,$DATABASE_PASSWORD,$DATABASE_NAME);

// call conexion instance
$con = $DB->connect();

// check authentication / local Storage
if(array_key_exists('auth_api',$_REQUEST)){
    
    $token = $_REQUEST['auth_api'];

    $sqlTkUser = "SELECT user_type, level_account FROM view_users WHERE UUID = '".$_COOKIE['uuid']."' AND token like '%".str_replace(" ","+",urldecode($token))."%'";
    
    $rsTkUser = $DB->getData($sqlTkUser);

    //echo $sqlTkUser;
    
    // check auth_api === local storage
    //if($localStorage == $_REQUEST['auth_api']){}

    // User Group
    $group          = $rsTkUser[0]['user_type'];
    $level          = $rsTkUser[0]['level_account'];

    // setting query
    $offSet         = 0;
    $numberOfRegistries = 20;
    $columns        = "UUID,product_id,making_banners, production_cost, production_cost_int, product_name,salemodel_id,is_taxable,tax_percent_int,salemodel_name,provider_id,provider_name,user_id,username,client_id,client_name,agency_id,agency_name,status_id,status_name,status_percent,offer_name,description,start_date,stop_date,sum(amount) as amount,currency,quantity,is_active";
    $tableOrView    = "view_proposals";
    $orderBy        = " group by UUID";
    
    // filters
    $filters                = "is_active = 'Y' ";
    $xfilter                = "";
    if($level < '99999'){
        $xfilter = "AND status_percent <= 25 AND status_percent <> 0";
    }

    if($level < '50'){
        $xfilter = "AND user_id = '".$_COOKIE['uuid']."' ";
    }

    $filters .= $xfilter;

    if(array_key_exists('search',$_REQUEST)){
        if($_REQUEST['search']!==''){
            if($filters != '')
                $filters .= " AND ";
            $jocker         = $_REQUEST['search'];
            $filters        .= " search like '%$jocker%'";
        }
    }

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
    
    if($filters !== ''){
        $filters = "WHERE ".$filters;
    }

    // Query creation
    $sql = "SELECT $columns FROM $tableOrView $filters $orderBy";
    $sqlPaged = "SELECT $columns FROM $tableOrView $filters $orderBy $limit";
    
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