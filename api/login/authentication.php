<?php
//REQUIRE GLOBAL conf
require_once('../../database/.config');

// REQUIRE conexion class
require_once('../../database/connect.database.php');

// REQUIRE create jwt function
require_once('../../assets/lib/create_token.php');

$DB = new MySQLDB($DATABASE_HOST,$DATABASE_USER,$DATABASE_PASSWORD,$DATABASE_NAME);

// call conexion instance
$con = $DB->connect();

// variables
$username               = ''; 
$password               = '';

$filters                = '';
if(array_key_exists('username',$_REQUEST)){
    if($_REQUEST['username']!==''){
        if($filters != '')
            $filters .= " AND ";
        $username           = $_REQUEST['username'];
        $filters            .= " (username = '$username' OR email = '$username') ";
    }
}

if(array_key_exists('password',$_REQUEST)){
    if($_REQUEST['password']!==''){
        if($filters != '')
            $filters .= " AND ";
        $password         = md5($_REQUEST['password']);
        $filters        .= " authentication_string = '$password'";
    }
}

if($filters == '')
    $filters = '1=2';


// Query user
$sql = "SELECT id as uuid, level_account, username, email, user_language FROM users WHERE account_locked='N' AND user_type <> 'provider' AND ($filters)";

//echo $sql;
$rs = $DB->getData($sql);

$numRows = $DB->numRows($sql);

header('Content-type: application/json');
// If returns
if($rs){
    if($numRows > 0){
        $uuid           = $rs[0]['uuid'];
        $email          = $rs[0]['email'];
        $user_language  = $rs[0]['user_language'];

        // create Token
        $jwt = jwToken($uuid,$email,$password);
        // Save Token on users table
        $sql2 = "UPDATE users SET token='$jwt' WHERE id = ('$uuid')";
        //echo $sql2;
        $execute = $DB->executeInstruction($sql2);

        $aToken     = array('token' => $jwt);
        $rs += $aToken;
        // Return Token to save on local Storage (JS)
        echo json_encode($rs);
    } else
        echo '{"status":"error","returning":"'.$numRows.' Rows"}';
}
else {
    echo '{"status":"error","returning":"script Error"}';
}

//close connection
$DB->close();
?>