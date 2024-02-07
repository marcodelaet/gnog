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
require_once('../../assets/lib/translation.php');

// check authentication / local Storage
if(array_key_exists('auth_api',$_REQUEST)){

    $user_id = '0';
    if(array_key_exists('uid',$_REQUEST)){
        $user_id = $_REQUEST['uid'];
    }

    // check auth_api === local storage
    //if($localStorage == $_REQUEST['auth_api']){}

    // values to insert
    $agency                 = 'Y';
    if(array_key_exists('agency',$_REQUEST)){
        if($_REQUEST['agency']!=='')
            $agency         = $_REQUEST['agency'];
    }
    $making_banners         = 'Y';
    if(array_key_exists('making_banners',$_REQUEST)){
        if($_REQUEST['making_banners']!=='')
            $making_banners = $_REQUEST['making_banners'];
    }
    $corporate_name         = addslashes(urldecode($_REQUEST['corporate_name']));
    $address                = addslashes(urldecode($_REQUEST['address']));
    if($address == ''){
        $address = 'Sin dirección';
    }
    $executive_id           = 'NULL';
    $executive_search       = " IS NULL";
    if($_REQUEST['executive_id'] != '0'){
        $executive_id           = "'".$_REQUEST['executive_id']."'";
        $executive_search       = " = " . $executive_id;
    } 


    $module     = "advertisers";
    $columns    = "id,executive_id,is_agency,making_banners,corporate_name,address,is_active,created_at,updated_at";
    $values     = "(UUID()),$executive_id,'$agency','$making_banners','$corporate_name','$address','Y',now(),now()";

    // Query creation
    $sql = "INSERT INTO $module ($columns) VALUES ($values)";

    
    // INSERT data
    $rs = $DB->executeInstruction($sql);

  

    // Response JSON 
    header('Content-type: application/json');
    if($rs){
        $query_get_id = "SELECT id FROM $module WHERE executive_id $executive_search AND corporate_name='$corporate_name' AND address='$address' AND is_agency='$agency' AND making_banners='$making_banners'";

        // getting Invoice ID
        $rs_advertiser    = $DB->getData($query_get_id);
        $advertiser_id    = $rs_advertiser[0]['id'];
        $auth_api       = $_REQUEST['auth_api'];
        $user_token     = $_REQUEST['tk'];
        
        $description_en     = "New advertiser $corporate_name registered on the platform";
        $description_es     = "Nuevo cliente $corporate_name registrado en la plataforma";
        $description_ptbr   = "Novo anunciante $corporate_name registrado na plataforma";
        
        setHistory($user_id,'advertiser',$advertiser_id,$description_en,$description_es,$description_ptbr,$user_token,$auth_api,'text');

        echo json_encode(['result' => 'OK','return_id' => $advertiser_id]);
    } else {
        echo json_encode(['result' => 'ERROR']);
    }
}

//close connection
$DB->close();
?>