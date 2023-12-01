<?php
$moduleName = 'Salemodel';
?>
<link rel="stylesheet" href="<?=$dir?>./assets/css/<?=$moduleName?>.css">
<link rel="stylesheet" href="<?=$dir?>./assets/css/Inputs.css">
<link rel="stylesheet" href="<?=$dir?>./assets/css/RecoveryLink.css">
<link rel="stylesheet" href="<?=$dir?>./assets/css/Button.css">
<script src="<?=$dir?>./assets/js/<?=strtolower($moduleName)?>.js" type="text/javascript"></script>

<div class='form-<?=strtolower($moduleName)?>-container'>
    <div class="form-container">
        <div class="form-header"><?=translateText('new')?> <?=translateText('sale_model')?></div>
        <form name='<?=strtolower($moduleName)?>' method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
            <div class="inputs-form-container">
                <div class="form-row">
                    <div class="col">
                        <label for="name"><?=ucfirst(translateText('name'))?> (*)</label>
                        <input
                        required
                        name ='name' 
                        placeholder='<?=ucfirst(translateText('name_of_m'))?> <?=translateText('product')?>'
                        title = '<?=ucfirst(translateText('name_of_m'))?> <?=translateText('product')?>'
                        value=''
                        class="form-control" 
                        type="text" 
                        maxlength="40"
                        autocomplete="salemodel_name"
                        />
                    </div>
                </div>
                <div class="form-row">
                    <div class="col">
                        <label for="description"><?=translateText('description')?></label>
                        <textarea
                        required
                        name ='description' 
                        placeholder='<?=translateText('description')?>'
                        title = '<?=translateText('description')?>'
                        value=''
                        class="form-control"  
                        autocomplete="description"
                        ></textarea>
                    </div>
                </div>

                <div class="form-row relation-section">
                    <div class="col">
                        <div class="form-row" >
                            <div class="col product-header">
                                &nbsp;<!--<?=translateText('relation')?>-->
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col custom-control custom-switch" style="text-align:right;">
                                <input type="checkbox" class="custom-control-input" value="0" onchange="refilterProductsType(this.value);" id="digital_product" name="digital_product" />
                                <label class="custom-control-label" for="digital_product"><?=translateText('digital_product');?></label>
                            </div>
                        </div>
                        <div class="form-row" >
                            <div class="col">
                                <label for="product_id"><?=translateText('product')?></label>
                                <spam id="sproduct">
                                    <select name="product_id[]" id="selectproduct" size="7" title="product_id" class="custom-select" autocomplete="product_id" multiple>
                                        <?=inputSelectNoZeroSelect('product',translateText('product'),'is_digital|||N','name','');?>
                                    </select>
                                </spam>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="inputs-button-container">
                <button class="button" name="btnSave" type="button" onClick="handleSubmit(<?=strtolower($moduleName)?>)" ><?=translateText('save')?></button>
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


