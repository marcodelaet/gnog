lang        = 'es-MX';
if(localStorage.getItem('ulang') == 'ptbr')
    lang    = 'pt-BR';
if(localStorage.getItem('ulang') == 'eng')
    lang    = 'en-US';


module      = 'proposal';
start_index = 0;
document.getElementById('nav-item-proposals').setAttribute('class',document.getElementById('nav-item-proposals').getAttribute('class').replace(' active','') + ' active');
var csrf_token = $('meta[name="csrf-token"]').attr('content');
//alert(csrf_token);
xcurrency = 'MXN';
proposal_id = '';

function handleSubmitAddProduct(form,proposalId){
    //form.submit();
    errors      = 0;
    authApi     = csrf_token;
    message     = '';

    var formData = new FormData(form);
    formData.append('auth_api',authApi);

    total                   = form.total.value;

    currency        = document.getElementById('currency').value;
    objProduct      = document.getElementsByName('product_id[]');
    objSaleModel    = document.getElementsByName('salemodel_id[]');
    objPrice        = document.getElementsByName('price[]');
    objState        = document.getElementsByName('state_id[]');
    objCity         = document.getElementsByName('city_id[]');
    objCounty       = document.getElementsByName('county_id[]');
    objColony       = document.getElementsByName('colony_id[]');

    objQuantity     = document.getElementsByName('quantity[]');
    objProviderId   = document.getElementsByName('provider_id[]');

    locat       = window.location.hostname;
    if(locat.slice(-1) != '/')
        locat += '/';

    if(errors > 0){
        alert(message);
    } else {

        proposal_id = proposalId;
        virg            = '';
        product_id      = '';
        salemodel_id    = '';
        price           = '';
        quantity        = '';
        provider_id     = '';
        state_id        = '';
        city_id         = '';
        county_id       = '';
        colony_id       = '';

        for(i=0; i < objProduct.length;i++)
        {
            if(i>0)
                virg = ',';

            xprice  = '0';
            if((objPrice[i].value != '') || (objPrice[i].value >= 0)){
                axPrice = objPrice[i].value.split(",");
                for(j=0;j < axPrice.length;j++){
                    apPrice     = axPrice[j].split(".");
                    for(k=0;k < apPrice.length;k++){
                        xprice      += apPrice[k];
                    }
                }    
            } 
            product_id      += virg + objProduct[i].value;
            salemodel_id    += virg + objSaleModel[i].value;
            price           += virg + xprice;
            xquantity       = 1;
            if((objQuantity[i].value != '') || (objQuantity[i].value > 0))
                xquantity = objQuantity[i].value;
            quantity        += virg + xquantity;
            provider_id     += virg + objProviderId[i].value;
            //if(objState[i].value)
            state_id        += virg + objState[i].value;
            city_id         += virg + objCity[i].value;
            county_id       += virg + objCounty[i].value;
            colony_id       += virg + objColony[i].value;
        }
        addProduct('['+product_id+']','['+salemodel_id+']','['+price+']',currency,'['+quantity+']','['+provider_id+']',proposal_id,'['+state_id+']','['+city_id+']','['+county_id+']','['+colony_id+']');

        form.btnSave.innerHTML = "Save";
        window.location.href = '?pr=Li9wYWdlcy9wcm9wb3NhbHMvZm9ybWVkaXQucGhw&ppid='+proposalId;
    }
}

function handleSubmit(form) {
    if (form.name.value !== '' && form.client_id.value !== '' && form.start_date.value !== '' || form.client_id.value !== '0' || form.agency_id.value !== '0' || form.total.value !== '0,00' || form.status_id.value !== '0') {
        //form.submit();
        errors      = 0;
        authApi     = csrf_token;
        message     = '';

        pixel       = 'N';
        if(form.pixel.checked)
            pixel   = 'Y';

        taxable     = 'N';
        if(form.taxable.checked)
            taxable = 'Y';

        var formData = new FormData(form);
        formData.append('auth_api',authApi);
        formData.append('office_id',form.officeDropdownMenuButton.value);
        formData.append('pixel_option',pixel);
        formData.append('taxable_option',taxable);

        total                   = form.total.value;
        status_id               = form.status_id.value;
        currency                = form.currency.value;

        objProduct      = document.getElementsByName('product_id[]');
        objSaleModel    = document.getElementsByName('salemodel_id[]');
        objPrice        = document.getElementsByName('price[]');
        objState        = document.getElementsByName('state_id[]');
        objCity         = document.getElementsByName('city_id[]');
        objCounty       = document.getElementsByName('county_id[]');
        objColony       = document.getElementsByName('colony_id[]');
    
        objQuantity     = document.getElementsByName('quantity[]');
        objProviderId   = document.getElementsByName('provider_id[]');

        locat       = window.location.hostname;
        if(locat.slice(-1) != '/')
            locat += '/';

        if(errors > 0){
            alert(message);
        } else{
            const requestURL = window.location.protocol+'//'+locat+'api/proposals/auth_proposal_add_new.php';
            //console.log(requestURL);
            const request = new XMLHttpRequest();
            request.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    // Typical action to be performed when the document is ready:
                    //console.log(request.responseText);                    
                    obj = JSON.parse(request.responseText);

                    proposal_id = obj[0].id;
                    virg            = '';
                    product_id      = '';
                    salemodel_id    = '';
                    price           = '';
                    quantity        = '';
                    provider_id     = '';
                    state_id        = '';
                    city_id         = '';
                    county_id       = '';
                    colony_id       = '';

                    for(i=0; i < objProduct.length;i++)
                    {
                        if(i>0)
                            virg = ',';

                        xprice  = '0';
                        if((objPrice[i].value != '') || (objPrice[i].value >= 0)){
                            axPrice = objPrice[i].value.split(",");
                            for(j=0;j < axPrice.length;j++){
                                apPrice     = axPrice[j].split(".");
                                for(k=0;k < apPrice.length;k++){
                                    xprice      += apPrice[k];
                                }
                            }    
                        } 
                        product_id      += virg + objProduct[i].value;
                        salemodel_id    += virg + objSaleModel[i].value;
                        price           += virg + xprice;
                        xquantity       = 1;
                        if((objQuantity[i].value != '') || (objQuantity[i].value > 0))
                            xquantity = objQuantity[i].value;
                        quantity        += virg + xquantity;
                        provider_id     += virg + objProviderId[i].value;
                        //if(objState[i].value)
                        state_id        += virg + objState[i].value;
                        city_id         += virg + objCity[i].value;
                        county_id       += virg + objCounty[i].value;
                        colony_id       += virg + objColony[i].value;
                    }
                    addProduct('['+product_id+']','['+salemodel_id+']','['+price+']',currency,'['+quantity+']','['+provider_id+']',proposal_id,'['+state_id+']','['+city_id+']','['+county_id+']','['+colony_id+']');

                    form.btnSave.innerHTML = "Save";
                    window.location.href = '?pr=Li9wYWdlcy9wcm9wb3NhbHMvZm9ybWVkaXQucGhw&ppid='+proposal_id;
                }
                else{
                    form.btnSave.innerHTML = "Saving...";
                }
            };
            request.open('POST', requestURL, false);
            //request.responseType = 'json';
            request.send(formData);
        }
    } else
        alert('Please, fill all required fields (*)');
}

