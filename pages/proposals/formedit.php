<?php
$moduleName = 'Proposal';
?>
<link rel="stylesheet" href="<?=$dir?>./assets/css/<?=$moduleName?>.css">
<link rel="stylesheet" href="<?=$dir?>./assets/css/Inputs.css">
<link rel="stylesheet" href="<?=$dir?>./assets/css/RecoveryLink.css">
<link rel="stylesheet" href="<?=$dir?>./assets/css/Button.css">
<script src="<?=$dir?>./assets/js/<?=strtolower($moduleName)?>.js" type="text/javascript"></script>


<div class='form-<?=strtolower($moduleName)?>-container'>
    <div class="form-container">
        <div class="form-header"><spam id="offer-name">Teste Teste</spam><spam id="advertiser-name">Advertiser / Agency</spam></div>
            <div class="list-products-container" id="list-products">
            </div>
        </div>
    </div>    
</div>


<?php 
if(array_key_exists('ppid',$_REQUEST)){ 
    $ppid        = $_REQUEST['ppid'];
?>
<script>
    handleListEditOnLoad("<?=$ppid?>","<?=strtolower($moduleName)?>")
</script>
<?php } ?>