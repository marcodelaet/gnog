<?php
$moduleName = 'Message';
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
                <a title="<?=translateText('add')?> <?=translateText('product')?>" class="btn btn-outline-primary my-2 my-sm-0" type="button" style="width:100%; text-align: center; vertical-align:middle;" onClick="location.href='?pr=<?=base64_encode('./pages/proposals/product/formadd.php')?>&ppid=<?=$_REQUEST['ppid']?>'"><span class="material-icons">add_box</span><div class="text-button"><?=translateText('add')?> <?=translateText('product')?></div></a>
            </div>
        </div>
    </div>

    <div class="form-container">
        <div class="form-header">
            <spam id="offer-name">&nbsp;</spam>
            <spam id="advertiser-name">Advertiser / Agency</spam>
            <spam id="proposal-dates">
                <spam id="start-date">
                    <a id="start-date-alink" title="<?=ucfirst(translateText('change'))?> <?=translateText('start_date')?>" type="button" onClick="changeDateForm('start',document.getElementById(this.id).innerText,'<?=$_REQUEST['ppid']?>');">
                        01/10/2023
                    </a>
                </spam> - 
                <spam id="stop-date" >
                    <a id="stop-date-alink" title="<?=ucfirst(translateText('change'))?> <?=translateText('stop_date')?>" type="button" onClick="changeDateForm('stop',document.getElementById(this.id).innerText,'<?=$_REQUEST['ppid']?>');">
                        31/10/2023
                    </a>
                </spam>
            </spam>
        </div>

        <div class="list-products-container" id="list-products">
        </div>
        <br/>
        <div id='list-files'>
            <table class="table table-hover table-sm">
                <caption>Proposal / Files</caption>
                <thead>
                    <tr>
                    <th class="column col-9" scope="col">
                        <?=ucfirst(translateText('file'));?>
                    </th>
                    <th class="column col-3" scope="col">
                    <?=ucfirst(translateText('date'));?>
                    </th>
                    </tr>
                </thead>
                <tbody id="listIProposalFiles">
                </tbody>
            </table>
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