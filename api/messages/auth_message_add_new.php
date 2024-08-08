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
$default_text = $_POST['default_text'];

if(array_key_exists('auth_api',$_POST)){
    $module = 'messagetemplates';

    // values to insert
    $columns    = "id,name,message_text,message_text_esp,message_text_eng,message_text_ptbr,module_name,is_active,created_at,updated_at";
    // values to update
    $values     = "UUID(),'".addslashes(urldecode($_POST['template_name']))."','".addslashes(urldecode($_POST['template_text_'.$default_text]))."','".addslashes(urldecode($_POST['template_text_esp']))."','".addslashes(urldecode($_POST['template_text_eng']))."','".addslashes(urldecode($_POST['template_text_ptbr']))."','".addslashes(urldecode($_POST['module_name']))."','Y',now(),now()";

    // Query creation
    $sql = "INSERT INTO $module ($columns) VALUES ($values)";
    //echo $sql;
    // INSERT data
    $rs = $DB->executeInstruction($sql);
}

// Response JSON 
header('Content-type: application/json');
if($rs){
    echo json_encode(['status' => 'OK']);
}
else {
    echo json_encode(['status' => 'ERROR_QUERY']);
}

//close connection
$DB->close();
?>