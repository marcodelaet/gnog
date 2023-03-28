<?php


ini_set('error_reporting', E_ALL);
ini_set('display_errors', true);

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
    $columns        = "id,proposalproduct_id,billboard_id,price_int,is_active,created_at,updated_at";
    $tableOrView    = "productsxbillboards";
    
    $billboard_id       = '';
    if(array_key_exists('bid',$_REQUEST)){
        $billboard_id       = $_REQUEST['bid'];
    }
    $proposalproduct_id = '';
    if(array_key_exists('pppid',$_REQUEST)){
        $proposalproduct_id = $_REQUEST['pppid'];
    }
    $price              = '';
    if(array_key_exists('pc',$_REQUEST)){
        $price              = ((str_replace('.','',str_replace(',','',$_REQUEST['pc']))));
    }
    $provider_id        = '';
    if(array_key_exists('pid',$_REQUEST)){
        $provider_id        = $_REQUEST['pid'];
    }

    /*************************************************
     * Adding Provider to ProposalxProduct
     ************************************************/
    $sqlpp  = "SELECT proposal_id, product_id, salemodel_id, provider_id, state, price_int, currency, quantity FROM proposalsxproducts WHERE id='$proposalproduct_id'";

    $rspp   = $DB->getData($sqlpp);

    $proposal_id    = $rspp[0]['proposal_id'];
    $product_id     = $rspp[0]['product_id'];
    $salemodel_id   = $rspp[0]['salemodel_id'];
    $pp_provider_id = $rspp[0]['provider_id'];
    $state          = "NULL";
    if(!is_null($rspp[0]['state'])){
        $state = "'".$rspp[0]['state']."'";
    }
    $price_int      = $rspp[0]['price_int'];
    $currency       = $rspp[0]['currency'];
    $quantity       = $rspp[0]['quantity'];

    $sqlCheckPpp  = "SELECT id FROM proposalsxproducts WHERE proposal_id='$proposal_id' AND salemodel_id='$salemodel_id' AND provider_id='$provider_id' AND state=$state AND price_int=$price_int AND currency='$currency' AND quantity=$quantity";

    $rsNumRowsPpp = $DB->numRows($sqlCheckPpp);
    
    if($rsNumRowsPpp < 1){
        if(is_null($pp_provider_id)){
            // update
            $sqlInsertPP = "UPDATE proposalsxproducts SET provider_id = '$provider_id' WHERE proposal_id='$proposal_id' AND salemodel_id='$salemodel_id' AND state=$state AND price_int=$price_int AND currency='$currency' AND quantity=$quantity";
        } else {
            // insert
            $sqlInsertPP = "INSERT INTO proposalsxproducts (id,proposal_id, product_id, salemodel_id, provider_id, state, price_int, currency, quantity, is_active, created_at, updated_at) VALUES (UUID(),'$proposal_id','$product_id','$salemodel_id','$provider_id',$state,$price_int,'$currency',$quantity,'Y',now(),now())";
        }
        $DB->executeInstruction($sqlInsertPP);
    }

    $sqlPpp  = "SELECT id FROM proposalsxproducts WHERE proposal_id='$proposal_id' AND salemodel_id='$salemodel_id' AND provider_id='$provider_id' AND state=$state AND price_int=$price_int AND currency='$currency' AND quantity=$quantity";

    $rsppp          = $DB->getData($sqlPpp);

    $proposalproduct_id    = $rsppp[0]['id'];

    $values = "UUID(),'$proposalproduct_id','$billboard_id',$price,'Y',now(),now()";


    /*************************************************
     * Adding billboard to productxbillboards
     ************************************************/
    // Query creation
    $sql = "INSERT INTO $tableOrView ($columns) VALUES ($values)";
    // LIST data
    //echo $sql;

    //$rs = false;
    $rs = $DB->executeInstruction($sql);
    // Response JSON 
    header('Content-type: application/json');
    if($rs){
        echo json_encode(["response" => "OK"]);
    } else {
        echo json_encode(["response" => "ERROR"]);//,$sqlCheckPpp,$rsNumRowsPpp,$sqlInsertPP]);
    }
}

//close connection
$DB->close();
?>