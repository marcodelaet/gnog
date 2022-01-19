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
    $product_id     = str_replace("[","",str_replace("]","",$_REQUEST['product_id'])); 
    $proposal_id    = $_REQUEST['proposal_id']; 
    $salemodel_id   = str_replace("[","",str_replace("]","",$_REQUEST['salemodel_id'])); 
    $price          = str_replace("[","",str_replace("]","",$_REQUEST['price'])); 
    $currency       = $_REQUEST['currency']; 
    $quantity       = str_replace("[","",str_replace("]","",$_REQUEST['quantity'])); 
    $xprovider      = str_replace("[","",str_replace("]","",$_REQUEST['provider_id']));
    $provider_id    = "null"; 
    
    $aProducts  = explode(",",$product_id);
    $aSalemodel = explode(",",$salemodel_id);
    $aPrice     = explode(",",$price);
    $aQuantity  = explode(",",$quantity);
    $aProvider  = explode(",",$xprovider);

    for($i = 0; $i < count($aProducts); $i++){
        if(array_key_exists('provider_id',$_REQUEST)){
            if($aProvider[$i] !== '0')
                $provider_id         = "('".$aProvider[$i]."')";
        }
 

        // Query creation
        $sql = "INSERT INTO proposalsxproducts (id,product_id,proposal_id,salemodel_id,provider_id,price,currency,quantity,is_active,created_at,updated_at) VALUES ((UUID()),('".$aProducts[$i]."'),('$proposal_id'),('".$aSalemodel[$i]."'),$provider_id,".$aPrice[$i].",'$currency',".$aQuantity[$i].",'Y',now(),now())";
        // INSERT data
        $rs = $DB->executeInstruction($sql);

    

        // Response JSON 
        if($rs){
            if($i === 0)
                header('Content-type: application/json');
            echo json_encode(["index" => $i,"status" => 'OK']);
        }
    }
}

//close connection
$DB->close();
?>