function handleSubmitProvider(form){
    if (form.total.value !== '0,00') {
        errors      = 0;
        authApi     = csrf_token;
        message     = '';

        total       = form.total.value;

        product     = document.getElementById('productID').value;
        saleModel   = document.getElementById('salemodelID').value;
        proposal_id = document.getElementById('proposalID').value;
        referrer    = document.getElementById('referrer').value;
        state       = document.getElementById('stateSel').value;
        city        = document.getElementById('citySel').value;
        county      = document.getElementById('countySel').value;
        colony      = document.getElementById('colonySel').value;
        currency    = document.getElementById('currency').value;

        objPrice        = document.getElementsByName('price[]');    
        objQuantity     = document.getElementsByName('quantity[]');
        objProviderId   = document.getElementsByName('provider_id[]');
        
        if(errors > 0){
            alert(message);
        } else{
            virg            = '';
            product_id      = '';
            salemodel_id    = '';
            price           = '';
            quantity        = '';
            provider_id     = '';
            state_id        = '';
            city_id         = '';
            county_id       = '';
            colony_id       = '';

            for(i=0; i < objProviderId.length;i++){
                if(i>0)
                    virg = ',';

                xprice  = '0';
                if((objPrice[i].value != '') || (objPrice[i].value >= 0)){
                    axPrice = objPrice[i].value.split(",");
                    for(j=0;j < axPrice.length;j++){
                        apPrice     = axPrice[j].split(".");
                        for(k=0;k < apPrice.length;k++){
                            xprice      += apPrice[k];
                        }
                    }    
                } 
                product_id      += virg + product;
                salemodel_id    += virg + saleModel;
                price           += virg + xprice;
                xquantity       = 1;
                if((objQuantity[i].value != '') || (objQuantity[i].value > 0))
                    xquantity = objQuantity[i].value;
                quantity        += virg + xquantity;
                provider_id     += virg + objProviderId[i].value;
                //if(objState[i].value)
                state_id        += virg + state;
                city_id         += virg + city;
                county_id       += virg + county;
                colony_id       += virg + colony;

            }
            addProduct('['+product_id+']','['+salemodel_id+']','['+price+']',currency,'['+quantity+']','['+provider_id+']',proposal_id,'['+state_id+']','['+city_id+']','['+county_id+']','['+colony_id+']');

            form.btnSave.innerHTML = "Save";
            window.location.href = '?pr=Li9wYWdlcy9wcm9wb3NhbHMvZm9ybWVkaXQucGhw&ppid='+proposal_id;
        }
    } else
        alert('Please, fill all required fields (*)');
}

