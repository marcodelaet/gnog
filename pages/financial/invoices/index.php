<?php
$moduleName = 'Invoice';

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
    
    <div class='<?=strtolower($moduleName)?>-container'>
        <div class="inputs-filter-container">
            <form name='filter' method="post" enctype="multipart/form-data">
                <div class="form-row" id="pages-controller-and-search">
                    <div class="input-group col-sm-6">
                        <button class="material-icons btn btn-outline-primary my-2 my-sm-0" title="First page" type="button" id="btn_firstpage" onClick="if(parseInt(filter.goto.value) > 1){handleListOnLoad(filter.search.value,1); filter.goto.value = 1;}">first_page</button>
                        <button class="material-icons btn btn-outline-primary my-2 my-sm-0" title="Previous page" type="button" id="btn_beforepage" onClick="if(parseInt(filter.goto.value) > 1){filter.goto.value = parseInt(filter.goto.value) - 1; handleListOnLoad(filter.search.value,(parseInt(filter.goto.value)));}">navigate_before</button>
                        <button class="material-icons btn btn-outline-primary my-2 my-sm-0" title="Next page" type="button" id="btn_nextpage" onClick="filter.goto.value = parseInt(filter.goto.value) + 1; handleListOnLoad(filter.search.value,(parseInt(filter.goto.value)));">navigate_next</button>
                        <button class="material-icons btn btn-outline-primary my-2 my-sm-0" title="Last page" type="button" id="btn_lastpage" onClick="gotoLast();">last_page</button>
                        <input name="goto" class="form-control rounded goto-page-input" placeholder="1" value="1" aria-label="Go to page..." /> <span class="of-pages">/ </span><span id="text-totalpages" class="form-control rounded total-pages">xxx</span>
                        <button class="material-icons btn btn-outline-primary my-2 my-sm-0" title="Go to page..." type="button" onClick="handleListOnLoad(filter.search.value,filter.goto.value);">plagiarism</button>
                        <input type="hidden" name="totalpages" value="1" />
                    </div>
                    <div class="input-group col-sm-2">
                    </div>
                    <div class="input-group col-sm-4">
                        <input type="search" name="search" class="form-control rounded" placeholder="Search..." aria-label="Search" />
                        <button class="material-icons btn btn-outline-primary my-2 my-sm-0" title="Search" type="button" onClick="filter.goto.value = 1; handleListOnLoad(filter.search.value,filter.goto.value)">search</button>
                    </div>
                </div>
            </form>        
        </div>
        <div class="result-container">
            <div class="row" id="invoices-list">
                <div class="col">
                    <span class="section-information-line"><?=translateText('invoices');?></span>
                    <table class="table table-hover table-sm">
                        <caption>Offers / Files</caption>
                        <thead>
                            <tr>
                                <th class="column" scope="col"><?=translateText('provider');?></th>
                                <th class="column" scope="col"><?=translateText('offer_campaign');?></th>
                                <th class="column" scope="col"><?=translateText('po_number');?></th>
                                <th class="column" scope="col"><?=translateText('invoice_number');?></th>
                                <th class="column" scope="col"><?=translateText('amount');?></th>
                                <th class="column" scope="col"><?=translateText('invoice_created_at');?></th>
                                <th class="column" scope="col"><?=translateText('month');?>/<?=translateText('year');?></th>
                                <th class="column" scope="col"><?=translateText('paid_amount');?></th>
                                <th class="column" scope="col"><?=translateText('paid_at');?></th>
                                <th class="column" style="text-align:center;" scope="col"><?=translateText('status');?></th>
                                <th class="column" scope="col">&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody id="listInvoices">
                            <tr>
                                <td class="table-column-ProviderName">Disney</td>
                                <td class="table-column-Offer">...</td>
                                <td class="table-column-PoNumber">...</td>
                                <td class="table-column-invoice-Number">...</td>
                                <td class="table-column-Amount">...</td>
                                <td class="table-column-Invoice-Date">...</td>
                                <td class="table-column-Month-Year">...</td>
                                <td class="table-column-Paid-Amount">...</td>
                                <td class="table-column-Paid-At">...</td>
                                <td class="table-column-Status">...</td>
                                <td class="table-column-Nothing">...</td>
                                <td class="table-column-Files">...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>        
        </div>
    </div>


    <div class="modal fade rounded" id="logModal" tabindex="-1" aria-labelledby="logModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="logModalLabel"><?=translateText('history')?> <?=translateText('from_invoice')?> </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="history-list" id="history"></div>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>


    <script>
        handleListOnLoad();

    $('#logModal').on('show.bs.modal', function (event) {
       // var button = $(event.relatedTarget) // Button that triggered the modal
        //var action = button.data('whatever') // Extract info from data-* attributes
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        //var modal = $(this)
       //modal.find('.modal-title').text(action + ' '+document.getElementById('invoice-number').innerText);
        // modal.find('.modal-body input').val(recipient)
    });
    </script>
<?php 
#Matriz utilizada para gerar os graficos
}
?>