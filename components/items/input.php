<?php
function inputSelect($table,$title,$where,$order,$selected){
    $authApi    = $_COOKIE['tk'];
    $protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,strpos( $_SERVER["SERVER_PROTOCOL"],'/'))).'://';
    $url = $_SERVER['HTTP_HOST'];
    if(substr($url,-1,1) != '/')
        $url .= '/';
    $fullUrl    = $protocol . $url;
    $table_plural = $table . 's';
    if(substr($table,-1,strlen($table) ) == 's')
        $table_plural = $table . 'es';

    $groupby = "name";
    if($table == 'advertiser') {
        $groupby = "UUID";
    }

    $fullUrl .= 'api/'.$table_plural.'/auth_'.$table.'_view.php?auth_api='.$authApi.'&order='.$order.'&where='.$where.'&selected='.$selected.'&groupby='.$groupby.'&allRows=1';
    //return $fullUrl;
    $homepage = file_get_contents($fullUrl);
    $obj = json_decode($homepage);
    //return $obj;
    if(is_array($obj))
        $numberOfRows = count($obj);
    else
        $numberOfRows = count($obj->data);
    $html        = '<option value="0" >'.translateText('please_select').' '.$title.'</option>';
    for($i=0;$i < $numberOfRows; $i++){
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
            case 'billboard':
                $id = $obj->data[$i]->uuid_full;
                $name = $obj->data[$i]->name;
                break;
            case 'provider':
                $id = $obj->data[$i]->uuid_full;
                $name = $obj->data[$i]->name;
                break;
            case 'rate':
                if(!is_null($obj[$i]->orderby))
                    $className = " class='bold' ";
                $id = $obj[$i]->id;
                $name = $obj[$i]->id;
                break;
            default:
                $id = $obj->data[$i]->uuid_full;
                $name = $obj->data[$i]->name;
                break;
        }
        if($id == $selected)
            $markingSelect = 'selected';    
        $html .= '<option '.$className.' value="'.$id.'" '.$markingSelect.' >'.$name.'</option>';
    }
    return $html;
}

function inputFilterSelect($table,$title,$where,$order,$selected){
    $authApi    = $_COOKIE['tk'];
    $protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,strpos( $_SERVER["SERVER_PROTOCOL"],'/'))).'://';
    $url = $_SERVER['HTTP_HOST'];
    if(substr($url,-1,1) != '/')
        $url .= '/';
    $fullUrl    = $protocol . $url;
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
    $authApi    = $_COOKIE['tk'];
    $protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,strpos( $_SERVER["SERVER_PROTOCOL"],'/'))).'://';
    $url = $_SERVER['HTTP_HOST'];
    if(substr($url,-1,1) != '/')
        $url .= '/';
    $fullUrl    = $protocol . $url;
    $table_plural = $table . 's';
    if(substr($table,-1,strlen($table) ) == 's')
        $table_plural = $table . 'es';

    $fullUrl .= 'api/'.$table_plural.'/auth_'.$table.'_view.php?auth_api='.$authApi.'&order='.$order.'&where='.$where.'&selected='.$selected;
    //return $fullUrl;
    $homepage = file_get_contents($fullUrl);
    $obj = json_decode($homepage);
    $html        = '';
    for($i=0;$i < count($obj->data); $i++){
        $className      = "";
        $markingSelect = ''; 
        switch($table){
            case  'advertiser':
                $id = $obj->data[$i]->uuid_full;
                $name = $obj->data[$i]->corporate_name;
                break;
            case 'user':
                $id = $obj->data[$i]->uuid_full;
                $name = $obj->data[$i]->username;
                break;
            case 'rate':
                if(!is_null($obj->data[$i]->orderby))
                    $className = " class='bold' ";
                $id = $obj->data[$i]->id;
                $name = $obj->data[$i]->id;
                break;
            default:
                $id = $obj->data[$i]->uuid_full;
                $name = $obj->data[$i]->name;
                break;
        }             
        if($id == $selected)
            $markingSelect = 'selected';      
        $html .= '<option '.$className.' value="'.$id.'" '.$markingSelect.' >'.$name.'</option>';
    }
    return $html;
}

