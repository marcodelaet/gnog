<?php 
$moduleName = 'Message'; 
$invite_body_esp = "lalalala";
?>
<link rel="stylesheet" href="<?=$dir?>./assets/css/<?=$moduleName?>.css">
<link rel="stylesheet" href="<?=$dir?>./assets/css/Inputs.css">
<link rel="stylesheet" href="<?=$dir?>./assets/css/Button.css">
<script src="<?=$dir?>./assets/js/<?=strtolower($moduleName)?>.js" type="text/javascript"></script>
<?php if(array_key_exists('ppid',$_REQUEST)){ ?>
<script>
    handleViewOnLoad("<?=$_REQUEST['ppid']?>")
</script>
<?php } ?>
<div class="card bg-light mb-3" id="<?=strtolower($moduleName)?>-card">
    <div class="card-header">
        <div class="<?=strtolower($moduleName)?>-header">
            <div class="<?=strtolower($moduleName)?>-main" >
                <spam id="<?=strtolower($moduleName)?>-name"><?=$moduleName?></spam>
                <spam class="<?=strtolower($moduleName)?>-client" id="client"></spam>
                <spam class="<?=strtolower($moduleName)?>-description" id="description"></spam><br/>
                <spam class="<?=strtolower($moduleName)?>-dates" id="dates"></spam>
                
            </div>
        </div>
    </div>
    <div class="card-body <?=strtolower($moduleName)?>-body">
        <!--***************************************
        ****** Products Section *******************-->
        <h5 class="card-title main-products-header"><?=translateText('Products')?></h5>
        <div class="<?=strtolower($moduleName)?>-data">
            <div id="products-list">
                <spam >aaaaaa bbbbbb da xxxx </spam><spam >- R$ 0,00</spam>
            </div>
        </div>
        <br/>
        <div id="files-table">
            <table class="table table-hover table-sm">
                <caption>Proposal / Files</caption>
                <thead>
                    <tr>
                        <th class="column col-9" scope="col">
                            <?=ucfirst(translateText('file'));?>
                        </th>
                        <th class="column col-3" scope="col">
                            <?=ucfirst(translateText('date'));?>
                        </th>
                    </tr>
                </thead>
                <tbody id="listIProposalFiles"></tbody>
            </table>
            <!-- Button trigger modal -->
             <div class="col-1 offset-11" id="div-sendbutton">
                <spam type="button" type="button" class="btn btn-success material-symbols-outlined" data-toggle="modal" data-whatever="Send" data-target="#sendEmailModal">send</spam>
            </div>

        </div>
        <div class="margin-space">&nbsp;</div>
        <div class="<?=strtolower($moduleName)?>-data">
         
        <?=inputDropDownStyle('status','','percent','','')?>
            </div>

        <div class="inputs-button-container">
            <input type="hidden" id='ppid' name="ppid" value="<?=$_REQUEST['ppid']?>"/>
            <Button class="button" type="button" onClick="window.location='?pr=<?=base64_encode('./pages/'.strtolower($moduleName).'s/index.php')?>'" >Back to <?=translateText($moduleName.'s');?></Button>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="sendEmailModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="sendEmailModal" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="sendEmailModalLabel">Send Message:
                <p class="fs-4">
                    <b>
                        <spam id="advertiser_contact_name"></spam> <br/>- (<spam id="advertiser_contact_email"></spam>)
                    </b>
                </p> 

            </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
        <form name="frmSendMail">
                <div class="form-group">
                    <div class="form-row">
                        <div class="col">
                            <label for="language" class="col-form-label"><?=translateText('language')?>:</label>
                            <SELECT name="option" id="language-option" onchange="changeMessageLanguage(this.value,document.getElementById('aname').value);">
                                <OPTION value="esp">Español</OPTION>
                                <OPTION value="ptbr">Português Brasileiro</OPTION>
                                <OPTION value="eng">English</OPTION>
                            </SELECT>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col">
                            <label for="bodyText" class="col-form-label"><?=translateText('message')?>: <i>(min 10 chars)</i></label>
                            <div class="editor" id="bodyText" style="padding:2rem; border: 1px solid gray; border-radius:1.2rem;">
                                <?=$invite_body_esp?>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="ppid" value="<?=$_REQUEST['ppid']?>" />
                <input type="hidden" id="aemail" name="aemail" value="" />
                <input type="hidden" id="aname" name="aname" value="" />
                <input type="hidden" id="bodytext-html" name="bodytext" value="" />
                
                <input type="hidden" name="uid" value="<?=$_COOKIE['uuid']?>" />
                <input type="hidden" name="tku" value="<?=$_COOKIE['tk']?>" />
            </form>
        </div>
        <div class="modal-footer">
            <span role="button" class="btn btn-secondary material-symbols-outlined" data-dismiss="modal" title="Close window">Close</span>
            <span role="button" class="btn btn-dark  material-symbols-outlined" title="Copy Message">content_copy</span>
            <span role="button" class="btn btn-success  material-symbols-outlined" id="modal-sendbutton" title="Send Message" >send</span>
        </div>
        </div>
    </div>
</div>
<script>
    // SendMail Modal 
    $('#sendEmailModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget) // Button that triggered the modal
      var action = button.data('whatever') // Extract info from data-* attributes
      // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
      // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
      var modal = $(this)
      //modal.find('.modal-title').text(action + ' Message:');
    // modal.find('.modal-body input').val(recipient)
    });

    document.getElementById('modal-sendbutton').classList.remove('disabled');


    $(document).ready(function() {
    $('.editor').notebook({
    autoFocus: false,
    placeholder: 'Your text here...',
    mode: 'multiline', // // multiline or inline
    modifiers: ['bold', 'italic', 'underline', 'h1', 'h2', 'ol', 'ul', 'anchor']});
    });


</script>