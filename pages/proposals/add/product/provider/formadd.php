<?php
$moduleName = 'Proposal';
?>

<link rel="stylesheet" href="<?=$dir?>./assets/css/<?=$moduleName?>.css">
<link rel="stylesheet" href="<?=$dir?>./assets/css/Inputs.css">
<link rel="stylesheet" href="<?=$dir?>./assets/css/RecoveryLink.css">
<link rel="stylesheet" href="<?=$dir?>./assets/css/Button.css">

<script src="<?=$dir?>./assets/js/<?=strtolower($moduleName)?>.js" type="text/javascript"></script>
<script>
        handleViewProductsOnLoad('<?=$_REQUEST['ppid']?>','<?=$_REQUEST['pppid']?>');
</script>
<div class='form-<?=strtolower($moduleName)?>-container'>
    <div class="form-container">
        <div class="form-header"><?=translateText('add');?> <?=translateText('provider')?> -> <?=translateText('product')?> -> <?=translateText(strtolower($moduleName))?></div>
        <form name='<?=strtolower($moduleName)?>' method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
            <div class="inputs-form-container">
                <div class="form-row" >
                    <div class="col">
                        <div id="proposal-name" class="proposal-name" style="font-size:2.5rem;">Nome da Campanha</div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div id="proposal-product-name" class="proposal-product-name" >Producto / Modelo de Venta</div>
                    </div>
                </div>
                <div class="row">&nbsp;</div>
                <div class="form-row main-contact-section">
                    <div class="col">
                        <div class="form-row"  style="margin-top:2rem;">
                            <div class="col-3 main-contact-header" style="font-weight: bolder; text-decoration:underline overline; font-size:1.2rem;">
                                <?=translateText('product');?>
                            </div>
                            <div class="col-3">
                                <span class="material-icons" id="is-digital" style="text-align:right;">checked</span><span class="digital-product"><?=translateText('digital_product');?></span>
                            </div>
                            <div class="col-4">
                                <span id="proposal-product-state" class="proposal-product-state">!Estado!</span>
                            </div>
                            <div class="col-2">
                                <label for="currency"><?=translateText('currency');?>:</label>
                                <input readonly id="currency" name="currency" class="form-control" value="MXN"/>
                            </div>
                        </div>
                        <div id="product-section">
                            <div id="product_0">
                                <div class="form-row" >
                                    <div class="col">
                                        <label for="price[]"><?=translateText('unit_price');?></label><br/>
                                        <input
                                        required
                                        onkeypress="$(this).mask('#.###.##0,00', {reverse: true});"
                                        onblur="calcAmountTotalOnProvider(<?=strtolower($moduleName)?>,0)"
                                        id='price_0'
                                        name ='price[]' 
                                        placeholder="999,99"
                                        title = '<?=translateText('unit_price');?>'
                                        value=''
                                        class="form-control" 
                                        type="currency" 
                                        maxlength="20"
                                        autocomplete="price"
                                        />
                                    </div>
                                    <div class="col">
                                        <label for="quantity[]"><?=translateText('quantity');?></label>
                                        <input
                                        required
                                        onblur="calcAmountTotalOnProvider(<?=strtolower($moduleName)?>,0)"
                                        name ='quantity[]' 
                                        placeholder='<?=translateText('quantity');?>'
                                        title = '<?=translateText('quantity');?>'
                                        value=''
                                        min=1
                                        max=9999999
                                        class="form-control" 
                                        type="number"
                                        autocomplete="quantity"
                                        />
                                    </div>
                                </div>
                                <div class="form-row" >
                                    <div class="col">
                                        <label for="amount[]"><?=translateText('amount');?></label><br/>
                                        <input
                                        id='amount_0'
                                        name ='amount[]'
                                        readonly 
                                        placeholder="0,00"
                                        title = '<?=translateText('amount');?>'
                                        value='0,00'
                                        class="form-control"
                                        />
                                    </div>
                                    <div class="col">
                                        <label for="provider_id[]"><?=translateText('provider');?></label>
                                        <spam id="sprovider">
                                            <select name="provider_id[]" title="provider_id" class="form-control">
                                                <?=inputSelect('provider',translateText('provider'),'','name','')?>
                                            </select>
                                        </spam>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col">
                                        &nbsp;
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-row" >
                            <div class="col" style="text-align:right;">
                                <button class="btn-primary material-icons-outlined" type="button" onclick="newProductForm('product-section','product-new',32);">add_circle_outline</button>
                            </div>
                        </div>
                        <div id="product-new">
                            <div class="form-row">
                                <div class="col">
                                    &nbsp;
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col">
                        <label for="total"><?=translateText('total');?></label><br/>
                        <input
                        id='total'
                        name ='total'
                        readonly 
                        placeholder="0,00"
                        title = '<?=translateText('total');?>'
                        value='0,00'
                        class="form-control"
                        />
                    </div>
                </div>
            </div>
            <div class="inputs-button-container">
                <input type="hidden" name="productID" id="productID" />
                <input type="hidden" name="salemodelID" id="salemodelID" />
                <input type="hidden" name="stateSel" id="stateSel" />
                <input type="hidden" name="proposalID" id="proposalID" />
                <input type="hidden" name="referrer" id="referrer" value="<?=$_REQUEST['pr']?>" />
                <button class="button" name="btnSave" type="button" onClick="handleSubmitProvider(<?=strtolower($moduleName)?>)" ><?=translateText('save');?></button>
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
    </div>    
</div>

