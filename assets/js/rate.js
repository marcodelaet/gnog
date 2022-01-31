lang = "es-MX";

function getCurrencyValue(base,to,value,localSite){
    if(base != to){
        errors      = 0;
        authApi     = 'dasdasdkasdeewef';
        message     = '';
    
        querystring = new Array('&base='+base+'&to='+to+'&value='+value);
    
        for(i=0;i<value.length;i++){
            value = value.replace(",","").replace(".","").replace(base,'').replace('$','').replace(' ','');
        }
        valueArray  = value.split("---");
        //alert(valueArray);
        if(valueArray.length > 1){
            for(i=0;i<valueArray.length;i++){
                querystring[i] = '&index='+i+'&base='+base+'&to='+to+'&value='+((valueArray[i])/100);
                //alert(querystring[i]);
            }
        }
    
        locat       = window.location.hostname;
        if(locat.slice(-1) != '/')
            locat += '/';
    
        if(errors > 0){
            alert(message);
        } else{
            index = 0;
            for(j=0;j<querystring.length;j++){
                const requestURL = window.location.protocol+'//'+locat+'api/rates/auth_rate_get.php?auth_api='+authApi+querystring[j];
                setTimeout(function() {
                    
                  }, 1000);
                //alert(requestURL);
                const request = new XMLHttpRequest();
                request.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        // Typical action to be performed when the document is ready:
                        obj = JSON.parse(request.responseText);
                        // Create our number formatter.
                        var formatter = new Intl.NumberFormat(lang, {
                            style: 'currency',
                            currency: obj.to,
                            //maximumSignificantDigits: 2,
    
                            // These options are needed to round to whole numbers if that's what you want.
                            //minimumFractionDigits: 2, // (this suffices for whole numbers, but will print 2500.10 as $2,500.1)
                            //maximumFractionDigits: 0, // (causes 2500.99 to be printed as $2,501)
                        });
                        //alert(formatter.format(obj.newValue));
                        switch(localSite){
                            case 'dashboard':
                               // alert('show: '+index);
                                    document.getElementById('goal-'+index).innerHTML = formatter.format(obj.newValue);
                            break;
                            default:
        
                            break; 
                        }
                        index++;
                        document.getElementById('goal-currency').innerHTML = obj.to;
                        //form.btnSave.innerHTML = "Save";
                        //alert('Status: '+obj.status);
                        //window.location.href = '?pr=Li9wYWdlcy9wcm9wb3NhbHMvdGtwL2luZGV4LnBocA==';
                    }
                    else{
                        //form.btnSave.innerHTML = "Saving...";
                    }
                };
                request.open('GET', requestURL, true);
                //request.responseType = 'json';
                request.send();
            }
        }
    }
}

function updateCurrencyListValue(base,to,value,localSite){
    errors      = 0;
    authApi     = 'dasdasdkasdeewef';
    message     = '';

    // starting variable
    querystring = new Array('&base='+base+'&to='+to+'&value='+value);
    valueArray      = [];
    currencyArray   = [];


    // getting values to convertion
    for(indexOfValues=0;indexOfValues < value.length;indexOfValues++){
        // forcing parse in INT
        currencyArray.push(base[indexOfValues].innerHTML);
        valueArray.push(value[indexOfValues].innerHTML.replace(",","").replace(".","").replace(currencyArray[indexOfValues],'').replace('$','').replace(' ','').replace('&nbsp;',''));
    }
    
    //alert(valueArray[0]);
    //alert(valueArray);
    if(valueArray.length > 1){
        for(i=0;i<valueArray.length;i++){
            querystring[i] = '&index='+i+'&base='+currencyArray[i]+'&to='+to+'&value='+((valueArray[i])/100);
            
            //alert(querystring[i]);
        }
    }

    locat       = window.location.hostname;
    if(locat.slice(-1) != '/')
        locat += '/';

    if(errors > 0){
        alert(message);
    } else{
        indexx = 0;
        for(j=0;j<querystring.length;j++){
            if(currencyArray[j] != to){
                const requestURL = window.location.protocol+'//'+locat+'api/rates/auth_rate_get.php?auth_api='+authApi+querystring[j];
                setTimeout(function() {
                    
                  }, 1000);
                //alert(requestURL);
                const request = new XMLHttpRequest();
                request.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        // Typical action to be performed when the document is ready:
                        obj = JSON.parse(request.responseText);
                        // Create our number formatter.
                        var formatter = new Intl.NumberFormat(lang, {
                            style: 'currency',
                            currency: obj.to,
                            //maximumSignificantDigits: 2,
    
                            // These options are needed to round to whole numbers if that's what you want.
                            //minimumFractionDigits: 2, // (this suffices for whole numbers, but will print 2500.10 as $2,500.1)
                            //maximumFractionDigits: 0, // (causes 2500.99 to be printed as $2,501)
                        });
                        //alert(formatter.format(obj.newValue));
                        switch(localSite){
                            case 'dashboard':
                               // alert('show: '+indexx);
                                    document.getElementById('amount-'+indexx).innerHTML = formatter.format(obj.newValue);
                            break;
                            default:
        
                            break; 
                        }
                        document.getElementById('currency-'+indexx).innerHTML = obj.to;
                        indexx++;
                        //form.btnSave.innerHTML = "Save";
                        //alert('Status: '+obj.status);
                        //window.location.href = '?pr=Li9wYWdlcy9wcm9wb3NhbHMvdGtwL2luZGV4LnBocA==';
                    }
                    else{
                        //form.btnSave.innerHTML = "Saving...";
                    }
                };
                request.open('GET', requestURL, true);
                //request.responseType = 'json';
                request.send();
            }
        }
    }
}