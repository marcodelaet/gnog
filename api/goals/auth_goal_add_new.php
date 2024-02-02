<?php
//REQUIRE GLOBAL conf
require_once('../../database/.config');

// REQUIRE conexion class
require_once('../../database/connect.database.php');

$DB = new MySQLDB($DATABASE_HOST,$DATABASE_USER,$DATABASE_PASSWORD,$DATABASE_NAME);

// call conexion instance
$con = $DB->connect();

// check authentication / local Storage
if(array_key_exists('auth_api',$_POST)){
    // check auth_api === local storage
    //if($localStorage == $_REQUEST['auth_api']){}

    // values to insert
    $table      = "goals";
    $columns    = "id,user_id,goal_month,goal_year,currency_id,goal_amount,created_at,updated_at";
    $user_id    = $_POST['executive_id'];
    if($user_id != '0')
    {
        $oks        = 0;
        $qtyValues  = count($_POST['amount_goal']);
        for($i=0;$i<$qtyValues;$i++){
            $year   = $_POST['start_year'];
            $month  = $_POST['start_month'][$i];
            $currency   = $_POST['rate_id'];
            if($_POST['amount_goal'][$i] != ''){
                $amount = (int)str_replace(".","",str_replace(",","",$_POST['amount_goal'][$i])); // tratar valor decimal / transformar em inteiro
                
                $values = "UUID(),'$user_id','$month','$year','$currency',$amount,now(),now()";

                // Query creation
                $sql = "INSERT INTO $table ($columns) VALUES ($values)";
                // INSERT data
                $rs = $DB->executeInstruction($sql);
                if($rs){
                    $oks++;
                }
            }
        }
    }
    $responseStatus     = "ERROR";
    // Response JSON 
    if($qtyValues === $oks){
        $responseStatus = "OK";
    }
    header('Content-type: application/json');
    echo json_encode(['status' => $responseStatus]);
}

//close connection
$DB->close();
?>