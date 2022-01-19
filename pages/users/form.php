<?php
$username = null;
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
<link rel="stylesheet" href="<?=$dir?>./assets/css/UserForm.css">
<link rel="stylesheet" href="<?=$dir?>./assets/css/Inputs.css">
<link rel="stylesheet" href="<?=$dir?>./assets/css/RecoveryLink.css">
<link rel="stylesheet" href="<?=$dir?>./assets/css/Button.css">
<script src="<?=$dir?>./assets/js/userform.js" type="text/javascript"></script>

<div class='form-user-container'>
    <div class="form-container">
        <div class="form-header">New User</div>
        <form name='user' method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
            <div class="inputs-form-container">
                <div class="form-row">
                    <div class="col">
                        <label for="username">Username</label>
                        <input
                        required
                        name ='username' 
                        placeholder='Username'
                        title = 'username'
                        value='<?=$username?>'
                        class="form-control" 
                        type="text" 
                        maxlength="30"
                        autocomplete="username"
                        />
                        <div class="invalid-feedback">
                            Please choose a username.
                        </div>
                    </div>
                </div>
                <div class="form-row" style="margin-top:1rem">
                    <div class="col">
                        <label for="email">E-mail</label>
                        <input
                        required
                        name ='email' 
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
                        <label for="mobile">Mobile N&ordm;</label><br/>
                        <input
                        id  = 'mobile'
                        name ='mobile' 
                        placeholder="Area Code + Number"
                        title = 'Mobile N&ordm;'
                        value='<?=$mobile?>'
                        class="form-control" 
                        type="tel" 
                        maxlength="12"
                        pattern="[0-9]{3}-[0-9]{2}-[0-9]{3}"
                        autocomplete="phone"
                        />
                        <div class="invalid-feedback">
                            Please type a valid mobile number.
                        </div>
                    </div>
                </div>
                <div class="form-row" style="margin-top:1rem">
                    <div class="col">
                        <label for="password">Password</label>
                        <input 
                        required
                        name ='password'
                        placeholder="*******"
                        title = 'Password'
                        value='<?=$password?>'
                        class="form-control" 
                        type="password" 
                        autocomplete="new-password"
                        />
                        <div class="invalid-feedback">
                            Please type a valid password
                        </div>
                    </div>
                    <div class="col">
                        <label for="retype_password">Retype Password</label>
                        <input 
                        required
                        name ='retype_password'
                        placeholder="*******"
                        title = 'Retype Password'
                        value='<?=$password?>'
                        class="form-control" 
                        type="password" 
                        autocomplete="new-password"
                        />
                        <div class="invalid-feedback">
                            Passwords must be the same
                        </div>
                    </div>
                </div>
            </div>
            <div class="inputs-button-container">
                <button class="button" name="btnSave" type="button" onClick="handleSubmit(user)" >Save</button>
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
    var input = document.querySelector("#mobile");
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


