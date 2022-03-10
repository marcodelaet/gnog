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

    // values to insert
    $salemodel_id           = $_GET['salemodel_id'];
    $product_id             = $_GET['product_id'];
    $product_price          = (float)str_replace(",",".",str_replace(".","",$_REQUEST['product_price'])) * 100;
    $currency               = $_GET['currency'];
    $name                   = $_GET['name'];
    $webpage_url            = $_GET['webpage_url'];
    $address                = $_GET['address'];
    $main_contact_name      = $_GET['main_contact_name'];
    $main_contact_surname   = $_GET['main_contact_surname'];
    $main_contact_email     = $_GET['main_contact_email'];
    $main_contact_position  = $_GET['main_contact_position'];
    $phone_ddi             = "000";
    if(array_key_exists('phone_ddi',$_GET)){
        if($_GET['phone_ddi']!=='')
            $phone_ddi         = $_GET['phone_ddi'];
    }
    $phone                 = "000";
    if(array_key_exists('phone',$_GET)){
        if($_GET['phone']!=='')
            $phone         = $_GET['phone'];
    }

    $columns    = "id, product_id, salemodel_id, product_price, currency, name, webpage_url, address, is_active, created_at, updated_at";
    $values     = "(UUID()),('$product_id'),('$salemodel_id'),$product_price,'$currency','$name','$webpage_url','$address','Y',now(),now()";
    $table      = "providers";

    // Query creation
    $sql = "INSERT INTO $table ($columns) VALUES ($values)";
    // INSERT data
    $rs = $DB->executeInstruction($sql);

    // Response JSON 
    if($rs){
        header('Content-type: application/json');
        echo json_encode(['status' => 'OK']);
    }
}

//close connection
$DB->close();
?>