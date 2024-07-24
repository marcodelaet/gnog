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
                        <?=translateText('product');?>
                      </div>
                    </div>
                    <div id="product-section">
                      <div id="product_0">
                        <div class="form-row">
                          <div class="col" id="div-productname"></div>
                        </div>
                        <div class="form-row">
                          <div class="col-2" id="div-note"></div>
                        </div>
                        <div class="form-row">&nbsp;</div>
                        <div class="form-container">
                          <div class="form-header"></div>
                            <div class="inputs-form-container">
                              <div class="input-group mb-3">
                                <div class="custom-file">
                                  <input type="file" class="custom-file-input" id="<?=strtolower($moduleName)?>-file" name="<?=strtolower($moduleName)?>_file" accept=".csv,.xls,.doc,.docx,.xlsx,.txt,.pdf" onchange="document.getElementById('<?=strtolower($moduleName)?>-file-label').innerHTML = this.value.split(/[|\/\\]+/)[2];" aria-describedby="<?=strtolower($moduleName)?>-file">
                                  <label class="custom-file-label" id="<?=strtolower($moduleName)?>-file-label" for="inputGroupFile01"><?=ucfirst(translateText('choose'));?> <?=(translateText('file'));?> <?=(translateText('to_upload'));?></label>
                                </div>
                              </div>
                            </div>
                            <div class="form-row">&nbsp;</div>
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
            </div>
            <div class="inputs-button-container">
              <input type="hidden" name="ppid" id="ppid" value="<?=$ppid?>"/>
              <input type="hidden" name="pppid" id="pppid" value="<?=$pppid?>"/>
              <input type="hidden" name="currency" id="currency" value=""/>
              <input type="hidden" name="ownerid" id="ownerid" value=""/>
              <button class="button" name="btnSave" type="button" onClick="handleSubmitFileProduct(<?=strtolower($moduleName)?>)" ><?=ucfirst(translateText('upload_file'));?></button>
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
    handleListAddProductOnLoad("<?=$ppid?>","<?=strtolower($moduleName)?>");
    handleListEditProductOnLoad("<?=$ppid?>","<?=$pppid?>");
    handleListProductFilesOnLoad("<?=$ppid?>","<?=$pppid?>");
</script>