function inputDropDownStyle($table,$where,$order,$selectedDescription,$selectedValue){
    $authApi    = $_COOKIE['tk'];
    $protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,strpos( $_SERVER["SERVER_PROTOCOL"],'/'))).'://';
    $url = $_SERVER['HTTP_HOST'];
    if(substr($url,-1,1) != '/')
        $url .= '/';
    $fullUrl    = $protocol . $url;
    $table_plural = $table . 's';
    if(substr($table,-1,strlen($table) ) == 's')
        $table_plural = $table . 'es';

    $fullUrl .= 'api/'.$table_plural.'/auth_'.$table.'_view.php?auth_api='.$authApi.'&order='.$order.'&where='.$where;
    //return $fullUrl;
    $homepage = file_get_contents($fullUrl);
    $obj = json_decode($homepage);
    $html       = '';
    $button     = '';
    $divInitIn  = '';
    $divInitFin = '';
    $divInitIn  .= '<div class="dropdown">';
    $divInitFin .= '<div class="dropdown-menu" aria-labelledby="'.$table.'DropdownMenuButton">';
    for($i=0;$i < count($obj->data); $i++){
        $className      = "";
        $markingSelect  = ''; 
        $icon           = '';

        switch($table){
            case 'status':
                $color_status = '#d60b0e';
                if($obj->data[$i]->percent == '100')
                    $color_status = '#298c3d';
                if($obj->data[$i]->percent == '90')
                    $color_status = '#03fc84';
                if($obj->data[$i]->percent == '75')
                    $color_status = '#77fc03';
                if($obj->data[$i]->percent == '50')
                    $color_status = '#ebfc03';
                if($obj->data[$i]->percent == '25')
                    $color_status = '#fc3d03';
                $icon = '<spam class="material-icons icon-data" id="card-status-icon" style="color:'.$color_status.'">thermostat</spam>';
                $id = $obj->data[$i]->uuid_full;
                $name = translateText($obj->data[$i]->simple_name) . ' ('.$obj->data[$i]->percent.'%)';
                break;
            case  'office':
                $id = $obj->data[$i]->uuid_full;
                $icon = '<spam><img src="./assets/img/'.$obj->data[$i]->icon_flag .'" height="24"/></spam>';
                $name = $obj->data[$i]->name;
                break;
            case  'advertiser':
                $id = $obj->data[$i]->uuid_full;
                $name = $obj->data[$i]->corporate_name;
                break;
            case 'user':
                $id = $obj->data[$i]->uuid_full;
                $name = $obj->data[$i]->username;
                break;
            case 'rate':
                if(!is_null($obj[$i]->orderby))
                    $className = " class='bold' ";
                $id = $obj->data[$i]->id;
                $name = $obj->data[$i]->id;
                break;
            default:
                $id = $obj->data[$i]->uuid_full;
                $name = $obj->data[$i]->name;
                break;
        } 
        if(($selectedValue == 0) || ($selectedValue == '') || (!isset($selectedValue))){         
            if($i==0){
                $button     .= '<button class="btn btn-secondary dropdown-toggle" type="button" id="'.$table.'DropdownMenuButton" name="'.$table.'DropdownMenuButton" value="'.$id.'" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'.$selectedDescription;
                $button     .= '</button>';
            } 
        } else {
            if($i==0){
                $button     .= '<button class="btn btn-secondary dropdown-toggle" type="button" id="'.$table.'DropdownMenuButton" name="'.$table.'DropdownMenuButton" value="'.$selectedValue.'" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'.$selectedDescription;
                $button     .= '</button>';
            }
        }    
        $html .= '<a class="dropdown-item" href="javascript:void(0);" onclick="document.getElementById(\''.$table.'DropdownMenuButton\').value = \''.$id.'\'; document.getElementById(\''.$table.'DropdownMenuButton\').innerHTML = \''.$name.'\'" >'.$icon.' '.$name.'</a>';
    }
    $htmlFull = $divInitIn.$button.$divInitFin.$html.'</div></div>';
    return $htmlFull;
}

