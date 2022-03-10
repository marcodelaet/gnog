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
    $columns = "left(uuid,13)as uuid, uuid as uuid_full, corporate_name, address, concat(contact_name,' ',contact_surname,' (', contact_email,')') as contact, contact_name, contact_surname, contact_email, contact_position, phone_international_code, phone_prefix, phone_number, is_agency, is_active, concat('+',phone_international_code,phone_number) as phone";
    $tableOrView    = "view_advertisers";
    $orderBy        = "order by corporate_name";

    // filters
    $filters                = '';
    if(array_key_exists('search',$_GET)){
        if($_GET['search']!==''){
            if($filters != '')
                $filters .= " AND ";
            $jocker         = $_GET['search'];
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