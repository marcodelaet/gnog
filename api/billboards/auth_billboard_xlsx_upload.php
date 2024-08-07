<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
$dir            = '../..';
//$dir            = ".";

require_once $dir . '/vendor/autoload.php';
require_once $dir.'/vendor/shuchkin/simplexlsx/src/SimpleXLSX.php';

use Shuchkin\SimpleXLSX;

//REQUIRE GLOBAL conf
require_once($dir.'/database/.config');

// REQUIRE conexion class
require_once($dir.'/database/connect.database.php');

$DB = new MySQLDB($DATABASE_HOST,$DATABASE_USER,$DATABASE_PASSWORD,$DATABASE_NAME);

// call conexion instance
$con = $DB->connect();
$country        = 'Mexico';
if(array_key_exists('country',$_POST)){
    $country    = $_POST['country'];
}

// counters
$readedLineCounter              = 0;
$insertedBillboardLineCounter   = 0;
$updatedBillboardLineCounter    = 0;
$insertedProviderLineCounter    = 0;
$insertedViewPointLineCounter   = 0;
$insertedSaleModelLineCounter   = 0;


$target_dir     = $dir.'/public/sheets/';
$target_file    = $target_dir . basename($_FILES["billboard_file"]["name"]);
$uploadOk       = 1;
$message        = '';
$imageFileType  = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
$fileSize       = $_FILES["billboard_file"]["size"];
$temporary_name = $_FILES["billboard_file"]["tmp_name"];

if($imageFileType != 'xlsx'){
    $message    .= "\n- Sorry, Only XLSX file is allowed";
    $uploadOk   = 0;
}

