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

    // User Group
    $group          = $_COOKIE['lacc'];
    $filters        = " pps.is_active = 'Y'";
    $subfilter      = "";

    $currency_selected  = '".$currency_selected."';
    if(array_key_exists('currency',$_REQUEST)){
        $currency_selected = $_REQUEST['currency'];
    }

    $estimatedCostPercent = 70;

    //echo $group;
    // filters
    if($group < '99999'){
        if($filters != '')
            $filters .= " AND ";
        $filters .= "pps.user_id = '".$_COOKIE['uuid']."' ";
    } else {
        if(array_key_exists('uid',$_REQUEST)){
            if($_REQUEST['uid']!==''){
                if($filters != '')
                    $filters .= " AND ";
                $uid         = $_REQUEST['uid'];
                $filters        .= " pps.user_id = '$uid'";
            }
        }
    }

    if(array_key_exists('status',$_REQUEST)){
        if($_REQUEST['status']!==''){
            if($filters != '')
                $filters .= " AND ";
            $statuses       = $_REQUEST['status'];
            $arrayStatus    = explode(",",$statuses);
            $filters        .= "(";
            for($i_status=0; $i_status < count($arrayStatus); $i_status++){
                if($i_status > 0)
                    $filters    .= " OR ";
                $filters        .= " pps.status_id = ".$arrayStatus[$i_status];
            }
            $filters        .= ")";
        }
    }

    if($_REQUEST['date']!==''){
        if($filters != '')
            $filters .= " AND ";
        $fullDate           = $_REQUEST['date'];
        $year               = substr($fullDate,0,4);
        $month              = substr($fullDate,4,2);
        $monthsubfilter         = " goal_month = ".(int)$month." AND ";    if(array_key_exists('date',$_REQUEST)){
        $lastday = 31;
        if((int)$month==2){
            $lastday = 28;
            if($year % 400 == 0)
                $lastday = 29;
        }
        if(((int)$month==4) || ((int)$month==6) || ((int)$month==9) || ((int)$month==11)){
            $lastday = 30;
        }
        $fullDateStart      = substr($fullDate,0,6).'01';
        $fullDateEnd        = substr($fullDate,0,6).$lastday;
        

        if(array_key_exists('type',$_REQUEST)){
            if($_REQUEST['type']=='yearly'){
                $fullDateStart      = substr($fullDate,0,4).'0101'; // 01-01-YEAR
                $fullDateEnd        = substr($fullDate,0,4).'1231'; // 31-12-YEAR
                $monthsubfilter     = "";
            }
        }
        $filters        .= " ((DATE(pps.start_date) >= date('$fullDateStart') AND DATE(pps.start_date) <= date('$fullDateEnd')) OR (DATE(pps.stop_date) >= date('$fullDateStart') AND DATE(pps.stop_date) <= date('$fullDateEnd')))";
        $subfilter      .= " (($monthsubfilter goal_year=$year) OR goal_month IS NULL )";
    }
}

    
if($filters !== ''){
    $filters = "WHERE ".$filters;
}

