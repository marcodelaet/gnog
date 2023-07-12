<?php
// security
$failDiv = '-fail';
if($d1==$d2){
  $failDiv = '';
}
?>
<div class="general-container<?=$failDiv?>">
<?php
if($d1==$d2){
  //call page
  if (array_key_exists('QUERY_STRING',$_SERVER)){
    if(array_key_exists('pr',$_REQUEST)){
      $pageToGo = base64_decode($_REQUEST['pr']);
      //echo $pageToGo;
      require($pageToGo);
      //echo base64_encode('./pages/users/list.php');
    }

  }
} else {
  ?>
  <div>
    <p class="alert-fail" Language-Tag='pt-BR'>
      <spam  style="font-weight: bolder;">Desculpe, estamos com problemas técnicos</spam><BR/>
      <spam>Mas não se preocupe, estamos trabalhando para normalizar o serviço</spam>
    </p>
    
    <p class="alert-fail" Language-Tag='esp-MX'>
      <spam  style="font-weight: bolder;">Lo sentimos, estamos teniendo problemas técnicos</spam><BR/>
      <spam>Pero no te preocupes, estamos trabajando para que el servicio vuelva a la normalidad</spam>
    </p>
    
    <p class="alert-fail" Language-Tag='en-US'>
      <spam  style="font-weight: bolder;">Sorry, we are having technical problems</spam><BR/>
      <spam>But don't worry, we are working to get the service back to normal</spam>
    </p>
  </div>
  <?php  
}



?>  
</div>