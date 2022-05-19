<?php

$moduleName = 'Goal';
$user_id       = 0;
if(array_key_exists('tid',$_GET))
    $user_id       = $_GET['tid'];

?>
<link rel="stylesheet" href="<?=$dir?>./assets/css/<?=$moduleName?>.css">
<link rel="stylesheet" href="<?=$dir?>./assets/css/Inputs.css">
<link rel="stylesheet" href="<?=$dir?>./assets/css/RecoveryLink.css">
<link rel="stylesheet" href="<?=$dir?>./assets/css/Button.css">
<script src="<?=$dir?>./assets/js/<?=strtolower($moduleName)?>.js" type="text/javascript"></script>

<div class='form-<?=strtolower($moduleName)?>-container'>
    <div class="form-container">
        <div class="form-header">New <?=$moduleName?></div>
        <form name='<?=strtolower($moduleName)?>' method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
            <div class="inputs-form-container">
                <div class="form-row">
                    <div class="col-sm-8">
                    <label for="user_id">Executive</label>
                    <select class="custom-select" name="user_id" title="Users" autocomplete="user_id" >
                        <?=inputFilterSelect('user','Choose an Executive','','username',"$user_id")?>
                    </select>
                    </div>
                    <div class="col-sm-2">
                        <label for="start_year">Year</label>
                        <select class="custom-select" name="start_year" title="Year" autocomplete="year">
                            <option value="2022">2022</option>
                            <option value="2023">2023</option>
                            <option value="2024">2024</option>
                            <option value="2025">2025</option>
                            <option value="2026">2026</option>
                            <option value="2027">2027</option>
                            <option value="2028">2028</option>
                            <option value="2029">2029</option>
                            <option value="2030">2030</option>
                        </select>
                    </div>
                    <div class="col-sm-2">
                        <label for="rate_id">Currency</label>
                        <select class="custom-select" name="rate_id" title="Rates" autocomplete="rate_id" >
                            <?=inputFilterNoZeroSelect('rate','Rates','','orderby','')?>
                        </select>
                    </div>
                </div>
                
                <div class="form-row" style="margin-top:1rem">
                    <div class="col-sm-3">
                        <label for="start_month">Month</label>
                        <select class="custom-select" name="start_month[]" title="Month" autocomplete="month">
                            <option value="1">January</option>
                            </select>
                            <select class="custom-select" name="start_month[]" title="Month" autocomplete="month">
                            <option value="2">February</option>
                            </select>
                            <select class="custom-select" name="start_month[]" title="Month" autocomplete="month">
                            <option value="3">March</option>
                            </select>
                            <select class="custom-select" name="start_month[]" title="Month" autocomplete="month">
                            <option value="4">April</option>
                            </select>
                            <select class="custom-select" name="start_month[]" title="Month" autocomplete="month">
                            <option value="5">May</option>
                            </select>
                            <select class="custom-select" name="start_month[]" title="Month" autocomplete="month">
                            <option value="6">June</option>
                            </select>
                    </div>
                    <div class="col">
                        <label for="amount_goal">Amount</label>
                        <input
                            required
                            onkeypress="$(this).mask('#.###.##0,00', {reverse: true});"
                            onchange="calcAmountTotal(<?=strtolower($moduleName)?>)"
                            name ='amount_goal[]' 
                            placeholder="999,99"
                            title = 'Goal / Amount'
                            value=''
                            class="form-control" 
                            type="currency" 
                            maxlength="20"
                            autocomplete="amount"
                        />
                        <input
                            required
                            onkeypress="$(this).mask('#.###.##0,00', {reverse: true});"
                            onchange="calcAmountTotal(<?=strtolower($moduleName)?>)"
                            name ='amount_goal[]' 
                            placeholder="999,99"
                            title = 'Goal / Amount'
                            value=''
                            class="form-control" 
                            type="currency" 
                            maxlength="20"
                            autocomplete="amount"
                        />
                        <input 
                            required
                            onkeypress="$(this).mask('#.###.##0,00', {reverse: true});"
                            onchange="calcAmountTotal(<?=strtolower($moduleName)?>)"
                            name ='amount_goal[]' 
                            placeholder="999,99"
                            title = 'Goal / Amount'
                            value=''
                            class="form-control" 
                            type="currency" 
                            maxlength="20"
                            autocomplete="amount"
                        />
                        <input
                            required
                            onkeypress="$(this).mask('#.###.##0,00', {reverse: true});"
                            onchange="calcAmountTotal(<?=strtolower($moduleName)?>)"
                            name ='amount_goal[]' 
                            placeholder="999,99"
                            title = 'Goal / Amount'
                            value=''
                            class="form-control" 
                            type="currency" 
                            maxlength="20"
                            autocomplete="amount"
                        />
                        <input
                            required
                            onkeypress="$(this).mask('#.###.##0,00', {reverse: true});"
                            onchange="calcAmountTotal(<?=strtolower($moduleName)?>)"
                            name ='amount_goal[]' 
                            placeholder="999,99"
                            title = 'Goal / Amount'
                            value=''
                            class="form-control" 
                            type="currency" 
                            maxlength="20"
                            autocomplete="amount"
                        />
                        <input
                            required
                            onkeypress="$(this).mask('#.###.##0,00', {reverse: true});"
                            onchange="calcAmountTotal(<?=strtolower($moduleName)?>)"
                            name ='amount_goal[]' 
                            placeholder="999,99"
                            title = 'Goal / Amount'
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
                            <select class="custom-select" name="start_month[]" title="Month" autocomplete="month">
                            <option value="7">July</option>
                            </select>
                            <select class="custom-select" name="start_month[]" title="Month" autocomplete="month">
                            <option value="8">August</option>
                            </select>
                            <select class="custom-select" name="start_month[]" title="Month" autocomplete="month">
                            <option value="9">September</option>
                            </select>
                            <select class="custom-select" name="start_month[]" title="Month" autocomplete="month">
                            <option value="10">Octuber</option>
                            </select>
                            <select class="custom-select" name="start_month[]" title="Month" autocomplete="month">
                            <option value="11">November</option>
                            </select>
                            <select class="custom-select" name="start_month[]" title="Month" autocomplete="month">
                            <option value="12">December</option> 
                            </select>
                    </div>
                    <div class="col">
                        <label for="amount_goal">Amount</label>
                        <input
                            required
                            onkeypress="$(this).mask('#.###.##0,00', {reverse: true});"
                            onchange="calcAmountTotal(<?=strtolower($moduleName)?>)"
                            name ='amount_goal[]' 
                            placeholder="999,99"
                            title = 'Goal / Amount'
                            value=''
                            class="form-control" 
                            type="currency" 
                            maxlength="20"
                            autocomplete="amount"
                        />
                        <input
                            required
                            onkeypress="$(this).mask('#.###.##0,00', {reverse: true});"
                            onchange="calcAmountTotal(<?=strtolower($moduleName)?>)"
                            name ='amount_goal[]' 
                            placeholder="999,99"
                            title = 'Goal / Amount'
                            value=''
                            class="form-control" 
                            type="currency" 
                            maxlength="20"
                            autocomplete="amount"
                        />
                        <input
                            required
                            onkeypress="$(this).mask('#.###.##0,00', {reverse: true});"
                            onchange="calcAmountTotal(<?=strtolower($moduleName)?>)"
                            name ='amount_goal[]' 
                            placeholder="999,99"
                            title = 'Goal / Amount'
                            value=''
                            class="form-control" 
                            type="currency" 
                            maxlength="20"
                            autocomplete="amount"
                        />
                        <input
                            required
                            onkeypress="$(this).mask('#.###.##0,00', {reverse: true});"
                            onchange="calcAmountTotal(<?=strtolower($moduleName)?>)"
                            name ='amount_goal[]' 
                            placeholder="999,99"
                            title = 'Goal / Amount'
                            value=''
                            class="form-control" 
                            type="currency" 
                            maxlength="20"
                            autocomplete="amount"
                        />
                        <input
                            required
                            onkeypress="$(this).mask('#.###.##0,00', {reverse: true});"
                            onchange="calcAmountTotal(<?=strtolower($moduleName)?>)"
                            name ='amount_goal[]' 
                            placeholder="999,99"
                            title = 'Goal / Amount'
                            value=''
                            class="form-control" 
                            type="currency" 
                            maxlength="20"
                            autocomplete="amount"
                        />
                        <input
                            required
                            onkeypress="$(this).mask('#.###.##0,00', {reverse: true});"
                            onchange="calcAmountTotal(<?=strtolower($moduleName)?>)"
                            name ='amount_goal[]' 
                            placeholder="999,99"
                            title = 'Goal / Amount'
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
                        <label for="amount_goal">Annual Amount</label>
                        <input
                            required
                            onkeypress="$(this).mask('#.###.##0,00', {reverse: true});"
                            id='amount_total'
                            name ='amount_total'
                            readonly=true 
                            placeholder="999,99"
                            title = 'Goal / Amount'
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
                <input type="hidden" name="auth_api" value="sj83fnfn8dsndvudsnudvnus">
                <button class="button" name="btnSave" type="button" onClick="handleSubmit(<?=strtolower($moduleName)?>)" >Save</button>
            </div>
        </form>
        <div class="space-margin">&nbsp;</div>
        <table class="table table-hover table-sm">
            <caption>List of <?=$moduleName?>s</caption>
            <thead>
                <tr>
                    <th scope="col">Executive</th>
                    <th scope="col">Year</th>
                    <th scope="col">Total Amount</th>
                    <th scope="col" style="text-align:center;">Settings</th>
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

