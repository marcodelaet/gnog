<?php
//REQUIRE GLOBAL conf
require_once('../../database/.config');

// REQUIRE conexion class
require_once('../../database/connect.database.php');

$DB = new MySQLDB($DATABASE_HOST,$DATABASE_USER,$DATABASE_PASSWORD,$DATABASE_NAME);

// call conexion instance
$con = $DB->connect();

// check authentication / local Storage
if(array_key_exists('auth_api',$_POST)){
    // check auth_api === local storage
    //if($localStorage == $_REQUEST['auth_api']){}

    $sett   = 'updated_at=now()';

    $cost_int = 0;
    if(array_key_exists('cost',$_POST))
        $cost_int = str_replace(",","",str_replace(".","",$_POST['cost']));
    
    $sett   .= ",cost_int=$cost_int";

    $price_int = 0;
    if(array_key_exists('price',$_POST))
        $price_int = str_replace(",","",str_replace(".","",$_POST['price']));
    
    $sett   .= ",price_int=$price_int";

    $quantity = 1;
    if(array_key_exists('quantity',$_POST))
        $quantity = $_POST['quantity'];
    
    $sett   .= ",quantity=$quantity";

    $currency = 'MXN';
    if(array_key_exists('currency',$_POST))
        $currency = $_POST['currency'];
    
    $sett   .= ",currency='$currency'";


    $provider_id = 'null';
    if(array_key_exists('provider_id',$_POST)){
        if($_POST['provider_id'] !== '0'){
            $provider_id = "'".$_POST['provider_id']."'";
        }
    }
    
    $sett   .= ",provider_id=$provider_id";

    $product_id = 'null';
    if(array_key_exists('product_id',$_POST)){
        if($_POST['product_id'] !== '0')
            $product_id = "'".$_POST['product_id']."'";
    }
    $sett   .= ",product_id=$product_id";

    $salemodel_id = 'null';
    if(array_key_exists('salemodel_id',$_POST)){
        if($_POST['salemodel_id'] !== 0)
            $salemodel_id = "'".$_POST['salemodel_id']."'";
    }
    $sett   .= ",salemodel_id=$salemodel_id";

    $start_date_product = 'null';
    if(array_key_exists('start_date_product',$_POST)){
        if($_POST['start_date_product'] !== 0)
            $start_date_product = "'".$_POST['start_date_product']."'";
    }
    $sett   .= ",start_date=$start_date_product";

    $stop_date_product = 'null';
    if(array_key_exists('stop_date_product',$_POST)){
        if($_POST['stop_date_product'] !== 0)
            $stop_date_product = "'".$_POST['stop_date_product']."'";
    }
    $sett   .= ",stop_date=$stop_date_product";
    
    

    // Query creation
    $sql = "UPDATE proposalsxproducts SET $sett WHERE id='".$_POST['pppid']."' AND proposal_id='".$_POST['ppid']."'";
    //echo $sql;
    // UPDATE data
    $rs = $DB->executeInstruction($sql);


    // Response JSON 
    if($rs){
        header('Content-type: application/json');
        echo json_encode(['response' => 'OK']);
    }
}

//close connection
$DB->close();
?>