function handleEditSubmit(tid,form) {
    if (form.name.value !== '' && form.address.value !== '' && form.main_contact_email.value !== '' || product_id != '0' || salemodel_id != '0') {
        //form.submit();
   
        errors      = 0;
        authApi     = csrf_token;
        
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
            const requestURL = window.location.protocol+'//'+locat+'api/proposals/auth_proposal_edit.php?auth_api='+authApi+sett;
            //console.log(requestURL);
            const request = new XMLHttpRequest();
            request.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                   // Typical action to be performed when the document is ready:
                   obj = JSON.parse(request.responseText);
                   form.btnSave.innerHTML = "Save";
                   window.location.href = '?pr=Li9wYWdlcy9wcm9wb3NhbHMvdGtwZWRpdC9pbmRleC5waHA=';
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

function handleViewOnLoad(ppid) {
    errors      = 0;
    //alert('ok');
    authApi     = csrf_token;
    locat       = window.location.hostname;

    filters     = '&ppid='+ppid;

    if(locat.slice(-1) != '/')
        locat += '/';

    if(errors > 0){

    } else{
        const requestURL = window.location.protocol+'//'+locat+'api/proposals/auth_proposal_get.php?auth_api='+authApi+filters;
        // console.log('xsjoe: \n'+requestURL);
        const request   = new XMLHttpRequest();
        position        = '*****';
        request.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                obj = JSON.parse(request.responseText);
                // Create our number formatter.
                var formatter = new Intl.NumberFormat(lang, {
                    style: 'currency',
                    currency: obj['data'][0].currency_c,
                    //maximumSignificantDigits: 2,

                    // These options are needed to round to whole numbers if that's what you want.
                    //minimumFractionDigits: 2, // (this suffices for whole numbers, but will print 2500.10 as $2,500.1)
                    //maximumFractionDigits: 0, // (causes 2500.99 to be printed as $2,501)
                });
                if(obj['data'][0].main_contact_position!='')
                    position = obj['data'][0].main_contact_position;
                client = obj['data'][0].client_name;
                if(obj['data'][0].agency_name != null)
                    client += ' / ' + obj['data'][0].agency_name;

                xxhtml                = '';
                color_status = '#d60b0e';
                if(obj['data'][0].status_percent == '100')
                    color_status = '#298c3d';
                if(obj['data'][0].status_percent == '90')
                    color_status = '#03fc84';
                if(obj['data'][0].status_percent == '75')
                    color_status = '#77fc03';
                if(obj['data'][0].status_percent == '50')
                    color_status = '#ebfc03';
                if(obj['data'][0].status_percent == '25')
                    color_status = '#fc3d03';
                startDate           = new Date(obj['data'][0].start_date);
                formattedStartDate  = startDate.getDate()+"/"+(parseInt(startDate.getMonth())+1)+"/"+startDate.getFullYear();
                stopDate            = new Date(obj['data'][0].stop_date);
                formattedStopDate   = stopDate.getDate()+"/"+(parseInt(stopDate.getMonth())+1)+"/"+stopDate.getFullYear(); 
                document.getElementById('proposal-name').innerHTML          = obj['data'][0].offer_name;
                document.getElementById('client').innerHTML                 = client;
                document.getElementById('description').innerHTML            = obj['data'][0].description;
                document.getElementById('dates').innerHTML                  = "("+ formattedStartDate+" - "+formattedStopDate+")";
                //document.getElementById('statusDropdownMenuButton').innerHTML            = '<spam class="material-icons icon-data" id="card-status-icon" style="color:'+color_status+'">thermostat</spam>' + obj[0].status_name + ' ('+ obj[0].status_percent+'%)';
                document.getElementById('statusDropdownMenuButton').value   = obj['data'][0].status_id; 
                document.getElementById('statusDropdownMenuButton').innerHTML = '<spam class="material-icons icon-data" id="card-status-icon" style="color:'+color_status+'">thermostat</spam>' + translateText(obj['data'][0].status_name,localStorage.getItem('ulang')) + ' ('+ obj['data'][0].status_percent+'%)';
                // products list for statement
                for(var i=0;i<obj['data'].length;i++){
                    xxhtml += '<spam class="product-line">'+obj['data'][i].quantity + ' x ' + obj['data'][i].product_name + ' / ' + obj['data'][i].salemodel_name+' - '+formatter.format(obj['data'][i].amount)+'</spam><br />';
                }
                classStatus = document.getElementsByClassName('dropdown-item status'); 
                for(var cs=0; cs < classStatus.length; cs++){
                    classStatus[cs].setAttribute('onclick',classStatus[cs].getAttribute('onclick').replace(",'');",",'"+obj['data'][0].status_id+"');"));
                }
                document.getElementById('products-list').innerHTML          = xxhtml;                
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

function handleViewProductsOnLoad(ppid,pppid) {
    errors      = 0;
    //alert('ok');
    authApi     = csrf_token;
    locat       = window.location.hostname;

    filters     = '&ppid='+ppid+'&pppid='+pppid;

    if(locat.slice(-1) != '/')
        locat += '/';

    if(errors > 0){

    } else{
        const requestURL = window.location.protocol+'//'+locat+'api/proposals/auth_proposal_get.php?auth_api='+authApi+filters;
        //console.log('xsjoe: \n'+requestURL);
        const request   = new XMLHttpRequest();
        position        = '*****';
        request.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                obj = JSON.parse(request.responseText);
                xcurrency = obj['data'][0].currency_c;
                // Create our number formatter.
                var formatter = new Intl.NumberFormat(lang, {
                    style: 'currency',
                    currency: xcurrency,
                    //maximumSignificantDigits: 2,

                    // These options are needed to round to whole numbers if that's what you want.
                    //minimumFractionDigits: 2, // (this suffices for whole numbers, but will print 2500.10 as $2,500.1)
                    //maximumFractionDigits: 0, // (causes 2500.99 to be printed as $2,501)
                });
                if(obj['data'][0].main_contact_position!='')
                    position = obj['data'][0].main_contact_position;
                client = obj['data'][0].client_name;
                if(obj['data'][0].agency_name != null)
                    client += ' / ' + obj['data'][0].agency_name;

                xxhtml                = '';
                color_status = '#d60b0e';
                if(obj['data'][0].status_percent == '100')
                    color_status = '#298c3d';
                if(obj['data'][0].status_percent == '90')
                    color_status = '#03fc84';
                if(obj['data'][0].status_percent == '75')
                    color_status = '#77fc03';
                if(obj['data'][0].status_percent == '50')
                    color_status = '#ebfc03';
                if(obj['data'][0].status_percent == '25')
                    color_status = '#fc3d03';


                is_digital_color    = "#298c3d";
                is_digital_text     = 'check';
                if(obj['data'][0].is_digital != 'Y'){
                    is_digital_color    = "#d60b0e";
                    is_digital_text     = 'cancel';
                }
                
                startDate           = new Date(obj['data'][0].start_date);
                formattedStartDate  = startDate.getDate()+"/"+(parseInt(startDate.getMonth())+1)+"/"+startDate.getFullYear();
                stopDate            = new Date(obj['data'][0].stop_date);
                formattedStopDate   = stopDate.getDate()+"/"+(parseInt(stopDate.getMonth())+1)+"/"+stopDate.getFullYear();
                document.getElementById('is-digital').style         = 'color:'+is_digital_color;
                document.getElementById('is-digital').innerText     = is_digital_text; 
                document.getElementById('proposal-name').innerHTML  = obj['data'][0].offer_name;
                document.getElementById('currency').value           = xcurrency;
                document.getElementById('productID').value          = obj['data'][0].product_id;
                document.getElementById('salemodelID').value        = obj['data'][0].salemodel_id;
                document.getElementById('proposalID').value         = obj['data'][0].UUID;
                document.getElementById('stateSel').value           = obj['data'][0].state;
                document.getElementById('citySel').value            = obj['data'][0].city;
                document.getElementById('countySel').value          = obj['data'][0].county;
                document.getElementById('colonySel').value          = obj['data'][0].colony;
                document.getElementById('proposal-product-state').innerText = obj['data'][0].state;
                for(var i=0;i<obj['data'].length;i++){
                    xxhtml += '<spam class="product-line">'+obj['data'][0].product_name + ' / ' + obj['data'][0].salemodel_name+'</spam><br />';
                }
                document.getElementById('proposal-product-name').innerHTML          = xxhtml;                
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

function handleListAddProductOnLoad(ppid){
    errors      = 0;
    authApi     = csrf_token;
    locat       = window.location.hostname;

    filters     = '&ppid='+ppid;
    orderby     = '&orderby=is_proposalbillboard_active DESC,concat(product_name,salemodel_name),provider_name ASC,state ASC,billboard_name';
  
    if(locat.slice(-1) != '/')
        locat += '/';

    if(errors > 0){

    } else{
        const requestURL = window.location.protocol+'//'+locat+'api/proposals/auth_proposal_get.php?auth_api='+authApi+filters+orderby;
        //console.log('mapaaaa- '+requestURL);
        const request = new XMLHttpRequest();
        request.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                
                obj = JSON.parse(request.responseText);

                advertiser_name = obj['data'][0].client_name;
                agency_name     = obj['data'][0].agency_name;
                
                if( (agency_name != '') && (agency_name != null)){
                    advertiser_name += " / " + agency_name;
                }
                const startDate = new Date(obj['data'][0].start_date);
                const stopDate  = new Date(obj['data'][0].stop_date);

                document.getElementById('start-date').innerText         = startDate.toLocaleDateString(lang);
                document.getElementById('stop-date').innerText          = stopDate.toLocaleDateString(lang);
                document.getElementById('offer-name').innerText         = obj['data'][0].offer_name;
                document.getElementById('advertiser-name').innerText    = advertiser_name;
                document.getElementById('info-currency').innerText      = obj['data'][0].currency_c;
                document.getElementById('currency').value               = obj['data'][0].currency_c;
                xcurrency = obj['data'][0].currency_c;
                // Create our number formatter.
                var formatter = new Intl.NumberFormat(lang, {
                    style: 'currency',
                    currency: xcurrency, // believing every currency will be MXN
                    //maximumSignificantDigits: 2,

                    // These options are needed to round to whole numbers if that's what you want.
                    //minimumFractionDigits: 2, // (this suffices for whole numbers, but will print 2500.10 as $2,500.1)
                    //maximumFractionDigits: 0, // (causes 2500.99 to be printed as $2,501)
                });
            }
            else {
                //form.btnSave.innerHTML = "Searching...";
            }
        };
        request.open('GET', requestURL);
        //request.responseType = 'json';
        request.send();
    }
}

function handleListEditOnLoad(ppid) {
    errors      = 0;
    authApi     = csrf_token;
    locat       = window.location.hostname;

    filters     = '&ppid='+ppid;
    orderby     = '&orderby=is_proposalbillboard_active DESC,concat(product_name,salemodel_name),provider_name ASC,state ASC,billboard_name';
  
    if(locat.slice(-1) != '/')
        locat += '/';

    if(errors > 0){

    } else{
        const requestURL = window.location.protocol+'//'+locat+'api/proposals/auth_proposal_get.php?auth_api='+authApi+filters+orderby;
        //console.log('mapaaaa- '+requestURL);
        const request = new XMLHttpRequest();
        request.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                
                obj = JSON.parse(request.responseText);

                // Create our number formatter.
                var formatter = new Intl.NumberFormat(lang, {
                    //style: 'currency',
                    //currency: obj[0].currency,
                    //maximumSignificantDigits: 2,

                    // These options are needed to round to whole numbers if that's what you want.
                    minimumFractionDigits: 2, // (this suffices for whole numbers, but will print 2500.10 as $2,500.1)
                    //maximumFractionDigits: 0, // (causes 2500.99 to be printed as $2,501)
                });

                advertiser_name = obj['data'][0].client_name;
                agency_name     = obj['data'][0].agency_name;
                
                if( (agency_name != '') && (agency_name != null)){
                    advertiser_name += " / " + agency_name;
                }
                document.getElementById('offer-name').innerText  = obj['data'][0].offer_name;
                document.getElementById('advertiser-name').innerText  = advertiser_name;
                xcurrency = obj['data'][0].currency_c;
                // Create our number formatter.
                var formatter = new Intl.NumberFormat(lang, {
                    style: 'currency',
                    currency: xcurrency, // believing every currency will be MXN
                    //maximumSignificantDigits: 2,

                    // These options are needed to round to whole numbers if that's what you want.
                    //minimumFractionDigits: 2, // (this suffices for whole numbers, but will print 2500.10 as $2,500.1)
                    //maximumFractionDigits: 0, // (causes 2500.99 to be printed as $2,501)
                });

                productOld      = 0;
                providerOld     = 0;
               // provider        = 0;
               // provider_name   = '';
                html            = '';
                numberProducts  = 0;
                numberProviders = 0;
                aBillboards     = ['Arco','Bajo Puente','Cartelera','Caseta','Columna','Mupi','Muro','Pantalla','Pantalla Led','Parabus','Puente Peatonal','Puente Vehicular','Reloj Digital','Valla'];
                aProviders      = new Array();
                showLine        = 1;

                for(i=0;i < obj['data'].length; i++){
                    // products list
                    product = obj['data'][i].salemodel_name + obj['data'][i].state;
                    if(product != productOld){
                        providerOld     = 0;
                        numberProducts++;
                       // if(showLine == 1){
                            html += '<div class="row list-products-row">' +
                            '<div class="col-sm-1">'+(numberProducts)+'</div>' +
                            '<div class="col-sm-3">'+obj['data'][i].product_name+' / '+obj['data'][i].salemodel_name+'</div>' +
                            '<div class="col-sm-2">'+obj['data'][i].state+'</div>'; 
                            //'<div class="col-sm-2">Rate % All</div>' +
                            if(aBillboards.indexOf(obj['data'][i].salemodel_name) != -1){
                            //if(obj[i].billboard_salemodel_name != null){
                                html += '<div class="col-sm-2" style="text-align:center; white-space: nowrap;"><a title="'+ucfirst(translateText('choose',localStorage.getItem('ulang')))+' '+obj['data'][i].salemodel_name+' '+translateText('on_map',localStorage.getItem('ulang'))+'" href="?pr=Li9wYWdlcy9tYXBzL2luZGV4LnBocA==&smid='+obj['data'][i].salemodel_id+'&ppid='+ppid+'&pppid='+obj['data'][i].proposalproduct_id+'&state='+obj['data'][i].state+'&city='+obj['data'][i].city+'&county='+obj['data'][i].county+'&colony='+obj['data'][i].colony+'"><span class="material-icons" style="font-size:1.2rem;">map</span><br/><span style="font-size:0.8rem">'+ucfirst(translateText('choose',localStorage.getItem('ulang')))+' '+obj['data'][i].salemodel_name+' '+translateText('on_map',localStorage.getItem('ulang'))+'</span></a></div>';
                            } else {
                                html += '<div class="col-sm-2" style="text-align:center; white-space: nowrap;"><a title="'+ucfirst(translateText('add+',localStorage.getItem('ulang')))+' '+translateText('provider',localStorage.getItem('ulang'))+'" href="?pr=Li9wYWdlcy9wcm9wb3NhbHMvYWRkL3Byb2R1Y3QvcHJvdmlkZXIvZm9ybWFkZC5waHA=&smid='+obj['data'][i].salemodel_id+'&ppid='+ppid+'&pppid='+obj['data'][i].proposalproduct_id+'&state='+obj['data'][i].state+'&city='+obj['data'][i].city+'&county='+obj['data'][i].county+'&colony='+obj['data'][i].colony+'"><span class="material-icons" style="font-size:1.2rem;">add_business</span> <br/><span style="font-size:0.8rem">'+ucfirst(translateText('add+',localStorage.getItem('ulang')))+' '+translateText('provider',localStorage.getItem('ulang'))+'</span></a></div>';
                            }
                            html += '</div>';
                        //}    
                    }
                    // css to special times
                    deletedbillboard = '';
                    if(obj['data'][i].is_proposalbillboard_active != 'Y'){
                        deletedbillboard = 'deleted-billboard';
                    }
                    
                    // providers
                    provider        = obj['data'][i].provider_id;
                    provider_name   = obj['data'][i].provider_name;
                    showLine        = 1;
                    if(obj['data'][i].is_proposalbillboard_active === null){
                       // provider_name = "";// "Sin proveedor";
                        if((aProviders.indexOf(provider) >= 0) && (aBillboards.indexOf(obj['data'][i].salemodel_name) != -1)){
                            showLine = 0;
                        }
                        //provider = '111';
                    }

                    if(provider != providerOld){
                        numberProviders++;
                        html += '<div class="row list-products-row">' +
                        '<div class="col-sm-2">' +
                        '<div class="col-sm-12 provider-name">'+provider_name+'</div>';
                        //html += '<a href="?pr=Li9wYWdlcy9tYXBzL2luZGV4LnBocA==&pid='+obj[i].provider_id+'&ppid='+ppid+'"><span class="material-icons" style="font-size:1.2rem;">edit</span></a>';
                        html += '</div>';
                        html += '</div>';
                        // if in a different provider, product must be showed again  
                        productOld = 0;    
                    }
                    

                    // list billboards
                    if((obj['data'][i].billboard_name != '')&&(obj['data'][i].billboard_name != null)){
                        if(provider != providerOld){
                            aProviders.push(obj['data'][i].provider_id);
                        }
                        $impression_cost_line = '';

                        if(obj['data'][i].making_banners == 'N'){
                            /*$impression_cost_line = '<a href="javascript:void(0);" onclick="addBannerCost(\''+obj['data'][i].proposalproduct_id+'\',\''+obj['data'][i].billboard_id+'\',\''+obj['data'][i].billboard_name+'\',\''+xcurrency+'\');">'+
                            '<span class="material-icons" style="font-size:1.5rem; color:black;" title="Informe de Costo para producción de '+obj['data'][i].billboard_salemodel_name+' '+obj['data'][i].billboard_name+'">receipt_long</span>'+
                            '</a>';*/
                            
                        }
                        html += '<div class="row list-billboards-row">' +
                        '<div class="col list-billboards-container">' +
                            '<div class="row" >' +
                                '<div class="col-sm-2 line-list-'+obj['data'][i].billboard_id+' '+deletedbillboard+'">'+obj['data'][i].billboard_name+'</div>' +
                                '<div class="col-sm-2 line-list-'+obj['data'][i].billboard_id+' '+deletedbillboard+'">'+(parseFloat(obj['data'][i].billboard_width)/100).toFixed(1)+' x '+(parseFloat(obj['data'][i].billboard_height)/100).toFixed(1)+'</div>' +
                                '<div class="col-sm-1 line-list-'+obj['data'][i].billboard_id+' '+deletedbillboard+'">'+obj['data'][i].billboard_viewpoint_name+'</div>' +
                                '<div class="col-sm-3 line-list-'+obj['data'][i].billboard_id+' '+deletedbillboard+'">'+formatter.format(obj['data'][i].billboard_cost)+' / <span id="price-'+obj['data'][i].billboard_id+'">'+formatter.format(obj['data'][i].billboard_price)+'</span>' +//' / <span id="cost-'+obj['data'][i].billboard_id+'">'+formatter.format(obj['data'][i].production_cost)+'</span>' +
                                '</div>'+ 
                            '<div class="input-group col-sm-3" id="rate-delete-'+obj['data'][i].billboard_id+'">';
                                if(deletedbillboard == '') {
                                    //html += '<label for="fee-'+obj[i].billboard_id+'">Fee rate</label>' +
                                    html += $impression_cost_line + 
                                    '<a href="javascript:void(0);" onclick="calculatorFee(\''+obj['data'][i].proposalproduct_id+'\',\''+obj['data'][i].billboard_id+'\','+obj['data'][i].billboard_cost_int+',\''+obj['data'][i].billboard_name+'\',\''+xcurrency+'\');">'+
                                    '<span class="material-icons" style="font-size:1.5rem; color:black;" title="Informe de costo del fee de '+obj['data'][i].billboard_salemodel_name+' '+obj['data'][i].billboard_name+'">price_change</span>'+
                                    '</a>'+
                                    '<input name="fee-'+obj['data'][i].billboard_id+'" id="fee-'+obj['data'][i].billboard_id+'" placeholder="% Fee" title="Percent (%) fee" aria-label="Percent (%) fee" value="30" class="form-control" style="height:1.5rem !important; width:3.5rem !important;" type="percent" maxlength="2" autocomplete="fee" />'+
                                    '<div class="input-group-append" style="height:1.5rem !important; width:3.5rem !important;"><span class="input-group-text">% ' +
                                    '<a href="javascript:void(0);" onclick="executeFeeOnPrice(\''+obj['data'][i].proposalproduct_id+'\',\''+obj['data'][i].billboard_id+'\','+obj['data'][i].billboard_cost_int+',\''+obj['data'][i].billboard_name+'\',\''+xcurrency+'\');">'+
                                    '<span class="material-icons" style="font-size:1.5rem; color:black;" title="Calcula Fee para '+obj['data'][i].billboard_salemodel_name+' '+obj['data'][i].billboard_name+'">calculate</span>'+
                                    '</a>'+
                                    '</span></div>';
                                }
                                html += '</div>';// + 
                                //'<div class="col-sm-1" id="button-delete-'+obj['data'][i].billboard_id+'">';

                        if(deletedbillboard == ''){
                            html += '<div class="col-sm-1" id="button-delete-'+obj['data'][i].billboard_id+'">'+
                            '<a href="javascript:void(0);" onclick="if(confirm(\'Confirma quitar '+obj['data'][i].salemodel_name+' clave '+obj['data'][i].billboard_name+' en la lista del estado de '+obj['data'][i].state+'?\')){handleRemoveFromList(\''+obj['data'][i].proposalproduct_id+'\',\''+obj['data'][i].billboard_id+'\');}">'+
                            '<span class="material-icons" style="font-size:1.5rem; color:black;" title="Remove '+obj['data'][i].billboard_salemodel_name+' '+obj['data'][i].billboard_name+' from list">delete</span></a></div>';
                        }
                        html += '</div>' +
                        '</div>' +
                        '</div>';    
                    }

                    productOld = obj['data'][i].salemodel_name + obj['data'][i].state;
                    providerOld = provider;
                }
                document.getElementById('list-products').innerHTML = html;
            }
            else {
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
    authApi     = csrf_token;
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
        tableList   = document.getElementById('listProposals');
        const requestURL = window.location.protocol+'//'+locat+'api/proposals/auth_proposal_list.php?auth_api='+authApi+filters;
        //console.log(requestURL);
        const request = new XMLHttpRequest();
        request.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                // Typical action to be performed when the document is ready:
                obj         = JSON.parse(request.responseText);
                if(typeof obj[0].response != 'undefined'){
                    html = '<tr><td colspan="8"><div style="margin-left:45%; margin-right:45%;text-align:center;" role="status">';
                    html += '0 Results';
                    html += '</td></tr>';
                    tableList.innerHTML = html;    
                }else{
                    html        = ''; 
                    for(var i=0;i < obj.length; i++){
                        var formatter = new Intl.NumberFormat(lang, {
                            style: 'currency',
                            currency: obj[i].currency,
                            //maximumSignificantDigits: 2,
                    
                            // These options are needed to round to whole numbers if that's what you want.
                            //minimumFractionDigits: 2, // (this suffices for whole numbers, but will print 2500.10 as $2,500.1)
                            //maximumFractionDigits: 0, // (causes 2500.99 to be printed as $2,501)
                        });
                        color_status = '#d60b0e';
                        if(obj[i].is_active == 'Y')
                            color_status = '#298c3d';



                        color_status = '#d60b0e';
                        color_letter = '#CCCCFF';
                        if(obj[i].status_percent == '100'){
                            color_status = '#298c3d';
                            color_letter = '#CCCCFF';
                        }
                        if(obj[i].status_percent == '90'){
                            color_status = '#03fc84';
                            color_letter = '#000000';
                        }
                        if(obj[i].status_percent == '75'){
                            color_status = '#77fc03';
                            color_letter = '#000000';
                        }
                        if(obj[i].status_percent == '50'){
                            color_status = '#ebfc03';
                            color_letter = '#6666FF';
                        }
                        if(obj[i].status_percent == '25'){
                            color_status = '#fc3d03';
                            color_letter = '#CCCCFF';
                        }
                            
                        agency = '';
                        if(typeof(obj[i].agency_name) === 'string')
                            agency = ' / '+obj[i].agency_name;
                        amount = obj[i].amount;
                        start_date  = new Date(obj[i].start_date);
                        stop_date   = new Date(obj[i].stop_date);
                        html += '<tr><td>'+obj[i].offer_name+'</td><td nowrap>'+obj[i].client_name+agency+'</td><td nowrap>'+obj[i].username+'</td><td nowrap>'+formatter.format(amount)+'</td><td>'+start_date.toLocaleString(lang).split(" ")[0].replace(",","")+'</td><td>'+stop_date.toLocaleString(lang).split(" ")[0].replace(",","")+'</td><td style="text-align:center;" ><span id="status_'+obj[i].UUID+'" class="material-icons" title="'+obj[i].status_percent+'% '+translateText(obj[i].status_name,localStorage.getItem('ulang'))+'" style="color:'+color_status+'">thermostat</span><br/><span class="status-description" style="background-color:'+color_status+'; color:'+color_letter+'">&nbsp;&nbsp;'+obj[i].status_percent+'% '+translateText(obj[i].status_name,localStorage.getItem('ulang'))+'&nbsp;&nbsp;</span></td><td nowrap style="text-align:center;">';
                        // information card
                        html += '<a href="?pr=Li9wYWdlcy9wcm9wb3NhbHMvaW5mby5waHA=&ppid='+obj[i].UUID+'"><span class="material-icons" style="font-size:1.5rem; color:black;" title="Information Card '+obj[i].offer_name+'">info</span></a>';

                        // Edit form
                        html += '<a href="?pr=Li9wYWdlcy9wcm9wb3NhbHMvZm9ybWVkaXQucGhw&ppid='+obj[i].UUID+'"><span class="material-icons" style="font-size:1.5rem; color:black;" title="Edit '+module + ' '+obj[i].offer_name+'">edit</span></a>';

                        // Remove 
                        html += '<a href="javascript:void(0)" onclick="handleRemove(\''+obj[i].UUID+'\',\''+obj[i].status_percent+'\')"><span class="material-icons" style="font-size:1.5rem; color:black;" title="Remove '+module + ' '+obj[i].offer_name+'">delete</span></a>';

                        html += '</td></tr>';
                    }
                    tableList.innerHTML = html;
                }
            }
            else{
                html = '<tr><td colspan="8"><div style="margin-left:45%; margin-right:45%;" class="spinner-border" style="text-align:center;" role="status">';
                //html += '<span class="sr-only">Loading...</span>';
                html += '<span class="sr-only">0 results</span>';
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

// remove billboard from proposals / product list
function handleRemoveFromList(proposalproduct_id,billboard_id){
    authApi     = csrf_token;
    filters     = '&pppid='+proposalproduct_id+'&pbid='+billboard_id;
    
    locat       = window.location.hostname;
    if(locat.slice(-1) != '/')
        locat += '/';

    const requestURL = window.location.protocol+'//'+locat+'api/proposals/auth_proposalproduct_remove.php?auth_api='+authApi+filters;
    //alert(requestURL);
    const request = new XMLHttpRequest();
    request.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            // Typical action to be performed when the document is ready:
            //console.log(request.responseText);
            obj = JSON.parse(request.responseText);
            if(obj.response == 'OK'){
                arrayLineList = document.getElementsByClassName('line-list-'+billboard_id);
                buttonDelete = document.getElementById('button-delete-'+billboard_id);
                rateDelete = document.getElementById('rate-delete-'+billboard_id);
                for(all=0;all < arrayLineList.length;all++){
                    arrayLineList[all].setAttribute('class',arrayLineList[all].getAttribute('class')+ ' deleted-billboard');
                }
                buttonDelete.innerHTML='';
                rateDelete.innerHTML='';
            }
            
        }
    };
    request.open('GET', requestURL);
    //request.responseType = 'json';
    request.send();
}


function handleRemove(ppid,status){
    authApi     = csrf_token;
    filters     = '&ppid='+ppid+'&lk='+status;
    
    locat       = window.location.hostname;
    if(locat.slice(-1) != '/')
        locat += '/';

    color_status = '#298c3d';
    if(locked_status == 'Y')
        color_status = '#d60b0e';
    const requestURL = window.location.protocol+'//'+locat+'api/proposals/auth_proposal_remove.php?auth_api='+authApi+filters;
    //alert(requestURL);
    const request = new XMLHttpRequest();
    request.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            // Typical action to be performed when the document is ready:
            obj = JSON.parse(request.responseText);
            document.getElementById('locked_status_'+tid).style = 'color:'+color_status;
        }
    };
    request.open('GET', requestURL);
    //request.responseType = 'json';
    request.send();
}

function calcAmountTotalOnProvider(form,index){
    currency    = document.getElementsByName('currency');
    xcurrency   = currency[0].value;
    var formatter = new Intl.NumberFormat(lang, {
        style: 'currency',
        currency: xcurrency,
        //maximumSignificantDigits: 2,

        // These options are needed to round to whole numbers if that's what you want.
        //minimumFractionDigits: 2, // (this suffices for whole numbers, but will print 2500.10 as $2,500.1)
        //maximumFractionDigits: 0, // (causes 2500.99 to be printed as $2,501)
    });
    price       = document.getElementsByName('price[]');
    xprice      = price[index].value;
    quantity    = document.getElementsByName('quantity[]');
    xquantity   = quantity[index].value;
    if(xprice > '0' && xquantity > '0'){
        amount = document.getElementsByName('amount[]');
        amount[index].value   = formatter.format(parseFloat(transformToInt(xprice)) * parseInt(xquantity));

        total = 0;
        for(i=0;i < amount.length; i++){
            xaAmount        = amount[i].value.split(" ");
            if(xaAmount.length <= 1){
                xaAmount        = amount[i].value.split("$");
            }
            aAmountValue1   = xaAmount[1];
            //alert("value: "+ amount[i].value + "\n\nxaAmount: " + xaAmount + "\n0: " + xaAmount[0] + "\n1: " + xaAmount[1])
            axAmountS       = aAmountValue1.split(",");
            xVAmount        = '';
            for(j=0;j < axAmountS.length; j++){
                xVAmount        += axAmountS[j];
            }
            axAmountFinal   = xVAmount.split(".");
            xVAmountFinal   = '';
            for(k=0;k < axAmountFinal.length; k++){
                xVAmountFinal    += axAmountFinal[k];
            }
            realAmount  = (parseInt(xVAmountFinal) * 1) / 100;
            total = (parseFloat(total) * 1)+ (parseFloat(realAmount) * 1);
            //alert(total);
        }
        form.total.value = formatter.format(total);
    }
}

function calcAmountTotal(form,index){
    currency    = document.getElementsByName('currency');
    xcurrency   = currency[0].value;
    var formatter = new Intl.NumberFormat(lang, {
        style: 'currency',
        currency: xcurrency,
        //maximumSignificantDigits: 2,

        // These options are needed to round to whole numbers if that's what you want.
        //minimumFractionDigits: 2, // (this suffices for whole numbers, but will print 2500.10 as $2,500.1)
        //maximumFractionDigits: 0, // (causes 2500.99 to be printed as $2,501)
    });
    price       = document.getElementsByName('price[]');
    xprice      = price[index].value;
    quantity    = document.getElementsByName('quantity[]');
    xquantity   = quantity[index].value;
    if(xprice > '0' && xquantity > '0'){
        amount = document.getElementsByName('amount[]');
        amount[index].value   = formatter.format(parseFloat(transformToInt(xprice)) * parseInt(xquantity));

        total = 0;
        for(i=0;i < amount.length; i++){
            xaAmount        = amount[i].value.split(" ");
            if(xaAmount.length <= 1){
                xaAmount        = amount[i].value.split("$");
            }
            aAmountValue1   = xaAmount[1];
            //alert("value: "+ amount[i].value + "\n\nxaAmount: " + xaAmount + "\n0: " + xaAmount[0] + "\n1: " + xaAmount[1])
            axAmountS       = aAmountValue1.split(",");
            xVAmount        = '';
            for(j=0;j < axAmountS.length; j++){
                xVAmount        += axAmountS[j];
            }
            axAmountFinal   = xVAmount.split(".");
            xVAmountFinal   = '';
            for(k=0;k < axAmountFinal.length; k++){
                xVAmountFinal    += axAmountFinal[k];
            }
            realAmount  = (parseInt(xVAmountFinal) * 1) / 100;
            total = (parseFloat(total) * 1)+ (parseFloat(realAmount) * 1);
            //alert(total);
        }
        form.total.value = formatter.format(total);
    }
}

function transformToInt(value){
    arrayValue = value.split('.');
    lenArrayValue = arrayValue.length;
    stringValue = '';
    for(i = 0;i < lenArrayValue; i++){
        stringValue += arrayValue[i];
    }

    arrayValue = stringValue.split(',');
    lenArrayValue = arrayValue.length;
    stringValue = '';
    for(j = 0;j < lenArrayValue; j++){
        stringValue += arrayValue[j];
    }
    finalValue = parseInt(stringValue) / 100;
    return finalValue;
}

function newProductForm(copy,destination,items){
    
    //let divRow = document.createElement("div").setAttribute('class','form-row');
    //let divCol = document.createElement("div").setAttribute('class','col');
    //divRow.appendChild(divCol);
    
    //document.getElementById(destination).after(divRow);
    start_index++;
    document.getElementById(destination).innerHTML += (document.getElementById(copy).innerHTML.replace('proposal,0','proposal,'+start_index).replace('proposal,0','proposal,'+start_index).replace('product_0','product_'+start_index).replace('state_0','state_'+start_index).replace('price_0','price_'+start_index).replace('amount_0','amount_'+start_index).replace('DropdownMenuButton_0','DropdownMenuButton_'+start_index).replace(",'0');",",'"+start_index+"');").replace('div-selectcolony_0','div-selectcolony_'+start_index).replace('div-selectcounty_0','div-selectcounty_'+start_index).replace('div-selectcity_0','div-selectcity_'+start_index).replace('div-selectState_0','div-selectState_'+start_index));

    for(iteration=0; iteration <= items; iteration++){
        //alert(items + ' - '+ iteration)
        document.getElementById(destination).innerHTML = document.getElementById(destination).innerHTML.replace('Value_0','Value_'+start_index).replace('Name_0','Name_'+start_index).replace('Id_0','Id_'+start_index).replace('DropdownMenuButton_0','DropdownMenuButton_'+start_index).replace(",'0');",",'"+start_index+"');").replace('product_0','product_'+start_index).replace('salemodel_0','salemodel_'+start_index).replace('provider_0','provider_'+start_index).replace('oohkeys_0','oohkeys_'+start_index);
    }
    htmlRemoveButton = '<div class="form-row" id="btnRemove_'+start_index+'" >';
    htmlRemoveButton += '<div class="col" style="text-align:right;">';
    htmlRemoveButton += '<button class="btn-danger material-icons-outlined" type="button" onclick="removeProductForm('+start_index+');">remove_circle_outline</button>';
    htmlRemoveButton += '</div>';
    htmlRemoveButton += '</div>';

    document.getElementById(destination).innerHTML += htmlRemoveButton;
}

function removeProductForm(index){
    document.getElementById('product_'+index).remove();
    document.getElementById('btnRemove_'+index).remove();
}

function getId(table,where){
    errors      = 0;
    authApi     = csrf_token;
    locat       = window.location.hostname;

    // filters     = '&tid='+tid;
    xfilters    = '';
    filters     = '';

    xwhere      = where.split(",");
    for(i=0;i < xwhere.length;i++){
        ywhere      = xwhere[i].split("|||");
        filters += "&"+ywhere[0]+"="+ywhere[1];
    }

    

    if(locat.slice(-1) != '/')
        locat += '/';

    if(errors > 0){

    } else{
        const requestURLGet = window.location.protocol+'//'+locat+'api/'+table+'s/auth_'+table+'_get.php?auth_api='+authApi+filters;
        //alert(requestURLGet);
        const requestGet = new XMLHttpRequest();
        requestGet.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                
                objGet = JSON.parse(requestGet.responseText);
                proposal_id = objGet[0].UUID;
                return objGet[0].UUID;
            }
            else{
                //form.btnSave.innerHTML = "Searching...";
            }
        };
        requestGet.open('GET', requestURLGet);
        //request.responseType = 'json';
        requestGet.send();
    }
}

