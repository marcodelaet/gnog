<?php
$dir = '';
if(array_key_exists('dir',$_REQUEST)){
    $dir = $_REQUEST['dir'];
}

// only load dababase option if it is not SET
if(!isset($DB)){
    //REQUIRE GLOBAL conf
    require_once($dir.'./database/.config');

    // REQUIRE conexion class
    require_once($dir.'./database/connect.database.php');
}

function translateText($xcode){
    $userLanguage = $_COOKIE['ulang'];

    global $DATABASE_HOST, $DATABASE_USER, $DATABASE_PASSWORD, $DATABASE_NAME;

    if(!isset($DB)){
        $DBTranslate = new MySQLDB($DATABASE_HOST,$DATABASE_USER,$DATABASE_PASSWORD,$DATABASE_NAME);

        // call conexion instance
        $con = $DBTranslate->connect();
    }

    // Query
    $sql = "SELECT id as uuid, text_eng, text_".$userLanguage." FROM translates WHERE is_active='Y' AND code_str = '$xcode'";

    $rs = $DBTranslate->getData($sql);
    if($rs){
        $returningText = $rs[0]['text_'.$userLanguage];
        if( is_null($returningText) || ($returningText == ''))
            $returningText = $rs[0]['text_eng'];
        return $returningText;
    } else {
        return 'Error';
    }

    //close connection
    $DBTranslate->close();

}

function translateTextInLanguage($xcode,$language){
    $userLanguage = $language;

    global $DATABASE_HOST, $DATABASE_USER, $DATABASE_PASSWORD, $DATABASE_NAME;

    $DBTranslate = new MySQLDB($DATABASE_HOST,$DATABASE_USER,$DATABASE_PASSWORD,$DATABASE_NAME);

    // call conexion instance
    $con = $DBTranslate->connect();

    // Query
    $sql = "SELECT id as uuid, text_eng, text_".$userLanguage." FROM translates WHERE is_active='Y' AND code_str = '$xcode'";

    $rs = $DBTranslate->getData($sql);
    if($rs){
        $returningText = $rs[0]['text_'.$userLanguage];
        if( is_null($returningText) || ($returningText == ''))
            $returningText = $rs[0]['text_eng'];
        $response = json_encode(["response"=>"OK","translation" => $returningText]);
    } else {
        $response = json_encode(["response"=>"Error","translation" => 'Error']);
    }
    //close connection
    $DBTranslate->close();
    return $response;
}


if(array_key_exists('fcn',$_REQUEST)){
    $function = $_REQUEST['fcn'];
    switch($function){
        case 'translateInLanguage':
            $xcode      = '';
            $language   = '';
            
            if(array_key_exists('code',$_REQUEST))
                $xcode = $_REQUEST['code'];
            if(array_key_exists('lng',$_REQUEST))
                $language = $_REQUEST['lng'];
            $response = translateTextInLanguage($xcode,$language);
            break;
    }
    header('Content-type: application/json'); 
    echo $response;
}

?>