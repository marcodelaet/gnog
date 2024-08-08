<?php

ini_set( 'display_errors', 1 );
error_reporting( E_ALL );
/*
ini_set('error_reporting', E_ALL);
ini_set('display_errors', true);
*/
//REQUIRE GLOBAL conf
require_once('../../database/.config');

// REQUIRE conexion class
require_once('../../database/connect.database.php');

// Loading SendMail class
require('../../assets/lib/SendMail.php');

// Creating a new instance to SendMail class
$SendGNogMail = new SendMail();

$sendOption = 'google';

require '../../assets/lib/.configSMTP';
/*
//FROM must be logged user data
$mail->setFrom('contato@gnog.com.br', 'GNog Media - Providers');
$mail->addReplyTo('contato@gnog.com.br', 'GNog Media - Providers');
*/

$from_name  = "Teste GNOG";
$from_email = "it@gnog.com.br";


$to_name       = 'Lorena Saitta, Christian Nolasco, Fernando Nogueira, Marco De Laet, Estephanie Torres, Amanda Gómes Morales, Juan Jose';
$to_email      = 'lorena@gnogmedia.com, finanzas@gnog.com.mx, fernando@gnog.com.mx, it@gnog.com.br, estephanie@gnog.com.mx, amanda@gnog.com.mx, juan@gnog.com.mx';
$signFilePath   = 'platform_CRM.png';

$subject        = "Plataforma GNog Providers";

if(!isset($DB)){
    $DB = new MySQLDB($DATABASE_HOST,$DATABASE_USER,$DATABASE_PASSWORD,$DATABASE_NAME);

    // call conexion instance
    $con = $DB->connect();
}

// REQUIRE utils functions
require_once('../../assets/lib/utils.php');
require_once('../../assets/lib/translation.php');

// call conexion instance
$con = $DB->connect();
$message    = '';
$errors     = 0;

