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
    
    $token = $_REQUEST['auth_api'];

    $sqlTkUser = "SELECT user_type FROM view_users WHERE UUID = '".$_COOKIE['uuid']."' AND token like '%".str_replace(" ","+",urldecode($token))."%'";
    
    $rsTkUser = $DB->getData($sqlTkUser);

    //echo $sqlTkUser;
    
    // check auth_api === local storage
    //if($localStorage == $_REQUEST['auth_api']){}

    // User Group
    $group          = $rsTkUser[0]['user_type'];

    // setting query
    $columns        = "UUID,product_id,making_banners, production_cost, production_cost_int, product_name,salemodel_id,is_taxable,tax_percent_int,salemodel_name,provider_id,provider_name,user_id,username,client_id,client_name,agency_id,agency_name,status_id,status_name,status_percent,offer_name,description,start_date,stop_date,sum(amount) as amount,currency,quantity,is_active";
    $tableOrView    = "view_proposals";
    $orderBy        = " group by UUID";
    
    // filters
    $filters                = "is_active = 'Y' ";
    if($group !== 'admin'){
        $filters .= "AND user_id = '".$_COOKIE['uuid']."' ";
    }

    if(array_key_exists('search',$_REQUEST)){
        if($_REQUEST['search']!==''){
            if($filters != '')
                $filters .= " AND ";
            $jocker         = $_REQUEST['search'];
            $filters        .= " search like '%$jocker%'";
        }
    }  
    
    if($filters !== ''){
        $filters = "WHERE ".$filters;
    }

    // Query creation
    $sql = "SELECT $columns FROM $tableOrView $filters $orderBy";
    // LIST data
    //echo $sql;
    $rs = $DB->getData($sql);
    $numberOfRows = $DB->numRows($sql); 

    // Response JSON 
    header('Content-type: application/json');
    if($rs){
        if($numberOfRows > 0){
            echo json_encode($rs);
        }
        else
            echo "[{'response':'0 results'}]";
    }
    else{
        echo '[{"response":"Error"}]';
    }
}

//close connection
$DB->close();
?>