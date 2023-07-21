<?php
$moduleName = 'Proposal';
?>
<link rel="stylesheet" href="<?=$dir?>./assets/css/<?=$moduleName?>.css">
<link rel="stylesheet" href="<?=$dir?>./assets/css/Inputs.css">
<link rel="stylesheet" href="<?=$dir?>./assets/css/RecoveryLink.css">
<link rel="stylesheet" href="<?=$dir?>./assets/css/Button.css">
<script src="<?=$dir?>./assets/js/<?=strtolower($moduleName)?>.js" type="text/javascript"></script>


<div class='form-<?=strtolower($moduleName)?>-container'>
    <div class="inputs-filter-container">
        <div class="form-row">
            <div class="input-group col-sm-11">
                &nbsp;
            </div>
            <div class="input-group col-sm-1 " style="margin-bottom:1rem;">
                <a type="button" title="Add New" class="btn btn-outline-primary my-2 my-sm-0" type="button" style="width:100%; text-align: center; vertical-align:middle;" onClick="location.href='?pr=<?=base64_encode('./pages/proposals/add/product/formadd.php')?>&ppid=<?=$_REQUEST['ppid']?>'"><span class="material-icons">add_box</span><div class="text-button"><?=translateText('add')?> <?=translateText('product')?></div></a>
            </div>
        </div>
    </div>

    <div class="form-container">
        <div class="form-header"><spam id="offer-name">&nbsp;</spam><spam id="advertiser-name">Advertiser / Agency</spam></div>
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