function addProduct(product_id,salemodel_id,price,currency,quantity,provider_id,proposal_id,state,city,county,colony){
    errors      = 0;
    authApi     = csrf_token;
    locat       = window.location.hostname;

    // filters     = '&tid='+tid
    //fields  = "product_id,salemodel_id,price,currency,quantity,provider_id,proposal_id";
    //values  = "'"+product_id+"','"+salemodel_id+"',"+price+",'"+currency+"',"+quantity+",'"+provider_id+"','"+proposal_id+"'";
    querystring = 'auth_api='+authApi+"&product_id="+product_id+"&salemodel_id="+salemodel_id+"&price="+price+"&currency="+currency+"&quantity="+quantity+"&provider_id="+provider_id+"&proposal_id="+proposal_id+"&state="+state+"&city="+city+"&county="+county+"&colony="+colony;


    if(locat.slice(-1) != '/')
        locat += '/';

    if(errors > 0){

    } else{
        const requestURLAdd = window.location.protocol+'//'+locat+'api/products/auth_product_add_new.php';
        //console.log(requestURLAdd + "\n?"+querystring);
        const requestAdd = new XMLHttpRequest();
        requestAdd.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                
                obj = JSON.parse(requestAdd.responseText);
                //console.log(obj);
//                return false;
            }
            else{
                //console.log(this.status + '\n' + JSON.parse(requestAdd.responseText));
                //form.btnSave.innerHTML = "Searching...";
            }
        };
        requestAdd.open('POST', requestURLAdd, false);
        requestAdd.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        //request.responseType = 'json';
        requestAdd.send(querystring);
    }
}

