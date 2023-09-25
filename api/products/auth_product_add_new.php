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

    // values to insert
    $product_id     = str_replace("[","",str_replace("]","",$_REQUEST['product_id'])); 
    $proposal_id    = $_REQUEST['proposal_id'];
    $xsalemodel_id  = str_replace("[","",str_replace("]","",$_REQUEST['salemodel_id'])); 
    $price          = str_replace("[","",str_replace("]","",$_REQUEST['price'])); 
    $cost           = str_replace("[","",str_replace("]","",$_REQUEST['cost'])); 
    $currency       = $_REQUEST['currency'];
    $state_id       = str_replace("[","",str_replace("]","",$_REQUEST['state'])); 
    $city_id        = str_replace("[","",str_replace("]","",$_REQUEST['city'])); 
    $county_id      = str_replace("[","",str_replace("]","",$_REQUEST['county'])); 
    $colony_id      = str_replace("[","",str_replace("]","",$_REQUEST['colony'])); 
    $quantity       = str_replace("[","",str_replace("]","",$_REQUEST['quantity'])); 
    $xprovider      = str_replace("[","",str_replace("]","",$_REQUEST['provider_id']));
    $xbillboard_id  = str_replace("[","",str_replace("]","",$_REQUEST['billboard_id']));
    $provider_id    = "null"; 
    $salemodel_id   = "null"; 
    $xquantity      = "1";
    $xprice         = "0";
    
    $aProducts  = explode(",",$product_id);
    $aSalemodel = explode(",",$xsalemodel_id);
    $aCost      = explode(",",$cost);
    $aPrice     = explode(",",$price);
    $aQuantity  = explode(",",$quantity);
    $aProvider  = explode(",",$xprovider);
    $aState     = explode(",",$state_id);
    $aCity      = explode(",",$city_id);
    $aCounty    = explode(",",$county_id);
    $aColony    = explode(",",$colony_id);
    $aBillboard = explode(",",$xbillboard_id);

    $lastIndex  = 0;
    $pppid      = '';
    $response   = "ERROR"; 
    for($i = 0; $i < count($aProducts); $i++){
        if(array_key_exists('provider_id',$_REQUEST)){
            if($aProvider[$i] !== '0')
                $provider_id= "('".$aProvider[$i]."')";
        }
        if(array_key_exists('salemodel_id',$_REQUEST)){
            if($aSalemodel[$i] !== '0')
                $salemodel_id= "('".$aSalemodel[$i]."')";
        }
        if(array_key_exists('quantity',$_REQUEST)){
            if(($aQuantity[$i] !== '0') || ($aQuantity[$i] !== ''))
                $xquantity   = $aQuantity[$i];
        }
        if(array_key_exists('cost',$_REQUEST)){
            if(($aCost[$i] !== '0') || ($aCost[$i] !== ''))
                $xcost      = $aCost[$i];
        }
        if(array_key_exists('price',$_REQUEST)){
            if(($aPrice[$i] !== '0') || ($aPrice[$i] !== ''))
                $xprice      = $aPrice[$i];
        }
        if(array_key_exists('billboard_id',$_REQUEST)){
            if($aBillboard[$i] !== '0')
                $billboard_id= "('".$aBillboard[$i]."')";
        }

        // Query creation
        $sql = "INSERT INTO proposalsxproducts (id,product_id,proposal_id,salemodel_id,provider_id,state,city,county,colony,cost_int,price_int,currency,quantity,is_active,created_at,updated_at) VALUES ((UUID()),('".$aProducts[$i]."'),('$proposal_id'),($salemodel_id),$provider_id,'$aState[$i]','$aCity[$i]','$aCounty[$i]','$aColony[$i]',$xcost,$xprice,'$currency',$xquantity,'Y',now(),now())";
        //echo "<BR/>".$sql;
        // INSERT data
        $rs = $DB->executeInstruction($sql);

        // Response JSON 
        if($rs){
            $lastIndex  = $i;
            $response   = "OK";
            $sqlGetPPPID = "SELECT id FROM proposalsxproducts WHERE product_id='".$aProducts[$i]."' AND proposal_id='$proposal_id' AND salemodel_id=$salemodel_id AND provider_id= $provider_id AND state='$aState[$i]' AND city='$aCity[$i]' AND county='$aCounty[$i]' AND colony='$aColony[$i]' AND price_int=$xprice AND currency='$currency' AND quantity=$xquantity";
            $pppid = $DB->getDataSingle($sqlGetPPPID)['id'];

            $columns        = "id,proposalproduct_id,billboard_id,cost_int,price_int,is_active,created_at,updated_at";
            $tableOrView    = "productsxbillboards";
            $values         = "UUID(),'$pppid',$billboard_id,$xcost,$xprice,'Y',now(),now()";

            if($aBillboard[$i] !== '0'){
                // Query creation
                $sqlPPP = "INSERT INTO $tableOrView ($columns) VALUES ($values)";
                //echo $sqlPPP;

                $rsPPP = $DB->executeInstruction($sqlPPP);
                if($rsPPP){
                    $response   = "OK";
                } else {
                    $response   = "ERROR_PPP";
                }
            }
        } else { $response = "ERROR";}
    } 
    header('Content-type: application/json');
    echo json_encode(["lastIndex" => $i,"pppid"=>$pppid,"status" => $response]);
}
//close connection
$DB->close();
?>