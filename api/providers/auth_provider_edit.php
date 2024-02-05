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
    // check auth_api === local storage
    //if($localStorage == $_REQUEST['auth_api']){}
    
    $sett   = "updated_at=now()";
    // values to update
    if(array_key_exists('name',$_REQUEST)){
        if($_REQUEST['name']!==''){
            $sett .= ",name='".addslashes(urldecode($_REQUEST['name']))."'";
        }
    }
    if(array_key_exists('address',$_REQUEST)){
        if($_REQUEST['address']!==''){
            $sett .= ",address='".addslashes(urldecode($_REQUEST['address']))."'";
        }
    }
    if(array_key_exists('webpage_url',$_REQUEST)){
        if($_REQUEST['webpage_url']!==''){
            $sett .= ",webpage_url='".addslashes(urldecode($_REQUEST['webpage_url']))."'";
        }
    }

    /* ***************************************
    ** PRODUCT FIELDS DISABLED ***************
    ******************************************

    if(array_key_exists('product_id',$_REQUEST)){
        if($_REQUEST['product_id']!=='0'){
            $sett .= ",product_id=('".$_REQUEST['product_id']."')";
        }
    }
    if(array_key_exists('salemodel_id',$_REQUEST)){
        if($_REQUEST['salemodel_id']!=='0'){
            $sett .= ",salemodel_id=('".$_REQUEST['salemodel_id']."')";
        }
    }
    
    if(array_key_exists('product_price',$_REQUEST)){
        $product_price = (float)str_replace(",",".",str_replace(".","",$_REQUEST['product_price'])) * 100;
        echo $product_price;
        if($product_price>0){
            $sett .= ",product_price=".$product_price;
        }
    }
    if(array_key_exists('currency',$_REQUEST)){
        if($_REQUEST['currency']!==''){
            $sett .= ",currency='".$_REQUEST['currency']."'";
        }
    }

    *****************************************************************/
    
    // Query creation
    $sql = "UPDATE providers SET $sett WHERE id=('".$_REQUEST['pid']."')";
    // INSERT data
    $rs = $DB->executeInstruction($sql);

    //echo $sql;

    // Response JSON 
    if($rs){
        header('Content-type: application/json');
        echo json_encode(['status' => 'OK']);
    }
}

//close connection
$DB->close();
?>