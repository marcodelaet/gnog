langTransl  = localStorage.getItem('ulang');
localLang   = 'en';
switch(langTransl){
    case 'ptbr':
        localLang   = 'pt';
        break;
    case 'esp':
        localLang   = 'es';
        break;
    
}
//setting user language to the HTML 
document.getElementsByTagName('html')[0].setAttribute('lang',localLang);

function translateText(code,toLanguage){
    errors      = 0;
    authApi     = csrf_token;
    locat       = window.location.hostname;

    querystring = '&fcn=translateInLanguage&dir=../.'+'&code='+code+'&lng='+toLanguage;

    if(locat.slice(-1) != '/')
        locat += '/';

    const requestURL = window.location.protocol+'//'+locat+'assets/lib/translation.php?auth_api='+authApi+querystring;
    //console.log(requestURL);
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

async function copyStringToClipboard(text) {
    try {
        await navigator.clipboard.writeText(text);
        alert(translateText('copied_to_clipboard',language));
    } catch (error) {
        console.error(error.message);
    }
}


function xmlReader (objFile,fieldName) {
    errors      = 0;
    authApi     = csrf_token;
    locat       = window.location.hostname;

    //querystring = '&fcn=xmlReader&dir=../.'+'&code='+code+'&lng='+toLanguage;
    var formData = new FormData();
    formData.append("file_field_name",fieldName)
    formData.append(fieldName, objFile);

    if(locat.slice(-1) != '/')
        locat += '/';

    const requestURL = window.location.protocol+'//'+locat+'assets/lib/xmlreader.php';
    //console.log(requestURL);
    const request = new XMLHttpRequest();
    request.onreadystatechange = function() {
        //console.log(this.readyState + '/n' + this.status);
        if (this.readyState == 4 && this.status == 200) {
            // Typical action to be performed when the document is ready:
            xobj = request.responseXML;
            //if(xobj.response == 'OK'){
                xresponse = xobj;
                console.log(xresponse);
                //alert(xresponse);
            //} else {
            //    xresponse = 'Error';
            //}
        }
    };
    request.open('POST', requestURL);
    //request.responseType = 'json';
    request.send(formData);
    return (xresponse);
 }

/*
function copyStringToClipboard (str) {
    // Create new element
    var el = document.createElement('textarea');
    // Set value (string to be copied)
    el.value = str;
    // Set non-editable to avoid focus and move outside of view
    el.setAttribute('readonly', '');
    el.style = {position: 'absolute', left: '-9999px'};
    document.body.appendChild(el);
    // Select text inside element
    el.select();
    // Copy text to clipboard
    document.execCommand('copy');
    // Remove temporary element
    document.body.removeChild(el);
    language = localStorage.getItem('ulang');
    alert(translateText('copied_to_clipboard',language));
 }
*/

function ucfirst(word){
    return word.charAt(0).toUpperCase() + word.slice(1);
 }