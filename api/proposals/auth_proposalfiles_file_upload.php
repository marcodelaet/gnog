<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', false);


//REQUIRE GLOBAL conf
require_once('../../database/.config');

// REQUIRE conexion class
require_once('../../database/connect.database.php');

// Loading SendMail class
require('../../assets/lib/SendMail.php');

// Creating a new instance to SendMail class
$SendGNogMail = new SendMail();

// initializing errors
$errors = 0;

if(!isset($DB)){
    $DB = new MySQLDB($DATABASE_HOST,$DATABASE_USER,$DATABASE_PASSWORD,$DATABASE_NAME);

    // call conexion instance
    $con = $DB->connect();
}

// REQUIRE utils functions
require_once('../../assets/lib/utils.php');
require_once('../../assets/lib/translation.php');

if(array_key_exists('uid',$_POST)){
    $user_id    = $_POST['uid'];
    $user_dir   = $user_id . '/';
}

/*******************************************
 *  get owner name and email
 */

 $to_name       = 'OWNER_NAME';
 $to_email      = 'OWNER_EMAIL';
 
 $from_name     = 'LOGGED USER NAME';
 $from_email    = 'LOGGED_USER_EMAIL';
 $signFilePath  = 'platform_CRM.png';
 

if(array_key_exists('ownerid',$_POST)){
    $owner_id = $_POST['ownerid'];
}

if(array_key_exists('ppid',$_POST)){
    $proposal_id = $_POST['ppid'];
    $proposal_dir= $proposal_id . '/';
}

if(array_key_exists('pppid',$_POST)){
    $proposalproduct_id = $_POST['pppid'];
    $proposalproduct_dir= $proposalproduct_id . '/';
}

if(array_key_exists('product',$_REQUEST)){
    $proposalproduct_id = $_REQUEST['product'];
    $proposalproduct_dir= $proposalproduct_id . '/';
}

$user_token = 'AUTO';
if(array_key_exists('usrTk',$_POST)){
    $user_token = $_POST['usrTk'];
}

$form_token = 'AUTO';
if(array_key_exists('authApi',$_POST)){
    $form_token = $_POST['authApi'];
}

// currency
$currency = '';
if(array_key_exists('currency',$_POST)){
    $currency = $_POST['currency'];
}

$dir            = '../..';
//$dir            = "";
$path_dir               = $dir."/public/proposals/attached/";
$target_proposal_dir    = $path_dir.$proposal_dir;
$target_product_dir     = $target_proposal_dir.$proposalproduct_dir;
$target_dir             = $target_product_dir;

# create directories if not exists in
if(!is_dir($target_proposal_dir)){
    mkdir($target_proposal_dir);
}
if(!is_dir($target_product_dir)){
    mkdir($target_product_dir);
}
if(!is_dir($target_dir)){
    mkdir($target_dir);
}

$file_name_orig             = basename($_FILES["proposal_file"]["name"]);
$file                       = $target_dir . $file_name_orig;
$uploadOk                   = 1;
$message                    = '';
$imageFileType              = strtolower(pathinfo($file,PATHINFO_EXTENSION));

$module = 'proposals';

$columns = '';

$fileSize               = $_FILES["proposal_file"]["size"];

$message = '';

$filesSent = '';


