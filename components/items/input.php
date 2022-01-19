<?php
function inputSelect($table,$title,$where,$order,$selected){
    $protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,strpos( $_SERVER["SERVER_PROTOCOL"],'/'))).'://';
    $url = $_SERVER['HTTP_HOST'];
    if(substr($url,-1,1) != '/')
        $url .= '/';
    $fullUrl    = $protocol . $url;
    $authApi    = 'fsdf9ejfineuf3nf93493nf';
    $table_plural = $table . 's';
    if(substr($table,-1,strlen($table) ) == 's')
        $table_plural = $table . 'es';

    $fullUrl .= 'api/'.$table_plural.'/auth_'.$table.'_view.php?auth_api='.$authApi.'&order='.$order.'&where='.$where.'&selected='.$selected;
    //return $fullUrl;
    $homepage = file_get_contents($fullUrl);
    $obj = json_decode($homepage);
    $html        = '<option value="0" >Please, select '.$title.'</option>';
    for($i=0;$i < count($obj); $i++){
        $markingSelect = ''; 
        if($table == 'advertiser')
            $name = $obj[$i]->corporate_name;
        elseif($table == 'user')
            $name = $obj[$i]->username;
        else
            $name = $obj[$i]->name;
        if($obj[$i]->uuid_full == $selected)
            $markingSelect = 'selected';    
        $html .= '<option value="'.$obj[$i]->uuid_full.'" '.$markingSelect.' >'.$name.'</option>';
    }
    return $html;
}
  
function inputFilterSelect($table,$title,$where,$order,$selected){

    $protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,strpos( $_SERVER["SERVER_PROTOCOL"],'/'))).'://';
    $url = $_SERVER['HTTP_HOST'];
    if(substr($url,-1,1) != '/')
        $url .= '/';
    $fullUrl    = $protocol . $url;
    $authApi    = 'fsdf9ejfineuf3nf93493nf';
    $table_plural = $table . 's';
    if(substr($table,-1,strlen($table) ) == 's')
        $table_plural = $table . 'es';

    $fullUrl .= 'api/'.$table_plural.'/auth_'.$table.'_view.php?auth_api='.$authApi.'&order='.$order.'&where='.$where.'&selected='.$selected;
    //return $fullUrl;
    $homepage = file_get_contents($fullUrl);
    $obj = json_decode($homepage);
    $html        = '<option value="0" >'.$title.'</option>';
    for($i=0;$i < count($obj); $i++){
        $id = $obj[$i]->uuid_full;
        $markingSelect = ''; 
        switch($table){
            case  'advertiser':
                $name = $obj[$i]->corporate_name;
                break;
            case 'user':
                $name = $obj[$i]->username;
                break;
            case 'rate':
                $id = $obj[$i]->id;
                $name = $obj[$i]->id;
                break;
            default:
                $name = $obj[$i]->name;
                break;
        }             
        if($id == $selected)
            $markingSelect = 'selected';    
        $html .= '<option value="'.$id.'" '.$markingSelect.' >'.$name.'</option>';
    }
    return $html;
}


function inputFilterNoZeroSelect($table,$title,$where,$order,$selected){
    $protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,strpos( $_SERVER["SERVER_PROTOCOL"],'/'))).'://';
    $url = $_SERVER['HTTP_HOST'];
    if(substr($url,-1,1) != '/')
        $url .= '/';
    $fullUrl    = $protocol . $url;
    $authApi    = 'fsdf9ejfineuf3nf93493nf';
    $table_plural = $table . 's';
    if(substr($table,-1,strlen($table) ) == 's')
        $table_plural = $table . 'es';

    $fullUrl .= 'api/'.$table_plural.'/auth_'.$table.'_view.php?auth_api='.$authApi.'&order='.$order.'&where='.$where.'&selected='.$selected;
    //return $fullUrl;
    $homepage = file_get_contents($fullUrl);
    $obj = json_decode($homepage);
    $html        = '';
    for($i=0;$i < count($obj); $i++){
        $markingSelect = ''; 
        if($table == 'advertiser')
            $name = $obj[$i]->corporate_name;
        elseif($table == 'user')
            $name = $obj[$i]->username;
        else
            $name = $obj[$i]->name;
        if($obj[$i]->uuid_full == $selected)
            $markingSelect = 'selected';    
        $html .= '<option value="'.$obj[$i]->uuid_full.'" '.$markingSelect.' >'.$name.'</option>';
    }
    return $html;
}
?>