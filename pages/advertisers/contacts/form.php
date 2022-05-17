<?php
$moduleName = $_REQUEST['md'];
$subModuleName = 'Contact';
?>
<link rel="stylesheet" href="<?=$dir?>./assets/css/<?=$subModuleName?>.css">
<link rel="stylesheet" href="<?=$dir?>./assets/css/Inputs.css">
<link rel="stylesheet" href="<?=$dir?>./assets/css/RecoveryLink.css">
<link rel="stylesheet" href="<?=$dir?>./assets/css/Button.css">
<script src="<?=$dir?>./assets/js/<?=strtolower($subModuleName)?>.js" type="text/javascript"></script>

<div class='form-<?=strtolower($subModuleName)?>-container'>
    <div class="form-container">
        <div class="form-header">New <?=$subModuleName?> for <?=$moduleName?></div>
        <form name='<?=strtolower($moduleName)?>_<?=strtolower($subModuleName)?>' method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
            <div class="form-row <?=strtolower($subModuleName)?>-section">
                <div class="col">
                    <!--<div id="<?=strtolower($subModuleName)?>-section" class="<?=strtolower($subModuleName)?>-section-block">-->
                    <div id="<?=strtolower($subModuleName)?>-section">
                        <div id="<?=strtolower($subModuleName)?>_0">
                            <div class="form-row" >
                                <div class="col">
                                    <label for="<?=strtolower($subModuleName)?>_name[]">Name</label>
                                    <input
                                    required
                                    name ='<?=strtolower($subModuleName)?>_name[]' 
                                    placeholder='Name'
                                    title = 'Name'
                                    class="form-control" 
                                    type="name" 
                                    />
                                    <div class="invalid-feedback">
                                        Please type the name of <?=strtolower($subModuleName)?>.
                                    </div>
                                </div>
                                <div class="col">
                                    <label for="<?=strtolower($subModuleName)?>_surname[]">Last name</label>
                                    <input
                                    required
                                    name ='<?=strtolower($subModuleName)?>_surname[]' 
                                    placeholder='Last name'
                                    title = 'Last name'
                                    class="form-control" 
                                    type="surname" 
                                    />
                                    <div class="invalid-feedback">
                                        Please type the last name of <?=strtolower($subModuleName)?>.
                                    </div>
                                </div>
                            </div>
                            <div class="form-row" >
                                <div class="col">
                                    <label for="<?=strtolower($subModuleName)?>_email[]">E-mail</label>
                                    <input
                                    required
                                    name ='<?=strtolower($subModuleName)?>_email[]' 
                                    placeholder='name@server.com'
                                    title = 'E-mail'
                                    class="form-control" 
                                    type="email" 
                                    />
                                    <div class="invalid-feedback">
                                        Please type a valid email.
                                    </div>
                                </div>
                                <div class="col">
                                    <label for="phone[]">Phone N&ordm;</label><br/>
                                    <input
                                    id='phone'
                                    name ='phone[]' 
                                    placeholder="Area Code + Number"
                                    title = 'Phone N&ordm;'
                                    value=''
                                    class="form-control" 
                                    type="tel" 
                                    maxlength="12"
                                    pattern="[0-9]{3}-[0-9]{2}-[0-9]{3}"
                                    autocomplete="phone"
                                    />
                                    <div class="invalid-feedback">
                                        Please type a valid phone number.
                                    </div>
                                </div>
                            </div>
                            <div class="form-row" >
                                <div class="col">
                                    <label for="<?=strtolower($subModuleName)?>_position[]">Position</label>
                                    <input
                                    required
                                    name ='<?=strtolower($subModuleName)?>_position[]' 
                                    placeholder='Position of the <?=strtolower($subModuleName)?>'
                                    title = 'Position'
                                    class="form-control" 
                                    type="position" 
                                    />
                                    <div class="invalid-feedback">
                                        Please type the position / role of the <?=strtolower($subModuleName)?>.
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col">
                                    &nbsp;
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-row" >
                        <div class="col" style="text-align:right;">
                            <button class="btn-primary material-icons-outlined" type="button" title="Add form spot to a new <?=strtolower($subModuleName)?>" onclick="newContactForm('<?=strtolower($subModuleName)?>-section','<?=strtolower($subModuleName)?>-new');">add_circle_outline</button>
                        </div>
                    </div>
                    <div id="<?=strtolower($subModuleName)?>-new">
                        <div class="form-row">
                            <div class="col">
                                &nbsp;
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col">
                            <input type="hidden" name="ElementID" value="<?=$_GET['tid']?>"/>
                            <input type="hidden" name="auth_api" value=csrf_token />
                            <input type="hidden" name="phone_ddi" value="000" />
                        </div>
                    </div>
                    <div class="inputs-button-container">
                        <button class="button" name="btnSave" type="button" onClick="addContact(<?=strtolower($moduleName)?>_<?=strtolower($subModuleName)?>,'<?=strtolower($moduleName)?>')" >Save</button>
                    </div>
                </div>
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

<script>
    var input = document.querySelector("#phone");
    window.intlTelInput(input, {
      // allowDropdown: false,
      // autoHideDialCode: false,
      // autoPlaceholder: "off",
      // dropdownContainer: document.body,
      // excludeCountries: ["us"],
      // formatOnDisplay: false,
      // geoIpLookup: function(callback) {
      //   $.get("http://ipinfo.io", function() {}, "jsonp").always(function(resp) {
      //     var countryCode = (resp && resp.country) ? resp.country : "";
      //     callback(countryCode);
      //   });
      // },
      // hiddenInput: "full_number",
      initialCountry: "mx",
      // localizedCountries: { 'de': 'Deutschland' },
      // nationalMode: false,
      // onlyCountries: ['us', 'gb', 'ch', 'ca', 'do'],
      // placeholderNumberType: "MOBILE",
       preferredCountries: ['mx', 'br', 'us'],
      // separateDialCode: true,
      utilsScript: "/assets/js/build/utils.js",
    });/*
$("input").intlTelInput({
    utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/8.4.6/js/utils.js"
  });*/
</script>
    </div>    
</div>


