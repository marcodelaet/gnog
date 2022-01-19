<?php 
require_once('./assets/conf.main.php'); 
require_once('./assets/lib/security_area.php');
require_once('./components/items/input.php');
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
echo $dir;
require('./components/content.main.php');
require_once('./components/footer.main.php');
   //phpinfo();
?>
      </div>
   </body>
</html>