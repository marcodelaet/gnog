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

    $groupby = "";
    if($table == 'advertiser') {
        $groupby = "UUID";
    }

    $fullUrl .= 'api/'.$table_plural.'/auth_'.$table.'_view.php?auth_api='.$authApi.'&order='.$order.'&where='.$where.'&selected='.$selected.'&groupby='.$groupby;
    //return $fullUrl;
    $homepage = file_get_contents($fullUrl);
    $obj = json_decode($homepage);
    $html        = '<option value="0" >'.translateText('please_select').' '.$title.'</option>';
    for($i=0;$i < count($obj); $i++){
        $className      = "";
        $markingSelect = ''; 
        switch($table){
            case  'advertiser':
                $id = $obj[$i]->uuid_full;
                $name = $obj[$i]->corporate_name;
                break;
            case 'user':
                $id = $obj[$i]->uuid_full;
                $name = $obj[$i]->username;
                break;
            case 'rate':
                if(!is_null($obj[$i]->orderby))
                    $className = " class='bold' ";
                $id = $obj[$i]->id;
                $name = $obj[$i]->id;
                break;
            default:
                $id = $obj[$i]->uuid_full;
                $name = $obj[$i]->name;
                break;
        }
        if($id == $selected)
            $markingSelect = 'selected';    
        $html .= '<option '.$className.' value="'.$id.'" '.$markingSelect.' >'.$name.'</option>';
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
    //return ($fullUrl);
    $homepage = file_get_contents($fullUrl);
    $obj = json_decode($homepage);
    //return $homepage;
    $html        = '<option value="0" >'.$title.'</option>';
    for($i=0;$i < count($obj); $i++){
        $className      = "";
        $markingSelect  = ''; 
        switch($table){
            case  'advertiser':
                $id = $obj[$i]->uuid_full;
                $name = $obj[$i]->corporate_name;
                break;
            case 'user':
                $id = $obj[$i]->uuid_full;
                $name = $obj[$i]->username;
                break;
            case 'rate':
                if(!is_null($obj[$i]->orderby))
                    $className = " class='bold' ";
                $id = $obj[$i]->id;
                $name = $obj[$i]->id;
                break;
            default:
                $id = $obj[$i]->uuid_full;
                $name = $obj[$i]->name;
                break;
        }             
        if($id == $selected)
            $markingSelect = 'selected';    
        $html .= '<option '.$className.' value="'.$id.'" '.$markingSelect.' >'.$name.'</option>';
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
        $className      = "";
        $markingSelect = ''; 
        switch($table){
            case  'advertiser':
                $id = $obj[$i]->uuid_full;
                $name = $obj[$i]->corporate_name;
                break;
            case 'user':
                $id = $obj[$i]->uuid_full;
                $name = $obj[$i]->username;
                break;
            case 'rate':
                if(!is_null($obj[$i]->orderby))
                    $className = " class='bold' ";
                $id = $obj[$i]->id;
                $name = $obj[$i]->id;
                break;
            default:
                $id = $obj[$i]->uuid_full;
                $name = $obj[$i]->name;
                break;
        }             
        if($id == $selected)
            $markingSelect = 'selected';      
        $html .= '<option '.$className.' value="'.$id.'" '.$markingSelect.' >'.$name.'</option>';
    }
    return $html;
}

function inputDropDownStyle($table,$where,$order,$selected){
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
    $html       .= '<div class="dropdown">';
    $html       .= '<button class="btn btn-secondary dropdown-toggle" type="button" id="'.$table.'DropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';

    $html       .= '</button>';
    $html       .= '<div class="dropdown-menu" aria-labelledby="'.$table.'DropdownMenuButton">';
    for($i=0;$i < count($obj); $i++){
        $className      = "";
        $markingSelect  = ''; 
        $icon           = '';

        switch($table){
            case 'status':
                $color_status = '#d60b0e';
                if($obj[$i]->percent == '100')
                    $color_status = '#298c3d';
                if($obj[$i]->percent == '90')
                    $color_status = '#03fc84';
                if($obj[$i]->percent == '75')
                    $color_status = '#77fc03';
                if($obj[$i]->percent == '50')
                    $color_status = '#ebfc03';
                if($obj[$i]->percent == '25')
                    $color_status = '#fc3d03';
                $icon = '<spam class="material-icons icon-data" id="card-status-icon" style="color:'.$color_status.'">thermostat</spam>';
                $id = $obj[$i]->uuid_full;
                $name = translateText($obj[$i]->simple_name) . ' ('.$obj[$i]->percent.'%)';
                break;
            case  'advertiser':
                $id = $obj[$i]->uuid_full;
                $name = $obj[$i]->corporate_name;
                break;
            case 'user':
                $id = $obj[$i]->uuid_full;
                $name = $obj[$i]->username;
                break;
            case 'rate':
                if(!is_null($obj[$i]->orderby))
                    $className = " class='bold' ";
                $id = $obj[$i]->id;
                $name = $obj[$i]->id;
                break;
            default:
                $id = $obj[$i]->uuid_full;
                $name = $obj[$i]->name;
                break;
        }             
        /*if($id == $selected)
             = 'selected';    */  
        $html .= '<a class="dropdown-item" href="#">'.$icon.' '.$name.'</a>';
    }
    $html .= '</div></div>';
    return $html;
}
?>