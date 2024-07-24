<?php
// ini_set('error_reporting', E_ALL);
// ini_set('display_errors', true);


$moduleName = 'Message';

?>
<link rel="stylesheet" href="<?=$dir?>./assets/css/<?=$moduleName?>.css">
<link rel="stylesheet" href="<?=$dir?>./assets/css/Inputs.css">
<link rel="stylesheet" href="<?=$dir?>./assets/css/RecoveryLink.css">
<link rel="stylesheet" href="<?=$dir?>./assets/css/Button.css">
<script src="<?=$dir?>./assets/js/<?=strtolower($moduleName)?>.js" type="text/javascript"></script>

<div class='form-<?=strtolower($moduleName)?>-container'>
    <div class="form-container">
        <div class="form-header"><?=translateText('new');?> <?=translateText('message_templates')?></div>
        <form name='<?=strtolower($moduleName)?>' method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
            <div class="inputs-form-container">
                <div class="form-row" >
                    <div class="col">
                        <label for="module_name"><?=ucfirst(translateText('module_name'));?></label>
                        <spam id="smodule_name">
                            <select name="module_name" id="module_name" title="module_name" class="form-control" autocomplete="module_name" required>
                                <option value="0"><?=ucfirst(translateText('choose'));?> <?=translateText('module_name')?></option>
                                <option value="proposals"><?=ucfirst(translateText('proposals'))?></option>
                                <option value="providers"><?=ucfirst(translateText('providers'))?></option>
                            </select>
                        </spam>
                    </div>
                    <div class="col-8">
                        <label for="template_name"><?=ucfirst(translateText('messagetemplate_name'));?></label>
                        <input
                        required
                        name ='template_name' 
                        id ='template_name' 
                        placeholder='<?=ucfirst(translateText('messagetemplate_name'));?>'
                        title = 'template_name'
                        value=''
                        class="form-control" 
                        type="text" 
                        maxlength="40"
                        autocomplete="template_name"
                        />
                    </div>
                </div>
                <div class="row">&nbsp;</div>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <input type="radio" name="default_text" value="esp" title="Default plantilla en Español" aria-label="Default Text" checked>
                            </div>
                        </div>
                        <div class="col">
                            <label for="template_text_esp" class="col-form-label"><?=ucfirst(translateText('template_text'))?> (Español): <i>(min 10 chars)</i></label>
                            <div class="editor1" id="editor_template_text_esp" style="padding:2rem; border: 1px solid gray; border-radius:1.2rem;">
                            </div>
                            <input type="hidden" name="template_text_esp" id="template_text_esp" value="" />
                        </div>
                    </div>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <input type="radio"  name="default_text" value="eng" title="Default English Text" aria-label="Default Text">
                            </div>
                        </div>
                        <div class="col">
                            <label for="template_text_esp" class="col-form-label"><?=ucfirst(translateText('template_text'))?> (English): <i>(min 10 chars)</i></label>
                            <div class="editor2" id="editor_template_text_eng" style="padding:2rem; border: 1px solid gray; border-radius:1.2rem;">
                            </div>
                            <input type="hidden" name="template_text_eng" id="template_text_eng" value="" />
                        </div>
                    </div>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <input type="radio"  name="default_text" value="ptbr" title="Default Texto em Português Brasil" aria-label="Default Text">
                            </div>
                        </div>
                        <div class="col">
                            <label for="template_text_ptbr" class="col-form-label"><?=ucfirst(translateText('template_text'))?> (Português Brasileiro): <i>(min 10 chars)</i></label>
                            <div class="editor3" id="editor_template_text_ptbr" style="padding:2rem; border: 1px solid gray; border-radius:1.2rem;">
                            </div>
                            <input type="hidden" name="template_text_ptbr" id="template_text_ptbr" value="" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="inputs-button-container">
                <button class="button" name="btnSave" type="button" onClick="handleSubmit(<?=strtolower($moduleName)?>)" ><?=ucfirst(translateText('save'));?></button>
            </div>
        </form>
      <?php
      if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    $myIP     = $ip;
    //$region   = geoip_country_code_by_name($myIP);
    // echo "IP: ".$myIP."<BR/>Region: ".$region;



      ?>
    </div>    
</div>

<script type="text/javascript">
    default_placeholder = 'Your text here...'
    if(ulang == "esp")
        default_placeholder = 'Su texto aquí...'
    if(ulang == "ptbr")
        default_placeholder = 'Seu texto aqui...'

    $(document).ready(function() {
    $('.editor1').notebook({
    autoFocus: false,
    placeholder: default_placeholder,
    mode: 'multiline', // // multiline or inline
    modifiers: ['bold', 'italic', 'underline', 'h1', 'h2', 'ol', 'ul', 'anchor']});
    });

    $(document).ready(function() {
    $('.editor2').notebook({
    autoFocus: false,
    placeholder: default_placeholder,
    mode: 'multiline', // // multiline or inline
    modifiers: ['bold', 'italic', 'underline', 'h1', 'h2', 'ol', 'ul', 'anchor']});
    });

    $(document).ready(function() {
    $('.editor3').notebook({
    autoFocus: false,
    placeholder: default_placeholder,
    mode: 'multiline', // // multiline or inline
    modifiers: ['bold', 'italic', 'underline', 'h1', 'h2', 'ol', 'ul', 'anchor']});
    });

    //changeMessageLanguage('esp',document.getElementById('pname').value,document.getElementById('plink').value);

  </script>