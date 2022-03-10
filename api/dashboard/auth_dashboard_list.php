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

    // User Group
    $group          = 'user';

    // setting query
    $columns        = "UUID,product_id,product_name,salemodel_id,salemodel_name,provider_id,provider_name,user_id,username,client_id,client_name,agency_id,agency_name,status_id,status_name,status_percent,offer_name,description,start_date,stop_date,month_diff_data,sum(amount) as amount,sum(amount_int) as amount_int, sum(amount_per_month) as amount_per_month, sum(amount_per_month_int) as amount_per_month_int, currency,quantity,is_active";
    $tableOrView    = "view_proposals";
    $orderBy        = " group by UUID";

    // filters
    $filters                = '';
    if($group !== 'admin'){
        $filters .= "user_id = '".$_COOKIE['uuid']."' ";
    }

    if(array_key_exists('search',$_REQUEST)){
        if($_REQUEST['search']!==''){
            if($filters != '')
                $filters .= " AND ";
            $jocker         = $_REQUEST['search'];
            $filters        .= " search like '%$jocker%'";
        }
    }

    if(array_key_exists('date',$_REQUEST)){
        if($_REQUEST['date']!==''){
            if($filters != '')
                $filters .= " AND ";
            $fullDate         = $_REQUEST['date'];
            $filters        .= " (stop_date >= '$fullDate' and start_date <= '$fullDate')";
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

    // Response JSON 
    if($rs){
        header('Content-type: application/json');
        echo json_encode($rs);
    }
}

//close connection
$DB->close();
?>