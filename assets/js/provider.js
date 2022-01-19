document.getElementById('nav-item-providers').setAttribute('class',document.getElementById('nav-item-providers').getAttribute('class').replace(' active','') + ' active');
var csrf_token = $('meta[name="csrf-token"]').attr('content');
//alert(csrf_token);

function handleSubmit(form) {
    if (form.name.value !== '' && form.address.value !== '' && form.main_contact_email.value !== '' || product_id != '0' || salemodel_id != '0') {
        //form.submit();
        errors      = 0;
        authApi     = 'dasdasdkasdeewef';
        message     = '';

        xname                   = form.name.value;
        address                 = form.address.value;
        webpage_url             = form.webpage_url.value;
        main_contact_name       = form.main_contact_name.value;
        main_contact_surname    = form.main_contact_surname.value;
        main_contact_email      = form.main_contact_email.value;
        phone_ddi               = document.getElementsByClassName('iti__selected-flag')[0].title.split(':')[1].replace(' ','').replace('+','');
        phone                   = form.phone.value;
        main_contact_position   = form.main_contact_position.value;
        product_id              = form.product_id.value;
        if(product_id == '0'){
            message += 'Please, select a product!\n';
            errors++;
        }
        salemodel_id            = form.salemodel_id.value;
        if(salemodel_id == '0'){
            message += 'Please, select a sale model!\n';
            errors++;
        }
        product_price           = form.product_price.value;
        currency                = form.currency.value;

        locat       = window.location.hostname;
        if(locat.slice(-1) != '/')
            locat += '/';

        if(errors > 0){
            alert(message);
        } else{
            const requestURL = window.location.protocol+'//'+locat+'api/providers/auth_provider_add_new.php?auth_api='+authApi+'&name='+xname+'&webpage_url='+webpage_url+'&address='+address+'&main_contact_name='+main_contact_name+'&main_contact_surname='+main_contact_surname+'&main_contact_email='+main_contact_email+'&main_contact_name='+main_contact_name+'&phone_ddi='+phone_ddi+'&phone='+phone+'&main_contact_position='+main_contact_position+'&product_id='+product_id+'&salemodel_id='+salemodel_id+'&product_price='+product_price+'&currency='+currency;
            //alert(requestURL);
            const request = new XMLHttpRequest();
            request.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                   // Typical action to be performed when the document is ready:
                   obj = JSON.parse(request.responseText);
                   form.btnSave.innerHTML = "Save";
                   //alert('Status: '+obj.status);
                   window.location.href = '?pr=Li9wYWdlcy9wcm92aWRlcnMvdGtwL2luZGV4LnBocA==';
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
    if (form.name.value !== '' && form.address.value !== '' && form.main_contact_email.value !== '' || product_id != '0' || salemodel_id != '0') {
        //form.submit();
   
        errors      = 0;
        authApi     = 'dasdasdkasdeewef';
        
        sett     = '&tid='+tid;
        xname          = form.name.value;
        if(xname !== ''){
            sett     += '&name='+xname;
        }
        address                 = form.address.value;
        if(address !== ''){
            sett     += '&address='+address;
        }
        webpage_url             = form.webpage_url.value;
        if(webpage_url !== ''){
            sett     += '&webpage_url='+webpage_url;
        }
        main_contact_name       = form.main_contact_name.value;
        if(main_contact_name !== ''){
            sett     += '&main_contact_name='+main_contact_name;
        }
        main_contact_surname    = form.main_contact_surname.value;
        if(main_contact_surname !== ''){
            sett     += '&main_contact_surname='+main_contact_surname;
        }
        main_contact_email      = form.main_contact_email.value;
        if(main_contact_email !== ''){
            sett     += '&main_contact_email='+main_contact_email;
        }
        /*phone_ddi  = form.mobile_ddi.value;
        if(phone_ddi !== ''){
            sett     += '&phone_ddi='+phone_ddi.replace(' ','');
        }*/
        phone                   = form.phone.value;
        if(phone !== ''){
            sett     += '&phone='+phone.replace(" ","");
        }
        main_contact_position   = form.main_contact_position.value;
        if(main_contact_position !== ''){
            sett     += '&main_contact_position='+main_contact_position;
        }
        product_id                   = form.product_id.value;
        if(product_id !== ''){
            sett     += '&product_id='+product_id.replace(" ","");
        }
        salemodel_id                   = form.salemodel_id.value;
        if(salemodel_id !== ''){
            sett     += '&salemodel_id='+salemodel_id.replace(" ","");
        }
        product_price                   = form.product_price.value;
        if(product_price !== ''){
            sett     += '&product_price='+product_price.replace(" ","");
        }
        currency                   = form.currency.value;
        if(currency !== ''){
            sett     += '&currency='+currency.replace(" ","");
        }

        //console.log(sett);
        //alert('pausa');
        locat       = window.location.hostname;
        if(locat.slice(-1) != '/')
            locat += '/';

        if(errors > 0){
           
        } else{
            const requestURL = window.location.protocol+'//'+locat+'api/providers/auth_provider_edit.php?auth_api='+authApi+sett;
            console.log(requestURL);
            const request = new XMLHttpRequest();
            request.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                   // Typical action to be performed when the document is ready:
                   obj = JSON.parse(request.responseText);
                   form.btnSave.innerHTML = "Save";
                   window.location.href = '?pr=Li9wYWdlcy9wcm92aWRlcnMvdGtwZWRpdC9pbmRleC5waHA=';
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

function handleViewOnLoad(tid) {
    errors      = 0;
    authApi     = 'dasdasdkasdeewef';
    locat       = window.location.hostname;

    filters     = '&tid='+tid;

    if(locat.slice(-1) != '/')
        locat += '/';

    if(errors > 0){

    } else{
        const requestURL = window.location.protocol+'//'+locat+'api/providers/auth_provider_get.php?auth_api='+authApi+filters;
        //alert(requestURL);
        const request   = new XMLHttpRequest();
        position        = '*****';
        request.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                obj = JSON.parse(request.responseText);
                // Create our number formatter.
                var formatter = new Intl.NumberFormat('pt-BR', {
                    style: 'currency',
                    currency: obj[0].currency,
                    //maximumSignificantDigits: 2,

                    // These options are needed to round to whole numbers if that's what you want.
                    //minimumFractionDigits: 2, // (this suffices for whole numbers, but will print 2500.10 as $2,500.1)
                    //maximumFractionDigits: 0, // (causes 2500.99 to be printed as $2,501)
                });
                if(obj[0].main_contact_position!='')
                    position = obj[0].main_contact_position;
                document.getElementById('provider_name').innerHTML          = obj[0].name;
                document.getElementById('group').innerHTML                  = obj[0].webpage_url;
                document.getElementById('card-contact-fullname').innerHTML  = obj[0].main_contact_name + ' ' + obj[0].main_contact_surname
                document.getElementById('card-contact-position').innerHTML  = ' ('+position+')';
                document.getElementById('card-address').innerHTML           = obj[0].address;
                document.getElementById('card-email').innerHTML             = obj[0].main_contact_email;
                document.getElementById('card-phone').innerHTML             = '+'+obj[0].phone_international_code.replace(" ","") + obj[0].phone_number.replace(" ","");
                document.getElementById('card-product').innerHTML           = obj[0].product_name;
                document.getElementById('card-product-price').innerHTML     = formatter.format(obj[0].product_price);
                document.getElementById('card-salemodel').innerHTML         = obj[0].salemodel_name;
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

function handleOnLoad(tid,form) {
    errors      = 0;
    authApi     = 'dasdasdkasdeewef';
    locat       = window.location.hostname;

    filters     = '&tid='+tid;
  
    if(locat.slice(-1) != '/')
        locat += '/';

    if(errors > 0){

    } else{
        const requestURL = window.location.protocol+'//'+locat+'api/providers/auth_provider_get.php?auth_api='+authApi+filters;
        //alert(requestURL);
        const request = new XMLHttpRequest();
        request.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                
                obj = JSON.parse(request.responseText);

                    // Create our number formatter.
                    var formatter = new Intl.NumberFormat('pt-BR', {
                        //style: 'currency',
                        //currency: obj[0].currency,
                        //maximumSignificantDigits: 2,

                        // These options are needed to round to whole numbers if that's what you want.
                        minimumFractionDigits: 2, // (this suffices for whole numbers, but will print 2500.10 as $2,500.1)
                        //maximumFractionDigits: 0, // (causes 2500.99 to be printed as $2,501)
                    });

                form.name.value                     = obj[0].name;
                form.address.value                  = obj[0].address;
                form.webpage_url.value              = obj[0].webpage_url;
                form.main_contact_name.value        = obj[0].main_contact_name;
                form.main_contact_surname.value     = obj[0].main_contact_surname;
                form.main_contact_email.value       = obj[0].main_contact_email;
                //form.phone_ddi.value              = obj[0].phone_international_code.replace(" ","");
                form.phone.value                    = obj[0].phone_number.replace(" ","");
                form.main_contact_position.value    = obj[0].main_contact_position;
                form.product_price.value            = formatter.format(obj[0].product_price);
                form.product_id.value               = obj[0].product_id;
                form.salemodel_id.value             = obj[0].salemodel_id;
                form.currency.value                 = obj[0].currency;
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

function handleListOnLoad(search) {
    errors      = 0;
    authApi     = 'dasdasdkasdeewef';
    locat       = window.location.hostname;

    filters     = '';
    if(typeof search == 'undefined')
        search  = '';
    if(search !== ''){
        filters     += '&search='+search;
    }

    if(locat.slice(-1) != '/')
        locat += '/';

    if(errors > 0){

    } else{
        tableList   = document.getElementById('listProviders');
        const requestURL = window.location.protocol+'//'+locat+'api/providers/auth_provider_view.php?auth_api='+authApi+filters;
        //alert(requestURL);
        const request = new XMLHttpRequest();
        request.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                // Typical action to be performed when the document is ready:
                obj         = JSON.parse(request.responseText);
                html        = '';
                country     = '';
                for(var i=0;i < obj.length; i++){
                    color_user_status = '#d60b0e';
                    if(obj[i].is_active == 'Y')
                        color_user_status = '#298c3d';

                        switch (obj[i].phone_international_code) {
                            case '52':
                                country = 'MEX';
                                break;
                            case '55':
                                country = 'BRA';
                                break;
                            case '1':
                                country = 'USA';
                                break;
                            default:
                                country = 'XXX';
                        }
                        
                    html += '<tr><td>'+obj[i].name+'</td><td>'+obj[i].webpage_url+'</td><td nowrap>'+obj[i].phone+'</td><td nowrap>'+obj[i].contact+'</td><td style="text-align:center;"><span id="locked_status_'+obj[i].uuid_full+'" class="material-icons" style="color:'+color_user_status+'">attribution</span></td><td nowrap style="text-align:center;">';
                    // information card
                    html += '<a href="?pr=Li9wYWdlcy9wcm92aWRlcnMvaW5mby5waHA=&tid='+obj[i].uuid_full+'"><span class="material-icons" style="font-size:1.5rem; color:black;" title="User Information Card '+obj[i].corporate_name+'">info</span></a>';

                    // Edit form
                    html += '<a href="?pr=Li9wYWdlcy9wcm92aWRlcnMvZm9ybWVkaXQucGhw&tid='+obj[i].uuid_full+'"><span class="material-icons" style="font-size:1.5rem; color:black;" title="Edit user '+obj[i].corporate_name+'">edit</span></a>';

                    // Remove 
                    html += '<a href="javascript:void(0)" onclick="handleRemove(\''+obj[i].uuid_full+'\',\''+obj[i].is_active+'\')"><span class="material-icons" style="font-size:1.5rem; color:black;" title="Remove user '+obj[i].corporate_name+'">delete</span></a>';

                    html += '</td></tr>';
                }
                tableList.innerHTML = html;
            }
            else{
                html = '<tr><td colspan="5"><div style="margin-left:45%; margin-right:45%;" class="spinner-border" style="text-align:center;" role="status">';
                html += '<span class="sr-only">Loading...</span>';
                html += '</div></td></tr>';
                tableList.innerHTML = html;
                //form.btnSave.innerHTML = "Searching...";
            }
        };
        request.open('GET', requestURL);
        //request.responseType = 'json';
        request.send();
    }
    // window.location.href = '?pr=Li9wYWdlcy91c2Vycy9saXN0LnBocA==';
}

function handleRemove(tid,locked_status){
    authApi     = 'dasdasdkasdeewef';
    filters     = '&tid='+tid+'&lk='+locked_status;
    
    locat       = window.location.hostname;
    if(locat.slice(-1) != '/')
        locat += '/';

    color_user_status = '#298c3d';
    if(locked_status == 'Y')
        color_user_status = '#d60b0e';
    const requestURL = window.location.protocol+'//'+locat+'api/providers/auth_provider_remove.php?auth_api='+authApi+filters;
    //alert(requestURL);
    const request = new XMLHttpRequest();
    request.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            // Typical action to be performed when the document is ready:
            obj = JSON.parse(request.responseText);
            document.getElementById('locked_status_'+tid).style = 'color:'+color_user_status;
        }
    };
    request.open('GET', requestURL);
    //request.responseType = 'json';
    request.send();
}