function inputDropDownSearchStyle($table,$title,$where,$order,$selected){
    $authApi    = $_COOKIE['tk'];
    $protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,strpos( $_SERVER["SERVER_PROTOCOL"],'/'))).'://';
    $url = $_SERVER['HTTP_HOST'];
    $groupby    = '0';
    $field      = $table;
    $find       = $field;
    $bring      = null;
    if(substr($url,-1,1) != '/')
        $url .= '/';
    
    if($table == 'state'){
        $table  = 'billboard';
        $field  = 'state';
        $groupby= '&groupby=state';
        $bring  = 'city';
    }
    if($table == 'city'){
        $table  = 'billboard';
        $field  = 'city';
        $groupby= '&groupby=city';
        $bring  = 'county';
    }
    if($table == 'county'){
        $table  = 'billboard';
        $field  = 'county';
        $groupby= '&groupby=county';
        $bring  = 'colony';
    }
    if($table == 'colony'){
        $table  = 'billboard';
        $field  = 'colony';
        $groupby= '&groupby=colony';
    }
    $fullUrl    = $protocol . $url;
    $authApi    = 'fsdf9ejfineuf3nf93493nf';
    $table_plural = $table . 's';
    
    
    if(substr($table,-1,strlen($table) ) == 's')
        $table_plural = $table . 'es';

    

    $fullUrl .= 'api/'.$table_plural.'/auth_'.$table.'_view.php?auth_api='.$authApi.'&orderby='.$order.'&where='.$where.'&selected='.$selected.'&allRows=1'.$groupby;
    //return $fullUrl;
    $homepage   = file_get_contents($fullUrl);

    $obj        = json_decode($homepage);
    if(is_array($obj))
        $numberOfRows = count($obj);
    else{
        $numberOfRows   = count($obj->data);
        $obj            = $obj->data;
        
    }

    $onchange = '';
    if(!is_null($bring))
        $onchange = "onmouseleave=\"if(document.getElementById('".$field."Value_0').innerText != '".translateText($title)."') { listSelectedFiltersDropDownStyle('$find',document.getElementById('".$field."Value_0').innerText,'$bring','$table','0'); }\"";

    $html        = '';
    $html       .= '<div class="dropdown" style="margin-top:1.2rem">';
    $html       .= '<button class="btn btn-primary dropdown-toggle" type="button" id="'.$field.'DropdownMenuButton_0" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >'; 
    $html       .= '<span class="caret" id="'.$field.'Value_0">'.translateText($title).'</span>';
    $html       .= '</button>';
    $html       .= '<ul class="dropdown-menu" aria-labelledby="'.$field.'DropdownMenuButton">';
    $html       .= '<input class="'.$field.'Name[]" name="'.$field.'Name" id="'.$field.'Name_0" type="text" placeholder="Search..">';
    for($i=0;$i < $numberOfRows; $i++){
       // $className      = "";
       // $markingSelect  = ''; 
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
            case 'billboard':
                if(!is_null($obj[$i]->orderby))
                    $className = " class='bold' ";
                $id = $obj[$i]->$field;
                $name = $obj[$i]->$field;
                break;
            default:
                $id = $obj[$i]->uuid_full;
                $name = $obj[$i]->name;
                break;
        }             
        /*if($id == $selected)
             = 'selected';    */ 
             //$html .=  '\'++++\'++++\'';
        $html .= '<li><a class="dropdown-item" href="#'.$field.'DropdownMenuButton_0" onclick="document.getElementById(\''.$field.'Value_0\').innerText=\''.$name.'\'; document.getElementById(\''.$field.'Id_0\').value=\''.$id.'\'; document.getElementById(\''.$field.'Name_0\').value=\''.$name.'\'; " '.$onchange.' >'.$icon.' '.$name.'</a></li>';
    }
    $html .= '</ul></div>';
    return $html;
}
?>