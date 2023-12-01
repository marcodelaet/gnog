<?php
$moduleName = 'Billboard';
$bid        = $_REQUEST['bid'];

?>
<link rel="stylesheet" href="<?=$dir?>./assets/css/<?=$moduleName?>.css">
<link rel="stylesheet" href="<?=$dir?>./assets/css/Inputs.css">
<link rel="stylesheet" href="<?=$dir?>./assets/css/RecoveryLink.css">
<link rel="stylesheet" href="<?=$dir?>./assets/css/Button.css">
<script src="<?=$dir?>./assets/js/<?=strtolower($moduleName)?>.js" type="text/javascript"></script>

<div class='form-<?=strtolower($moduleName)?>-container'>
    <div class="form-container">
        <div class="form-header"><?=ucfirst(translateText('edit'));?> <?=ucfirst(translateText(strtolower($moduleName)))?></div>
        <br/>
        <form name='<?=strtolower($moduleName)?>' method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
            <div class="inputs-form-container">
                <div class="form-row">
                    <div class="col">
                        <label for="name_key"><?=ucfirst(translateText('key'));?></label>
                        <input
                        required
                        name ='name_key' 
                        placeholder='<?=ucfirst(translateText('key'));?>'
                        title = '<?=ucfirst(translateText('key'));?>'
                        value=''
                        class="form-control" 
                        type="text" 
                        maxlength="50"
                        autocomplete="name_key"
                        readonly
                        disabled
                        />
                    </div>
                </div>
                <div class="form-row">
                    <div class="col">
                        <label for="address"><?=ucfirst(translateText('address'));?></label>
                        <textarea
                        required
                        name ='address' 
                        placeholder='99, Address - City - Country - Postal Code'
                        title = '<?=ucfirst(translateText('address'));?>'
                        value=''
                        class="form-control"  
                        autocomplete="address"
                        readonly
                        disabled
                        ></textarea>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col">
                        <label for="category"><?=ucfirst(translateText('category'));?></label>
                        <input
                        required
                        name ='category' 
                        placeholder='<?=ucfirst(translateText('category'));?>'
                        title = '<?=ucfirst(translateText('category'));?>'
                        value=''
                        class="form-control" 
                        type="text" 
                        maxlength="30"
                        autocomplete="category"
                        readonly
                        disabled
                        />
                    </div>
                    <div class="col">
                        <label for="coordenates"><?=ucfirst(translateText('coordenates'));?></label>
                        <input
                        required
                        name ='coordenates' 
                        placeholder='<?=ucfirst(translateText('coordenates'));?>'
                        title = '<?=ucfirst(translateText('coordenates'));?>'
                        value=''
                        class="form-control" 
                        type="text" 
                        maxlength="40"
                        autocomplete="coordenates"
                        readonly
                        disabled
                        />
                    </div>
                </div>
                <div class="form-row">
                    <div class="col">
                        <label for="salemodel"><?=ucfirst(translateText('sale_model'));?></label>
                        <input
                        required
                        name ='salemodel' 
                        placeholder='<?=ucfirst(translateText('sale_model'));?>'
                        title = '<?=ucfirst(translateText('sale_model'));?>'
                        value=''
                        class="form-control" 
                        type="text" 
                        maxlength="40"
                        autocomplete="salemodel"
                        readonly
                        disabled
                        />
                    </div>
                    <div class="col">
                        <label for="viewpoint"><?=ucfirst(translateText('viewpoint'));?></label>
                        <input
                        required
                        name ='viewpoint' 
                        placeholder='<?=ucfirst(translateText('viewpoint'));?>'
                        title = '<?=ucfirst(translateText('viewpoint'));?>'
                        value=''
                        class="form-control" 
                        type="text" 
                        maxlength="40"
                        autocomplete="viewpoint"
                        readonly
                        disabled
                        />
                    </div>
                    <div class="col">
                        <label for="iluminated">&nbsp;</label>
                        <input
                        required
                        name ='iluminated' 
                        placeholder='<?=ucfirst(translateText('is_iluminated'));?>'
                        title = '<?=ucfirst(translateText('is_iluminated'));?>'
                        value=''
                        class="form-control" 
                        type="text" 
                        maxlength="40"
                        autocomplete="iluminated"
                        readonly
                        disabled
                        />
                    </div>
                </div>
                <div class="form-row">
                    <div class="col">
                        <label for="dimensions"><?=ucfirst(translateText('dimensions'));?></label>
                        <input
                        required
                        name ='dimensions' 
                        placeholder='<?=ucfirst(translateText('dimensions'));?>'
                        title = '<?=ucfirst(translateText('dimensions'));?>'
                        value=''
                        class="form-control" 
                        type="text" 
                        maxlength="40"
                        autocomplete="dimensions"
                        readonly
                        disabled
                        />
                    </div>
                    <div class="col">
                        <label for="provider"><?=ucfirst(translateText('provider'));?></label>
                        <input
                        required
                        name ='provider' 
                        placeholder='<?=ucfirst(translateText('provider'));?>'
                        title = '<?=ucfirst(translateText('provider'));?>'
                        value=''
                        class="form-control" 
                        type="text" 
                        maxlength="40"
                        autocomplete="provider"
                        readonly
                        disabled
                        />
                    </div>
                </div>
                <div class="form-row">
                    <div class="col">
                        <label for="cost"><?=ucfirst(translateText('cost'));?></label>
                        <input
                        required
                        name ='cost' 
                        placeholder='<?=ucfirst(translateText('cost'));?>'
                        title = '<?=ucfirst(translateText('cost'));?>'
                        value=''
                        class="form-control" 
                        type="currency" 
                        onkeypress="$(this).mask('#.###.##0,00', {reverse: true});"
                        maxlength="40"
                        autocomplete="cost"
                        />
                    </div>
                    <div class="col">
                        <label for="price"><?=ucfirst(translateText('price'));?></label>
                        <input
                        required
                        name ='price' 
                        placeholder='<?=ucfirst(translateText('price'));?>'
                        title = '<?=ucfirst(translateText('price'));?>'
                        value=''
                        class="form-control" 
                        type="currency" 
                        onkeypress="$(this).mask('#.###.##0,00', {reverse: true});"
                        maxlength="40"
                        autocomplete="price"
                        />
                    </div>
                </div>
            </div>
            <div class="inputs-button-container">
                <button class="button" name="btnSave" type="button" onClick="handleEditSubmit('<?=$bid?>',<?=strtolower($moduleName)?>)" ><?=ucfirst(translateText('save'));?></button>
            </div>
        </form>
      <?php
      if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    $myIP     = $ip;
    //$region   = geoip_country_code_by_name($myIP);
    // echo "IP: ".$myIP."<BR/>Region: ".$region;
 ?>


<?php if(array_key_exists('bid',$_REQUEST)){ ?>
<script>
    handleOnLoad("<?=$bid?>",<?=strtolower($moduleName)?>)
</script>
<?php } ?>