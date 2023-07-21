<?php


// ini_set('error_reporting', E_ALL);
// ini_set('display_errors', true);

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
    $product_id     = str_replace("[","",str_replace("]","",$_REQUEST['product_id'])); 
    $proposal_id    = $_REQUEST['proposal_id']; 
    $salemodel_id   = str_replace("[","",str_replace("]","",$_REQUEST['salemodel_id'])); 
    $price          = str_replace("[","",str_replace("]","",$_REQUEST['price'])); 
    $currency       = $_REQUEST['currency'];
    $state_id       = str_replace("[","",str_replace("]","",$_REQUEST['state'])); 
    $city_id        = str_replace("[","",str_replace("]","",$_REQUEST['city'])); 
    $county_id      = str_replace("[","",str_replace("]","",$_REQUEST['county'])); 
    $colony_id      = str_replace("[","",str_replace("]","",$_REQUEST['colony'])); 
    $quantity       = str_replace("[","",str_replace("]","",$_REQUEST['quantity'])); 
    $xprovider      = str_replace("[","",str_replace("]","",$_REQUEST['provider_id']));
    $provider_id    = "null"; 
    $xquantity       = "1";
    $xprice          = "0";
    
    $aProducts  = explode(",",$product_id);
    $aSalemodel = explode(",",$salemodel_id);
    $aPrice     = explode(",",$price);
    $aQuantity  = explode(",",$quantity);
    $aProvider  = explode(",",$xprovider);
    $aState     = explode(",",$state_id);
    $aCity      = explode(",",$city_id);
    $aCounty    = explode(",",$county_id);
    $aColony    = explode(",",$colony_id);

    $lastIndex  = 0;
    $response   = "ERROR"; 
    for($i = 0; $i < count($aProducts); $i++){
        
        if(array_key_exists('provider_id',$_REQUEST)){
            if($aProvider[$i] !== '0')
                $provider_id= "('".$aProvider[$i]."')";
        }
        if(array_key_exists('quantity',$_REQUEST)){
            if(($aQuantity[$i] !== '0') || ($aQuantity[$i] !== ''))
                $xquantity   = $aQuantity[$i];
        }
        if(array_key_exists('price',$_REQUEST)){
            if(($aPrice[$i] !== '0') || ($aPrice[$i] !== ''))
                $xprice      = $aPrice[$i];
        }

        // Query creation
        $sql = "INSERT INTO proposalsxproducts (id,product_id,proposal_id,salemodel_id,provider_id,state,city,county,colony,price_int,currency,quantity,is_active,created_at,updated_at) VALUES ((UUID()),('".$aProducts[$i]."'),('$proposal_id'),('".$aSalemodel[$i]."'),$provider_id,'$aState[$i]','$aCity[$i]','$aCounty[$i]','$aColony[$i]',$xprice,'$currency',$xquantity,'Y',now(),now())";
        //echo "<BR/>".$sql;
        // INSERT data
        $rs = $DB->executeInstruction($sql);

        // Response JSON 
        if($rs){
            $lastIndex  = $i;
            $response   = "OK";
                
        } else { $response = "ERROR";}
    } 
    header('Content-type: application/json');
    echo json_encode(["lastIndex" => $i,"status" => $response]);
}

//close connection
$DB->close();
?>