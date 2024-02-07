<?php
$moduleName = 'Provider';
$username   = null;
$search     = null;
$email      = null;
$mobile     = null;

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
                <div class="input-group col-sm-10">
                    &nbsp;
                </div>
                <div class="input-group col-sm-1 button-with-title" style="margin-bottom:1rem;">
                    <a type="button" title="<?=ucfirst(translateText('add'))?>" class="btn btn-outline-primary my-2 my-sm-0" type="button" style="width:100%; text-align: center; vertical-align:middle;" onClick="location.href='?pr=<?=base64_encode('./pages/'.strtolower($moduleName).'s/form.php')?>'"><span class="material-icons">add_box</span><div class="text-button"><?=ucfirst(translateText('add'))?></div></a>
                </div>
                <div class="input-group col-sm-1 button-with-title" style="margin-bottom:1rem;">
                    <a type="button" title="Import <?=ucfirst(translateText(strtolower($moduleName)))?>es from CSV file" class="btn btn-outline-primary my-2 my-sm-0" type="button" style="width:100%; text-align: center; vertical-align:middle;" onClick="location.href='?pr=<?=base64_encode('./pages/'.strtolower($moduleName).'s/formcsv.php')?>'"><span class="material-icons-outlined">file_upload</span><div class="text-button">CSV</div></a>
                </div>
            </div>
            <form name='filter' method="post" enctype="multipart/form-data">
            <div class="form-row" id="pages-controller-and-search">
                    <div class="input-group col-sm-6">
                        <button class="material-icons btn btn-outline-primary my-2 my-sm-0" title="First page" type="button" id="btn_firstpage" onClick="if(parseInt(filter.goto.value) > 1){handleListOnLoad(filter.search.value,1); filter.goto.value = 1;}">first_page</button>
                        <button class="material-icons btn btn-outline-primary my-2 my-sm-0" title="Previous page" type="button" id="btn_beforepage" onClick="if(parseInt(filter.goto.value) > 1){filter.goto.value = parseInt(filter.goto.value) - 1; handleListOnLoad(filter.search.value,(parseInt(filter.goto.value)));}">navigate_before</button>
                        <button class="material-icons btn btn-outline-primary my-2 my-sm-0" title="Next page" type="button" id="btn_nextpage" onClick="filter.goto.value = parseInt(filter.goto.value) + 1; handleListOnLoad(filter.search.value,(parseInt(filter.goto.value)));">navigate_next</button>
                        <button class="material-icons btn btn-outline-primary my-2 my-sm-0" title="Last page" type="button" id="btn_lastpage" onClick="gotoLast();">last_page</button>
                        <input name="goto" class="form-control rounded goto-page-input" value=1 placeholder="1" aria-label="Go to page..." /> <span class="of-pages">/ </span><span id="text-totalpages" class="form-control rounded total-pages">xxx</span>
                        <button class="material-icons btn btn-outline-primary my-2 my-sm-0" title="Go to page..." type="button" onClick="handleListOnLoad(filter.search.value,filter.goto.value);">plagiarism</button>
                        <input type="hidden" name="totalpages" value="1" />
                    </div>
                    <div class="input-group col-sm-2">
                    </div>
                    <div class="input-group col-sm-4">
                        <input type="search" name="search" class="form-control rounded" placeholder="<?=ucfirst(translateText('search'))?>..." aria-label="<?=ucfirst(translateText('search'))?>" />
                        <button class="material-icons btn btn-outline-primary my-2 my-sm-0" title="<?=ucfirst(translateText('search'))?>" type="button" onClick="filter.goto.value = 1; handleListOnLoad(filter.search.value,filter.goto.value)">search</button>
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
                    <th scope="col"><?=ucfirst(translateText(strtolower($moduleName)))?></th>
                    <th scope="col"><?=ucfirst(translateText('webpage'))?></th>
                    <th scope="col">&nbsp;</th>
                    <th scope="col" style="text-align:center;"><?=ucfirst(translateText('active'))?></th>
                    <th scope="col" style="text-align:center;"><?=ucfirst(translateText('settings'))?></th>
                </tr>
            </thead>
            <tbody id="list<?=$moduleName?>s">
                <tr>
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
    handleListOnLoad(filter.search.value,filter.goto.value);
</script>


