<?php
$moduleName = 'Advertiser';
$advertiser = null;
$password = null;
$email    = null;
$mobile   = null;

if(array_key_exists('username',$_POST))
{
  $username = $_POST['username'];
  $email    = $_POST['email'];
  $mobile   = $_POST['mobile'];
}



?>
<link rel="stylesheet" href="<?=$dir?>./assets/css/<?=$moduleName?>.css">
<link rel="stylesheet" href="<?=$dir?>./assets/css/Inputs.css">
<link rel="stylesheet" href="<?=$dir?>./assets/css/RecoveryLink.css">
<link rel="stylesheet" href="<?=$dir?>./assets/css/Button.css">
<script src="<?=$dir?>./assets/js/<?=strtolower($moduleName)?>.js" type="text/javascript"></script>

<div class='form-<?=strtolower($moduleName)?>-container'>
    <div class="form-container">
        <div class="form-header">New <?=$moduleName?></div>
        <form name='<?=strtolower($moduleName)?>' method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
            <div class="inputs-form-container">
                <div class="form-row">
                    <div class="col custom-control custom-switch" style="text-align:right;">
                        <input type="checkbox" class="custom-control-input" id="customSwitch1" name="agency">
                        <label class="custom-control-label" for="customSwitch1">Is Agency</label>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col">
                        <label for="corporate_name">Corporate name</label>
                        <input
                        required
                        name ='corporate_name' 
                        placeholder='Corporate name'
                        title = 'corporate_name'
                        value='<?=$advertiser?>'
                        class="form-control" 
                        type="text" 
                        maxlength="40"
                        autocomplete="corporate_name"
                        />
                        <div class="invalid-feedback">
                            Please type the Corporate name
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col">
                        <label for="address">Address</label>
                        <textarea
                        required
                        name ='address' 
                        placeholder='99, Address - City - Country - Postal Code'
                        title = 'address'
                        value=''
                        class="form-control"  
                        autocomplete="address"
                        ></textarea>
                        <div class="invalid-feedback">
                            Please type the Address of the <?=$moduleName?>
                        </div>
                    </div>
                </div>
                <div class="form-row main-contact-section">
                    <div class="col">
                        <div class="form-row" >
                            <div class="col main-contact-header">
                                Main Contact
                            </div>
                        </div>
                        <div class="form-row" >
                            <div class="col">
                                <label for="main_contact_name">Name</label>
                                <input
                                required
                                name ='main_contact_name' 
                                placeholder='Name of main contact'
                                title = 'Name of main contact'
                                value=''
                                class="form-control" 
                                type="name" 
                                />
                                <div class="invalid-feedback">
                                    Please type the name of main contact.
                                </div>
                            </div>
                            <div class="col">
                                <label for="main_contact_surname">Last name</label>
                                <input
                                required
                                name ='main_contact_surname' 
                                placeholder='Last name of main contact'
                                title = 'Last name of main contact'
                                value='<?=$email?>'
                                class="form-control" 
                                type="surname" 
                                />
                                <div class="invalid-feedback">
                                    Please type the last name of main contact.
                                </div>
                            </div>
                        </div>
                        <div class="form-row" >
                            <div class="col">
                                <label for="main_contact_email">E-mail</label>
                                <input
                                required
                                name ='main_contact_email' 
                                placeholder='name@server.com'
                                title = 'E-mail'
                                value='<?=$email?>'
                                class="form-control" 
                                type="email" 
                                />
                                <div class="invalid-feedback">
                                    Please type a valid email.
                                </div>
                            </div>
                            <div class="col">
                                <label for="phone">Phone N&ordm;</label><br/>
                                <input
                                id='phone'
                                name ='phone' 
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
                                <label for="main_contact_position">Position</label>
                                <input
                                required
                                name ='main_contact_position' 
                                placeholder='Position of the main contact'
                                title = 'Position'
                                value='<?=$email?>'
                                class="form-control" 
                                type="position" 
                                />
                                <div class="invalid-feedback">
                                    Please type the position / role of the main contact.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="inputs-button-container">
                <button class="button" name="btnSave" type="button" onClick="handleSubmit(<?=strtolower($moduleName)?>)" >Save</button>
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