function listSelectedFiltersDropDownStyle(findInColumn,findString,bringColumn,table,index){
    errors      = 0;
    authApi     = csrf_token;
    locat       = window.location.hostname;
    submodule   = table;
    uxlang  = localStorage.getItem('ulang'); 

    filters = '';
    if( (findInColumn != '') && (findString != '')){
        filters = '&where='+findInColumn+'|||'+findString;
    }

    nextColumn = 'city';
    switch (bringColumn) {
    case 'city':
        nextColumn = 'county';
        break;
    case 'county':
        nextColumn = 'colony';
        break;
    }

    groupby = '&groupby='+bringColumn;
    orderby = '&orderby='+bringColumn;
    label   = translateText(bringColumn,uxlang);

    onchangestr = '';
    if(bringColumn != 'colony')
        onchangestr = "onmouseleave=\"if(document.getElementById('"+bringColumn+"Value_"+index+"').innerText != '"+label+"') { listSelectedFiltersDropDownStyle('"+bringColumn+"',document.getElementById('"+bringColumn+"Value_"+index+"').innerText,'"+nextColumn+"','"+table+"','"+index+"'); }\"";
    if(locat.slice(-1) != '/')
        locat += '/';

    if(errors > 0){

    } else{
        tableList   = document.getElementById('div-select'+bringColumn+'_'+index);
        const requestURL = window.location.protocol+'//'+locat+'api/'+submodule+'s/auth_'+submodule+'_view.php?auth_api='+authApi+filters+groupby+orderby+'&nameField='+bringColumn+'&fcn=selectInDropDown&allRows=1';
        //console.log(requestURL);
        const request = new XMLHttpRequest();
        request.onreadystatechange = function() {
            html        = '';
            html       += '<div class="dropdown" style="margin-top:1.2rem">';
            html       += '<button class="btn btn-primary dropdown-toggle" type="button" id="'+bringColumn+'DropdownMenuButton_'+index+'" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >'; 
            html       += '<span class="caret" id="'+bringColumn+'Value_'+index+'">'+label+'</span>';
            html       += '</button>';
            html       += '<ul class="dropdown-menu" aria-labelledby="'+bringColumn+'DropdownMenuButton">';
           // html       += '<input class="'+bringColumn+'Name[]" name="'+bringColumn+'Name" id="'+bringColumn+'Name_'+index+'" type="text" placeholder="Search..">';
            if (this.readyState == 4 && this.status == 200) {
                // Typical action to be performed when the document is ready:
                obj = JSON.parse(request.responseText);
                if( (obj.response != 'error') && (obj.response != 'ZERO_RETURN')){
                    html += '<li><a class="dropdown-item" href="#'+bringColumn+'DropdownMenuButton_'+index+'" onclick="document.getElementById(\''+bringColumn+'Value_'+index+'\').innerText=\''+label+'\'; document.getElementById(\''+bringColumn+'Id_'+index+'\').value=\'All\'; document.getElementById(\''+bringColumn+'Name_'+index+'\').value=\'All\'; " '+onchangestr+' >'+label+'</a></li>';
                    for(var i=0;i < obj['data'].length; i++){
                        html += '<li><a class="dropdown-item" href="#'+bringColumn+'DropdownMenuButton_'+index+'" onclick="document.getElementById(\''+bringColumn+'Value_'+index+'\').innerText=\''+obj['data'][i].name+'\'; document.getElementById(\''+bringColumn+'Id_'+index+'\').value=\''+obj['data'][i].name+'\'; document.getElementById(\''+bringColumn+'Name_'+index+'\').value=\''+obj['data'][i].name+'\'; " '+onchangestr+' >'+obj['data'][i].name+'</a></li>';
                    }
                }
                else {
                    html    = '';
                }
                tableList.innerHTML = html;
            }
            else{
                html += '<li><a class="dropdown-item" href="#'+bringColumn+'DropdownMenuButton_'+index+'" onclick="document.getElementById(\''+bringColumn+'Value_'+index+'\').innerText=\'Cargando...\'; document.getElementById(\''+bringColumn+'Id_'+index+'\').value=\'0\'; document.getElementById(\''+bringColumn+'Name_'+index+'\').value=\'cargando...\'; " '+onchangestr+' >Cargando...</a></li>';
                tableList.innerHTML = html;
                //form.btnSave.innerHTML = "Searching...";
            }
            html += '</ul></div>';
        };
        request.open('GET', requestURL);
        //request.responseType = 'json';
        request.send();
    } 
}


