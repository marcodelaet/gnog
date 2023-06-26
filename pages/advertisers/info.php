<?php $moduleName = 'Advertiser'; ?>
<link rel="stylesheet" href="<?=$dir?>./assets/css/<?=$moduleName?>.css">
<link rel="stylesheet" href="<?=$dir?>./assets/css/Inputs.css">
<link rel="stylesheet" href="<?=$dir?>./assets/css/Button.css">
<script src="<?=$dir?>./assets/js/<?=strtolower($moduleName)?>.js" type="text/javascript"></script>
<?php if(array_key_exists('aid',$_REQUEST)){ ?>
<script>
    handleViewOnLoad("<?=$_REQUEST['aid']?>")
</script>
<?php } ?>
<div class="card bg-light mb-3" id="<?=strtolower($moduleName)?>-card">
    <div class="card-header">
        <div class="<?=strtolower($moduleName)?>-header">
            <div class="photo-container" >
                <img class="<?=strtolower($moduleName)?>-photo" id="<?=strtolower($moduleName)?>-proto-<?=$_REQUEST['aid']?>" src="/public/<?=strtolower($moduleName)?>/images/logo_example.png" style="background-color:#FFF"/>
            </div>
            <div class="<?=strtolower($moduleName)?>-main" >
                <spam id="<?=strtolower($moduleName)?>_name"><?=$moduleName?></spam>
                <spam class="<?=strtolower($moduleName)?>-group" id="group"></spam>
                <spam class="impressions">&nbsp;</spam>
            </div>
        </div>
    </div>
    <div class="card-body <?=strtolower($moduleName)?>-body">
        <h5 class="card-title main-contact-header">Contact</h5> 
        <div class="<?=strtolower($moduleName)?>-data">
            <spam class="material-icons icon-data">location_on</spam>
            <spam id="card-address">99, example, street</spam>
        </div>
        <div id="list-contacts">
            <div class="space-blank">&nbsp;</div>
            <div class="<?=strtolower($moduleName)?>-data">
                <spam id="card-contact-fullname-and-position">aaaaaa bbbbbb da xxxx (zzzzz)</spam>
            </div>
            <div class="<?=strtolower($moduleName)?>-data">
                <spam class="material-icons icon-data">email</spam>
                <spam id="card-email">email@dma.com</spam>
            </div>
            <div class="<?=strtolower($moduleName)?>-data">
                <spam class="material-icons icon-data">phone</spam>
                <spam id="card-phone">+5255999999</spam>
            </div>
        </div>
        <div class="inputs-button-container">
            <Button class="button" type="button" onClick="window.location='?pr=<?=base64_encode('./pages/'.strtolower($moduleName).'s/index.php')?>'" >Back to <?=$moduleName?>s</Button>
        </div>
    </div>
</div>
