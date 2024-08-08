<?php
 error_reporting(E_ALL);
 ini_set('display_errors', 1); 

//REQUIRE GLOBAL conf
require_once('../../database/.config');

// REQUIRE conexion class
require_once('../../database/connect.database.php');

if(!isset($DB)){
    $DB = new MySQLDB($DATABASE_HOST,$DATABASE_USER,$DATABASE_PASSWORD,$DATABASE_NAME);

    // call conexion instance
    $con = $DB->connect();
}

// REQUIRE utils functions
require_once('../../assets/lib/utils.php');
require_once('../../assets/lib/translation.php');

// check authentication / local Storage
if(array_key_exists('auth_api',$_REQUEST)){
    // check auth_api === local storage
    //if($localStorage == $_REQUEST['auth_api']){}
    $user_id = '0';
    if(array_key_exists('uid',$_REQUEST)){
        $user_id = $_REQUEST['uid'];
    }
    /* ***************************************
    ** PRODUCT FIELDS DISABLED ***************
    ******************************************

    // values to insert
    $salemodel_id           = $_GET['salemodel_id'];
    $product_id             = $_GET['product_id'];
    if(array_key_exists('product_price',$_REQUEST)){
        if($_REQUEST['product_price'] != ''){
            $product_price          = (float)str_replace(",",".",str_replace(".","",$_REQUEST['product_price'])) * 100;
        }
    }
    $currency               = $_GET['currency'];
    ************************************************************/
    
    $name                   = addslashes(urldecode($_GET['name']));
    $webpage_url            = addslashes(urldecode($_GET['webpage_url']));
    $address                = addslashes(urldecode($_GET['address']));

    $columns    = "id, name, webpage_url, address, is_active, created_at, updated_at";
    $values     = "(UUID()),'$name','$webpage_url','$address','Y',now(),now()";
    $module      = "providers";

    // Query creation
    $sql = "INSERT INTO $module ($columns) VALUES ($values)";
    // INSERT data
    $rs = $DB->executeInstruction($sql);

    // Response JSON 
    header('Content-type: application/json');
    if($rs){
        $query_get_id = "SELECT id FROM $module WHERE name='$name' AND webpage_url='$webpage_url' AND address='$address'";

        // getting Invoice ID
        $rs_provider    = $DB->getData($query_get_id);
        $provider_id    = $rs_provider[0]['id'];
        $auth_api       = $_REQUEST['auth_api'];
        $user_token     = $_REQUEST['tk'];
        
        $description_en     = "New provider $name registered on the platform";
        $description_es     = "Nuevo proveedor $name registrado en la plataforma";
        $description_ptbr   = "Novo provedor $name registrado na plataforma";

        setHistory($user_id,'providers',$provider_id,$description_en,$description_es,$description_ptbr,$user_token,$auth_api,'text');

        echo json_encode(['result' => 'OK','return_id' => $provider_id]);
    } else {
        echo json_encode(['result' => 'ERROR']);
    }


}

//close connection
$DB->close();
?>