<?php
/*
error_reporting(E_ALL);
ini_set('display_errors', 1); 
*/

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
require_once('../../assets/lib/translation.php');

// check authentication / local Storage
if(array_key_exists('auth_api',$_POST)){
    // check auth_api === local storage
    //if($localStorage == $_REQUEST['auth_api']){}
    $user_id = '0';
    if(array_key_exists('uid',$_POST)){
        $user_id = $_POST['uid'];
    }

    // values to insert
    $name                   = addslashes(urldecode($_POST['name']));
    $description            = addslashes(urldecode($_POST['description']));
    $isDigital              = $_POST['digital_product'];

    $columns    = "id, product_ids_rel,name, description, is_digital, is_active, created_at, updated_at";
    $values     = "(UUID()),'','$name','$description','$isDigital','Y',now(),now()";
    $table      = "salemodels";

    // Query creation
    $sql = "INSERT INTO $table ($columns) VALUES ($values)";
    // INSERT data
    $rs = $DB->executeInstruction($sql);

    // Response JSON 
    if($rs){
        $query_get_id = "SELECT id FROM salemodels WHERE name='$name' AND description='$description' AND is_digital='$isDigital'";

        // getting Invoice ID
        $rs_salemodel    = $DB->getData($query_get_id);
        $salemodel_id    = $rs_salemodel[0]['id'];
        $auth_api       = $_POST['auth_api'];
        //$user_token     = $_POST['tk'];

        // walking by products selecteds
        $products   = $_POST['product_id'];
        foreach($products as $product_id){
            // adding productxsalemodels 
            $sql_insert_productxsalemodels  = "INSERT INTO productxsalemodels (id,product_id,salemodel_id,is_active,created_at,updated_at) VALUES (UUID(),'$product_id','$salemodel_id','Y',now(),now())";
            $rs = $DB->executeInstruction($sql_insert_productxsalemodels);
        }
        header('Content-type: application/json');
            echo json_encode(['status' => 'OK']);
    }
}

//close connection
$DB->close();
?>