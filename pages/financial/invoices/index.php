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
                <div class="form-row">
                    <div class="input-group col-sm-8">
                        &nbsp;
                    </div>
                    <div class="input-group col-sm-4">
                        <input type="search" name="search" class="form-control rounded" placeholder="<?=translateText('search');?>..." aria-label="<?=translateText('search');?>" />
                        <button class="material-icons btn btn-outline-primary my-2 my-sm-0" title="<?=translateText('search');?>" type="button" onClick="handleListOnLoad(filter.search.value)">search</button>
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