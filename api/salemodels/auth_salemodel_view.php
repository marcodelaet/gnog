<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', true);
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

    // setting query
    
    $columns        = "(sm.id) as uuid_full, (pd.id) as product_id, pd.code, pd.name as product_name, sm.name, sm.description, sm.is_active";
    $tableOrView    = " products pd JOIN productxsalemodels psm ON psm.product_id = pd.id RIGHT JOIN salemodels sm ON psm.salemodel_id = sm.id";
    $orderBy        = "order by sm.name";

    // filters
    $filters                = '';
    if(array_key_exists('search',$_REQUEST)){
        if($_REQUEST['search']!==''){
            $jocker         = $_REQUEST['search'];
            $filters        .= "AND search like '%$jocker%'";
        }
    }

    if(array_key_exists('digyn',$_GET)){
        $_GET['where'] = 'is_digital|||'.$_GET['digyn'].'***'.$_GET['where'];
    }

    $tableNick  = '';
    if(array_key_exists('where',$_GET)){
        if($_GET['where']!==''){
            if($filters != '')
                $filters .= " AND ( ";

            $multiWhere = explode("*|*",$_GET['where']);
           // echo $multiWhere;
            for($m=0; $m< count($multiWhere); $m++){
                $wherers    = explode("***",$multiWhere[$m]);
                if($m > 0)
                    $filters .= " ) OR ( ";
                for($i=0; $i< count($wherers); $i++){
                    $jocker         = explode("|||",$wherers[$i]);
                    $tableNick = 'sm';
                    $filtered = '';
                    if($jocker[0] == 'is_digital'){
                        if(strpos($tableOrView,' JOIN') > 0){
                            $tableNick = 'sm.';
                        }
                        $filters        .= " $tableNick$jocker[0]='$jocker[1]'";
                    }
                   // echo substr($filters,-7,7)."<BR/>";
                    if(($filters != '') && ((substr($filters,-8,8) != " ) OR ( ") && (substr($filters,-5,5) != " AND ")) && (substr($filters,-7,7) != " AND ( ")){
                        $filtered = " ";
                        if(($i==0) && (count($wherers)>1)){
                            $filtered = " AND (( ";
                        }
                        $filters .= $filtered;// . "COUNT: ". count($wherers) ." i: $i / m: $m";
                    }
                   /* else{
                        if($m>0)
                            $filters .= " ( ";
                    }*/

                    if($jocker[0] == 'product_id'){
                        if(strpos($tableOrView,' JOIN') > 0){
                            $tableNick = 'pd.';
                        }
                        $jocker[0] = 'id';
                    }
                    if($jocker[1] == 'null'){
                        $filters        .= " $tableNick$jocker[0] IS NULL";
                    } else {
                        if($jocker[0] != 'is_digital'){
                            $filters        .= " $tableNick$jocker[0]='$jocker[1]'";
                        }
                    }
                }
            }
            //echo '<br/><br/>CCCC: ' . count(explode("***",$multiWhere[0]));
            if(count(explode("***",$multiWhere[0]))>1){
                $filters .= " ) )";
            }
        }
    }

    $filtered= "WHERE is_active='Y'"; 
    if(strpos($tableOrView,' JOIN') > 0){
        $filtered= "WHERE sm.is_active='Y'"; 
    }
    if($filters != '')
        $filters = "$filtered AND $filters";

    


    // Query creation
    $sql = "SELECT $columns FROM $tableOrView $filters $orderBy";
    // LIST data
    //echo "<BR/>".$sql."<BR/>";
    $rs = $DB->getData($sql);
    $numRows = $DB->numRows($sql);

    // Response JSON
    header('Content-type: application/json'); 
    if($rs){
        echo json_encode(['response'=>'OK','data'=>$rs,'numRows'=>$numRows]);
    } else {
        echo json_encode(['response'=>'ERROR','SQL'=>$sql]);
    }
}

//close connection
$DB->close();
?>