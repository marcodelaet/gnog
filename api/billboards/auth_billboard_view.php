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
    $addColumn  = "";
    if(array_key_exists("addcolumn",$_REQUEST)){
        if($_REQUEST['addcolumn']!==''){
            $addColumn      = $_REQUEST["addcolumn"].",";
        }
    }

    $offSet         = 0;
    $numberOfRegistries = 100;
    $columns        = "left(uuid,13) as uuid, uuid as uuid_full, name, category, address, state, city, county, colony, height, width, coordenates, latitud, longitud, price_int, cost_int, price, cost, is_iluminated, is_digital, provider_id, provider_name, salemodel_name, viewpoint_name, photo, is_active, CONCAT(provider_name, salemodel_name, viewpoint_name,name, category,state, city, county, colony) as search";
    if(array_key_exists('fcn',$_REQUEST)){
        if($_REQUEST['fcn'] == 'selectInDropDown'){
            $name = 'name';
            if(array_key_exists('nameField',$_REQUEST))
                $name = $_REQUEST['nameField']; 
            $columns        = 'uuid as id, '.$name.' as name';
        }
    }
    $tableOrView    = "view_billboards";
    $orderBy        = "order by name";

    $groupBy        = "";

    // page
    if(array_key_exists('p',$_REQUEST)){
        if($_REQUEST['p']!==''){
            $offSet        = intval($_REQUEST['p']) * $numberOfRegistries;
        }
    }
    $limit          = "limit $offSet, $numberOfRegistries";

    if(array_key_exists('allRows',$_REQUEST)){
        if($_REQUEST['allRows']!=='0'){
            $limit = '';
            $numberOfRegistries = 10000000;
        }
    }

    // order by
    if(array_key_exists('orderby',$_REQUEST)){
        if($_REQUEST['orderby']!==''){
            $ordered        = $_REQUEST['orderby'];
            $orderBy        = " ORDER BY $ordered";
        }
    }

    // group by
    if(array_key_exists('groupby',$_REQUEST)){
        if($_REQUEST['groupby']!==''){
            $grouped        = $_REQUEST['groupby'];
            $groupBy        = " GROUP BY $grouped";
        }
    }

    // filters     
    $filters = '';
    if(array_key_exists('search',$_REQUEST)){
        if($_REQUEST['search']!==''){
            if($filters != '')
                $filters .= " AND ";
            $jocker         = $_REQUEST['search'];
            $filters        .= " search like '%$jocker%'";
        }
    }
    
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
                    if($filters != '')
                        $filters .= " AND ";
                    else
                        $filters .= " ( ";
                    $jocker         = explode("|||",$wherers[$i]);
                    $filters        .= " $jocker[0]='$jocker[1]'";
                }
            }
            $filters .= " ) ";
        }
    }
    $plusfilter = '';
    if(array_key_exists('pppid',$_REQUEST)){
        $pppid      = $_REQUEST['pppid'];
        $plusfilter = "(is_productbillboard_active != 'N' AND proposalproduct_id != '$pppid') OR ";
    }

    if($filters != '')
        $filters .= " AND ";
    
    $filters                .= " ($plusfilter (is_productbillboard_active IS NULL AND proposalproduct_id IS NULL))";

    if($filters !== ''){
        $filters = "WHERE ".$filters;
    }

    // Query creation
    $sqlNumRows = "SELECT count(*) as total FROM $tableOrView $filters";
    $sqlPaged = "SELECT $columns FROM $tableOrView $filters $groupBy $orderBy $limit";
    // LIST data
    //echo $sqlPaged;
    
    $rs = $DB->getData($sqlPaged);
    $rsNumRows = $DB->getData($sqlNumRows);
    // Response JSON
    header('Content-type: application/json');
    if($rsNumRows[0]['total'] > 0){
        $totalPages  = intval($rsNumRows[0]['total'] / $numberOfRegistries)+1;
        if($rs){
            echo json_encode(["response" => "OK","data" => $rs, "rows" => $rsNumRows[0]['total'], "pages" => "$totalPages"]);
        } else {
            echo json_encode(["response" => "ERROR"]);
        }  
    } else {
        echo json_encode(["response" => "ZERO_RETURN", "rows" => $rsNumRows[0]['total'], "pages" => "0"]);
    }
}

//close connection
$DB->close();
?>