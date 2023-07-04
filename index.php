<?php 
session_start();
require_once __DIR__ . '/vendor/autoload.php';



//ini_set('error_reporting', E_ALL);
//ini_set('display_errors', true);

require_once __DIR__.'/vendor/shuchkin/simplexlsx/src/SimpleXLSX.php';

use Shuchkin\SimpleXLSX;

require_once('./assets/conf.main.php'); 
require_once('./assets/lib/security_area.php');
require_once('./components/items/input.php');
require_once('./assets/lib/translation.php');
?>
<!DOCTYPE html>
<html lang="en">
<?php
require_once('./components/header.main.php');
?>
  <body <?php if($_REQUEST['pr'] == base64_encode('./pages/maps/index.php')) { ?> onload="theMap('<?=$_REQUEST['smid']?>','<?=$_REQUEST['state']?>','<?=$_REQUEST['city']?>','<?=$_REQUEST['county']?>','<?=$_REQUEST['colony']?>','<?=$_REQUEST['pppid']?>');" <?php } ?>>
    <noscript>You need to enable JavaScript to run this app.</noscript>
<?php      if($LOCALSERVER == 'local') {
?>
<div id="develop-area">
      DEVELOP AREA   -   DEVELOP AREA   -   DEVELOP AREA   -   DEVELOP AREA   -   DEVELOP AREA  -   DEVELOP AREA   
    </div>
<?php  
} else {
  if(substr($SUBDOMAIN,0,4) == 'beta') {
    ?> 
    <div id="beta-notify">
    BETA HOMOLOGATION - BETA HOMOLOGATION - BETA HOMOLOGATION - BETA HOMOLOGATION - BETA HOMOLOGATION
    </div>
    <?php
  } else { 
    // nothing  
  }
}
?>    
    <div id="root">
      <?php
require('./components/menu.main.php');
require('./components/content.main.php');
require_once('./components/footer.main.php');
   //phpinfo();


//echo '?pr='.base64_encode('./pages/users/login/formedit.php').'&tid=98eb8c5c-eebb-11ed-9ed2-008cfa5abdac';
//echo '?pr='.base64_encode('./pages/proposals/add/product/provider/formadd.php');
?>
      </div>
   </body>
</html>