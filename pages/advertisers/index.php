<?php
$moduleName = 'Advertiser';
$username   = null;
$search     = null;
$email      = null;
$mobile     = null;

if(array_key_exists('advertiser',$_POST))
{
  $advertiser   = $_POST['advertiser'];
  $email        = $_POST['email'];
  $mobile       = $_POST['mobile'];
  $search       = $_POST['search'];
}

?>
<link rel="stylesheet" href="<?=$dir?>./assets/css/<?=$moduleName;?>.css">
<link rel="stylesheet" href="<?=$dir?>./assets/css/Inputs.css">
<link rel="stylesheet" href="<?=$dir?>./assets/css/RecoveryLink.css">
<link rel="stylesheet" href="<?=$dir?>./assets/css/Button.css">
<script src="<?=$dir?>./assets/js/<?=strtolower($moduleName)?>.js" type="text/javascript"></script>

    <div class='list-<?=strtolower($moduleName)?>-container'>
    <div class="filter-container" style="margin-bottom:1rem;">
        
        <div class="inputs-filter-container">
            <div class="form-row">
                <div class="input-group col-sm-11">
                    &nbsp;
                </div>
                <div class="input-group col-sm-1 " style="margin-bottom:1rem;">
                    <button type="button" title="Add New" class="material-icons btn btn-outline-primary my-2 my-sm-0" style="width:100%; text-align: center; vertical-align:middle;" onClick="location.href='?pr=Li9wYWdlcy9hZHZlcnRpc2Vycy9mb3JtLnBocA=='">add_box</button>
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
    <div class="<?=strtolower($moduleName)?>s-list">
        <table class="table table-hover table-sm">
            <caption>List of <?=$moduleName?>s</caption>
            <thead>
                <tr>
                    <th scope="col">Corporate name</th>
                    <th scope="col">&nbsp;</th>
                    <th scope="col">Main contact</th>
                    <th scope="col" style="text-align:center;">Country</th>
                    <th scope="col" style="text-align:center;">Active</th>
                    <th scope="col" style="text-align:center;">Settings</th>
                </tr>
            </thead>
            <tbody id="list<?=$moduleName?>s">
                <tr>
                    <td>...</td>
                    <td>...</td>
                    <td>...</td>
                    <td>...</td>
                    <td style="text-align:center;">...</td>
                    <td style="text-align:center;">...</td>
                </tr>
            </tbody>
        </table>
    </div>  
</div>
<script>
    handleListOnLoad();
</script>


