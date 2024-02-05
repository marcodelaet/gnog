<?php
$moduleName = 'Provider';
$pid        = $_REQUEST['pid'];
?>
<link rel="stylesheet" href="<?=$dir?>./assets/css/<?=$moduleName?>.css">
<link rel="stylesheet" href="<?=$dir?>./assets/css/Inputs.css">
<link rel="stylesheet" href="<?=$dir?>./assets/css/RecoveryLink.css">
<link rel="stylesheet" href="<?=$dir?>./assets/css/Button.css">
<script src="<?=$dir?>./assets/js/<?=strtolower($moduleName)?>.js" type="text/javascript"></script>

<div class='form-<?=strtolower($moduleName)?>-container'>
    <div class="form-container">
        <div class="form-header"><?=ucfirst(translateText('edit'));?> <?=ucfirst(translateText(strtolower($moduleName)));?></div>
        <form name='<?=strtolower($moduleName)?>' method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
            <div class="inputs-form-container">
                <div class="form-row">
                    <div class="col">
                        <label for="name"><?=ucfirst(translateText('name'));?></label>
                        <input
                        required
                        name ='name' 
                        placeholder='<?=ucfirst(translateText('name'));?>'
                        title = '<?=ucfirst(translateText('name'));?>'
                        value=''
                        class="form-control" 
                        type="text" 
                        maxlength="40"
                        autocomplete="provider_name"
                        />
                        <div class="invalid-feedback">
                            Please type the Corporate name
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <label for="name"><?=ucfirst(translateText('webpage'));?></label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon3">https://example.com/</span>
                        </div>
                        <input
                        required
                        name ='webpage_url' 
                        placeholder='Type the URL here'
                        title = '<?=ucfirst(translateText('webpage'));?>'
                        value=''
                        class="form-control" 
                        type="text" 
                        maxlength="200"
                        autocomplete="webpage_url"
                        />
                        <div class="invalid-feedback">
                            Please type the Corporate name
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col">
                        <label for="address"><?=ucfirst(translateText('address'));?></label>
                        <textarea
                        required
                        name ='address' 
                        placeholder='99, <?=ucfirst(translateText('address'));?> - City - Country - Postal Code'
                        title = '<?=ucfirst(translateText('address'));?>'
                        value=''
                        class="form-control"  
                        autocomplete="address"
                        ></textarea>
                        <div class="invalid-feedback">
                            Please type the Address of the <?=$moduleName?>
                        </div>
                    </div>
                </div>
<!-- PRODUCT AREA - DISABLED 
                <div class="form-row product-section">
                    <div class="col">
                        <div class="form-row" >
                            <div class="col product-header">
                                <?=ucfirst(translateText('product'));?>
                            </div>
                        </div>
                        <div class="form-row" >
                            <div class="col">
                                <label for="product_id"><?=ucfirst(translateText('product'));?></label>
                                <spam id="sproduct">
                                    <select name="product_id" id="selectproduct" title="product_id" class="form-control" autocomplete="product_id" required>
                                        <?=inputSelect('product',ucfirst(translateText('product')),'','name','');?>
                                    </select>
                                </spam>

                                
                                <div class="invalid-feedback">
                                    Please choose a product for the Provider.
                                </div>
                            </div>
                            <div class="col">
                                <label for="product_price"><?=ucfirst(translateText('price'));?></label>
                                <input
                                required
                                name ='product_price' 
                                placeholder='0,00'
                                title = '<?=ucfirst(translateText('price'));?>'
                                value=''
                                class="form-control" 
                                type="currency" 
                                autocomplete="price"
                                />
                                <div class="invalid-feedback">
                                    Please type the price for each product.
                                </div>
                            </div>
                            <div class="col-2">
                                <label for="currency">&nbsp;</label>
                                <select
                                required
                                name ='currency' 
                                title = '<?=ucfirst(translateText('currency'));?>'
                                class="form-control"
                                autocomplete="currency">
                                    <option value="MXN">MXN</option>
                                    <option value="USD">USD</option>
                                    <option value="BRL">BRL</option>
                                </select>
                                <div class="invalid-feedback">
                                    Please type the price for each product.
                                </div>
                            </div>
                        </div>
                        <div class="form-row" >
                            <div class="col">
                                <label for="salemodel_id"><?=ucfirst(translateText('sale_model'));?></label>
                                <spam id="ssalemodel">
                                    <select name="salemodel_id" id="selectsalemodel" title="salemodel_id" class="form-control" autocomplete="salemodel_id" required>
                                        <?=inputSelect('salemodel',ucfirst(translateText('sale_model')),'','name','')?>
                                    </select>
                                </spam>
                                <div class="invalid-feedback">
                                    Please choose a sale model.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


END OF PRODUCT AREA -->
            <div class="inputs-button-container">
                <button class="button" name="btnSave" type="button" onClick="handleEditSubmit('<?=$pid?>',<?=strtolower($moduleName)?>)" ><?=ucfirst(translateText('save'));?></button>
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


<?php if(array_key_exists('pid',$_REQUEST)){ ?>
<script>
    handleOnLoad("<?=$pid?>",<?=strtolower($moduleName)?>)
</script>
<?php } ?>