if ($uploadOk > 0) {
    $status = "waiting_first_approval"; // every time the user upload a new file, the status resets to waiting_first_approval
    $status_id = "2"; // status id = 2 (25% SENT)
    
    $update = true;
    
    // If exist data, record the waiting approval status and updated_at now()
    if($update === true){
        // RECORDING invoice data 
        $update_proposal_data = "UPDATE proposals SET status_id='$status_id', updated_at=now() WHERE id='$proposal_id'";
    
        // updating invoice on database
        $rs_proposal_update = $DB->executeInstruction($update_proposal_data);
    }

    // UPLOADING INVOICE FILE
    $uploading      = $file_name_orig;
    $file_name      = $uploading; //.'.'.$imageFileType;
    $file           = $target_dir.$file_name;

    //echo $file;
    // Checking if file is already on table
    $check_file_exist = "SELECT id FROM files WHERE file_location='$target_dir' AND file_name='$file_name' AND proposalproduct_id='$proposalproduct_id' AND module_type='proposals' AND user_id='$user_id' AND is_active='Y'";
    //$message .= "\n- $check_file_exist";

    $fileNumRows    = $DB->numRows($check_file_exist);

    if($fileSize > 0){
        if(move_uploaded_file($_FILES["proposal_file"]["tmp_name"], $file)) {
            if($filesSent != '')
                $filesSent .= ', ';
            $filesSent .= $uploading;

            $return = json_encode(["file" => $file, "filetype" => $imageFileType, "size" => $fileSize]);
            $description = 'Proposal file';

            if($fileNumRows < 1){
                // creating INSERT sql to files
                $sql_insert_file = "INSERT INTO files (id,file_location,file_name,file_type,proposalproduct_id,user_id,description,module_type,is_active,created_at,updated_at) VALUES (UUID(),'$target_dir','".$file_name."','".$imageFileType."','$proposalproduct_id','$user_id','$description','proposals','Y',now(),now())";
                
                // saving lines on database
                $rsfile = $DB->executeInstruction($sql_insert_file);

                if($rsfile){
                    $message .= "\n- $uploading file sent succesfully";
                    $return = json_encode(["status" => "OK","message" => $message]);
                }
            } else {
                // getting file ID
                $rs_file_data   = $DB->getData($check_file_exist);

                $file_id        = $rs_file_data[0]['id'];

                $sql_update_file = "UPDATE files SET updated_at=now() WHERE id='$file_id'";
                
                // updating file information on database
                $rs_file_update = $DB->executeInstruction($sql_update_file);
            }
        }
        else {
            $errors++;
            $message .= "\n- $uploading file not sent";
            $return = json_encode(["status"=>"ERROR","message" => $message]);
        }
    }

    // SENDING MAIL - MAKING LOG

    //GETTING lOGED USER DATA - SENDER
    $sql_get_user = "SELECT username, email from view_users WHERE UUID = '$user_id'";
    $rs_get_user  = $DB->getData($sql_get_user);
    $user_name = $rs_get_user[0]['username'];
    $user_email = $rs_get_user[0]['email'];

    //changing FROM to logged user
    $from_name     = "$user_name";
    $from_email    = "$user_email";


    //GETTING OWNER USER DATA - RECEIVER
    $sql_get_owner = "SELECT username, email from view_users WHERE UUID = '$owner_id'";
    $rs_get_owner  = $DB->getData($sql_get_owner);
    $owner_name = $rs_get_owner[0]['username'];
    $owner_email = $rs_get_owner[0]['email'];

    //changing FROM to logged user
    $to_name     = "$owner_name";
    $to_email    = "$owner_email";


    // setting history log
    $description_en     = "$user_name sent proposal files for approval ($filesSent)";
    $description_es     = "$user_name envió archivo de propuesta para aprobación ($filesSent)";
    $description_ptbr   = "$user_name enviou arquivo de proposta para aprovação ($filesSent)";
    setHistory($user_id,'proposals',$proposalproduct_id,$description_en,$description_es,$description_ptbr,$user_token,$form_token,'text');

    $subject       = 'Notificación - GNog CRM';
    $messageHtml   = "<p>Esp: <p>$description_es </p></p>";
    $messageHtml   .= "<p>PtBR: <p>$description_ptbr </p></p>";
    $messageHtml   .= "<p>Eng: <p>$description_en </p></p>";
                               
    $SendGNogMail->sendGNogMail($from_name,$from_email,$to_name,$to_email,$subject,$messageHtml,$signFilePath,null);

} else {
    $errors++;
    $message .= 'Error PANIC';
    $return = json_encode(["status" => "error", "message" => "$message"]);
}

// Everything OK?
$return = json_encode(["status"=>"OK","message" => $message]);

//$errors = 1;
if($errors > 0){
    $return = json_encode(["status" => "error", "message" => "$message"]);
}

header('Content-type: application/json');
echo $return;

//close connection
$DB->close();

?>