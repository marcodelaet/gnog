<?php
$moduleNameProp = 'Proposal';


?>
<link rel="stylesheet" href="<?=$dir?>./assets/css/<?=$moduleNameProp;?>.css">
<link rel="stylesheet" href="<?=$dir?>./assets/css/Inputs.css">
<link rel="stylesheet" href="<?=$dir?>./assets/css/RecoveryLink.css">
<link rel="stylesheet" href="<?=$dir?>./assets/css/Button.css">
<script src="<?=$dir?>./assets/js/<?=strtolower($moduleNameProp)?>.js" type="text/javascript"></script>

<div class='list-<?=strtolower($moduleNameProp)?>-container'>
    <div class="filter-container" style="margin-bottom:1rem;">
        <div class="inputs-filter-container">
            <div class="form-row">
                <div class="input-group col-sm-11">
                    &nbsp;
                </div>
                <div class="input-group col-sm-1 " style="margin-bottom:1rem;">
                    <a type="button" title="Add New" class="btn btn-outline-primary my-2 my-sm-0" type="button" style="width:100%; text-align: center; vertical-align:middle;" onClick="location.href='?pr=Li9wYWdlcy9wcm9wb3NhbHMvZm9ybS5waHA='"><span class="material-icons">add_box</span><div class="text-button"><?=translateText('add')?></div></a>
                </div>
            </div>
            <form name='filter' method="post" enctype="multipart/form-data">
                <div class="form-row">
                    <div class="input-group col-sm-8">
                        &nbsp;
                    </div>
                    <div class="input-group col-sm-4">
                        <input type="search" name="search" class="form-control rounded" placeholder="Search..." aria-label="Search" />
                        <button class="material-icons btn btn-outline-primary my-2 my-sm-0" title="Search" type="button" onClick="handleListOnLoad(filter.search.value)">search</button>
                    </div>
                </div>
            </form>
        </div>
    </div>  
    <div class="<?=strtolower($moduleNameProp)?>s-list">
        <table class="table table-hover table-sm">
            <caption>List of <?=$moduleNameProp?>s</caption>
            <thead>
                <tr>
                    <th scope="col"><?=translateText('offer_campaign')?></th>
                    <th scope="col"><?=translateText('advertiser')?></th>
                    <th scope="col"><?=translateText('assign_executive')?></th>
                    <th scope="col"><?=translateText('amount')?></th>
                    <th scope="col"><?=translateText('start_date')?></th>
                    <th scope="col"><?=translateText('stop_date')?></th>
                    <th scope="col" style="text-align:center;"><?=translateText('status')?></th>
                    <th scope="col" style="text-align:center;"><?=translateText('settings')?></th>
                </tr>
            </thead>
            <tbody id="list<?=$moduleNameProp?>s">
                <tr>
                    <td>...</td>
                    <td>...</td>
                    <td>...</td>
                    <td>...</td>
                    <td>...</td>
                    <td>...</td>
                    <td>...</td>
                    <td style="text-align:center;">...</td>
                </tr>
            </tbody>
        </table>
    </div>  
</div>
<script>
    handleListOnLoad();
</script>


