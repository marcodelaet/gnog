<?php 
$moduleName = 'Provider'; 

$user_fullname= "Teste";
$personal_url_to_register = "URLYRLURLURLURL";

$invite_body_esp = "lalalala";


?>
<link rel="stylesheet" href="<?=$dir?>./assets/css/<?=$moduleName?>.css">
<link rel="stylesheet" href="<?=$dir?>./assets/css/Inputs.css">
<link rel="stylesheet" href="<?=$dir?>./assets/css/Button.css">
<script src="<?=$dir?>./assets/js/<?=strtolower($moduleName)?>.js" type="text/javascript"></script>
<?php if(array_key_exists('pid',$_REQUEST)){ ?>
<script>
    handleViewOnLoad("<?=$_REQUEST['pid']?>");
    handleLoadProposals("<?=$_REQUEST['pid']?>");
</script>
<?php } ?>
<div class="card bg-light mb-3" id="<?=strtolower($moduleName)?>-card">
    <div class="card-header">
        <div class="<?=strtolower($moduleName)?>-header">
            <div class="photo-container" >
                <img class="<?=strtolower($moduleName)?>-photo" id="<?=strtolower($moduleName)?>-proto-<?=$_REQUEST['pid']?>" src="/public/<?=strtolower($moduleName)?>/images/logo_example.png" style="background-color:#FFF"/>
            </div>
            <div class="<?=strtolower($moduleName)?>-main" >
                <spam id="<?=strtolower($moduleName)?>_name"><?=$moduleName?></spam>
                <spam class="<?=strtolower($moduleName)?>-group" id="webpage"></spam>
            </div>
        </div>
    </div>
    <div class="card-body <?=strtolower($moduleName)?>-body-proposals">
        <div class="row">
            <div class="col-md-10">
                <h5 class="card-title main-proposals-header">Proposals</h5> 
            </div>
            <div class="col-md-2">
                <a href="?pr=<?=base64_encode('./pages/providers/proposal/addform.php')?>&pid=<?=$_REQUEST['pid']?>"><span class="material-icons" style="font-size: 1.2rem;">add_business</span></a> 
            </div>
        </div>
        <div id="list-proposals">
            <div class="space-blank">&nbsp;</div>
            <div class="<?=strtolower($moduleName)?>-data">
                <spam id="card-proposal-name">
                    <li>Offer Name 1</li>
                    <li>Offer Name 2</li>

                </spam>
            </div>
        </div>
    </div>
    <div class="card-body <?=strtolower($moduleName)?>-body-contacts">
        <h5 class="card-title main-contact-header">Contact</h5> 
        <div class="<?=strtolower($moduleName)?>-data">
            <spam class="material-icons icon-data">location_on</spam>
            <spam id="card-address">99, example, street</spam>
        </div>
        <div id="list-contacts">
            <div class="space-blank">&nbsp;</div>
            <div class="<?=strtolower($moduleName)?>-data">
                <spam id="card-contact-fullname-and-position">aaaaaa bbbbbb da xxxx (zzzzz)</spam>
            </div>
            <div class="<?=strtolower($moduleName)?>-data">
                <spam class="material-icons icon-data">email</spam>
                <spam id="card-email">email@dma.com</spam>
            </div>
            <div class="<?=strtolower($moduleName)?>-data">
                <spam class="material-icons icon-data">phone</spam>
                <spam id="card-phone">+5255999999</spam>
            </div>
        </div>
        <div class="spaces">&nbsp;</div>
        <div class="download-pdf-file">
            <spam class="material-icons icon-data">picture_as_pdf</spam>
            <a href="/public/providers_1.2_202306-es.pdf" target="_blank"><spam class="pdf-file-es">Plataforma de Facturas - Manual (en Español)</spam></a>
        </div>
        <div class="download-pdf-file">
            <spam class="material-icons icon-data">picture_as_pdf</spam>
            <a href="/public/providers_1.2_202306-ptBR.pdf" target="_blank"><spam class="pdf-file-ptBR">Plataforma de Faturas - Manual (em Portugues Brasil)</spam></a>
        </div>
        <div class="inputs-button-container">
            <Button class="button" type="button" onClick="window.location='?pr=<?=base64_encode('./pages/'.strtolower($moduleName).'s/index.php')?>'" >Back to <?=$moduleName?>s</Button>
        </div>
    </div>
</div>


<div class="modal fade" id="sendmailModal" tabindex="-1" aria-labelledby="sendmailModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="sendmailModalLabel"> <?=translateText('send_user_crt_url_to')?>: 
            <p>
                <b>
                    <spam id="provider_contact_name"></spam> - (
                    <spam id="provider_contact_email"></spam>)
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
                            <SELECT name="option" id="language-option" onchange="changeMessageLanguage(this.value,document.getElementById('pname').value,document.getElementById('plink').value);">
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
                <input type="hidden" name="pid" value="<?=$_REQUEST['pid']?>" />
                <input type="hidden" id="pemail" name="pemail" value="" />
                <input type="hidden" id="pname" name="pname" value="" />
                <input type="hidden" id="plink" name="plink" value="" />
                <input type="hidden" id="bodytext-html" name="bodytext" value="" />
                
                <input type="hidden" name="uid" value="<?=$_COOKIE['uuid']?>" />
                <input type="hidden" name="tku" value="<?=$_COOKIE['tk']?>" />
            </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?=translateText('close')?></button>
        <button type="button" id="sendbutton" class="btn btn-primary" onclick="this.disabled = true; document.getElementById(this.id).innerText='<?=translateText('sent')?>'; sendmailToProviderContact(frmSendMail);"><?=translateText('send_message')?></button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
    $('.editor').notebook({
    autoFocus: false,
    placeholder: 'Your text here...',
    mode: 'multiline', // // multiline or inline
    modifiers: ['bold', 'italic', 'underline', 'h1', 'h2', 'ol', 'ul', 'anchor']});
    });

    //changeMessageLanguage('esp',document.getElementById('pname').value,document.getElementById('plink').value);

  </script>