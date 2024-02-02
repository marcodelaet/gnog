<?php

$moduleName = 'Goal';
$user_id       = 0;
if(array_key_exists('tid',$_GET))
    $user_id       = $_GET['tid'];

$level  = $_COOKIE['lacc'];

?>
<link rel="stylesheet" href="<?=$dir?>./assets/css/<?=$moduleName?>.css">
<link rel="stylesheet" href="<?=$dir?>./assets/css/Inputs.css">
<link rel="stylesheet" href="<?=$dir?>./assets/css/RecoveryLink.css">
<link rel="stylesheet" href="<?=$dir?>./assets/css/Button.css">
<script src="<?=$dir?>./assets/js/<?=strtolower($moduleName)?>.js" type="text/javascript"></script>

<div class='form-<?=strtolower($moduleName)?>-container'>
    <div class="form-container">
        <div class="form-header"><?=ucfirst(translateText('new'))?> <?=ucfirst(translateText(strtolower($moduleName)))?>s</div>
<?php
if($level >= '99999'){
?>
        <form name='<?=strtolower($moduleName)?>' method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
            <div class="inputs-form-container">
                <div class="form-row">
                    <div class="col-sm-8">
                    <label for="executive"><?=translateText('executive');?></label>
                        <select name="executive_id" id="selectexecutive" title="executive_id" class="form-control" autocomplete="executive_id" required>
                            <?=inputSelect('user',translateText('executive'),'user_type|||executive*|*user_type|||admin','username','')?>
                        </select>
                    </div>
                    <div class="col-sm-2">
                        <label for="start_year"><?=translateText('year')?></label>
                        <select class="custom-select" name="start_year" title="<?=translateText('year')?>" autocomplete="year">
                            <?php
                                echo showYearOptions($YEAR_TODAY,(int)$YEAR_TODAY+10,$YEAR_TODAY);
                            ?>
                        </select>
                    </div>
                    <div class="col-sm-2">
                        <label for="rate_id"><?=translateText('currency')?></label>
                        <select class="custom-select" name="rate_id" title="Rates" autocomplete="rate_id" >
                            <?=inputFilterNoZeroSelect('rate','Rates','','orderby','')?>
                        </select>
                    </div>
                </div>
                
                <div class="form-row" style="margin-top:1rem">
                    <div class="col-sm-3">
                        <label for="start_month"><?=translateText('month')?></label>
                        <select class="custom-select" name="start_month[]" title="<?=translateText('month')?>" autocomplete="month">
                            <option value="1"><?=translateText('january')?></option>
                            </select>
                            <select class="custom-select" name="start_month[]" title="<?=translateText('month')?>" autocomplete="month">
                            <option value="2"><?=translateText('february')?></option>
                            </select>
                            <select class="custom-select" name="start_month[]" title="<?=translateText('month')?>" autocomplete="month">
                            <option value="3"><?=translateText('march')?></option>
                            </select>
                            <select class="custom-select" name="start_month[]" title="<?=translateText('month')?>" autocomplete="month">
                            <option value="4"><?=translateText('april')?></option>
                            </select>
                            <select class="custom-select" name="start_month[]" title="<?=translateText('month')?>" autocomplete="month">
                            <option value="5"><?=translateText('may')?></option>
                            </select>
                            <select class="custom-select" name="start_month[]" title="<?=translateText('month')?>" autocomplete="month">
                            <option value="6"><?=translateText('june')?></option>
                            </select>
                    </div>
                    <div class="col">
                        <label for="amount_goal"><?=translateText('amount')?></label>
                        <input
                            required
                            onkeypress="$(this).mask('#.###.##0,00', {reverse: true});"
                            onchange="calcAmountGoalTotal(<?=strtolower($moduleName)?>)"
                            name ='amount_goal[]' 
                            placeholder="999,99"
                            title = '<?=translateText('goal')?> / <?=translateText('amount')?>'
                            value=''
                            class="form-control" 
                            type="currency" 
                            maxlength="20"
                            autocomplete="amount"
                        />
                        <input
                            required
                            onkeypress="$(this).mask('#.###.##0,00', {reverse: true});"
                            onchange="calcAmountGoalTotal(<?=strtolower($moduleName)?>)"
                            name ='amount_goal[]' 
                            placeholder="999,99"
                            title = '<?=translateText('goal')?> / <?=translateText('amount')?>'
                            value=''
                            class="form-control" 
                            type="currency" 
                            maxlength="20"
                            autocomplete="amount"
                        />
                        <input 
                            required
                            onkeypress="$(this).mask('#.###.##0,00', {reverse: true});"
                            onchange="calcAmountGoalTotal(<?=strtolower($moduleName)?>)"
                            name ='amount_goal[]' 
                            placeholder="999,99"
                            title = '<?=translateText('goal')?> / <?=translateText('amount')?>'
                            value=''
                            class="form-control" 
                            type="currency" 
                            maxlength="20"
                            autocomplete="amount"
                        />
                        <input
                            required
                            onkeypress="$(this).mask('#.###.##0,00', {reverse: true});"
                            onchange="calcAmountGoalTotal(<?=strtolower($moduleName)?>)"
                            name ='amount_goal[]' 
                            placeholder="999,99"
                            title = '<?=translateText('goal')?> / <?=translateText('amount')?>'
                            value=''
                            class="form-control" 
                            type="currency" 
                            maxlength="20"
                            autocomplete="amount"
                        />
                        <input
                            required
                            onkeypress="$(this).mask('#.###.##0,00', {reverse: true});"
                            onchange="calcAmountGoalTotal(<?=strtolower($moduleName)?>)"
                            name ='amount_goal[]' 
                            placeholder="999,99"
                            title = '<?=translateText('goal')?> / <?=translateText('amount')?>'
                            value=''
                            class="form-control" 
                            type="currency" 
                            maxlength="20"
                            autocomplete="amount"
                        />
                        <input
                            required
                            onkeypress="$(this).mask('#.###.##0,00', {reverse: true});"
                            onchange="calcAmountGoalTotal(<?=strtolower($moduleName)?>)"
                            name ='amount_goal[]' 
                            placeholder="999,99"
                            title = '<?=translateText('goal')?> / amount'
                            value=''
                            class="form-control" 
                            type="currency" 
                            maxlength="20"
                            autocomplete="amount"
                        />
                        <div class="invalid-feedback">
                            Please type a valid password
                        </div>
                    </div>
                    <div class="col">
                        <label for="start_month">Month</label>
                            <select class="custom-select" name="start_month[]" title="<?=translateText('month')?>" autocomplete="month">
                            <option value="7"><?=translateText('july')?></option>
                            </select>
                            <select class="custom-select" name="start_month[]" title="<?=translateText('month')?>" autocomplete="month">
                            <option value="8"><?=translateText('august')?></option>
                            </select>
                            <select class="custom-select" name="start_month[]" title="<?=translateText('month')?>" autocomplete="month">
                            <option value="9"><?=translateText('september')?></option>
                            </select>
                            <select class="custom-select" name="start_month[]" title="<?=translateText('month')?>" autocomplete="month">
                            <option value="10"><?=translateText('octuber')?></option>
                            </select>
                            <select class="custom-select" name="start_month[]" title="<?=translateText('month')?>" autocomplete="month">
                            <option value="11"><?=translateText('november')?></option>
                            </select>
                            <select class="custom-select" name="start_month[]" title="<?=translateText('month')?>" autocomplete="month">
                            <option value="12"><?=translateText('december')?></option> 
                            </select>
                    </div>
                    <div class="col">
                        <label for="amount_goal"><?=translateText('amount')?></label>
                        <input
                            required
                            onkeypress="$(this).mask('#.###.##0,00', {reverse: true});"
                            onchange="calcAmountGoalTotal(<?=strtolower($moduleName)?>)"
                            name ='amount_goal[]' 
                            placeholder="999,99"
                            title = '<?=translateText('goal')?> / <?=translateText('amount')?>'
                            value=''
                            class="form-control" 
                            type="currency" 
                            maxlength="20"
                            autocomplete="amount"
                        />
                        <input
                            required
                            onkeypress="$(this).mask('#.###.##0,00', {reverse: true});"
                            onchange="calcAmountGoalTotal(<?=strtolower($moduleName)?>)"
                            name ='amount_goal[]' 
                            placeholder="999,99"
                            title = '<?=translateText('goal')?> / <?=translateText('amount')?>'
                            value=''
                            class="form-control" 
                            type="currency" 
                            maxlength="20"
                            autocomplete="amount"
                        />
                        <input
                            required
                            onkeypress="$(this).mask('#.###.##0,00', {reverse: true});"
                            onchange="calcAmountGoalTotal(<?=strtolower($moduleName)?>)"
                            name ='amount_goal[]' 
                            placeholder="999,99"
                            title = '<?=translateText('goal')?> / <?=translateText('amount')?>'
                            value=''
                            class="form-control" 
                            type="currency" 
                            maxlength="20"
                            autocomplete="amount"
                        />
                        <input
                            required
                            onkeypress="$(this).mask('#.###.##0,00', {reverse: true});"
                            onchange="calcAmountGoalTotal(<?=strtolower($moduleName)?>)"
                            name ='amount_goal[]' 
                            placeholder="999,99"
                            title = '<?=translateText('goal')?> / <?=translateText('amount')?>'
                            value=''
                            class="form-control" 
                            type="currency" 
                            maxlength="20"
                            autocomplete="amount"
                        />
                        <input
                            required
                            onkeypress="$(this).mask('#.###.##0,00', {reverse: true});"
                            onchange="calcAmountGoalTotal(<?=strtolower($moduleName)?>)"
                            name ='amount_goal[]' 
                            placeholder="999,99"
                            title = '<?=translateText('goal')?> / <?=translateText('amount')?>'
                            value=''
                            class="form-control" 
                            type="currency" 
                            maxlength="20"
                            autocomplete="amount"
                        />
                        <input
                            required
                            onkeypress="$(this).mask('#.###.##0,00', {reverse: true});"
                            onchange="calcAmountGoalTotal(<?=strtolower($moduleName)?>)"
                            name ='amount_goal[]' 
                            placeholder="999,99"
                            title = '<?=translateText('goal')?> / <?=translateText('amount')?>'
                            value=''
                            class="form-control" 
                            type="currency" 
                            maxlength="20"
                            autocomplete="amount"
                        />
                        <div class="invalid-feedback">
                            Please type a valid password
                        </div>
                    </div>
                </div>
                <div class="form-row" style="margin-top:1rem">
                    <div class="col">
                        <label for="amount_goal"><?=translateText('amount')?> (Total - <?=ucfirst(translateText('annual'))?>)</label>
                        <input
                            required
                            onkeypress="$(this).mask('#.###.##0,00', {reverse: true});"
                            id='amount_total'
                            name ='amount_total'
                            readonly=true 
                            placeholder="999,99"
                            title = '<?=translateText('goal')?> / <?=translateText('amount')?>'
                            value=''
                            class="form-control" 
                            type="currency" 
                            maxlength="20"
                            autocomplete="amount"
                        />
                        <div class="invalid-feedback">
                            Please type a valid password
                        </div>
                    </div>
                </div>
            </div>
            <div class="inputs-button-container">
                <button class="button" name="btnSave" type="button" onClick="handleGoalSubmit(<?=strtolower($moduleName)?>)" >Save</button>
            </div>
        </form>
<?php 
} 
?>
        <div class="space-margin">&nbsp;</div>
        <table class="table table-hover table-sm">
            <caption>List of <?=$moduleName?>s</caption>
            <thead>
                <tr>
                    <th scope="col"><?=translateText('executive')?></th>
                    <th scope="col"><?=translateText('year')?></th>
                    <th scope="col"><?=translateText('amount')?> (Total)</th>
                    <th scope="col" style="text-align:center;"><?=translateText('settings')?></th>
                </tr>
            </thead>
            <tbody id="<?=strtolower($moduleName)?>-list">
                <tr>
                    <td>...</td>
                    <td>...</td>
                    <td>...</td>
                    <td style="text-align:center;">...</td>
                </tr>
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

<script type="text/javascript">
    handleListGoalAtFormOnLoad();
</script>


