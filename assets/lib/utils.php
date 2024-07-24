<?php
$dir = '';
if(array_key_exists('dir',$_REQUEST)){
    $dir = $_REQUEST['dir'];
}


if(!function_exists('mime_content_type')) {
    function mime_content_type($filename) {

        $mime_types = array(

            'txt' => 'text/plain',
            'htm' => 'text/html',
            'html' => 'text/html',
            'php' => 'text/html',
            'css' => 'text/css',
            'js' => 'application/javascript',
            'json' => 'application/json',
            'xml' => 'application/xml',
            'swf' => 'application/x-shockwave-flash',
            'flv' => 'video/x-flv',

            // images
            'png' => 'image/png',
            'jpe' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'jpg' => 'image/jpeg',
            'gif' => 'image/gif',
            'bmp' => 'image/bmp',
            'ico' => 'image/vnd.microsoft.icon',
            'tiff' => 'image/tiff',
            'tif' => 'image/tiff',
            'svg' => 'image/svg+xml',
            'svgz' => 'image/svg+xml',

            // archives
            'zip' => 'application/zip',
            'rar' => 'application/x-rar-compressed',
            'exe' => 'application/x-msdownload',
            'msi' => 'application/x-msdownload',
            'cab' => 'application/vnd.ms-cab-compressed',

            // audio/video
            'mp3' => 'audio/mpeg',
            'qt' => 'video/quicktime',
            'mov' => 'video/quicktime',

            // adobe
            'pdf' => 'application/pdf',
            'psd' => 'image/vnd.adobe.photoshop',
            'ai' => 'application/postscript',
            'eps' => 'application/postscript',
            'ps' => 'application/postscript',

            // ms office
            'doc' => 'application/msword',
            'rtf' => 'application/rtf',
            'xls' => 'application/vnd.ms-excel',
            'ppt' => 'application/vnd.ms-powerpoint',

            // open office
            'odt' => 'application/vnd.oasis.opendocument.text',
            'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
        );
        $strExt    = explode('.',strtolower($filename));
        $ext = array_pop($strExt);
        if (array_key_exists($ext, $mime_types)) {
            return $mime_types[$ext];
        }
        elseif (function_exists('finfo_open')) {
            $finfo = finfo_open(FILEINFO_MIME);
            $mimetype = finfo_file($finfo, $filename);
            finfo_close($finfo);
            return $mimetype;
        }
        else {
            return 'application/octet-stream';
        }
    }
}

function setHistory($user_id,$module_name,$module_id,$description_en,$description_es,$description_ptbr,$user_token,$form_token,$resultType){
    global $DATABASE_HOST, $DATABASE_USER, $DATABASE_PASSWORD, $DATABASE_NAME;

    $DBHistory = new MySQLDB($DATABASE_HOST,$DATABASE_USER,$DATABASE_PASSWORD,$DATABASE_NAME);

    // call conexion instance
    $con = $DBHistory->connect();

    $nowDateTime = "now()";
    if($module_name == 'invoices_payed_from_waiting'){ // if is approval time before paied status
        $nowDateTime = "subtime(now(), '0:0:10.000000')";
        $module_name = 'invoices';
    }

    // Query
    $sql = "INSERT INTO loghistory (id, user_id, module_name, module_id, description_en, description_es, description_ptbr, user_token, form_token, created_at, updated_at) VALUES (UUID(),'$user_id', '$module_name', '$module_id', '$description_en','$description_es','$description_ptbr', '$user_token', '$form_token', $nowDateTime, $nowDateTime)"; 

    $rs = $DBHistory->executeInstruction($sql);
    if($rs){
        if($resultType == 'json')
            $response = json_encode(["response"=>"OK"]);
        if($resultType == 'text')
            $response = "OK";
    } else {
        if($resultType == 'json')
            $response = json_encode(["response"=>"Error"]);
        if($resultType == 'text')
            $response = "Error: ".$sql;
    }
    //close connection
    $DBHistory->close();
    return $response;
}

function sendmailto($to,$subject,$message,$headers){
    $to = "user1@example.com, user2@example.com";
    $subject = "This is a test HTML email";
    
    $message = "
    <html>
    <head>
    <title>This is a test HTML email</title>
    </head>
    <body>
    <p>Test email. Please ignore.</p>
    </body>
    </html>
    ";
    
    // It is mandatory to set the content-type when sending HTML email
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    
    // More headers. From is required, rest other headers are optional
    $headers .= 'From: <info@example.com>' . "\r\n";
    $headers .= 'Cc: sales@example.com' . "\r\n";
    
    mail($to,$subject,$message,$headers);
}

?>


