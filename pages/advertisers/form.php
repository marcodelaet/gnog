<?php
$moduleName = 'Advertiser';
$advertiser = null;
$password = null;
$email    = null;
$mobile   = null;

if(array_key_exists('username',$_POST))
{
  $username = $_POST['username'];
  $email    = $_POST['email'];
  $mobile   = $_POST['mobile'];
}



?>
<link rel="stylesheet" href="<?=$dir?>./assets/css/<?=$moduleName?>.css">
<link rel="stylesheet" href="<?=$dir?>./assets/css/Inputs.css">
<link rel="stylesheet" href="<?=$dir?>./assets/css/RecoveryLink.css">
<link rel="stylesheet" href="<?=$dir?>./assets/css/Button.css">
<script src="<?=$dir?>./assets/js/<?=strtolower($moduleName)?>.js" type="text/javascript"></script>

<div class='form-<?=strtolower($moduleName)?>-container'>
    <div class="form-container">
        <div class="form-header"><?=Ucfirst(translateText('new'));?> <?=Ucfirst(translateText(strtolower($moduleName)));?></div>
        <form name='<?=strtolower($moduleName)?>' method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
            <div class="inputs-form-container">
                <div class="form-row">
                    <div class="col custom-control custom-switch" style="text-align:right;">
                        <input type="checkbox" class="custom-control-input" id="customSwitch1" name="agency">
                        <label class="custom-control-label" for="customSwitch1"><?=Ucfirst(translateText('is_agency'));?></label>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col">
                        <label for="corporate_name"><?=Ucfirst(translateText('corporate_name'));?></label>
                        <input
                        required
                        name ='corporate_name' 
                        placeholder='<?=Ucfirst(translateText('corporate_name'));?>'
                        title = '<?=Ucfirst(translateText('corporate_name'));?>'
                        value='<?=$advertiser?>'
                        class="form-control" 
                        type="text" 
                        maxlength="40"
                        autocomplete="corporate_name"
                        />
                    </div>
                    <div class="col-2" id="sclient">
                        <label for="executive"><?=translateText('executive');?></label>
                        <select name="executive_id" id="selectexecutive" title="executive_id" class="form-control" autocomplete="executive_id" required>
                            <?=inputSelect('user',translateText('executive'),'user_type|||executive*|*user_type|||admin','username','')?>
                        </select>
                    </div>

                    <div class="col custom-control custom-switch" style="text-align:right; vertical-align:middle;">
                        <br/>
                        <input type="checkbox" class="custom-control-input" id="making-banners" name="making_banners">
                        <label class="custom-control-label" for="making-banners"><?=Ucfirst(translateText('making_banners'));?></label>
                    </div>
                </div>
                <div class="form-row">
                </div>    
                <div class="form-row">
                    <div class="col">
                        <label for="address"><?=Ucfirst(translateText('address'));?></label>
                        <textarea
                        required
                        name ='address' 
                        placeholder='99, <?=Ucfirst(translateText('address'));?> - City - Country - Postal Code'
                        title = '<?=Ucfirst(translateText('address'));?>'
                        value=''
                        class="form-control"  
                        autocomplete="address"
                        ></textarea>
                        <div class="invalid-feedback">
                            Please type the Address of the <?=$moduleName?>
                        </div>
                    </div>
                </div>
                
            </div>
            <div class="inputs-button-container">
                <button class="button" name="btnSave" type="button" onClick="handleSubmit(<?=strtolower($moduleName)?>)" ><?=Ucfirst(translateText('continue'));?></button>
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