function listAdvertiserContacts(aid){
    errors      = 0;
    authApi     = csrf_token;
    locat       = window.location.hostname;
    submodule   = 'contact';

    if(locat.slice(-1) != '/')
        locat += '/';

    filters     = '&aid='+aid;

    if(errors > 0){

    } else{
        tableList   = document.getElementById('div-selectContact');
        const requestURL = window.location.protocol+'//'+locat+'api/'+submodule+'s/auth_'+submodule+'_list.php?auth_api='+authApi+filters;
        //console.log(requestURL);
        const request = new XMLHttpRequest();
        request.onreadystatechange = function() {
            labelContact = translateText('contact',localStorage.getItem('ulang'));
            html    = '<label for="contact_id">'+labelContact[0].toUpperCase() + labelContact.slice(1);+'</label>';
            html   += '<spam id="scontact">'
            html   += '<SELECT name="contact_id" title="contact_id" class="form-control" autocomplete="contact_id">';
            if (this.readyState == 4 && this.status == 200) {
                // Typical action to be performed when the document is ready:
                obj = JSON.parse(request.responseText);
                if( (obj.response != 'error') && (obj.response != 'ZERO_RETURN')){
                    for(var i=0;i < obj.length; i++){
                        contact_fullname = obj[i].contact_name + ' ' + obj[i].contact_surname + ' (' + obj[i].contact_email + ')';
                        html += '<OPTION value="'+obj[i].contact_id+'"/>'+contact_fullname;
                    }
                    html    += '</SELECT>';
                    html    += '</spam>';
                }
                else {
                    html    = '';
                }
                tableList.innerHTML = html;
            }
            else{
                html    += '<OPTION value="0000"/>Loading...';
                html    += '</SELECT>';
                tableList.innerHTML = html;
                //form.btnSave.innerHTML = "Searching...";
            }
        };
        request.open('GET', requestURL);
        //request.responseType = 'json';
        request.send();
    } 
}

