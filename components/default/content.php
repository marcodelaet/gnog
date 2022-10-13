<div class="general-container">
<?php
// security


echo '<text>';
if ( $xlsx = Shuchkin\SimpleXLSX::parse( './public/sheets/carteleras.xlsx' ) ) {
	$header_values = $rows = [];

    foreach ($xlsx->rows(1) as $k => $r) {
        if ($k === 0) {
            $header_values = $r;
            continue;
        }
        $rows[] = array_combine($header_values, $r);
    }
    //print_r($rows);
    
    // [i]['Tipo']
    // [i]['Clave']
    // [i]['Dirección']
    // [i]['Estado']
    // [i]['Vista']
    // [i]['Base']
    // [i]['Alto']
    // [i]['Iluminación']
    // [i]['Latitud']
    // [i]['Longitud']
    // [i]['Tarifa Publicada']
    // [i]['Categoría (NSE)']
    // [i]['Renta']
    // [i]['Proveedor']

} else {
	echo Shuchkin\SimpleXLSX::parseError();
}
echo '</text>';

//call page
if (array_key_exists('QUERY_STRING',$_SERVER)){
  if(array_key_exists('pr',$_REQUEST)){
    $pageToGo = base64_decode($_REQUEST['pr']);
    //echo $pageToGo;
    require($pageToGo);
    //echo base64_encode('./pages/users/list.php');
  }

}



?>  
</div>