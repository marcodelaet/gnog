<?php
// ini_set('error_reporting', E_ALL);
// ini_set('display_errors', true);


$moduleName = 'Proposal';

$mexico_id = '57b71c86-b204-11ed-997f-008cfa5abdac';
if('1' == '2'){
    $mexico_id = '4d2af032-b204-11ed-a96a-246fbf72fd9f';
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
<script type="text/javascript">
    var d_start = [];
    var d_stop  = [];
    d_start[0]  = 0;
    d_stop[0]   = 0;
</script>

<div class='form-<?=strtolower($moduleName)?>-container'>
    <div class="form-container">
        <div class="form-header"><?=translateText('new');?> <?=translateText(strtolower($moduleName))?></div>
        <form name='<?=strtolower($moduleName)?>' method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
            <div class="inputs-form-container">
                <div class="form-row">
                    <div class="col custom-control custom-switch" style="text-align:right;">
                        <input type="checkbox" class="custom-control-input" id="pixel" name="pixel">
                        <label class="custom-control-label" for="pixel"><?=translateText('pixel_required');?></label>
                    </div>
                </div>
                <div class="form-row" >
                    <div class="col">
                        <label for="client_id"><?=translateText('client');?></label>
                        <spam id="sclient">
                            <select name="client_id" id="selectclient" title="client_id" class="form-control" autocomplete="client_id" onchange="if(agency_id.value == '0') { listAdvertiserContacts(this.value) }" required>
                                <?=inputSelect('advertiser',translateText('client'),'is_agency-N','name','')?>
                            </select>
                        </spam>
                    </div>
                    <div class="col">
                        <label for="agency_id"><?=translateText('agency');?></label>
                        <spam id="sagency">
                            <select name="agency_id" id="selectagency" title="agency_id" class="form-control" autocomplete="agency_id" onchange="listAdvertiserContacts(this.value)">
                                <?=inputSelect('advertiser',translateText('agency'),'is_agency-Y','name','')?>
                            </select>
                        </spam>
                    </div>
                    <div class="col custom-control custom-switch" style="text-align:right; vertical-align:middle;">
                    <br/>
                        <input type="checkbox" class="custom-control-input" id="taxable" name="taxable">
                        <label class="custom-control-label" for="taxable"><?=translateText('is_taxable');?></label>
                    </div>
                    <div class="col-2">
                        <br/>
                        <div class="input-group-prepend">
                            <input
                                name ='tax_percent' 
                                placeholder='30'
                                title = 'tax %'
                                value=''
                                class="form-control" 
                                type="text" 
                                size="3"
                                maxlength="3"
                                autocomplete="tax"
                            />
                            <span class="input-group-text">%</span>
                        </div>
                    </div>
                </div>
                <div id="div-selectContact"></div>
                <div class="row">&nbsp;</div>
                <div class="form-row">
                    <div class="col-8">
                        <label for="name"><?=translateText('offer_name');?></label>
                        <input
                        required
                        name ='name' 
                        placeholder='<?=translateText('offer_name');?>'
                        title = 'name'
                        value=''
                        class="form-control" 
                        type="text" 
                        maxlength="40"
                        autocomplete="provider_name"
                        />
                    </div>
                    <div class="col-2" >&nbsp;</div>
                    <div class="col-2" >
                        <label for="officeDropdownMenuButton"><?=translateText('gnog_office');?></label>
                            <?=inputDropDownStyle('office','','orderby','Mexico',$mexico_id)?>
                    </div>
                </div>
                <div class="row">&nbsp;</div>
                <div class="form-row">
                    <div class="col">
                        <label for="description"><?=translateText('description');?></label>
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
                </div>
                <div class="form-row">
                    <div class="dateInputFixedW">
                        <label for="start_date"><?=translateText('start_date');?></label>
                        <input
                        required
                        name ='start_date' 
                        id ='start_date' 
                        placeholder='12/12/2020'
                        title = 'start_date'
                        value=''
                        class="form-control" 
                        type="date" 
                        maxlength="8"
                        autocomplete="start-date"
                        />
                        <div class="invalid-feedback">
                            Please type the Offer name
                        </div>
                    </div>
                    <div class="dateInputFixedW">
                        <label for="stop_date"><?=translateText('stop_date');?></label>
                        <input
                        required
                        name ='stop_date' 
                        id ='stop_date' 
                        placeholder='12/12/2020'
                        title = 'stop_date'
                        value=''
                        class="form-control" 
                        type="date" 
                        maxlength="8"
                        autocomplete="stop-date"
                        />
                        <div class="invalid-feedback">
                            Please type the Offer name
                        </div>
                    </div>
                    <div class="col" id="sclient">
                        <label for="executive"><?=translateText('executive');?></label>
                        <select name="executive_id" id="selectexecutive" title="executive_id" class="form-control" autocomplete="executive_id" required>
                            <?=inputSelect('user',translateText('executive'),'user_type|||executive*|*user_type|||admin','username','')?>
                        </select>
                    </div>
                </div>
                <div class="form-row main-contact-section">
                    <div class="col">
                        <div class="form-row"  style="margin-top:2rem;">
                            <div class="col main-contact-header" style="font-weight: bolder; text-decoration:underline overline; font-size:1.2rem;">
                                <?=translateText('products');?>
                            </div>
                            <div class="col-2">
                                <label for="currency"><?=translateText('currency');?></label>
                                <select
                                required
                                name ='currency' 
                                title = '<?=translateText('currency');?>'
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
                                    <div class="col custom-control custom-switch" style="text-align:right;">
                                        <input type="checkbox" class="custom-control-input" value="0" onchange="refilterProductsType(this.value,this.id.substr(this.id.search('-')+1));" id="digital_product-0" name="digital_product[]" />
                                        <label class="custom-control-label" for="digital_product-0"><?=translateText('digital_product');?></label>
                                    </div>
                                </div>
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
                                    <div class="col-4">
                                    </div>
                                    <div class="col-2" id="div-selectproduct_0">
                                        <label for="product_id[]"><?=translateText('product');?></label>
                                        <spam id="sproduct">
                                            <!--<select name="product_id[]" id="selectproduct_0" title="product_id" class="form-control" autocomplete="product_id" onchange="refilterSaleModel(document.getElementById('digital_product-'+this.id.split('_')[1]).value,this.value,this.id.split('_')[1]); checkOOHSelection(this[this.selectedIndex].innerText,this.id.split('_')[1])" required>-->
                                            <select name="product_id[]" id="selectproduct_0" title="product_id" class="form-control" autocomplete="product_id" required>
                                                <?=inputSelect('product',translateText('product'),'is_digital|||N','name','')?>
                                            </select>
                                        </spam>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col">
                                        <!--<label for="notes[]"><?=translateText('notes');?></label>-->
                                        <label for="notes[]">Observaci&oacute;n</label>
                                        <div class="input-group mb-3">
                                            <textarea
                                            required
                                            name ='notes[]' 
                                            placeholder='Notes about the product'
                                            title = 'notes'
                                            class="form-control" 
                                            autocomplete="notes"
                                            ></textarea>
                                        </div>
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
                    <div class="col-10">
                    </div>
                    <div class="col-2">
                        <label for="status_id"><?=translateText('status');?></label>
                        <spam id="sstatus">
                            <select name="status_id" id="selectstatus" title="status_id" class="form-control">
                                <?=inputSelect('status',translateText('status'),'','percent','')?>
                            </select>
                        </spam>
                    </div>
                </div>
            </div>
            <div class="inputs-button-container">
                <button class="button" name="btnSave" type="button" onClick="handleSubmit(<?=strtolower($moduleName)?>)" ><?=ucfirst(translateText('continue'));?></button>
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

// resetando primeiro produto como OFFLINE
refilterProductsType(1,0);

</script>