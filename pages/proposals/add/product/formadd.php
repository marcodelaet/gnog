<?php
$moduleName = 'Proposal';

$mexico_id = '57b71c86-b204-11ed-997f-008cfa5abdac';
if('1' == '2'){
    $mexico_id = '4d2af032-b204-11ed-a96a-246fbf72fd9f';
}

$ppid = '';
if(array_key_exists('ppid',$_REQUEST)){
    $ppid = $_REQUEST['ppid'];
}
?>
<link rel="stylesheet" href="<?=$dir?>./assets/css/<?=$moduleName?>.css">
<link rel="stylesheet" href="<?=$dir?>./assets/css/Inputs.css">
<link rel="stylesheet" href="<?=$dir?>./assets/css/RecoveryLink.css">
<link rel="stylesheet" href="<?=$dir?>./assets/css/Button.css">
<style>
  /* Style the input field */
  .billboardId {
    padding: 20px;
    margin-top: -6px;
    border: 0;
    border-radius: 0;
    background: #f1f1f1;
  }
  </style>
<script src="<?=$dir?>./assets/js/<?=strtolower($moduleName)?>.js" type="text/javascript"></script>

<div class='form-<?=strtolower($moduleName)?>-container'>
    <div class="form-container">
        <div class="form-header">
            <?=translateText('add');?> <?=translateText('product');?> -> <?=translateText(strtolower($moduleName))?>
            <div class="row">&nbsp;</div>
            <spam id="offer-name">Offer </spam>
            <spam id="advertiser-name">Cliente / Agencia</spam>
        </div>
        <form name='<?=strtolower($moduleName)?>' method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
            <div class="inputs-form-container">
                <div class="row">&nbsp;</div>
                <div class="form-row">
                    <div class="col-8">
                        <spam id="offer-name"></spam>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col">
                        <?=translateText('start_date');?>:
                        <spam class="inputs-input" id="start-date"></spam>
                    </div>
                    <div class="col">
                        <?=translateText('stop_date');?>:
                        <spam class="inputs-input" id="stop-date"></spam>
                    </div>
                    <div class="col-2">
                        <?=translateText('currency');?>:
                        <spam class="inputs-input" id="info-currency"></spam>
                    </div>
                </div>
                <div class="form-row main-contact-section">
                    <div class="col">
                        <div class="form-row"  style="margin-top:2rem;">
                            <div class="col main-contact-header" style="font-weight: bolder; text-decoration:underline overline; font-size:1.2rem;">
                                <?=translateText('products');?>
                            </div>
                        </div>
                        <div>
                            <div class="form-row">
                                <div class="col custom-control custom-switch" style="text-align:right;">
                                    <input type="checkbox" class="custom-control-input" value="0" onchange="refilterProductsType(this.value);" id="digital_product" name="digital_product">
                                    <label class="custom-control-label" for="digital_product"><?=translateText('digital_product');?></label>
                                </div>
                            </div>
                        </div>
                        <div id="product-section">
                            <div id="product_0">
                                <div class="form-row">
                                    <div class="col">
                                        &nbsp;
                                    </div>
                                    <input class="stateId" name="state_id[]" id="stateId_0" type="hidden" value="All">
                                    <input class="cityId" name="city_id[]" id="cityId_0" type="hidden" value="All">
                                    <input class="countyId" name="county_id[]" id="countyId_0" type="hidden" value="All">
                                    <input class="colonyId" name="colony_id[]" id="colonyId_0" type="hidden" value="All">
                                    <div class="col-2" id="div-selectState_0">
                                        <?=inputDropDownSearchStyle('state','state','is_active|||Y','state','tete')?>
                                    </div>
                                    <!-- 
                                        onchange="if(agency_id.value == '0') { listAdvertiserContacts(this.value) }"
                                    -->
                                    <div class="col-2" id="div-selectcity_0"></div>
                                    <div class="col-2" id="div-selectcounty_0"></div>
                                    <div class="col-2" id="div-selectcolony_0"></div>
                                </div>
                                <br/>
                                <div class="form-row">
                                    <div class="col" id="div-selectProduct">
                                        <label for="product_id[]"><?=translateText('product');?></label>
                                        <spam id="sproduct">
                                            <select name="product_id[]" title="product_id" class="form-control" autocomplete="product_id" required>
                                                <?=inputSelect('product','Product','is_digital="N"','name','')?>
                                            </select>
                                        </spam>
                                    </div>
                                    <div class="col" id="div-selectSaleModel">
                                        <label for="salemodel_id[]"><?=translateText('sale_model');?></label>
                                        <spam id="ssalemodel">
                                            <select name="salemodel_id[]" title="salemodel_id" class="form-control" autocomplete="salemodel_id" >
                                                <?=inputSelect('salemodel','Sale model','is_digital="N"','name','')?>
                                            </select>
                                        </spam>
                                    </div>
                                </div>
                                <div class="form-row" >
                                    <div class="col">
                                        <label for="price[]"><?=translateText('unit_price');?></label><br/>
                                        <input
                                        required
                                        onkeypress="$(this).mask('#.###.##0,00', {reverse: true});"
                                        onblur="calcAmountTotal(<?=strtolower($moduleName)?>,0)"
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
                                        onblur="calcAmountTotal(<?=strtolower($moduleName)?>,0)"
                                        name ='quantity[]' 
                                        placeholder='<?=translateText('quantity');?>'
                                        title = '<?=translateText('quantity');?>'
                                        value=''
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
                                <button class="btn-primary material-icons-outlined" type="button" onclick="newProductForm('product-section','product-new',100);">add_circle_outline</button>
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
                <input type="hidden" name="ppid" id="ppid" value="<?=$ppid?>"/>
                <input type="hidden" name="currency" id="currency" />
                <button class="button" name="btnSave" type="button" onClick="handleSubmitAddProduct(<?=strtolower($moduleName)?>,'<?=$ppid?>')" ><?=translateText('save');?></button>
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

<script>
$(document).ready(function(){
  $("#stateName_0").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $(".dropdown-menu li").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});

$(document).ready(function(){
  $("#stateName_1").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $(".dropdown-menu li").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});

$(document).ready(function(){
  $("#stateName_2").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $(".dropdown-menu li").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});

$(document).ready(function(){
  $("#stateName_3").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $(".dropdown-menu li").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});

$(document).ready(function(){
  $("#stateName_4").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $(".dropdown-menu li").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});

$(document).ready(function(){
  $("#stateName_5").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $(".dropdown-menu li").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});

$(document).ready(function(){
  $("#stateName_6").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $(".dropdown-menu li").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});

$(document).ready(function(){
  $("#stateName_7").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $(".dropdown-menu li").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});

$(document).ready(function(){
  $("#stateName_8").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $(".dropdown-menu li").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});

$(document).ready(function(){
  $("#stateName_9").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $(".dropdown-menu li").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});


    handleListAddProductOnLoad("<?=$ppid?>","<?=strtolower($moduleName)?>")
</script>