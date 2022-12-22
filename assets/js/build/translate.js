function translateText(code,toLanguage){
    errors      = 0;
    authApi     = csrf_token;
    locat       = window.location.hostname;

    $querystring = '&fcn=translateInLanguage&dir=../.'+'&code='+code+'&lng='+toLanguage;

    if(locat.slice(-1) != '/')
        locat += '/';

    const requestURL = window.location.protocol+'//'+locat+'assets/lib/translation.php?auth_api='+authApi+$querystring;
    console.log(requestURL);
    const request = new XMLHttpRequest();
    request.onreadystatechange = function() {
        //console.log(this.readyState + '/n' + this.status);
        if (this.readyState == 4 && this.status == 200) {
            // Typical action to be performed when the document is ready:
            xobj = JSON.parse(request.responseText);
            if(xobj.response == 'OK'){
                xresponse = xobj.translation;
                //alert(xresponse);
            } else {
                xresponse = 'Error';
            }
        }
    };
    request.open('GET', requestURL,false);
    //request.responseType = 'json';
    request.send();
    return (xresponse);
}