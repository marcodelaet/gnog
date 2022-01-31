<?php
$moduleName = 'Advertiser';
?>
<link rel="stylesheet" href="<?=$dir?>./assets/css/<?=$moduleName?>.css">
<link rel="stylesheet" href="<?=$dir?>./assets/css/Inputs.css">
<link rel="stylesheet" href="<?=$dir?>./assets/css/RecoveryLink.css">
<link rel="stylesheet" href="<?=$dir?>./assets/css/Button.css">
<script src="<?=$dir?>./assets/js/<?=strtolower($moduleName)?>.js" type="text/javascript"></script>

<div class='form-<?=strtolower($moduleName)?>-container'>
    <div class="form-container">
        <div class="form-header">Import <?=$moduleName?>s from CSV file</div>
        <form name='<?=strtolower($moduleName)?>' method="post" enctype="multipart/form-data" class="needs-validation" action="http://gnogcrm.local/api/advertisers/auth_advertiser_csv_upload.php" novalidate>
            <div class="inputs-form-container">
                <div class="input-group mb-3">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="<?=strtolower($moduleName)?>-file" name="<?=strtolower($moduleName)?>_file" accept=".csv" onchange="document.getElementById('<?=strtolower($moduleName)?>-file-label').innerHTML = this.value.split(/[|\/\\]+/)[2];" aria-describedby="<?=strtolower($moduleName)?>-file">
                        <label class="custom-file-label" id="<?=strtolower($moduleName)?>-file-label" for="inputGroupFile01">Choose csv file</label>
                    </div>
                </div>
            </div>
            <div class="inputs-form-container">
                <div class="input-group mb-12">
                    <div  class="link-to-file">
                        <a target="_blank" href="https://docs.google.com/spreadsheets/d/1kkge5SEg5uCaWwldydJm1z1V6mUenO998iuFf8ZOT7s/edit?usp=sharing"><spam></spam><spam>Access to spreadsheet</spam></a>
                    </div>
                </div>
            </div>
            <div class="form-row">&nbsp;</div>
            <div class="inputs-button-container">
                <button class="button" name="btnSave" type="button" onClick="handleSubmitCSV(<?=strtolower($moduleName)?>)" >Upload list of <?=strtolower($moduleName)?>s</button>
            </div>
        </form>
    </div>    
</div>