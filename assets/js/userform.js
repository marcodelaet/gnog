var csrf_token = $('meta[name="csrf-token"]').attr('content');
//alert(csrf_token);

function handleSubmit(form) {
    if (form.username.value !== '' && form.email.value !== '' && form.mobile.value !== '' && form.password.value !== '' && form.retype_password.value !== '') {
        //form.submit();
        errors      = 0;
        authApi     = 'dasdasdkasdeewef';
        username    = form.username.value;
        email       = form.email.value;
        mobile_ddi  = document.getElementsByClassName('iti__selected-flag')[0].title.split(':')[1].replace(' ','').replace('+','');
        mobile      = form.mobile.value;
        password    = form.password.value;
        password2   = form.retype_password.value;
        locat       = window.location.hostname;
        if(locat.slice(-1) != '/')
            locat += '/';

        if(password != password2)
        {
            errors++;
            alert('Please, retype password exactly like in the password field');
        }

        if(errors > 0){

        } else{
            const requestURL = window.location.protocol+'//'+locat+'api/users/auth_user_add_new.php?auth_api='+authApi+'&username='+username+'&email='+email+'&mobile_international_code='+mobile_ddi+'&mobile_number='+mobile+'&password='+password;
            
            const request = new XMLHttpRequest();
            request.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                   // Typical action to be performed when the document is ready:
                   obj = JSON.parse(request.responseText);
                   form.btnSave.innerHTML = "Save";
                   //alert('Status: '+obj.status);
                   window.location.href = '?pr=Li9wYWdlcy91c2Vycy90a3AvaW5kZXgucGhw';
                }
                else{
                    form.btnSave.innerHTML = "Saving...";
                }
            };
            request.open('GET', requestURL);
            //request.responseType = 'json';
            request.send();
        }
    } else
        alert('Please, fill all required fields (*)');
}


function handleEditSubmit(tid,form) {
    if (form.username.value !== '' && form.email.value !== '' && form.mobile.value !== '') {
        //form.submit();
        errors      = 0;
        authApi     = 'dasdasdkasdeewef';
        filters     = '&tid='+tid;
        email       = form.email.value;
        if(email !== ''){
            filters     += '&email='+email;
        }
        mobile_ddi  = form.mobile_ddi.value;
        if(mobile_ddi !== ''){
            filters     += '&mobile_ddi='+mobile_ddi.replace(' ','');
        }
        mobile      = form.mobile.value;
        if(mobile !== ''){
            filters     += '&mobile='+mobile;
        }
        password    = form.password.value;
        password2   = form.retype_password.value;
        locat       = window.location.hostname;
        if(locat.slice(-1) != '/')
            locat += '/';

        if(password != password2){
            errors++;
            alert('Please, retype password exactly like in the password field');
        }
        else{
            if(password !== ''){
                filters     += '&password='+password;
            }
        }

        if(errors > 0){

        } else{
            const requestURL = window.location.protocol+'//'+locat+'api/users/auth_user_edit.php?auth_api='+authApi+filters;
            
            const request = new XMLHttpRequest();
            request.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                   // Typical action to be performed when the document is ready:
                   obj = JSON.parse(request.responseText);
                   form.btnSave.innerHTML = "Save";
                   window.location.href = '?pr=Li9wYWdlcy91c2Vycy90a3BlZGl0L2luZGV4LnBocA==';
                   //alert('Status: '+obj.status);
                }
                else{
                    form.btnSave.innerHTML = "Saving...";
                }
            };
            request.open('GET', requestURL);
            //request.responseType = 'json';
            request.send();
        }
    } else
        alert('Please, fill all required fields (*)');
}

function handleOnLoad(tid,form) {
    errors      = 0;
    authApi     = 'dasdasdkasdeewef';
    locat       = window.location.hostname;

    filters     = '&tid='+tid;
  
    if(locat.slice(-1) != '/')
        locat += '/';

    if(errors > 0){

    } else{
        const requestURL = window.location.protocol+'//'+locat+'api/users/auth_user_get.php?auth_api='+authApi+filters;
        const request = new XMLHttpRequest();
        request.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                // Typical action to be performed when the document is ready:
                obj = JSON.parse(request.responseText);
                form.username.value     = obj[0].username;
                form.email.value        = obj[0].email;
                form.mobile_ddi.value   = obj[0].mobile_international_code.replace(" ","");
                form.mobile.value       = obj[0].mobile_number.replace(" ","");
            }
            else{
                //form.btnSave.innerHTML = "Searching...";
            }
        };
        request.open('GET', requestURL);
        //request.responseType = 'json';
        request.send();
    }
}

