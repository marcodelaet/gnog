<?php
$moduleName = 'Dashboard';

//PRIVATE AREA
$token=true;
if($token === true) {
    $dir='';
$dir2='';
if(1==2)
{
  $dir  = '../../.';
  $dir2 = "../../../.";
}
?>
<link rel="stylesheet" href="<?=$dir?>./assets/css/<?=$moduleName?>.css">
<link rel="stylesheet" href="<?=$dir?>./assets/css/Inputs.css">
<link rel="stylesheet" href="<?=$dir?>./assets/css/Button.css">
<script src="<?=$dir?>./assets/js/<?=strtolower($moduleName)?>.js" type="text/javascript"></script>
<script src="<?=$dir?>./assets/js/rate.js" type="text/javascript"></script>
<div class='<?=strtolower($moduleName)?>-container'>
    <div class="filter-container" style="margin-bottom:1rem;">
        <div class="inputs-filter-container">
            <form name='filter' method="post" enctype="multipart/form-data">
                <div class="form-row">
                    <div class="input-group col-sm-3">
                        <select class="custom-select" name="month" title="Month" autocomplete="month">
                            <option value="1">January</option>
                            <option value="2">February</option>
                            <option value="3">March</option>
                            <option value="4">April</option>
                            <option value="5">May</option>
                            <option value="6">June</option>
                            <option value="7">July</option>
                            <option value="8">August</option>
                            <option value="9">September</option>
                            <option value="10">Octuber</option>
                            <option value="11">November</option>
                            <option value="12">December</option> 
                        </select>
                    </div>
                    <div class="input-group col-sm-2">
                        <select class="custom-select" name="year" title="Year" autocomplete="year">
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
                    <div class="input-group col-sm-4">
                    </div>
                    <div class="input-group col-sm-3">
                        <select class="custom-select" name="status_id" title="Status" autocomplete="status_id" multiple>
                            <?=inputFilterNoZeroSelect('status','Status','','percent','')?>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="input-group col">
                        &nbsp;
                    </div>
                </div>
                <div class="form-row">
                    <div class="input-group col-sm-3">
                        <select class="custom-select" name="executive_id" title="Assigned Executive" autocomplete="executive_id">
                            <?=inputFilterSelect('user','Executive','','username','')?>
                        </select>
                    </div>
                    <!--<div class="input-group col-sm-3">
                        <select class="custom-select" name="advertiser_id" title="Client or Agency" autocomplete="advertiser_id">
                            <? // inputFilterSelect('advertiser','Client / Agency','','corporate_name','')?>
                        </select>
                    </div>
                    <div class="input-group col-sm-2">
                        <select class="custom-select" name="provider_id" title="Provider" autocomplete="provider_id">
                            <? //inputFilterSelect('provider','Provider','','name','')?>
                        </select>
                    </div>-->
                    <div class="input-group col-sm-1">
                        <select class="custom-select" name="rate_id" title="Rates" autocomplete="rate_id" onChange="updateCurrencyListValue(document.getElementsByClassName('currency-line'),this.value,document.getElementsByClassName('amount-line'),'dashboard'); getCurrencyValue(document.getElementById('goal-currency').innerText,this.value,document.getElementById('goal-0').innerText+'---'+document.getElementById('goal-1').innerText,'dashboard');">
                            <?=inputFilterSelect('rate','Rates','','orderby','')?>
                        </select>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="result-container">
        <div class="row">
            <div class="col">
                Dashboard Private Area
                <table class="table table-hover table-sm">
                    <caption>List of Proposals / Goals</caption>
                    <thead>
                        <tr>
                            <th scope="col">Offer / Campaign</th>
                            <th scope="col">Advertiser</th>
                            <th scope="col">Assign Executive</th>
                            <th scope="col">Amount</th>
                            <th scope="col">Status</th>
                            <th scope="col" style="text-align:center;">Settings</th>
                        </tr>
                    </thead>
                    <tbody id="listDashboard">
                        <tr>
                            <td class="table-column-offerName">Nestle</td>
                            <td class="table-column-AdvertiserName">...</td>
                            <td class="table-column-AssignedExecutive">...</td>
                            <td class="table-column-Amount">...</td>
                            <td class="table-column-Status">...</td>
                            <td style="text-align:center;">...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-8">
                &nbsp;
            </div>
            <div class="col-sm-4 goal-section" >
                <div class="hidden" ><spam class="goal-currency" id="goal-currency">MXN</spam></div>
                <div ><spam class="goal-title">Goal of the month:</spam><spam class="goal-result" id="goal-0">10,000.99</spam><div>
                <div ><spam class="goal-title">Total Reached:</spam><spam class="goal-result" id="goal-1">0.99</spam><div>
                <div ><spam class="goal-title">% Reached:</spam><spam class="goal-result" id="goal-percent">0.01%</spam><div>
            </div>
        </div>
    </div>    
</div>
<script>
    handleListOnLoad();
</script>
<?php 
}
?>