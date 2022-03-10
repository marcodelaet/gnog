<?php
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

    // User Group
    $group          = 'user';

    // setting query
    $columns        = "UUID,goal_amount,sum(goal_amount) as total_amount,currency_id as currency,goal_month,goal_year";
    $tableOrView    = "view_goals";
    $orderBy        = "";
    $groupBy        = "";

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
            $groupBy        = " ORDER BY $grouped";
        }
    }
    
    // filters
    $filters                = '';

    if(array_key_exists('search',$_REQUEST)){
        if($_REQUEST['search']!==''){
            if($filters != '')
                $filters .= " AND ";
            $jocker         = $_REQUEST['search'];
            $filters        .= " search like '%$jocker%'";
        }
    }
    
    if(array_key_exists('tid',$_REQUEST)){
        if($_REQUEST['tid']!==''){
            if($filters != '')
                $filters .= " AND ";
            $user_id         = $_REQUEST['tid'];
            $filters        .= " UUID = '$user_id'";
        }
    }

    if(array_key_exists('month',$_REQUEST)){
        if($_REQUEST['month']!==''){
            if($filters != '')
                $filters .= " AND ";
            $month         = $_REQUEST['month'];
            $filters        .= " goal_month = '$month'";
        }
    }

    if(array_key_exists('year',$_REQUEST)){
        if($_REQUEST['year']!==''){
            if($filters != '')
                $filters .= " AND ";
            $year         = $_REQUEST['year'];
            $filters        .= " goal_year = '$year'";
        }
    }

    if($filters !== ''){
        $filters = "WHERE ".$filters;
    }

    // Query creation
    $sql = "SELECT $columns FROM $tableOrView $filters $orderBy $groupBy";
    // LIST data
    //echo $sql;
    $rs = $DB->getData($sql);

    // Response JSON 
    if($rs){
        header('Content-type: application/json');
        echo json_encode($rs);
    }
}

//close connection
$DB->close();
?>