// setting query
//$columns        = "UUID,product_id,product_name,salemodel_id,salemodel_name,provider_id,provider_name,user_id,username,client_id,client_name,agency_id,agency_name,status_id,status_name,status_percent,offer_name,description,start_date,stop_date,month_diff_data,sum(CASE WHEN cost_".$currency_selected." = '0' THEN (amount_".$currency_selected." * ".$estimatedCostPercent.")/100 ELSE cost_".$currency_selected." END) as cost,sum(CASE WHEN cost_".$currency_selected."_int = 0 THEN (amount_".$currency_selected."_int * ".$estimatedCostPercent.")/100 ELSE cost_".$currency_selected."_int END) as cost_int, sum(CASE WHEN cost_per_month_".$currency_selected." = 0 THEN (amount_per_month_".$currency_selected." * ".$estimatedCostPercent.")/100 ELSE cost_per_month_".$currency_selected." END) as cost_per_month, sum(CASE WHEN cost_per_month_".$currency_selected."_int = 0 THEN (amount_per_month_".$currency_selected."_int * ".$estimatedCostPercent.")/100 ELSE cost_per_month_".$currency_selected."_int END) as cost_per_month_int, sum(amount_$currency_selected) as amount,sum(amount_".$currency_selected."_int) as amount_int, sum(amount_per_month_$currency_selected) as amount_per_month, sum(amount_per_month_".$currency_selected."_int) as amount_per_month_int, '$currency_selected' as currency,quantity,is_active";
$columns        = "pps.UUID,pps.product_id,pps.product_name,pps.salemodel_id,pps.salemodel_name,pps.provider_id,pps.provider_name,pps.user_id,pps.username,pps.client_id,pps.client_name,pps.agency_id,pps.agency_name,pps.status_id,pps.status_name,pps.status_percent,pps.offer_name,pps.description,pps.start_date,pps.stop_date,pps.month_diff_data,g.goal_month,g.goal_year,round(sum(goal_amount_int),2) as goal_amount_int,CASE WHEN pps.status_percent = 100 THEN round(sum(CASE WHEN (pps.cost_".$currency_selected." = '0' OR pps.cost_".$currency_selected." IS NULL) THEN (pps.amount_".$currency_selected." * 70)/100 ELSE pps.cost_".$currency_selected." END),2)  ELSE sum(0) END as utility_cost,CASE WHEN pps.status_percent = 100 THEN round(sum(CASE WHEN (pps.cost_".$currency_selected."_int = '0' OR pps.cost_".$currency_selected."_int IS NULL) THEN (pps.amount_".$currency_selected."_int * 70)/100 ELSE pps.cost_".$currency_selected."_int END),2) ELSE sum(0) END as utility_cost_int,CASE WHEN pps.status_percent = 100 THEN round(sum(CASE WHEN (pps.cost_per_month_".$currency_selected." = 0 OR pps.cost_per_month_".$currency_selected." IS NULL) THEN (pps.amount_per_month_".$currency_selected." * 70)/100 ELSE pps.cost_per_month_".$currency_selected." END),2) ELSE sum(0) END as utility_cost_per_month,CASE WHEN pps.status_percent = 100 THEN round(sum(CASE WHEN (pps.cost_per_month_".$currency_selected."_int = 0 OR pps.cost_per_month_".$currency_selected."_int IS NULL) THEN (pps.amount_per_month_".$currency_selected."_int * 70)/100 ELSE pps.cost_per_month_".$currency_selected."_int END),2) ELSE sum(0) END as utility_cost_per_month_int,CASE WHEN pps.status_percent < 100 THEN round(sum(CASE WHEN (pps.cost_".$currency_selected." = '0' OR pps.cost_".$currency_selected." IS NULL) THEN (pps.amount_".$currency_selected." * 70)/100 ELSE pps.cost_".$currency_selected." END),2)  ELSE sum(0) END as pipe_cost,CASE WHEN pps.status_percent < 100 THEN round(sum(CASE WHEN (pps.cost_".$currency_selected."_int = '0' OR pps.cost_".$currency_selected."_int IS NULL) THEN (pps.amount_".$currency_selected."_int * 70)/100 ELSE pps.cost_".$currency_selected."_int END),2) ELSE sum(0) END as pipe_cost_int,CASE WHEN pps.status_percent < 100 THEN round(sum(CASE WHEN (pps.cost_per_month_".$currency_selected." = 0 OR pps.cost_per_month_".$currency_selected." IS NULL) THEN (pps.amount_per_month_".$currency_selected." * 70)/100 ELSE pps.cost_per_month_".$currency_selected." END),2) ELSE sum(0) END as pipe_cost_per_month,CASE WHEN pps.status_percent < 100 THEN round(sum(CASE WHEN (pps.cost_per_month_".$currency_selected."_int = 0 OR pps.cost_per_month_".$currency_selected."_int IS NULL) THEN (pps.amount_per_month_".$currency_selected."_int * 70)/100 ELSE pps.cost_per_month_".$currency_selected."_int END),2) ELSE sum(0) END as pipe_cost_per_month_int,round(sum(CASE WHEN pps.cost_".$currency_selected." = '0' THEN (pps.amount_".$currency_selected." * 70)/100 ELSE pps.cost_".$currency_selected." END),2) as cost,round(sum(CASE WHEN pps.cost_".$currency_selected."_int = 0 THEN (pps.amount_".$currency_selected."_int * 70)/100 ELSE pps.cost_".$currency_selected."_int END),2) as cost_int,round(sum(CASE WHEN pps.cost_per_month_".$currency_selected." = 0 THEN (pps.amount_per_month_".$currency_selected." * 70)/100 ELSE pps.cost_per_month_".$currency_selected." END),2) as cost_per_month,round(sum(CASE WHEN pps.cost_per_month_".$currency_selected."_int = 0 THEN (pps.amount_per_month_".$currency_selected."_int * 70)/100 ELSE pps.cost_per_month_".$currency_selected."_int END),2) as cost_per_month_int,round(sum(pps.amount_".$currency_selected."),2) as amount,round(sum(pps.amount_".$currency_selected."_int),2) as amount_int,CASE WHEN pps.status_percent = 100 THEN round(sum(pps.amount_".$currency_selected."),2) ELSE sum(0) END as utility_amount,CASE WHEN pps.status_percent = 100 THEN round(sum(pps.amount_".$currency_selected."_int),2) ELSE sum(0) END as utility_amount_int,CASE WHEN pps.status_percent < 100 THEN round(sum(pps.amount_".$currency_selected."),2) ELSE sum(0) END as pipe_amount,CASE WHEN pps.status_percent < 100 THEN round(sum(pps.amount_".$currency_selected."_int),2) ELSE sum(0) END as pipe_amount_int,round(sum(pps.amount_per_month_".$currency_selected."),2) as amount_per_month,round(sum(pps.amount_per_month_".$currency_selected."_int),2) as amount_per_month_int,CASE WHEN pps.status_percent = 100 THEN round(sum(pps.amount_per_month_".$currency_selected."),2) ELSE sum(0) END as utility_amount_per_month,CASE WHEN pps.status_percent = 100 THEN round(sum(pps.amount_per_month_".$currency_selected."_int),2) ELSE sum(0) END as utility_amount_per_month_int,CASE WHEN pps.status_percent < 100 THEN round(sum(pps.amount_per_month_".$currency_selected."),2) ELSE sum(0) END as pipe_amount_per_month,CASE WHEN pps.status_percent < 100 THEN round(sum(pps.amount_per_month_".$currency_selected."_int),2) ELSE sum(0) END as pipe_amount_per_month_int,'MXN' as currency,pps.quantity,pps.is_active";
//$columns        = "UUID,product_id,product_name,salemodel_id,salemodel_name,provider_id,provider_name,user_id,username,client_id,client_name,agency_id,agency_name,status_id,status_name,status_percent,offer_name,description,start_date,stop_date,month_diff_data,sum(cost_$currency_selected) as cost,sum(cost_".$currency_selected."_int) as cost_int, sum(cost_per_month_$currency_selected) as cost_per_month, sum(cost_per_month_".$currency_selected."_int) as cost_per_month_int, sum(amount_$currency_selected) as amount,sum(amount_".$currency_selected."_int) as amount_int, sum(amount_per_month_$currency_selected) as amount_per_month, sum(amount_per_month_".$currency_selected."_int) as amount_per_month_int, '$currency_selected' as currency,quantity,is_active";
$tableOrView    = "view_proposals pps LEFT JOIN (SELECT uuid,goal_month,goal_year,sum(goal_".$currency_selected.") as goal_amount_int FROM view_goals WHERE $subfilter GROUP BY uuid,goal_month) AS g ON ((pps.user_id = g.UUID) AND ( (CONCAT(g.goal_year,SUBSTR(CONCAT('00',g.goal_month),LENGTH(g.goal_month)+1,2)) >= CONCAT(YEAR(pps.start_date),SUBSTR(CONCAT('00',MONTH(pps.start_date)),LENGTH(MONTH(pps.start_date))+1,2))) AND (CONCAT(g.goal_year,SUBSTR(CONCAT('00',g.goal_month),LENGTH(g.goal_month)+1,2)) <= CONCAT(YEAR(pps.stop_date),SUBSTR(CONCAT('00',MONTH(pps.stop_date)),LENGTH(MONTH(pps.stop_date))+1,2))) ) )";
$groupBy        = " group by pps.user_id,g.goal_month";
$orderBy        = " order by SUBSTR(CONCAT('00',g.goal_month),LENGTH(g.goal_month)+1,2)";

if(array_key_exists('groupby',$_REQUEST)){
    $groupBy        = " group by pps.user_id,g.goal_month";
}
// Query creation
$sql = "SELECT $columns FROM $tableOrView $filters $groupBy $orderBy";
// LIST data
//echo $sql;

$rs = $DB->getData($sql);
$numberOfRows = $DB->numRows($sql); 

// Response JSON 
header('Content-type: application/json');
if($rs){
    if($numberOfRows > 0)
        echo json_encode($rs);
    else
        echo "[{'response':'0 results'}]";
}
else{
    echo '[{"response":"Error"}]';
}
}

//close connection
$DB->close();
?>