function listProviderContacts(pid){

}

function refilterProductsType(typeInt,indexValue){
    typeInt++;
    if(typeInt > 1)
        typeInt = 0;
    document.getElementById('digital_product').value = typeInt;
    
    errors      = 0;
    authApi     = csrf_token;
    locat       = window.location.hostname;
    submodule   = 'product';

    if(locat.slice(-1) != '/')
        locat += '/';

    filters     = "&digyn=Y";
    if(typeInt == '0')
        filters     = "&digyn=N";
        
    if(errors > 0){

    } else{
        productList   = document.getElementById('div-selectproduct_0');
        const requestURL = window.location.protocol+'//'+locat+'api/'+submodule+'s/auth_'+submodule+'_list.php?auth_api='+authApi+filters;
        //console.log(requestURL);
        const request = new XMLHttpRequest();
        request.onreadystatechange = function() {
            html    = '<label for="product_id[]">'+ucfirst(translateText('product',localStorage.getItem('ulang')))+'</label>';
            html   += '<spam id="sproduct">'
            html   += '<SELECT id="selectproduct_'+indexValue+'" name="product_id[]" onchange="refilterSaleModel('+typeInt+',this.value)" title="product_id" class="form-control" autocomplete="product_id"  required>';
            if (this.readyState == 4 && this.status == 200) {
                // Typical action to be performed when the document is ready:
                obj = JSON.parse(request.responseText);
                if( (obj.response != 'error') && (obj.response != 'ZERO_RETURN')){
                    html += '<OPTION value="0"/>'+translateText('please_select',localStorage.getItem('ulang'))+' '+ucfirst(translateText('product',localStorage.getItem('ulang')));
                    for(var i=0;i < obj.length; i++){
                        html += '<OPTION value="'+obj[i].uuid_full+'"/>'+obj[i].name;
                    }
                    html    += '</SELECT>';
                    html    += '</spam>';
                }
                else {
                    html    = '';
                }
                productList.innerHTML = html;
            }
            else{
                html    += '<OPTION value="0000"/>Loading...';
                html    += '</SELECT>';
                productList.innerHTML = html;
                //form.btnSave.innerHTML = "Searching...";
            }
        };
        request.open('GET', requestURL);
        //request.responseType = 'json';
        request.send();
    }
    //refilterSaleModel(typeInt);
}


function refilterSaleModel(typeInt,productCode,indexValue){
    errors      = 0;
    authApi     = csrf_token;
    locat       = window.location.hostname;
    submodule   = 'salemodel';
    if(document.getElementById("div-selectsalemodel_"+indexValue).style.display === "none"){
        document.getElementById("div-oohkeys_"+indexValue).style.display = 'none';
        document.getElementById("div-provider_"+indexValue).style.display = 'block';
        document.getElementById("div-selectsalemodel_"+indexValue).style.display = 'block';    
    }


    if(locat.slice(-1) != '/')
        locat += '/';

    filters     = "&digyn=Y";
    if(typeInt == '0')
        filters     = "&digyn=N";

    if(productCode){
        filters     += "&where=product_id|||"+productCode+"*|*product_id|||null";

    }

    if(errors > 0){

    } else{
        salemodelList   = document.getElementById('div-selectsalemodel_0');
        const requestURL = window.location.protocol+'//'+locat+'api/'+submodule+'s/auth_'+submodule+'_view.php?auth_api='+authApi+filters;
        //console.log(requestURL);
        const request = new XMLHttpRequest();
        request.onreadystatechange = function() {
            html    = '<label for="salemodel_id[]">' + ucfirst(translateText('sale_model',localStorage.getItem('ulang'))) + '</label>';
            html   += '<spam id="ssalemodel">'
            html   += '<SELECT id="selectsalemodel_'+indexValue+'"  name="salemodel_id[]" title="salemodel_id" class="form-control" autocomplete="salemodel_id" required>';
            if (this.readyState == 4 && this.status == 200) {
                // Typical action to be performed when the document is ready:
                obj = JSON.parse(request.responseText);
                if( (obj.response != 'error') && (obj.response != 'ZERO_RETURN')){
                    html += '<OPTION value="0"/>' + translateText('please_select',localStorage.getItem('ulang')) + ' ' + ucfirst(translateText('sale_model',localStorage.getItem('ulang'))) + '';
                    for(var i=0;i < obj['data'].length; i++){
                        html += '<OPTION value="'+obj['data'][i].uuid_full+'"/>'+obj['data'][i].name;
                    }
                    html    += '</SELECT>';
                    html    += '</spam>';
                }
                else {
                    html    = '';
                }            
                salemodelList.innerHTML = html;
            }
            else{
                html    += '<OPTION value="0000"/>Loading...';
                html    += '</SELECT>';
                salemodelList.innerHTML = html;
                //form.btnSave.innerHTML = "Searching...";
            }
        };
        request.open('GET', requestURL);
        //request.responseType = 'json';
        request.send();
    }
}


