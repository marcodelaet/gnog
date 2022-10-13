function handleLogin(form) {
    username    = form.username.value;
    password    = form.password.value;
    filters     = 'username='+username+'&password='+password;
    locat       = window.location.hostname;
    //alert(locat);
    if(locat.slice(-1) != '/')
        locat += '/';

       // alert(locat);

    const requestURL = window.location.protocol+'//'+locat+'api/login/authentication.php';
    //alert(requestURL+'?'+filters);
    const request = new XMLHttpRequest();
    request.open('POST', requestURL,true);
    request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    request.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            // Typical action to be performed when the document is ready:
            obj = JSON.parse(request.responseText);
            if(obj.status === 'error'){
                alert('username or password incorrect!');
                form.password.value = '';
            }
            else{
                //console.log(obj);
                // save token on LS
                localStorage.setItem('tokenGNOG', obj.token);
                localStorage.setItem('uuid', obj[0].uuid);
                localStorage.setItem('ulang', obj[0].user_language);
                localStorage.setItem('lacc', obj[0].level_account);

                var d = new Date();
                d.setTime(d.getTime() + (1*24*60*60*1000));
                var expires = "expires="+ d.toUTCString();
                document.cookie = 'tk' + "=" + obj.token+ ";" + expires + ";path=/";
                document.cookie = 'uuid' + "=" + obj[0].uuid+ ";" + expires + ";path=/";
                document.cookie = 'ulang' + "=" + obj[0].user_language+ ";" + expires + ";path=/";
                document.cookie = 'lacc' + "=" + obj[0].level_account+ ";" + expires + ";path=/";

                window.location.href = '?pr=Li9wYWdlcy9kYXNoYm9hcmQvaW5kZXgucGhw';
            }
        }
    };

    //request.responseType = 'json';
    request.send(filters);
}

function handleRecovery() {
    window.location.href = '?pr=Li9wYWdlcy91c2Vycy9yZWNvdmVyeS9pbmRleC5waHA=';
}