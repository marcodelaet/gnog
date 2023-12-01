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
    $offSet         = 0;
    $numberOfRegistries = 1000;
    
    $columns        = "(sm.id) as uuid_full, (pd.id) as product_id, pd.code, pd.name as product_name, pd.is_digital as product_is_digital, sm.name, sm.description, sm.is_digital as is_digital, sm.is_active, CASE WHEN pd.name IS NULL THEN sm.name ELSE concat(pd.name,sm.name) END as search";
    $tableOrView    = " products pd JOIN productxsalemodels psm ON psm.product_id = pd.id RIGHT JOIN salemodels sm ON psm.salemodel_id = sm.id";
    $orderBy        = "order by name";
    $groupBy        = "";


    // page
    if(array_key_exists('returninglines',$_REQUEST)){
        $numberOfRegistries = $_REQUEST['returninglines'];
    }

    if(array_key_exists('p',$_REQUEST)){
        if($_REQUEST['p']!==''){
            $offSet        = intval($_REQUEST['p']) * $numberOfRegistries;
        }
    }
    $limit          = "limit $offSet, $numberOfRegistries";

    // filters
    $filters                = '';
    if(array_key_exists('search',$_REQUEST)){
        if($_REQUEST['search']!==''){
            $jocker         = $_REQUEST['search'];
            if((strtolower($jocker) == 'todos') || (strtolower($jocker) == 'all')){
                $filters        = " product_id IS NULL";
            } elseif(strtolower($jocker) == 'digital'){
                $filters        = " is_digital = 'Y'";
            } elseif(strtolower($jocker) == 'offline'){
                $filters        = " is_digital = 'N'";
            } elseif(strtolower($jocker) == 'off'){
                $filters        = " is_digital = 'N'";
            } else {
                $filters        = " search like '%$jocker%'";
            }
        }
    }

    if(array_key_exists('orderby',$_REQUEST)){
        $orderBy = "order by ".$_REQUEST['orderby'];
    }

    // group by
    if(array_key_exists('groupby',$_REQUEST)){
        if($_REQUEST['groupby']!==''){
            $grouped        = $_REQUEST['groupby'];
            $groupBy        = " GROUP BY $grouped";
        }
    }


    if(array_key_exists('digyn',$_REQUEST)){
        $_REQUEST['where'] = 'is_digital|||'.$_REQUEST['digyn'].'***'.$_REQUEST['where'];
    }

    $tableNick  = '';
    if(array_key_exists('where',$_REQUEST)){
        if($_REQUEST['where']!==''){
            if($filters != '')
                $filters .= " AND ( ";

            $multiWhere = explode("*|*",$_REQUEST['where']);
           // echo $multiWhere;
            for($m=0; $m< count($multiWhere); $m++){
                $wherers    = explode("***",$multiWhere[$m]);
                if($m > 0)
                    $filters .= " ) OR ( ";
                for($i=0; $i< count($wherers); $i++){
                    $jocker         = explode("|||",$wherers[$i]);
                    $tableNick = 'sm';
                    $filtered = '';
                    /*
                    if($jocker[0] == 'is_digital'){
                        if(strpos($tableOrView,' JOIN') > 0){
                            $tableNick = 'sm.';
                        }
                        $filters        .= " $tableNick$jocker[0]='$jocker[1]'";
                    }
                    */
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
                            //$tableNick = 'pd.';
                            $tableNick = '(product_';
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
        //$filtered= "WHERE sm.is_active='Y'"; 
        $filtered= "WHERE is_active='Y'";
    }
    if($filters != '')
        $filters = "$filtered AND $filters";

    if(array_key_exists('digyn',$_REQUEST)){
        $filters .= " AND is_digital = '".$_REQUEST['digyn']."'";
    }

    

    // Query creation
    $sql = "SELECT * FROM (SELECT $columns FROM $tableOrView) AS t1 $filters $groupBy $orderBy";
    $sqlPaged = "SELECT * FROM (SELECT $columns FROM $tableOrView) AS t1 $filters $groupBy $orderBy $limit" ;
    // LIST data
    // echo $sql;
    $rs = $DB->getData($sqlPaged);
    $rsNumRows = $DB->numRows($sql);

    // Response JSON
    header('Content-type: application/json'); 
    if($rsNumRows > 0){
        $totalPages  = intval($rsNumRows / $numberOfRegistries)+1;
        if($rs){
            echo json_encode(["response" => "OK","data" => $rs, "rows" => $rsNumRows, "pages" => "$totalPages"]);
        } else {
            echo json_encode(["response" => "ERROR"]);
        }  
    } else {
        echo json_encode(["response" => "ZERO_RETURN", "rows" => $rsNumRows, "pages" => "0"]);
    }
}

//close connection
$DB->close();
?>