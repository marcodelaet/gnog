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

$pppid = '';
if(array_key_exists('pppid',$_REQUEST)){
    $pppid = $_REQUEST['pppid'];
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
        <div class="form-header">
            <?=ucfirst(translateText('edit'));?> <?=translateText('product');?> -> <?=translateText(strtolower($moduleName))?>
            <div class="row">&nbsp;</div>
            <spam id="offer-name"> </spam>
            <spam id="advertiser-name"></spam>
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
                        <input type="hidden" id="start-date-input" name="start_date"/>
                        <spam class="inputs-input" id="start-date"></spam>
                    </div>
                    <div class="col">
                        <?=translateText('stop_date');?>:
                        <input type="hidden" id="stop-date-input" name="stop_date"/>
                        <spam class="inputs-input" id="stop-date"></spam>
                    </div>
                    <div class="col-2">
                        <?=translateText('currency');?>:
                        <input type="hidden" id="currency-input" name="currency"/>
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
                                    <div class="col-2" id="div-selectState">
                                        <?=inputDropDownSearchStyle('state','state','is_active|||Y','state','tete')?>
                                    </div>
                                    <!-- 
                                        onchange="if(agency_id.value == '0') { listAdvertiserContacts(this.value) }"
                                    -->
                                    <div class="col-2" id="div-selectcity"></div>
                                    <div class="col-2" id="div-selectcounty"></div>
                                    <div class="col-2" id="div-selectcolony"></div>
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
                                </div>
                                <div class="form-row">
                                  <div class="col-2" id="div-note"></div>
                                </div>
                                <div class="form-row">
                                    <div class="col-2" id="div-selectproduct_0">
                                        <label for="product_id[]"><?=translateText('product');?></label>
                                        <spam id="sproduct">
                                            <select name="product_id[]" id="selectproduct" title="product_id" class="form-control" autocomplete="product_id" onchange="refilterSaleModel(document.getElementById('digital_product-'+this.id.split('_')[1]).value,this.value,this.id.split('_')[1]); checkOOHSelection(this[this.selectedIndex].innerText,this.id.split('_')[1])" required>
                                                <?=inputSelect('product',translateText('product'),'','name','')?>
                                            </select>
                                        </spam>
                                    </div>
                                    <div class="col" id="div-selectsalemodel_0" >
                                        <label for="salemodel_id[]"><?=translateText('sale_model');?></label>
                                        <spam id="ssalemodel">
                                            <select name="salemodel_id[]" id="selectsalemodel_0" title="salemodel_id" class="form-control" autocomplete="salemodel_id" >
                                                <?=inputSelect('salemodel',translateText('sale_model'),'is_digital|||N','name','')?>
                                            </select>
                                        </spam>
                                    </div>
                                    <div class="col" id="div-oohkeys_0" style="display: none">
                                    </div>
                                </div>
                                <div class="form-row" >
                                    <div class="col" id='div-cost_0'>
                                        <label for="cost"><?=ucfirst(translateText('cost'));?> (<?=ucfirst(translateText('unit'))?>)</label><br/>
                                        <input
                                        required
                                        onkeypress="$(this).mask('#'+thousands+'###'+thousands+'##0'+cents+'00', {reverse: true});"
                                        onblur="calcAmountTotal(<?=strtolower($moduleName)?>)"
                                        id='cost'
                                        name ='cost' 
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
                                        <label for="price"><?=translateText('unit_price');?></label><br/>
                                        <input
                                        required
                                        onkeypress="$(this).mask('#'+thousands+'###'+thousands+'##0'+cents+'00', {reverse: true});"
                                        onblur="calcAmountTotal(<?=strtolower($moduleName)?>)"
                                        id='price'
                                        name ='price' 
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
                                        <label for="quantity"><?=translateText('quantity');?></label>
                                        <input
                                        required
                                        onblur="calcAmountTotal(<?=strtolower($moduleName)?>)"
                                        id='quantity'
                                        name ='quantity' 
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
                                        <label for="amount"><?=translateText('amount');?></label><br/>
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
                                        <label for="provider_id"><?=translateText('provider');?></label>
                                        <spam id="sprovider">
                                            <select name="provider_id" id="selectprovider" title="provider_id" class="form-control">
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
                <input type="hidden" name="pppid" id="pppid" value="<?=$pppid?>"/>
                <input type="hidden" name="currency" id="currency" />
                <button class="button" name="btnSave" type="button" onClick="handleSubmitEditProduct(<?=strtolower($moduleName)?>)" ><?=ucfirst(translateText('save'));?></button>
            </div>
        </form>
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
        <div id="div-specialbuttons">
          
        </div>
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

<div class="modal fade" id="sendmailModal" tabindex="-1" aria-labelledby="sendmailModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="sendmailModalLabel"> <?=translateText('send_user_crt_url_to')?>: 
            <p>
                <b>
                    <spam id="provider_contact_name"></spam> - (
                    <spam id="provider_contact_email"></spam>)
                </b>
            </p> 
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form name="frmSendMail">
          <div class="form-group">
            <div class="form-row">
                <div class="col">
                    <label for="language" class="col-form-label"><?=translateText('language')?>:</label>
                    <SELECT name="option" id="language-option" onchange="changeMessageLanguage(this.value,document.getElementById('pname').value,document.getElementById('plink').value);">
                        <OPTION value="esp">Español</OPTION>
                        <OPTION value="ptbr">Português Brasileiro</OPTION>
                        <OPTION value="eng">English</OPTION>
                    </SELECT>
                </div>
            </div>
            <div class="form-row">
                <div class="col">
                    <label for="bodyText" class="col-form-label"><?=translateText('message')?>: <i>(min 10 chars)</i></label>
                    <div class="editor" id="bodyText" style="padding:2rem; border: 1px solid gray; border-radius:1.2rem;">
	                    <?=$invite_body_esp?>
	                </div>
                </div>
            </div>
          </div>
          <input type="hidden" name="pid" value="<?=$_REQUEST['pid']?>" />
          <input type="hidden" id="pemail" name="pemail" value="" />
          <input type="hidden" id="pname" name="pname" value="" />
          <input type="hidden" id="plink" name="plink" value="" />
          <input type="hidden" id="bodytext-html" name="bodytext" value="" />
          
          <input type="hidden" name="uid" value="<?=$_COOKIE['uuid']?>" />
          <input type="hidden" name="tku" value="<?=$_COOKIE['tk']?>" />
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?=translateText('close')?></button>
        <button type="button" id="sendbutton" class="btn btn-primary" onclick="this.disabled = true; document.getElementById(this.id).innerText='<?=translateText('sent')?>'; sendmailToProviderContact(frmSendMail);"><?=translateText('send_message')?></button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
    $('.editor').notebook({
    autoFocus: false,
    placeholder: 'Your text here...',
    mode: 'multiline', // // multiline or inline
    modifiers: ['bold', 'italic', 'underline', 'h1', 'h2', 'ol', 'ul', 'anchor']});
    });

    //changeMessageLanguage('esp',document.getElementById('pname').value,document.getElementById('plink').value);

  
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


    handleListAddProductOnLoad("<?=$ppid?>","<?=strtolower($moduleName)?>");
    handleListEditProductOnLoad("<?=$ppid?>","<?=$pppid?>");
    handleListProductFilesOnLoad("<?=$ppid?>","<?=$pppid?>");
</script>