// check authentication / local Storage
if(array_key_exists('auth_api',$_POST)){
    // check auth_api === local storage
    //if($localStorage == $_POST['auth_api']){}

    // setting query
    $tableOrView    = "providers";

    $auth_api   = $_POST['auth_api'];
    
    // filters
    $filters        = '';

    $uuid           = '';
    if(array_key_exists('pid',$_POST)){
        if($_POST['pid']!==''){
            if($filters != '')
                $filters .= " AND ";
            $pid         = $_POST['pid'];
            $filters    .= " id = '$pid'";
            $provider_id = $pid;
        }
    } else {
        $errors++;
        $message .= "\n-no_id_information";
    }

    // Getting Executive data
    $user_id = '';
    if(array_key_exists('uid',$_POST)){
        if($_POST['uid']!==''){
            $user_id    = $_POST['uid'];
        }
    } else {
        $errors++;
        $message .= "\n-no_user_information";
    }

    $user_token = '';
    if(array_key_exists('tku',$_POST)){
        if($_POST['tku']!==''){
            $user_token    = $_POST['tku'];
        }
    } else {
        $errors++;
        $message .= "\n-no_token_information";
    }
    
    if($errors <= 0){
        if($sendOption == 'google'){
            /* *************************************************
            ** SENDING EMAIL AND CREATING HISTORY LOG
            ************************************************* */
            // getting user information
            $sql_get_user = "SELECT CONCAT(u.username) as username, u.email as user_email FROM view_users u WHERE u.UUID = '$user_id'";
            $rs_get_user  = $DB->getData($sql_get_user);
    
    
            $user_fullname      = $rs_get_user[0]['username'];
            $user_email         = $rs_get_user[0]['user_email'];
        
    
            /*****************************************************************
             * getting email body text on languages
            ****************************************************** */
            $provider_email = $_POST['email'];
            $provider_name  = $_POST['name'];
            $invite_body = "
            <html>
            <head>
              <title>$subject</title>
              <style amp-custom>            
                .download-pdf-file{
                      display: flex;
                      vertical-align: middle;
                      font-size: 0.7rem;
                }
              </style>        
            </head>
            <body>
                <div class='messageText'>
                    <p>".rawurldecode($_POST['bodytext'])."</p>
                </div>
                <div class='signature'>
                    <img src='https://providers.gnogmedia.com/assets/img/$signFilePath' />
                </div>
            </body>
            </html>
            ";
    
            if((substr($SUBDOMAIN,0,4) == 'beta') || ($LOCALSERVER != 'local')) {
                $to_name    = "TESTE BETA - Homologação";
                $to_email   = "it@gnog.com.br";
                $mail->AddAddress($to_email,$to_name);
            } else {
                //changing TO to logged user
                $to_name    = "$provider_name";
                $to_email   = "$provider_email";
                $mail->AddAddress($to_email,$to_name);

                $from_name  = "$user_fullname";
                $from_email = "$user_email";
    
                $mail->setFrom("$user_email", "$user_fullname");
                $mail->addReplyTo("$user_email", "$user_fullname");
            }        
            /*****************************************************************
             * recording historylog 
             ********************************************************* */ 
            $description_en     = "$user_fullname sent plataform access to provider contact ($provider_name <$provider_email>) using email";
            $description_es     = "$user_fullname envió el acceso a la plataforma para el contacto del proveedor ($provider_name <$provider_email>) por correo";
            $description_ptbr   = "$user_fullname enviou o acesso à plataforma para o contato do provedor ($provider_name <$provider_email>) por email";
    
            // setting history log
            setHistory($user_id,'providers',$provider_id,$description_en,$description_es,$description_ptbr,$user_token,$auth_api,'text');
            
            $mail->Subject = $subject;
            
            $mail->isHTML(true);
    
            $mail->Body = "$invite_body";
    
            // Anexando arquivo
            
            // attached files (pdf)
            // $attachedFiles = '../../public/providers_1.2_202306-ptBR.pdf;../../public/providers_1.2_202306-es.pdf';
    

            // every file is in the same path
            $path = "../../public/";

            // pdf 1
            $filename = "providers_1.2_202306-es.pdf";

            $fileType = mime_content_type( $path.$filename );
            $fileName = basename( $path.$filename );
    
            // creating the attached file
            $fp = fopen( $path.$fileName, "rb" ); // open file
            $attached_file_local = fread( $fp, filesize( $path ) ); // Calculating file size
            $attached_file = chunk_split(base64_encode( $attached_file_local )); // encoding file in 64 Bits
            fclose( $fp ); // Close file
    
            //$mail->AddAttachment($attached_file, $fileName);
            $mail->AddAttachment($path.$fileName, $filename);
    
            // pdf 2
            $filename = "providers_1.2_202306-ptBR.pdf";
            $fileType = mime_content_type( $path.$filename );
            $fileName = basename( $path.$filename );
    
            // creating the attached file
            $fp = fopen( $path.$fileName, "rb" ); // open file
            $attached_file_local = fread( $fp, filesize( $path ) ); // Calculating file size
            $attached_file = chunk_split(base64_encode( $attached_file_local )); // encoding file in 64 Bits
            fclose( $fp ); // Close file
    
            //$mail->AddAttachment($attached_file, $fileName);
            $mail->AddAttachment($path.$fileName, $filename);
    
            $messageHtml   = "$invite_body";
    
            $attachedFiles = '';
            //if($LOCALSERVER != 'local') {
                
                if(!$mail->send()){
                    $return = "Error";
                    $message = "\n- Error sending mail message: \n --- $mail->ErrorInfo ---";
                }else{
                    $return = "OK";
                    $message .= "\n- mail sent to $to_name<$to_email>";
                }
                
                if($SendGNogMail->sendGNogMail($from_name,$from_email,$to_name,$to_email,$subject,$messageHtml,$signFilePath,$attachedFiles)){
                    $return = "OK";
                    $message .= "\n- mail sent to $to_name<$to_email> ";
                } else {
                    $return = "Error";
                    $message = "\n- Error sending mail message:";
                }
            //}
            /*************************************
             * END SEND MAIL AND HISTORY SECTION
             *************************************/
            
            $message .= "\n- data record successfully";
            //$return = json_encode(["status" => "Error","message" => $message]);
            $response = json_encode(["status" => $return,"message" => $message]); 
        } else {
            /* *************************************************
            ** SENDING EMAIL AND CREATING HISTORY LOG
            ************************************************* */
    
            // getting user information
            $sql_get_user = "SELECT CONCAT(u.username) as username, u.email as user_email FROM view_users u WHERE u.UUID = '$user_id'";
            $rs_get_user  = $DB->getData($sql_get_user);
    
    
            $user_fullname      = $rs_get_user[0]['username'];
            $user_email         = $rs_get_user[0]['user_email'];
        
    
            /*****************************************************************
             * getting email body text on languages
            ****************************************************** */
            $provider_email = $_POST['email'];
            $provider_name  = $_POST['name'];
            $invite_body    = rawurldecode($_POST['bodytext']);
    
            if((substr($SUBDOMAIN,0,4) == 'beta') || ($LOCALSERVER != 'local')) {
                $to_name    = "TESTE BETA - Homologação";
                $to_email   = "it@gnog.com.br";
                $from_name  = "$user_fullname";
                $from_email = "$user_email";
            } else {
                //changing TO to logged user
                $to_name    = "$provider_name";
                $to_email   = "$provider_email";
                $from_name  = "$user_fullname";
                $from_email = "$user_email";
            }        
            /*****************************************************************
             * recording historylog 
             ********************************************************* */ 
            $description_en     = "$user_fullname sent plataform access to provider contact ($provider_name <$provider_email>) using email";
            $description_es     = "$user_fullname envió el acceso a la plataforma para el contacto del proveedor ($provider_name <$provider_email>) por correo";
            $description_ptbr   = "$user_fullname enviou o acesso à plataforma para o contato do provedor ($provider_name <$provider_email>) por email";
    
            // setting history log
            setHistory($user_id,'providers',$provider_id,$description_en,$description_es,$description_ptbr,$user_token,$auth_api,'text');
            
            $subject       = "Plataforma GNog Providers";
    
            $messageHtml   = "$invite_body";
    
            $attachedFiles = '';
            if($SendGNogMail->sendGNogMail($from_name,$from_email,$to_name,$to_email,$subject,$messageHtml,$signFilePath,$attachedFiles)){
                $return = "OK";
                $message .= "\n- mail sent to $to_name<$to_email> ";
            } else {
                $return = "Error";
                $message = "\n- Error sending mail message:";
            }
            /*************************************
             * END SEND MAIL AND HISTORY SECTION
             *************************************/
            
            // message sent
            $message .= "\n- data record successfully";
            $response = json_encode(["status" => $return,"message" => $message]); 
        }
    } else {
        // message sent
        $response = json_encode(["status" => "Error","message" => $message]);
    }

} else {
    $message .= "\n- no authorization";
    $response = json_encode(["status" => "Error","message" => $message]);
}

header('Content-type: application/json');
echo $response;

//close connection
$DB->close();

?>




