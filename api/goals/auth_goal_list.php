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
    $sql_sec = "SELECT username, email, user_language, user_type, level_account, token, account_locked FROM view_users WHERE token LIKE '%".str_replace(" ","+",$_REQUEST['auth_api'])."%'";
    $rs_sec = $DB->getData($sql_sec);

    //echo "<BR/>$sql_sec<BR/>";

    // User Group
    $group          = $rs_sec[0]['user_type'];
    $level          = $rs_sec[0]['level_account'];
    $username       = $rs_sec[0]['username'];

    // currency default: MXN (Pesos Mexicanos)
    $currency         = 'MXN';
    if(array_key_exists('currency',$_REQUEST)){
        if($_REQUEST['currency']!==''){
            $currency         = $_REQUEST['currency'];
        }
    }

    // setting query
    $columns        = "username,UUID,goal_$currency as goal_amount,sum(goal_$currency) as total_amount,'$currency' as currency,goal_month,goal_year";
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
            $groupBy        = " GROUP BY $grouped";
        }
    }
    
    // filters
    $filters                = '';

    if($level < '99999'){
        if($filters != '')
            $filters .= " AND ";
        $filters  .= " username = '$username'";
    }

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
    $sql = "SELECT $columns FROM $tableOrView $filters $groupBy $orderBy";
    // LIST data
    //echo $sql;
    $rs = $DB->getData($sql);

    // Response JSON 
    header('Content-type: application/json');
    if($rs){
        echo json_encode($rs);
    }
}

//close connection
$DB->close();
?>