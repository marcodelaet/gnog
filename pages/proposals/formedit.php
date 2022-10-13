<?php
$moduleName = 'Proposal';
$tid        = $_REQUEST['tid'];
?>
<link rel="stylesheet" href="<?=$dir?>./assets/css/<?=$moduleName?>.css">
<link rel="stylesheet" href="<?=$dir?>./assets/css/Inputs.css">
<link rel="stylesheet" href="<?=$dir?>./assets/css/RecoveryLink.css">
<link rel="stylesheet" href="<?=$dir?>./assets/css/Button.css">
<script src="<?=$dir?>./assets/js/<?=strtolower($moduleName)?>.js" type="text/javascript"></script>


<div class='form-<?=strtolower($moduleName)?>-container'>
    <div class="form-container">
        <div class="form-header">Edit <?=$moduleName?></div>
        <form name='<?=strtolower($moduleName)?>' method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
            <div class="inputs-form-container">
            <div class="form-row">
                    <div class="col custom-control custom-switch" style="text-align:right;">
                        <input type="checkbox" class="custom-control-input" id="customSwitch1" name="pixel">
                        <label class="custom-control-label" for="customSwitch1">Pixel required</label>
                    </div>
                </div>
                <div class="form-row" >
                    <div class="col">
                        <label for="client_id">Client</label>
                        <spam id="sclient">
                            <select name="client_id" id="selectclient" title="client_id" class="form-control" autocomplete="client_id" required>
                                <?=inputSelect('advertiser','Client','is_agency-N','name','')?>
                            </select>
                        </spam>
                        <div class="invalid-feedback">
                            Please choose a Client.
                        </div>
                    </div>
                    <div class="col">
                        <label for="agency_id">Agency</label>
                        <spam id="sagency">
                            <select name="agency_id" id="selectagency" title="agency_id" class="form-control" autocomplete="agency_id">
                                <?=inputSelect('advertiser','Agency','is_agency-Y','name','')?>
                            </select>
                        </spam>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col">
                        <label for="name">Offer Name</label>
                        <input
                        required
                        name ='name' 
                        placeholder='Offer Name'
                        title = 'name'
                        value=''
                        class="form-control" 
                        type="text" 
                        maxlength="40"
                        autocomplete="provider_name"
                        />
                        <div class="invalid-feedback">
                            Please type the Offer name
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <label for="name">Description</label>
                    <div class="input-group mb-3">
                        <textarea
                        required
                        name ='description' 
                        placeholder='About the offer'
                        title = 'description'
                        class="form-control" 
                        autocomplete="description"
                        ></textarea>
                        <div class="invalid-feedback">
                            Please type a description about the offer
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col">
                        <label for="start_date">Start date</label>
                        <input
                        required
                        name ='start_date' 
                        placeholder='12/12/2020'
                        title = 'start_date'
                        value=''
                        class="form-control" 
                        type="date" 
                        maxlength="8"
                        autocomplete="date"
                        />
                        <div class="invalid-feedback">
                            Please type the Offer name
                        </div>
                    </div>
                    <div class="col">
                        <label for="stop_date">Stop date</label>
                        <input
                        required
                        name ='stop_date' 
                        placeholder='12/12/2020'
                        title = 'stop_date'
                        value=''
                        class="form-control" 
                        type="date" 
                        maxlength="8"
                        autocomplete="date"
                        />
                        <div class="invalid-feedback">
                            Please type the Offer name
                        </div>
                    </div>
                </div>
                <div class="form-row main-contact-section">
                    <div class="col">
                        <div class="form-row" >
                            <div class="col main-contact-header">
                                Products
                            </div>
                            <div class="col-2">
                                <label for="currency">Currency</label>
                                <select
                                required
                                name ='currency' 
                                title = 'Currency'
                                class="form-control"
                                autocomplete="currency">
                                    <option value="MXN">MXN</option>
                                    <option value="USD">USD</option>
                                    <option value="BRL">BRL</option>
                                </select>
                            </div>
                        </div>
                        <div id="product-section">
                            <div id="product_0">
                                <div class="form-row">
                                    <div class="col">
                                        <label for="product_id[]">Product</label>
                                        <spam id="sproduct">
                                            <select name="product_id[]" title="product_id" class="form-control" autocomplete="product_id" required>
                                                <?=inputSelect('product','Product','','name','')?>
                                            </select>
                                        </spam>
                                        <div class="invalid-feedback">
                                            Please choose a Product option.
                                        </div>
                                    </div>
                                    <div class="col">
                                        <label for="salemodel_id[]">Sale model</label>
                                        <spam id="ssalemodel">
                                            <select name="salemodel_id[]" title="salemodel_id" class="form-control" autocomplete="salemodel_id">
                                                <?=inputSelect('salemodel','Sale model','','name','')?>
                                            </select>
                                        </spam>
                                        <div class="invalid-feedback">
                                            Please choose a Sale model option.
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row" >
                                    <div class="col">
                                        <label for="price[]">Unit Price</label><br/>
                                        <input
                                        required
                                        onkeypress="$(this).mask('#.###.##0,00', {reverse: true});"
                                        onblur="calcAmountTotal(<?=strtolower($moduleName)?>,0)"
                                        id='price_0'
                                        name ='price[]' 
                                        placeholder="999,99"
                                        title = 'Unit price'
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
                                    <div class="col">
                                        <label for="quantity[]">Quantity</label>
                                        <input
                                        required
                                        onblur="calcAmountTotal(<?=strtolower($moduleName)?>,0)"
                                        name ='quantity[]' 
                                        placeholder='Quantity'
                                        title = 'Quantity'
                                        value=''
                                        class="form-control" 
                                        type="number"
                                        autocomplete="quantity"
                                        />
                                        <div class="invalid-feedback">
                                            Please type the position / role of the main contact.
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row" >
                                    <div class="col">
                                        <label for="amount[]">Amount</label><br/>
                                        <input
                                        id='amount_0'
                                        name ='amount[]'
                                        readonly 
                                        placeholder="0,00"
                                        title = 'Amount'
                                        value='0,00'
                                        class="form-control"
                                        />
                                    </div>
                                    <div class="col">
                                        <label for="provider_id[]">Provider</label>
                                        <spam id="sprovider">
                                            <select name="provider_id[]" title="provider_id" class="form-control">
                                                <?=inputSelect('provider','Provider','','name','')?>
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
                                <button class="btn-primary material-icons-outlined" type="button" onclick="newProductForm('product-section','product-new');">add_circle_outline</button>
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
                        <label for="total">Total</label><br/>
                        <input
                        id='total'
                        name ='total'
                        readonly 
                        placeholder="0,00"
                        title = 'Total'
                        value='0,00'
                        class="form-control"
                        />
                    </div>
                    <div class="col">
                        <label for="status_id">Status</label>
                        <spam id="sstatus">
                            <select name="status_id" id="selectstatus" title="status_id" class="form-control">
                                <?=inputSelect('status','Status','','percent','')?>
                            </select>
                        </spam>
                    </div>
                </div>
            </div>
            <div class="inputs-button-container">
                <button class="button" name="btnSave" type="button" onClick="handleSubmit(<?=strtolower($moduleName)?>)" >Save</button>
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


<?php if(array_key_exists('tid',$_REQUEST)){ ?>
<script>
    handleOnLoad("<?=$tid?>",<?=strtolower($moduleName)?>)
</script>
<?php } ?>