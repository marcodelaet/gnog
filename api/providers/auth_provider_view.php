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

    // setting query
    $columns        = "left(uuid,13) as uuid, uuid as uuid_full, product_id, product_name, salemodel_id, salemodel_name, product_price, currency, name, address, webpage_url, concat(contact_name,' ', contact_surname,' (', contact_email,')') as contact, contact_name, contact_surname, contact_email, contact_position, phone_international_code, phone_prefix, phone_number, concat('+',phone_international_code,phone_number) as phone, is_active";
    $tableOrView    = "view_providers";
    $orderBy        = "order by name";

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