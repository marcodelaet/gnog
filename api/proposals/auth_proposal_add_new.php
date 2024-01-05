<?php
//ini_set('error_reporting', E_ALL);
//ini_set('display_errors', true);

//REQUIRE GLOBAL conf
require_once('../../database/.config');

// REQUIRE conexion class
require_once('../../database/connect.database.php');

// Loading SendMail class
require('../../assets/lib/SendMail.php');

// Creating a new instance to SendMail class
$SendGNogMail = new SendMail();

$from_name     = 'GNog Media - Providers';
$from_email    = 'nocontestar@gnogmedia.com';
//$to_name       = 'Lorena Saitta, Christian Nolasco, Fernando Nogueira, Marco De Laet, Estephanie Torres, Amanda Gómes Morales, Juan Jose';
//$to_email      = 'lorena@gnogmedia.com, finanzas@gnog.com.mx, fernando@gnog.com.mx, it@gnog.com.br, estephanie@gnog.com.mx, amanda@gnog.com.mx, juan@gnog.com.mx';
$signFilePath  = 'platform_CRM.png';

if(!isset($DB)){
    $DB = new MySQLDB($DATABASE_HOST,$DATABASE_USER,$DATABASE_PASSWORD,$DATABASE_NAME);

    // call conexion instance
    $con = $DB->connect();
}

// REQUIRE utils functions
require_once('../../assets/lib/translation.php');


// check authentication / local Storage
if(array_key_exists('auth_api',$_REQUEST)){
    // check auth_api === local storage
    //if($localStorage == $_REQUEST['auth_api']){}

    $user_token = $_REQUEST['auth_api'];
    $auth_api   = $_REQUEST['auth_api'];

    // values to insert
    $user_id        = $_COOKIE['uuid']; // get cookie value
    $executive_id   = $_POST['executive_id'];
    $name           = $_POST['name'];
    $client_id      = $_POST['client_id'];
    $agency_id      = 'NULL';
    if($_POST['agency_id'] != '0')
        $agency_id  = "('".$_POST['agency_id']."')";
    $contact_id     = $_POST['contact_id'];
    $office_id      = $_POST['office_id'];
    $description    = $_POST['description'];
    $start_date     = $_POST['start_date'];
    $stop_date      = $_POST['stop_date'];
    $status_id      = $_POST['status_id'];
    
    $tax_percent    = '0';
    if(($_POST['tax_percent'] != '') && ($_POST['tax_percent'] > '0') )
        $tax_percent    = $_POST['tax_percent'];

   /* $pixel_original = $_POST['pixel'];

    $pixel = "N";
    if(isset($pixel_original)){
        $pixel = "Y";
    }*/

    $pixel      = $_POST['pixel_option'];
    $taxable    = $_POST['taxable_option'];
    
    $columns    = 'id,user_id,status_id,offer_name,advertiser_id,agency_id,contact_id,office_id,description,start_date,stop_date,tax_percent_int,is_taxable,is_pixel,is_active,created_at, updated_at';
    $values     = "(UUID()),('$executive_id'),$status_id,'$name',('$client_id'),$agency_id,('$contact_id'),'$office_id','$description','$start_date','$stop_date',$tax_percent,'$taxable','$pixel','Y',now(),now()";
    $table      = "proposals";

    // Query creation
    $sql = "INSERT INTO $table ($columns) VALUES ($values)";
    // INSERT data 
    //echo $sql;
    
    $rs = $DB->executeInstruction($sql);

    // Response JSON 
    if($rs){
        // setting SELECT query
        $columns        = "id,offer_name";
        $tableOrView    = "proposals";
        $filters        = "WHERE offer_name = '$name' AND advertiser_id = '$client_id' AND description = '$description'";
        // Query creation
        $sqlGet = "SELECT $columns FROM $tableOrView $filters";
        // LIST data
        // echo $sqlGet;
        $rsGet = $DB->getData($sqlGet);
        
        if($rsGet)
        {
           // echo "<BR /> FOI - PASSOU";
            header('Content-type: application/json');
            echo json_encode($rsGet);

            $description_en     = "New proposal $name added to CRM starting at $start_date to $stop_date";
            $description_es     = "Nueva propuesta $name agregada en el CRM empezando en $start_date hasta $stop_date";
            $description_ptbr   = "Nova proposta $name adicionada ao CRM iniciando em $start_date até $stop_date";
            // setting history log
            setHistory($user_id,'proposals',$rsGet[0]['id'],$description_en,$description_es,$description_ptbr,$user_token,$auth_api,'text');
    
        }
    }
}

//close connection
$DB->close();
?>