<?php 
session_start();
require_once __DIR__ . '/vendor/autoload.php';

$d1 = 1;
$d2 = 1;


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
<html>
<?php
require_once('./components/header.main.php');

?>
  <body <?php if($_REQUEST['pr'] == base64_encode('./pages/maps/index.php')) { ?> onload="theMap('<?=$_REQUEST['smid']?>','<?=$_REQUEST['state']?>','<?=$_REQUEST['city']?>','<?=$_REQUEST['county']?>','<?=$_REQUEST['colony']?>','<?=$_REQUEST['pppid']?>');" <?php } ?>>
    <!-- Google Tag Manager (noscript) -->
      <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-WJV6X9VN"
      height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    <noscript>You need to enable JavaScript to run this app.</noscript>
<?php


if($LOCALSERVER == 'local') {
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
//echo '?pr='.base64_encode('./pages/billboards/formedit.php');
?>
      </div>
   </body>
</html>