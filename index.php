<?php 
session_start();
require_once __DIR__ . '/vendor/autoload.php';



ini_set('error_reporting', E_ALL);
ini_set('display_errors', true);

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
  <body>
    <noscript>You need to enable JavaScript to run this app.</noscript>
    <div id="root">
      <?php
require('./components/menu.main.php');
require('./components/content.main.php');
require_once('./components/footer.main.php');
   //phpinfo();
?>
      </div>
   </body>
</html>