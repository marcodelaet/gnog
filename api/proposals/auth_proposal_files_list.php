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

    $sqlTkUser = "SELECT user_type FROM view_users WHERE UUID = '".$_COOKIE['uuid']."' AND token like '%".str_replace(" ","+",urldecode($token))."%'";
    
    $rsTkUser = $DB->getData($sqlTkUser);

    //echo $sqlTkUser;
    
    // check auth_api === local storage
    //if($localStorage == $_REQUEST['auth_api']){}

    // User Group
    $group          = $rsTkUser[0]['user_type'];

    // setting query
    $offSet         = 0;
    $numberOfRegistries = 20;
    $columns        = "user_id,file_location,file_name,file_type,file_description,file_is_active,file_created_at,file_updated_at,module_type,proposalproduct_id,proposal_id,product_name,product_id,salemodel_name,salemodel_id,user_email,search";
    $tableOrView    = "view_proposal_files";
    $orderBy        = " ORDER BY file_updated_at DESC";

    // filters
    $filters                = "file_is_active = 'Y' ";
    if(array_key_exists('pppid',$_REQUEST)){
        if($filters != '')
            $filters .= " AND ";
        $filters .= " proposalproduct_id = '".$_REQUEST['pppid']."' ";
    }

    if(array_key_exists('ppid',$_REQUEST)){
        if($filters != '')
            $filters .= " AND ";
        $filters .= " proposal_id = '".$_REQUEST['ppid']."' ";
    }

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