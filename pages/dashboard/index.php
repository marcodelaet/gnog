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
<script src="<?=$dir?>./assets/js/goal.js" type="text/javascript"></script>

<div class="lateral-filter-container">
    <div class="input-group col-sm-12">
        <select class="custom-select" name="status_id" id="status_id" title="Status" autocomplete="status_id" onclick="handleListGoalOnLoad(document.getElementById('executive_id').value,undefined,document.getElementById('month').value,document.getElementById('year').value,'status='+returnSelectedStatuses(this)); handleListOnLoad(document.getElementById('executive_id').value,undefined,document.getElementById('month').value,document.getElementById('year').value,'status='+returnSelectedStatuses(this));" multiple>
            <?=inputFilterNoZeroSelect('status',translateText('status'),'','percent','')?>
        </select>
    </div>
    <div class="form-row">
        <div class="input-group col">
            &nbsp;
        </div>
    </div>
    <div class="input-group col-sm-12   ">
        <select class="custom-select" name="executive_id" id="executive_id" title="Assigned Executive" onchange="handleListGoalOnLoad(this.value,undefined,document.getElementById('month').value,document.getElementById('year').value,'status='+returnSelectedStatuses(document.getElementById('status_id'))); handleListOnLoad(this.value,undefined,document.getElementById('month').value,document.getElementById('year').value,'status='+returnSelectedStatuses(document.getElementById('status_id')));" autocomplete="executive_id">
        <?php if($_COOKIE['lacc'] >= 99999) { ?>
            <?=inputSelect('user',translateText('executive'),'user_type|||executive*|*user_type|||admin','username','')?>
            <?php } else { ?>
                <option value="0"><?=translateText('only_admin');?></option>
            <?php } ?>
        </select>
    </div>
    <div class="filter-container col-sm-8" style="margin-bottom:1rem;">
        <div class="inputs-filter-container">
            <form name='filter' method="post" enctype="multipart/form-data">
                <div class="form-row">
                    <div class="input-group col-sm-7">
                        <select class="custom-select" name="month" id="month" title="Month" autocomplete="month" onchange="handleListGoalOnLoad(document.getElementById('executive_id').value,undefined,this.value,document.getElementById('year').value,'status='+returnSelectedStatuses(document.getElementById('status_id'))); handleListOnLoad(document.getElementById('executive_id').value,undefined,this.value,document.getElementById('year').value,'status='+returnSelectedStatuses(document.getElementById('status_id')));">
                            <option value="1"><?=translateText('january');?></option>
                            <option value="2"><?=translateText('february');?></option>
                            <option value="3"><?=translateText('march');?></option>
                            <option value="4"><?=translateText('april');?></option>
                            <option value="5"><?=translateText('may');?></option>
                            <option value="6"><?=translateText('june');?></option>
                            <option value="7"><?=translateText('july');?></option>
                            <option value="8"><?=translateText('august');?></option>
                            <option value="9"><?=translateText('september');?></option>
                            <option value="10"><?=translateText('octuber');?></option>
                            <option value="11"><?=translateText('november');?></option>
                            <option value="12"><?=translateText('december');?></option> 
                        </select>
                    </div>
                    <div class="input-group col-sm-5">
                        <select class="custom-select" name="year" id="year" title="Year" autocomplete="year" onchange="handleListGoalOnLoad(document.getElementById('executive_id').value,undefined,document.getElementById('month').value,this.value,'status='+returnSelectedStatuses(document.getElementById('status_id'))); handleListOnLoad(document.getElementById('executive_id').value,undefined,document.getElementById('month').value,this.value,'status='+returnSelectedStatuses(document.getElementById('status_id')));">
                            <option value="2022">2022</option>
                            <option value="2023">2023</option>
                            <option value="2024">2024</option>
                            <option value="2025">2025</option>
                            <option value="2026">2026</option>
                            <option value="2027">2027</option>
                            <option value="2028">2028</option>
                            <option value="2029">2029</option>
                            <option value="2030">2030</option>
                            <option value="2029">2031</option>
                            <option value="2030">2032</option>
                        </select>
                    </div>
                </div>
                <div  class="form-row">
                    <div class="input-group col-sm-7">
                        &nbsp;
                    </div>
                    <div class="input-group col-sm-5">
                        <div class="currency-select">
                            <select class="custom-select" id="rate_id" name="rate_id" title="Rates" autocomplete="rate_id" onChange="handleListGoalOnLoad(this.value); handleListOnLoad('','','','','',this.value);// getCurrencyValue(document.getElementById('goal-currency').innerText,this.value,document.getElementById('goal-0').innerText+'---'+document.getElementById('goal-1').innerText+'---'+document.getElementById('goal-2').innerText,'dashboard'); updateCurrencyListValue(document.getElementsByClassName('currency-line'),this.value,document.getElementsByClassName('amount-line'),'dashboard'); updateCurrencyListMonthlyValue(document.getElementsByClassName('currency-line'),this.value,document.getElementsByClassName('amount-month-line'),'dashboard'); ">
                                <?=inputFilterNoZeroSelect('rate','Rates','','orderby','USD')?>
                            </select>
                        </div>
                        <div class="update-date-division">
                            <span class="update-date-text">Last Update:</span>
                            <span id="last-update-date">
                                dd-mm-yyyy hh:mm:ss
                            </span>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div class='<?=strtolower($moduleName)?>-container'>
    <div class="result-container">
        <div class="row">
            <div class="col">
                Dashboard Private Area
                <table class="table table-hover table-sm">
                    <caption>List of Proposals / Goals</caption>
                    <thead>
                        <tr>
                            <th scope="col"><?=translateText('offer_campaign');?></th>
                            <th scope="col"><?=translateText('advertiser');?></th>
                            <th scope="col"><?=translateText('assign_executive');?></th>
                            <th scope="col"><?=translateText('amount');?></th>
                            <th scope="col"><?=translateText('monthly');?></th>
                            <th scope="col" style="text-align:center;"><?=translateText('status');?></th>
                            <th scope="col" style="text-align:center;"><?=translateText('settings');?></th>
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
            <div class="graph" id="graph-proposals"></div>
        </div>   
    <div>
        <div class="row">
            <div class="col-sm-6">
                &nbsp;
            </div>
            <div class="col-sm-6 goal-section" >
                <div class="hidden" ><spam class="goal-currency" id="goal-currency">MXN</spam></div>
                <div ><spam class="goal-title"><?=translateText('goals_of_month');?>:</spam><spam class="goal-result" id="goal-0">0.00</spam><spam class="hidden" id="goal-2">0</spam><div>
                <div ><spam class="goal-title"><?=translateText('total_reached');?>:</spam><spam class="goal-result" id="goal-1">0.00</spam><div>
                <div ><spam class="goal-title">% <?=translateText('reached');?>:</spam><spam class="goal-result" id="goal-percent">0.00%</spam><div>
            </div>
        </div>
    </div>    
</div>

<script>
    updateRates();
    handleListGoalOnLoad();
    handleListOnLoad();
</script>
<?php 

#Matriz utilizada para gerar os graficos

    

}
?>