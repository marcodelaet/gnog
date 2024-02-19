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
<script type="text/javascript">
    var d_start = [];
    var d_stop  = [];
    d_start[0]  = 0;
    d_stop[0]   = 0;
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
                                <input type="hidden" id="start-date-input" name="start_date"/>
                                <input type="hidden" id="stop-date-input" name="stop_date"/>
                            </div>
                        </div>
                        <div id="product-section">
                            <div id="product_0">
                            <br/>
                                <div class="form-row">
                                    <div class="col-2 custom-control custom-switch" style="text-align:center; vertical-align:middle;" id="div-datetype-option_0">
                                        <input type="checkbox" class="custom-control-input" value="0" onchange="remakeDateField(this.value,this.id.substr(this.id.search('-')+1));" id="datetype_option-0" name="datetype_option[]" />
                                        <label class="custom-control-label" for="datetype_option-0"><?=ucfirst(translateText('unique_date'));?></label>
                                    </div>
                                    <div class="dateInputFixedW" id="div-startDate-product-0">
                                        <label id="label-start_date_product_0" for="start_date_product[]"><?=translateText('start_date');?></label>
                                        <input
                                        required
                                        name ='start_date_product[]'
                                        id  ='start_date_product_0' 
                                        placeholder='12/12/2020'
                                        title = 'start_date_product'
                                        value=''
                                        class="form-control" 
                                        type="date" 
                                        maxlength="8"
                                        autocomplete="start-date-product"
                                        onfocus="if(<?=strtolower($moduleName)?>.start_date.value!=''){if((this.value=='null') || (this.value=='')){if(d_start[this.id.split('_')[3]]<=0){if(confirm('<?=translateText('start_date');?> es la mista <?=translateText('start_date');?> de la campaña?')){this.value=<?=strtolower($moduleName)?>.start_date.value; }else{d_start[this.id.split('_')[3]]++; this.focus();}}}}else{alert('<?=translateText('fill');?> <?=translateText('start_date');?> <?=translateText('first');?>'); <?=strtolower($moduleName)?>.start_date.focus();}"
                                        />
                                    </div>
                                    <div class="dateInputFixedW" id="div-stopDate-product-0">
                                        <label for="stop_date_product[]"><?=translateText('stop_date');?></label>
                                        <input
                                        required
                                        name ='stop_date_product[]'
                                        id  ='stop_date_product_0' 
                                        placeholder='12/12/2020'
                                        title = 'stop_date_product'
                                        value=''
                                        class="form-control" 
                                        type="date" 
                                        maxlength="8"
                                        autocomplete="stop-date-product"
                                        onfocus="if(<?=strtolower($moduleName)?>.stop_date.value!=''){if((this.value=='null') || (this.value=='')){if(d_stop[this.id.split('_')[3]]<=0){if(confirm('<?=translateText('stop_date');?> es la mista <?=translateText('stop_date');?> de la campaña?')){this.value=<?=strtolower($moduleName)?>.stop_date.value;}else{d_stop[this.id.split('_')[3]]++; this.focus();}}}}else{alert('<?=translateText('fill');?> <?=translateText('stop_date');?> <?=translateText('first');?>'); <?=strtolower($moduleName)?>.stop_date.focus();}"
                                        />
                                    </div>

                                </div>                                
                                <div class="form-row" >
                                    <div class="col" id='div-cost_0'>
                                        <label for="cost[]"><?=ucfirst(translateText('cost'));?> (<?=ucfirst(translateText('unit'))?>)</label><br/>
                                        <input
                                        required
                                        onkeypress="$(this).mask('#'+thousands+'###'+thousands+'##0'+cents+'00', {reverse: true});"
                                        onblur="calcAmountTotal(<?=strtolower($moduleName)?>,this.id.substr(this.id.search('_')+1))"
                                        id='cost_0'
                                        name ='cost[]' 
                                        placeholder="999,99"
                                        title = '<?=translateText('cost');?>'
                                        value=''
                                        class="form-control" 
                                        type="currency" 
                                        maxlength="20"
                                        autocomplete="cost"
                                        />
                                    </div>
                                    <div class="col" id='div-price_0'>
                                        <label for="price[]"><?=translateText('unit_price');?></label><br/>
                                        <input
                                        required
                                        onkeypress="$(this).mask('#'+thousands+'###'+thousands+'##0'+cents+'00', {reverse: true});"
                                        onblur="calcAmountTotal(<?=strtolower($moduleName)?>,this.id.substr(this.id.search('_')+1))"
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
                                        <div class="invalid-feedback">
                                            Please type a valid phone number.
                                        </div>
                                    </div>
                                    <div class="col" id='div-quantity_0'>
                                        <label for="quantity[]"><?=translateText('quantity');?></label>
                                        <input
                                        required
                                        onblur="calcAmountTotal(<?=strtolower($moduleName)?>,this.id.substr(this.id.search('_')+1))"
                                        id='quantity_0'
                                        name ='quantity[]' 
                                        placeholder='<?=translateText('quantity');?>'
                                        title = '<?=translateText('quantity');?>'
                                        value='1'
                                        class="form-control" 
                                        type="number"
                                        autocomplete="quantity"
                                        />
                                        <div class="invalid-feedback">
                                            Please type the quantity of this product.
                                        </div>
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
                                    <div class="col" id="div-provider_0">
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
                <input type="hidden" name="citySel" id="citySel" />
                <input type="hidden" name="countySel" id="countySel" />
                <input type="hidden" name="colonySel" id="colonySel" />
                <input type="hidden" name="proposalID" id="proposalID" />
                <input type="hidden" name="referrer" id="referrer" value="<?=$_REQUEST['pr']?>" />
                <button class="button" name="btnSave" type="button" onClick="handleSubmitProvider(<?=strtolower($moduleName)?>)" ><?=ucfirst(translateText('save'));?></button>
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

