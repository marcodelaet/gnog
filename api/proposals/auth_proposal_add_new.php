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
    $user_id        = $_COOKIE['uuid']; // get cookie value
    $name           = $_GET['name'];
    $client_id      = $_GET['client_id'];
    $agency_id      = 'NULL';
    if($_GET['agency_id'] != '0')
        $agency_id  = "('".$_GET['agency_id']."')";
    $contact_id     = $_GET['contact_id'];
    $description    = $_GET['description'];
    $start_date     = $_GET['start_date'];
    $stop_date      = $_GET['stop_date'];
    $status_id      = $_GET['status_id'];
    $pixel          = $_GET['pixel'];
    
    $columns    = 'id,user_id,status_id,offer_name,advertiser_id,agency_id,contact_id,description,start_date,stop_date,is_pixel,is_active,created_at, updated_at';
    $values     = "(UUID()),('$user_id'),$status_id,'$name',('$client_id'),$agency_id,('$contact_id'),'$description','$start_date','$stop_date','$pixel','Y',now(),now()";
    $table      = "proposals";

    // Query creation
    $sql = "INSERT INTO $table ($columns) VALUES ($values)";
    // INSERT data
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
        }
        else
            echo 'Error Get: ' . $sqlGet;
    }
    else
        echo 'Error Insert: ' . $sql;
}

//close connection
$DB->close();
?>