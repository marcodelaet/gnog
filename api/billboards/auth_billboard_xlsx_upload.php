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

$target_dir     = $dir.'/public/sheets/';
$target_file    = $target_dir . basename($_FILES["billboard_file"]["name"]);
$uploadOk       = 1;
$message        = '';
$imageFileType  = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
$fileSize       = $_FILES["billboard_file"]["size"];

if($imageFileType != 'xlsx'){
    $message    .= "\n- Sorry, Only XLSX file is allowed";
    $uploadOk   = 0;
}

if ($uploadOk > 0) {
    if (move_uploaded_file($_FILES["billboard_file"]["tmp_name"], $target_file)) {
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
            $sqlbillboards  = "SELECT name_key,state,county,city,colony,provider_id,salemodel_id FROM billboards WHERE LOWER(name_key) = LOWER('".$cleanClave."')";
            // Executing Query 
            $rsbillboardID = $DB->getDataSingle($sqlbillboards);

            $claveInExcel = isset($cleanClave) ? $cleanClave : null;

            // cleaning address fields on Excel
            $cleanState     = $rows[$i]['Estado '];
            $cleanCity      = $rows[$i]['Ciudad '];
            $cleanCounty    = $rows[$i]['Alcaldía / Municipio'];
            $cleanColony    = $rows[$i]['Colonia'];
            //if(isset($rsbillboardID["name_key"])){
                // Cleaning names
                $cleanProvider  = str_replace("\n","",str_replace("\r","",$rows[$i]['Proveedor']));
                $cleanVista     = str_replace("\n","",str_replace("\r","",$rows[$i]['Vista']));
                //$cleanTipo      = str_replace("\n","",str_replace("\r","",$rows[$i]['Tipo']));
                $cleanTipo      = str_replace("\n","",str_replace("\r","",$rows[$i]['Categoria']));
                
                // Queries getting IDs
                $sqlSaleModels  = "SELECT id, name FROM salemodels WHERE LOWER(name) = LOWER('".$cleanTipo."')";
                $sqlViewPoints  = "SELECT id, name FROM viewpoints WHERE REPLACE(LOWER(name),' ','') = REPLACE(LOWER('".$cleanVista."'),' ','')";
                $sqlProviders   = "SELECT id, name FROM providers WHERE REPLACE(LOWER(name),' ','') LIKE REPLACE(LOWER('".$cleanProvider."'),' ','')";

                //echo $sqlProviders . "\n";

                //$message .= ' PPPP ' . $sqlProviders . ' SSSS ' . $sqlSaleModels . ' VVVV ' . $sqlViewPoints;

                $salemodelID    = 'NULL';
                $rssalemodelID = $DB->getDataSingle($sqlSaleModels);
                if(strtolower(str_replace('"','',str_replace(' ','',$rssalemodelID["name"]))) == strtolower(str_replace('"','',str_replace(' ','',$cleanTipo)))){
                    $salemodelID    = "'".$rssalemodelID["id"]."'";
                } else {
                    if(($rssalemodelID["name"] == '') || (is_null($rssalemodelID["name"]))){
                        $insertNewSaleModel = "INSERT INTO salemodels (id, name, description, is_digital, is_active, created_at, updated_at) VALUES (UUID(),'".$cleanTipo."','".$cleanTipo."','N','Y',now(),now())";
                        if(!$rs_insertNewSaleModel = $DB->executeInstruction($insertNewSaleModel)){
                            $message .= "\nError on INSERT: ".$insertNewViewPoint;
                        }
                        //$message .= $insertNewSaleModel . ' |SSS| ';
                        $salemodelID = "'".$DB->getDataSingle($sqlSaleModels)["id"]."'";
                    }
                }
                $viewPointID    = 'NULL';
                $rsviewpointID = $DB->getDataSingle($sqlViewPoints);
                //echo $rsviewpointID["name"] . " -------- " . $rows[$i]['Vista'] . "<BR/>";
                if(strtolower(str_replace('"','',str_replace(' ','',$rsviewpointID["name"]))) == strtolower(str_replace('"','',str_replace(' ','',$cleanVista)))){
                    $viewPointID    = "'".$rsviewpointID["id"]."'";
                }else{
                    if(($rsviewpointID["name"] == '') || (is_null($rsviewpointID["name"]))){
                        $insertNewViewPoint = "INSERT INTO viewpoints (id, name, is_active, created_at, updated_at) VALUES (UUID(),'".$cleanVista."','Y',now(),now())";
                        if(!$rs_insertNewViewPoint = $DB->executeInstruction($insertNewViewPoint)){
                            $message .= "\nError on INSERT: ".$insertNewViewPoint;
                        }
                        //$message .= $insertNewViewPoint . ' |VVV| ';
                        $viewPointID = "'".$DB->getDataSingle($sqlViewPoints)["id"]."'";
                    } 
                    else { echo "ERROR: ".$sqlViewPoints . " <BR/> Name: ".$rsviewpointID["name"]."<BR/> COMPAT: ". strtolower(str_replace('"','',str_replace(' ','',$rsviewpointID["name"]))) . " && " .strtolower(str_replace('"','',str_replace(' ','',$cleanVista))); }
                }

                $providerID    = 'NULL';
                $rsproviderID = $DB->getDataSingle($sqlProviders);
                $numProviders = $DB->numRows($sqlProviders);
                if(str_replace('í','i',str_replace('á','a',strtolower(str_replace(' ','',$rsproviderID["name"])))) == str_replace('í','i',str_replace('á','a',strtolower(str_replace(' ','',$cleanProvider))))){
                    $providerID     = "'".$rsproviderID["id"]."'";
                } else {
                    if(($numProviders == '0')){ // || ($rsproviderID["name"] == '') || (is_null($rsproviderID["name"]))
                        $insertNewProvider = "INSERT INTO providers (id, name, is_active, created_at, updated_at) VALUES (UUID(),'".$cleanProvider."','Y',now(),now())";
                        if(!$rs_insertNewProvider = $DB->executeInstruction($insertNewProvider)){
                            $message .= "\nError on INSERT: ".$insertNewViewPoint;
                        }
                        //$message .= $insertNewProvider . ' |PPP| ';
                        $providerID = "'".$DB->getDataSingle($sqlProviders)["id"]."'";
                    } 
                    else {echo "ERROR: ".$sqlProviders . " <BR/> Name: ".$rsproviderID["name"]."<BR/> NUM: ". $numProviders . " <BR/> COMPAT: ". str_replace('í','i',str_replace('á','a',strtolower(str_replace(' ','',$rsproviderID["name"])))) . " && " .str_replace('í','i',str_replace('á','a',strtolower(str_replace(' ','',$cleanProvider))));}
                }
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
                    $width      = intval(floatval($rows[$i]['Base'])*100);
                    $height     = intval(floatval($rows[$i]['Alto'])*100);
                    $price_int  = floatval(str_replace(",",".",str_replace("$","",$rows[$i]['Tarifa Publicada']))) * 100;
    //                $cost_int   = floatval(str_replace(",",".",str_replace("$","",$rows[$i]['Renta']))) * 100;
                    $cost_int   = floatval(str_replace(",",".",str_replace("$","",$rows[$i]['Costo']))) * 100;


                    $insertNewBillboard = "INSERT INTO billboards (id,name_key,address,state,county,city,colony,category,coordenates,latitud,longitud,price_int,cost_int,width,height,photo,provider_id,salemodel_id,viewpoint_id,is_iluminated, is_digital, is_active, created_at, updated_at) VALUES (UUID(),'".$rows[$i]['Clave']."','".$rows[$i]['Dirección']."','".$rows[$i]['Estado ']."','".$rows[$i]['Alcaldía / Municipio']."','".$rows[$i]['Ciudad ']."','".$rows[$i]['Colonia']."','".$rows[$i]['Categoría (NSE)']."','".$rows[$i]['Coordenadas']."','".$rows[$i]['Latitud']."','".$rows[$i]['Longitud']."',$price_int,$cost_int,$width,$height,'".$cleanClave.".jpg.jpg',$providerID,$salemodelID,$viewPointID,'$iluminated','N','Y',now(),now())";

                    if(!$rs_insertNewBillboard = $DB->executeInstruction($insertNewBillboard)){
                        $message .= "\nError on INSERT: ".$insertNewBillboard;
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
                    if((strtolower(str_replace('"','',str_replace(' ','',$rsbillboardID["state"]))) != strtolower(str_replace('"','',str_replace(' ','',$cleanState)))) || (strtolower(str_replace('"','',str_replace(' ','',$rsbillboardID["county"]))) != strtolower(str_replace('"','',str_replace(' ','',$cleanCounty)))) || (strtolower(str_replace('"','',str_replace(' ','',$rsbillboardID["city"]))) != strtolower(str_replace('"','',str_replace(' ','',$cleanCity)))) || (strtolower(str_replace('"','',str_replace(' ','',$rsbillboardID["colony"]))) != strtolower(str_replace('"','',str_replace(' ','',$cleanColony))))){
                        $updateBillboard = "UPDATE billboards SET state = '$cleanState',county = '$cleanCounty',city = '$cleanCity',colony = '$cleanColony' WHERE name_key = '". $rsbillboardID["name_key"]."'";
                        if(!$execUpdateLocal = $DB->executeInstruction($updateBillboard)){
                            $message .= "\nError on Update: ".$updateBillboard;
                        }
                    }
                    // check changes on SaleModel ID
                    if($rsbillboardID["salemodel_id"] != str_replace("'","",$salemodelID)){
                        $updateBillboard = "UPDATE billboards SET salemodel_id=$salemodelID WHERE name_key = '". $rsbillboardID["name_key"]."'";
                        if(!$execUpdateSaleModel = $DB->executeInstruction($updateBillboard)){
                            $message .= "\nError on Update: ".$updateBillboard;
                        }
                    }
                }
           /* }else{

            }*/
        }
        $return = json_encode(["status" => "OK", "message" => "UPLOADED"]);
    } else { $message .= "UPLOAD ERROR";}
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