function checkOOHSelection(stringValue,indexValue){
    xhtml = "";
    if(stringValue == "OOH"){
        //xhtml += '<div class="col">';
        xhtml += '<label for="oohkeys[]">'+ucfirst(translateText('key',localStorage.getItem('ulang')))+ '(s) - '+stringValue+'</label><br/>';
        xhtml += '<TEXTAREA id="oohkeys_'+indexValue+'" name="oohkeys[]" rows="5" placeholder="'+ucfirst(translateText('key',localStorage.getItem('ulang')))+ '(s) - '+stringValue+'" class="form-control" id="oohkeys_0"></TEXTAREA>';
        //xhtml += '</div>';
        if(document.getElementById("div-oohkeys_"+indexValue).style.display === "none"){
            document.getElementById("div-selectsalemodel_"+indexValue).style.display = 'none';
            document.getElementById("div-provider_"+indexValue).style.display = 'none';
            document.getElementById("div-oohkeys_"+indexValue).style.display = 'block';
        }
    }
    document.getElementById("div-oohkeys_"+indexValue).innerHTML = xhtml;
}

function executeFeeOnPrice(proposalproduct_id,billboard_id,price_int,name,xxcurrency){
    authApi     = csrf_token;
    
    locat       = window.location.hostname;
    if(locat.slice(-1) != '/')
        locat += '/';
    
    var formatter = new Intl.NumberFormat(lang, {
        style: 'currency',
        currency: xxcurrency,
        //maximumSignificantDigits: 2,

        // These options are needed to round to whole numbers if that's what you want.
        //minimumFractionDigits: 2, // (this suffices for whole numbers, but will print 2500.10 as $2,500.1)
        //maximumFractionDigits: 0, // (causes 2500.99 to be printed as $2,501)
    });
    price = parseInt(price_int) / 100;
    feeInput = document.getElementById('fee-'+billboard_id);
    newPrice = price/((100 - parseFloat(feeInput.value))/100);
    newPrice_int = parseInt(newPrice * 100);
    filters     = '&npc='+newPrice_int+'&pbid='+billboard_id+'&pppid='+proposalproduct_id;

    if(confirm('Confirma el cambio de '+feeInput.value+'% ('+(formatter.format(price))+' para '+formatter.format(newPrice)+') en '+name)){  //traduzir
        const requestURL = window.location.protocol+'//'+locat+'api/proposals/auth_proposalproduct_change_price.php?auth_api='+authApi+filters;
        //console.log(requestURL);
        const request = new XMLHttpRequest();
        request.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                // Typical action to be performed when the document is ready:
                //console.log(request.responseText);
                obj = JSON.parse(request.responseText);
                if(obj.response == 'OK'){
                    
                    priceSPAM   = document.getElementById('price-'+billboard_id);
                    priceSPAM.innerText=formatter.format(newPrice);
                }
                
            }
        };
        request.open('GET', requestURL);
        //request.responseType = 'json';
        request.send();
    }
}

function addBannerCost(proposalproduct_id,billboard_id,name,xxcurrency){
    authApi     = csrf_token;
    
    locat       = window.location.hostname;
    if(locat.slice(-1) != '/')
        locat += '/';
    
    var formatter = new Intl.NumberFormat(lang, {
        style: 'currency',
        currency: xxcurrency,
        //maximumSignificantDigits: 2,

        // These options are needed to round to whole numbers if that's what you want.
        //minimumFractionDigits: 2, // (this suffices for whole numbers, but will print 2500.10 as $2,500.1)
        //maximumFractionDigits: 0, // (causes 2500.99 to be printed as $2,501)
    });

    cost = 0;
    let new_cost = prompt("Costo de producción", cost);  //traduzir

    if (new_cost > 0) {

        newCost_int = parseInt(new_cost * 100);
        filters     = '&cst='+newCost_int+'&pbid='+billboard_id+'&pppid='+proposalproduct_id;

        if(confirm('Confirma el costo de '+(formatter.format(new_cost))+' en '+name)){  //traduzir
            const requestURL = window.location.protocol+'//'+locat+'api/proposals/auth_proposalproduct_add_cost.php?auth_api='+authApi+filters;
            //console.log(requestURL);
            const request = new XMLHttpRequest();
            request.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    // Typical action to be performed when the document is ready:
                    //console.log(request.responseText);
                    obj = JSON.parse(request.responseText);
                    if(obj.response == 'OK'){
                        
                        priceSPAM   = document.getElementById('cost-'+billboard_id);
                        priceSPAM.innerText=formatter.format(new_cost);
                    }
                    
                }
            };
            request.open('GET', requestURL);
            //request.responseType = 'json';
            request.send();
        }
    }
}


function calculatorFee(proposalproduct_id,billboard_id,price_int,name,xxcurrency){
    authApi     = csrf_token;
    
    locat       = window.location.hostname;
    if(locat.slice(-1) != '/')
        locat += '/';
    
    var formatter = new Intl.NumberFormat(lang, {
        style: 'currency',
        currency: xxcurrency,
        //maximumSignificantDigits: 2,

        // These options are needed to round to whole numbers if that's what you want.
        //minimumFractionDigits: 2, // (this suffices for whole numbers, but will print 2500.10 as $2,500.1)
        //maximumFractionDigits: 0, // (causes 2500.99 to be printed as $2,501)
    });
    price = parseInt(price_int) / 100;


    let new_price = prompt("nuevo monto", price);  //traduzir

    if (new_price > 0) {

        document.getElementById('fee-'+billboard_id).value = 100-((price / new_price) * 100);
        feeInput = document.getElementById('fee-'+billboard_id).value;
        newPrice = price/((100 - parseFloat(feeInput))/100);
        newPrice_int = parseInt(newPrice * 100);
        filters     = '&npc='+newPrice_int+'&pbid='+billboard_id+'&pppid='+proposalproduct_id;

        if(confirm('Confirma el cambio de '+feeInput.value+'% ('+(formatter.format(price))+' para '+formatter.format(newPrice)+') en '+name)){  //traduzir
            const requestURL = window.location.protocol+'//'+locat+'api/proposals/auth_proposalproduct_change_price.php?auth_api='+authApi+filters;
            //console.log(requestURL);
            const request = new XMLHttpRequest();
            request.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    // Typical action to be performed when the document is ready:
                    //console.log(request.responseText);
                    obj = JSON.parse(request.responseText);
                    if(obj.response == 'OK'){
                        
                        priceSPAM   = document.getElementById('price-'+billboard_id);
                        priceSPAM.innerText=formatter.format(newPrice);
                    }
                    
                }
            };
            request.open('GET', requestURL);
            //request.responseType = 'json';
            request.send();
        }
    }
}

function changeStatus(proposalId,newStatus,oldStatus){
    authApi     = csrf_token;

    if(newStatus != oldStatus){
        msg = '';
        if(oldStatus == 1){
            msg = 'No es posible cambiar propuestas perdidas!'; //traduzir
            
        }

        if(oldStatus == 6){
            msg = 'No es posible cambiar propuestas ya aprobadas!';  //traduzir
        }
        if(msg != ''){
            alert(msg);
            return false;
        }
    }

    locat       = window.location.hostname;
    if(locat.slice(-1) != '/')
        locat += '/';


    let uid = localStorage.getItem('uuid');
    filters = '&uid='+uid+'&ppid='+proposalId;
    
    if(newStatus != oldStatus){
        filters += '&newStatus='+newStatus+'&oldStatus='+oldStatus;
        const requestURL = window.location.protocol+'//'+locat+'api/proposals/auth_proposal_changeStatus.php?auth_api='+authApi+filters;   
        //console.log(requestURL);
        const request = new XMLHttpRequest();
        request.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                // Typical action to be performed when the document is ready:
                //console.log(request.responseText);
                obj = JSON.parse(request.responseText);
                if(obj.response == 'OK'){
                    // cambiar la información en vivo con el nuevo status. Si el status es 100% o 0%, no permitir más cambios


                }
                
            }
        };
        request.open('GET', requestURL);
        //request.responseType = 'json';
        request.send();
    }
    
    
}