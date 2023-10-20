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
                <a title="<?=translateText('add')?> <?=translateText('product')?>" class="btn btn-outline-primary my-2 my-sm-0" type="button" style="width:100%; text-align: center; vertical-align:middle;" onClick="location.href='?pr=<?=base64_encode('./pages/proposals/add/product/formadd.php')?>&ppid=<?=$_REQUEST['ppid']?>'"><span class="material-icons">add_box</span><div class="text-button"><?=translateText('add')?> <?=translateText('product')?></div></a>
            </div>
        </div>
    </div>

    <div class="form-container">
        <div class="form-header">
            <spam id="offer-name">&nbsp;</spam>
            <spam id="advertiser-name">Advertiser / Agency</spam>
            <spam id="proposal-dates">
                <spam id="start-date">01/10/2023</spam> - 
                <spam id="stop-date">
                    <a id="stop-date-alink" title="<?=ucfirst(translateText('change'))?> <?=translateText('stop_date')?>" type="button" onClick="changeDateForm(document.getElementById(this.id).innerText,'<?=$_REQUEST['ppid']?>');">
                        31/10/2023
                    </a>
                </spam>
            </spam>
        </div>

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