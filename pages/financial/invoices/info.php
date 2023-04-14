<?php 
$moduleName = 'Invoice'; 
$message_modal_approval = translateText('approve_files') .' '. translateText('from_invoice');
$btn_approval_pay       = ucfirst(translateText('approve_files'));
$status = '';
if(array_key_exists('sts',$_REQUEST)){
  $status = $_REQUEST['sts'];
}

if($status != 'waiting_approval'){
  $message_modal_approval = translateText('pay_invoice');
  $btn_approval_pay       = ucfirst(translateText('pay_invoice'));
}

?>
<link rel="stylesheet" href="<?=$dir?>./assets/css/<?=$moduleName?>.css">
<link rel="stylesheet" href="<?=$dir?>./assets/css/Inputs.css">
<link rel="stylesheet" href="<?=$dir?>./assets/css/Button.css">
<script src="<?=$dir?>./assets/js/<?=strtolower($moduleName)?>.js" type="text/javascript"></script>
<?php if(array_key_exists('iid',$_REQUEST)){ ?>
<script>
    handleViewOnLoad("<?=$_REQUEST['iid']?>")
</script>
<?php } ?>
<div class="card bg-light mb-3" id="<?=strtolower($moduleName)?>-card">
    <div class="card-header">
        <div class="<?=strtolower($moduleName)?>-header">
            <div class="<?=strtolower($moduleName)?>-main" >
                <spam id="<?=strtolower($moduleName)?>-name" class="<?=strtolower($moduleName)?>-name"><?=translateText($moduleName,$_COOKIES['ulang'])?></spam>
                <spam class="<?=strtolower($moduleName)?>-number" id="invoice-number">11122-4445555</spam>
            </div>
        </div>
    </div>
    <div class="card-body <?=strtolower($moduleName)?>-body">
        <div class="<?=strtolower($moduleName)?>-data">
            <spam id="provider-name" class="provider-name">Provider Name</spam>
            <spam id="offer-name" class="offer-name">Offer Name / product name - salemodel name</spam>
        </div>
        <div class="<?=strtolower($moduleName)?>-data">
            <spam id="month-year" class="month-year">11/2022 - </spam>
            <spam id="invoice-value" class="invoice-value"><?=translateText('invoice_amount')?>: MXN$ 122,212.21 - </spam> 
            <spam id="paid-value" class="paid-value"><?=translateText('paid')?>: MXN$ 0.21</spam>
            
        </div>
        <div id="list-files">
            <div class="space-blank">&nbsp;</div>
            <div class="<?=strtolower($moduleName)?>-data">
                <spam class="file-list-item"><?=translateText('invoice_file')?> </spam>
                <spam id="invoice-file"></spam>
            </div>
            <div class="<?=strtolower($moduleName)?>-data">
                <spam class="file-list-item"><?=translateText('xml_file')?></spam>
                <spam id="xml-file"></spam>
            </div>
            <div class="<?=strtolower($moduleName)?>-data">
                <spam class="file-list-item"><?=translateText('po_file')?></spam>
                <spam id="po-file"></spam>
            </div>
            <div class="<?=strtolower($moduleName)?>-data">
                <spam class="file-list-item"><?=translateText('report_file')?></spam>
                <spam id="report-file"></spam>
            </div>
            <div class="<?=strtolower($moduleName)?>-data">
                <spam class="file-list-item"><?=translateText('presentation_file')?></spam>
                <spam id="presentation-file"></spam>
            </div>
        </div>
<?php if(($status != 'approval_denied') && ($status != 'paid')){ ?>
        <div class="container">
            <div class="row">
<?php if(($status != 'invoice_approved') && ($status != 'parcial_paid')){?>
                <div class="col" id="btn-deny-div" style="text-align: center;">
                    <Button class="btn btn-danger" type="button" data-toggle="modal" data-target="#motiveModal" data-whatever="@mdo" ><?=ucfirst(translateText('deny_files'))?></Button>
                </div>
<?php } ?>
                <div class="col" style="text-align: center;">
                    <Button class="btn btn-success" id="btn-approve" type="button" data-toggle="modal" data-target="#approveModal" data-whatever="<?=$message_modal_approval?>" ><?=$btn_approval_pay?></Button>
                </div>
            </div>
        </div>
<?php } ?>
        <div class="inputs-button-container">
            <Button class="button" type="button" onClick="window.location='?pr=<?=base64_encode('./pages/financial/invoices/index.php')?>'" >Back to <?=$moduleName?>s</Button>
        </div>
    </div>
