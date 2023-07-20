<?php $moduleName = 'Proposal'; ?>
<link rel="stylesheet" href="<?=$dir?>./assets/css/<?=$moduleName?>.css">
<link rel="stylesheet" href="<?=$dir?>./assets/css/Inputs.css">
<link rel="stylesheet" href="<?=$dir?>./assets/css/Button.css">
<script src="<?=$dir?>./assets/js/<?=strtolower($moduleName)?>.js" type="text/javascript"></script>
<?php if(array_key_exists('ppid',$_REQUEST)){ ?>
<script>
    handleViewOnLoad("<?=$_REQUEST['ppid']?>")
</script>
<?php } ?>
<div class="card bg-light mb-3" id="<?=strtolower($moduleName)?>-card">
    <div class="card-header">
        <div class="<?=strtolower($moduleName)?>-header">
            <div class="<?=strtolower($moduleName)?>-main" >
                <spam id="<?=strtolower($moduleName)?>-name"><?=$moduleName?></spam>
                <spam class="<?=strtolower($moduleName)?>-client" id="client"></spam>
                <spam class="<?=strtolower($moduleName)?>-description" id="description"></spam><br/>
                <spam class="<?=strtolower($moduleName)?>-dates" id="dates"></spam>
                
            </div>
        </div>
    </div>
    <div class="card-body <?=strtolower($moduleName)?>-body">
        <!--***************************************
        ****** Products Section *******************-->
        <h5 class="card-title main-products-header"><?=translateText('Products')?></h5>
        <div class="<?=strtolower($moduleName)?>-data">
            <div id="products-list">
                <spam >aaaaaa bbbbbb da xxxx </spam><spam >- R$ 0,00</spam>
            </div>
        </div>
        <div class="margin-space">&nbsp;</div>
        <div class="<?=strtolower($moduleName)?>-data">
         
        <?=inputDropDownStyle('status','','percent','','')?>
            </div>

        <div class="inputs-button-container">
            <input type="hidden" id='ppid' name="ppid" value="<?=$_REQUEST['ppid']?>"/>
            <Button class="button" type="button" onClick="window.location='?pr=<?=base64_encode('./pages/'.strtolower($moduleName).'s/index.php')?>'" >Back to <?=translateText($moduleName.'s');?></Button>
        </div>
    </div>
</div>