if ($uploadOk > 0) {
    if (move_uploaded_file($temporary_name, $target_file)) {
        //echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";

        $return = json_encode(["file" => "$target_file", "filetype" => "$imageFileType", "size" => "$fileSize"]);

        // Loading xlsx file                                                
        if ( $xlsx = Shuchkin\SimpleXLSX::parse( $target_file ) ) {
            $header_values = $rows = [];

            foreach ($xlsx->rows(0) as $k => $r) {
                if ($k === 0) {
                    $header_values = $r;
                    continue;
                }
                //echo "\r\n<BR/>".$header_values[$k];
                $rows[] = array_combine($header_values, $r);
            }
            //print_r($rows);
        } else {
            echo Shuchkin\SimpleXLSX::parseError();
        }
        $message = "";
        for($i=0;$i < count($rows);$i++){
            $cleanClave = str_replace("\n","",str_replace("\r","",$rows[$i]['Clave']));
            // CHECKING DUPLICATION
            $sqlbillboards  = "SELECT name_key,state,county,city,colony,country,provider_id,salemodel_id FROM billboards WHERE LOWER(REPLACE(name_key,'\n',' ')) = LOWER(REPLACE('".$cleanClave."','\n',' '))";
            // Executing Query 
            $rsbillboardID = $DB->getDataSingle($sqlbillboards);
            $numbillboards = $DB->numRows($sqlbillboards);

            $claveInExcel = isset($cleanClave) ? $cleanClave : null;

            // cleaning address fields on Excel
            $cleanState     = $rows[$i]['Estado '];
            $cleanCity      = $rows[$i]['Ciudad '];
            $cleanCounty    = $rows[$i]['Alcaldía / Municipio'];
            $cleanColony    = $rows[$i]['Colonia'];
            //if(isset($rsbillboardID["name_key"])){
                // Cleaning names
                $cleanProvider  = '';
                $cleanVista     = '';
                $cleanTipo      = '';
                if(!is_null($rows[$i]['Proveedor'])){
                    $cleanProvider  = str_replace("\n","",str_replace("\r","",$rows[$i]['Proveedor']));
                }
                if(!is_null($rows[$i]['Vista'])){
                    $cleanVista     = str_replace("\n","",str_replace("\r","",$rows[$i]['Vista']));
                }
                if(!is_null($rows[$i]['Categoria'])){
                    $cleanTipo      = str_replace("\n","",str_replace("\r","",$rows[$i]['Tipo']));
                    //$cleanTipo      = str_replace("\n","",str_replace("\r","",$rows[$i]['Categoria']));
                }
                
                // Queries getting IDs
                $sqlSaleModels  = "SELECT id, name FROM salemodels WHERE LOWER(name) = LOWER('".$cleanTipo."')";
                $sqlViewPoints  = "SELECT id, name FROM viewpoints WHERE REPLACE(LOWER(name),' ','') = REPLACE(LOWER('".$cleanVista."'),' ','')";
                $sqlProviders   = "SELECT id, name FROM providers WHERE REPLACE(LOWER(name),' ','') LIKE REPLACE(LOWER('".$cleanProvider."'),' ','')";

                //echo $sqlProviders . "\n";

                //$message .= ' PPPP ' . $sqlProviders . ' SSSS ' . $sqlSaleModels . ' VVVV ' . $sqlViewPoints;

                $salemodelID    = 'NULL';
                $rssalemodelID = $DB->getDataSingle($sqlSaleModels);
                $numSalemodels = $DB->numRows($sqlSaleModels);
                $salemodelNameFromDB    = '';
                if($numSalemodels > 0){
                    $salemodelNameFromDB    = $rssalemodelID["name"];
                    if(!is_null($cleanTipo)){
                        if(strtolower(str_replace('"','',str_replace(' ','',$salemodelNameFromDB))) == strtolower(str_replace('"','',str_replace(' ','',$cleanTipo)))){
                            $salemodelID    = "'".$rssalemodelID["id"]."'";
                        } 
                    } 
                } else {
                    $insertNewSaleModel = "INSERT INTO salemodels (id, product_ids_rel,name, description, is_digital, is_active, created_at, updated_at) VALUES (UUID(),'','".$cleanTipo."','".$cleanTipo."','N','Y',now(),now())";
                    if(!$rs_insertNewSaleModel = $DB->executeInstruction($insertNewSaleModel)){
                        $message .= "\nError on INSERT: ".$insertNewSaleModel;
                    } else {
                        $insertedSaleModelLineCounter++;
                    }
                    //$message .= $insertNewSaleModel . ' |SSS| ';
                }
                $salemodelID = "'".$DB->getDataSingle($sqlSaleModels)["id"]."'";

                $viewPointID    = 'NULL';
                $rsviewpointID = $DB->getDataSingle($sqlViewPoints);
                $numviewpoints = $DB->numRows($sqlViewPoints);
                $viewpointNameFromDB    = '';
                if($numviewpoints > 0){
                    $viewpointNameFromDB    = $rsviewpointID["name"];
                    if(!is_null($cleanVista)) {
                        if(strtolower(str_replace('"','',str_replace(' ','',$viewpointNameFromDB))) == strtolower(str_replace('"','',str_replace(' ','',$cleanVista)))){
                            $viewPointID    = "'".$rsviewpointID["id"]."'";
                        }
                    }
                } else {
                    $insertNewViewPoint = "INSERT INTO viewpoints (id, name, is_active, created_at, updated_at) VALUES (UUID(),'".$cleanVista."','Y',now(),now())";
                    if(!$rs_insertNewViewPoint = $DB->executeInstruction($insertNewViewPoint)){
                        $message .= "\nError on INSERT: ".$insertNewViewPoint;
                    } else {
                        $insertedViewPointLineCounter++;
                    }
                    //$message .= $insertNewViewPoint . ' |VVV| ';
                }
                $viewPointID = "'".$DB->getDataSingle($sqlViewPoints)["id"]."'";

                $providerID    = 'NULL';
                $rsproviderID = $DB->getDataSingle($sqlProviders);
                $numProviders = $DB->numRows($sqlProviders);
                $providerNameFromDB    = '';
                if($numProviders > 0){
                    $providerFromDB    = $rsproviderID["name"];
                    if(!is_null($cleanProvider)){
                        if(str_replace('í','i',str_replace('á','a',strtolower(str_replace(' ','',$providerFromDB)))) == str_replace('í','i',str_replace('á','a',strtolower(str_replace(' ','',$cleanProvider))))){
                            $providerID     = "'".$rsproviderID["id"]."'";
                        } 
                    }
                } else {
                    $insertNewProvider = "INSERT INTO providers (id, name, is_active, created_at, updated_at) VALUES (UUID(),'".$cleanProvider."','Y',now(),now())";
                    if(!$rs_insertNewProvider = $DB->executeInstruction($insertNewProvider)){
                        $message .= "\nError on INSERT: ".$insertNewProvider;
                    }else{
                        $insertedProviderLineCounter++;
                    }
                    //$message .= $insertNewProvider . ' |PPP| ';
                } 
                $providerID = "'".$DB->getDataSingle($sqlProviders)["id"]."'";

                $namekeySet = 1;
                if(isset($rsbillboardID["name_key"])){
                    if($rsbillboardID["name_key"] == $claveInExcel)
                        $namekeySet = 0;
                }
                if($namekeySet==1){
                    $iluminated = 'N';
                    if($rows[$i]['Iluminación'] == 'Si')
                        $iluminated = 'Y';

                    // CONVERT NUMBERS TO INT
    //                $width      = intval(str_replace(".","",str_replace(",","",str_replace("$","",$rows[$i]['Base']))));
    //                $height     = intval(str_replace(".","",str_replace(",","",str_replace("$","",$rows[$i]['Alto']))));
                    $base       = 0;
                    if(is_numeric($rows[$i]['Base'])){
                        $base   = $rows[$i]['Base'];
                    }
                    $width      = intval(floatval($base)*100);

                    $side       = 0;
                    if(is_numeric($rows[$i]['Alto'])){
                        $side   = $rows[$i]['Alto'];
                    }
                    $height     = intval(floatval($side)*100);
                    $priceInRow = 0;
                    if(is_numeric(str_replace(",",".",str_replace("$","",$rows[$i]['Tarifa Publicada'])))){
                        $priceInRow = str_replace(",",".",str_replace("$","",$rows[$i]['Tarifa Publicada']));
                    }
                    $price_int  = floatval($priceInRow) * 100;
    //                $cost_int   = floatval(str_replace(",",".",str_replace("$","",$rows[$i]['Renta']))) * 100;
                    $costInRow = 0;
                    if(is_numeric(str_replace(",",".",str_replace("$","",$rows[$i]['Costo'])))){
                        $costInRow = str_replace(",",".",str_replace("$","",$rows[$i]['Costo']));
                    }
                    $cost_int   = floatval($costInRow) * 100;
                    if($numbillboards == 0){
                        $insertNewBillboard = "INSERT INTO billboards (id,name_key,address,state,county,city,colony,country,category,coordenates,latitud,longitud,price_int,cost_int,width,height,photo,provider_id,salemodel_id,viewpoint_id,is_iluminated, is_digital, is_active, created_at, updated_at) VALUES (UUID(),REPLACE('".str_replace("'","''",$rows[$i]['Clave'])."','\n',' '),'".str_replace("'","''",$rows[$i]['Dirección'])."','".str_replace("'","''",$rows[$i]['Estado '])."','".str_replace("'","''",$rows[$i]['Alcaldía / Municipio'])."','".str_replace("'","''",$rows[$i]['Ciudad '])."','".str_replace("'","''",$rows[$i]['Colonia'])."','$country','".$rows[$i]['Categoría (NSE)']."','".$rows[$i]['Coordenadas']."','".$rows[$i]['Latitud']."','".$rows[$i]['Longitud']."',$price_int,$cost_int,$width,$height,'".str_replace("'","''",$cleanClave).".jpg.jpg',$providerID,$salemodelID,$viewPointID,'$iluminated','N','Y',now(),now())";
                        if(!$rs_insertNewBillboard = $DB->executeInstruction($insertNewBillboard)){
                            $message .= "\nError on INSERT: ".$insertNewBillboard;
                        }else{
                            $insertedBillboardLineCounter++;
                        }
                    }

                    //$message .= $insertNewBillboard . ' ***|*** ';
                } else {
                    // Cleaning names
                    $cleanProvider  = str_replace("\n","",str_replace("\r","",$rows[$i]['Proveedor']));

                    // Queries getting IDs
                    $sqlProviders   = "SELECT id, name FROM providers WHERE REPLACE(LOWER(name),' ','') LIKE REPLACE(LOWER('".$cleanProvider."'),' ','')";
                    $rsproviderID   = $DB->getDataSingle($sqlProviders);
                    $providerID     = !isset($DB->getDataSingle($sqlProviders)["id"]) ? 0 : $DB->getDataSingle($sqlProviders)["id"];
                    
                    // checking if provider changes
                    if($rsbillboardID["provider_id"] != $providerID){
                        // provider changes - ao que tudo indica, nunca a mesma chave pertencerá a outro provedor
                    } 
                    // check changes on new fields (state,county,city,colony / '".$rows[$i]['Estado ']."','".$rows[$i]['Alcaldía / Municipio']."','".$rows[$i]['Ciudad ']."','".$rows[$i]['Colonia']."')
                    $stateFromDB    = "";
                    if(!is_null($rsbillboardID["state"])){
                        $stateFromDB    = $rsbillboardID["state"];
                    }
                    
                    $cityFromDB     = "";
                    if(!is_null($rsbillboardID["city"])){
                        $cityFromDB     = $rsbillboardID["city"];
                    }
                    $countyFromDB   = "";
                    if(!is_null($rsbillboardID["county"])){
                        $countyFromDB   = $rsbillboardID["county"];
                    }
                    $colonyFromDB   = "";
                    if(!is_null($rsbillboardID["colony"])){
                        $colonyFromDB   = $rsbillboardID["colony"];
                    }

                    // identifying when counter passed by
                    $alreadyUpdated = 0;
                    if((strtolower(str_replace('"','',str_replace(' ','',$stateFromDB))) != strtolower(str_replace('"','',str_replace(' ','',$cleanState)))) || (strtolower(str_replace('"','',str_replace(' ','',$countyFromDB))) != strtolower(str_replace('"','',str_replace(' ','',$cleanCounty)))) || (strtolower(str_replace('"','',str_replace(' ','',$cityFromDB))) != strtolower(str_replace('"','',str_replace(' ','',$cleanCity)))) || (strtolower(str_replace('"','',str_replace(' ','',$colonyFromDB))) != strtolower(str_replace('"','',str_replace(' ','',$cleanColony))))){
                        $updateBillboard = "UPDATE billboards SET country = '$country',state = '$cleanState',county = '$cleanCounty',city = '$cleanCity',colony = '$cleanColony' WHERE name_key = '". $rsbillboardID["name_key"]."'";
                        if(!$execUpdateLocal = $DB->executeInstruction($updateBillboard)){
                            $message .= "\nError on Update: ".$updateBillboard;
                        }else{
                            $alreadyUpdated=1;
                            $updatedBillboardLineCounter++;
                        }
                    }
                    // check changes on SaleModel ID
                    if($rsbillboardID["salemodel_id"] != str_replace("'","",$salemodelID)){
                        $updateBillboard = "UPDATE billboards SET salemodel_id=$salemodelID WHERE name_key = '". $rsbillboardID["name_key"]."'";
                        if(!$execUpdateSaleModel = $DB->executeInstruction($updateBillboard)){
                            $message .= "\nError on Update: ".$updateBillboard;
                        }else{
                            if($alreadyUpdated != 1)
                                $updatedBillboardLineCounter++;
                            else
                                $alreadyUpdated = 0;
                        }


                    }
                }
           /* }else{

            }*/
            $readedLineCounter++;
        }
        $return = json_encode(["status" => "OK", "message" => "UPLOADED","total_lines"=>$readedLineCounter,"new_billboards"=>$insertedBillboardLineCounter,"updated_billboards"=>$updatedBillboardLineCounter,"new_viewpoints"=>$insertedViewPointLineCounter,"new_salemodels"=>$insertedSaleModelLineCounter,"new_providers"=>$insertedProviderLineCounter]);
    } else { $message .= "UPLOAD ERROR - $target_file <-- ".$temporary_name;}
} else {
    $message .= "ERROR ON EXTENSION - $imageFileType";
}

//$message .= " XXX ". $_SERVER['DOCUMENT_ROOT'];
if($message != '')
    $return = json_encode(["status" => "error", "message" => "$message"]);

header('Content-type: application/json');
echo $return;

//close connection
$DB->close();


?>