</div>

<div class="modal fade" id="motiveModal" tabindex="-1" aria-labelledby="motiveModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="motiveModalLabel"><?=translateText('deny_files')?> <?=translateText('from_invoice')?> </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form name="frmDeny">
          <div class="form-group">
            <label for="motive" class="col-form-label"><?=translateText('motive')?>: <i>(min 10 chars)</i></label>
            <textarea class="form-control" id="motive" name="motive"></textarea>
          </div>
          <input type="hidden" name="iid" value="<?=$_REQUEST['iid']?>" />
          <input type="hidden" name="sts" value="<?=$_REQUEST['sts']?>" />
          <input type="hidden" name="uid" value="<?=$_COOKIE['uuid']?>" />
          <input type="hidden" name="tku" value="<?=$_COOKIE['tk']?>" />
          <input type="hidden" name="invoice_amount" value="" />
          <input type="hidden" name="paid_amount" value="" />
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?=translateText('close')?></button>
        <button type="button" class="btn btn-primary" onclick="this.disabled = true; invoiceChangeStatus(frmDeny,'deny')"><?=translateText('save')?></button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="approveModal" tabindex="-1" aria-labelledby="approveModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="approveModalLabel"><?=translateText('approve_files')?> <?=translateText('from_invoice')?> </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form name="frmApprove">
            <div class="form-group">
                <div class="inputs-form-container">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><?=translateText('currency')?></span>
                        </div>
                        <select
                        required
                        name ='currency' 
                        title = '<?=translateText('currency');?>'
                        class="form-control"
                        autocomplete="currency"
                        onchange="if(this.value=='BRL'){document.getElementById('currency-symbol').innerText='R$';} else {document.getElementById('currency-symbol').innerText='$';}">
                            <option value="MXN">MXN</option>
                            <option value="USD">USD</option>
                            <option value="BRL">BRL</option>
                        </select> &nbsp;&nbsp;&nbsp;&nbsp;
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="currency-symbol">$</span>
                            <span class="input-group-text">0.00</span>
                        </div>
                        <input type='currency' class="form-control" placeholder="Total Pagado" name="invoice_value" id="invoice_value"  title="Total Pagado" autocomplete="invoice_value" onkeypress="$(this).mask('#,###,##0.00', {reverse: true});"/>
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><?=translateText('payment_date')?></span>
                        </div>
                        <input type='date' class="form-control" placeholder="<?=translateText('payment_date')?>" name="payment_date" id="payment_date"  title="<?=translateText('payment_date')?>" autocomplete="payment_date"/>
                    </div>
                    <input type="hidden" name="iid" value="<?=$_REQUEST['iid']?>" />
                    <input type="hidden" name="sts" value="<?=$_REQUEST['sts']?>" />
                    <input type="hidden" name="uid" value="<?=$_COOKIE['uuid']?>" />
                    <input type="hidden" name="tku" value="<?=$_COOKIE['tk']?>" />
                    <input type="hidden" name="invoice_amount" value="" />
                    <input type="hidden" name="paid_amount" value="" />
                </div>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?=translateText('close')?></button>
        <button type="button" class="btn btn-primary" onclick="this.disabled = true; invoiceChangeStatus(frmApprove,'pay')"><?=ucfirst(translateText('pay'))?></button>
<?php if($status == 'waiting_approval'){ ?>
        <button type="button" id="btn-approval-only" class="btn btn-warning" onclick="this.disabled = true; invoiceChangeStatus(frmApprove,'approval')"><?=ucfirst(translateText('approval_only'))?></button>
<?php  } ?>
      </div>
    </div>
  </div>
</div>


<script type="text/javascript">
    $('#motiveModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget) // Button that triggered the modal
      var recipient = button.data('whatever') // Extract info from data-* attributes
      // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
      // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
      var modal = $(this)
      modal.find('.modal-title').text('<?=ucfirst(translateText('deny_files'))?> <?=translateText('from_invoice')?> '+document.getElementById('invoice-number').innerText);
    // modal.find('.modal-body input').val(recipient)
    });

    $('#approveModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget) // Button that triggered the modal
      var action = button.data('whatever') // Extract info from data-* attributes
      // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
      // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
      var modal = $(this)
      modal.find('.modal-title').text(action + ' '+document.getElementById('invoice-number').innerText);
    // modal.find('.modal-body input').val(recipient)
    });
</script>