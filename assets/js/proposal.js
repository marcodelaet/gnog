lang        = 'es-MX';
start_index = 0;
document.getElementById('nav-item-proposals').setAttribute('class',document.getElementById('nav-item-proposals').getAttribute('class').replace(' active','') + ' active');
var csrf_token = $('meta[name="csrf-token"]').attr('content');
//alert(csrf_token);

proposal_id = '';

function handleSubmit(form) {
    if (form.name.value !== '' && form.client_id.value !== '' && form.start_date.value !== '' || form.client_id.value !== '0' || form.agency_id.value !== '0' || form.total.value !== '0,00' || form.status_id.value !== '0') {
        //form.submit();
        errors      = 0;
        authApi     = 'dasdasdkasdeewef';
        message     = '';

        pixel      = 'N';
        if(form.pixel.checked)
            pixel               = 'Y';
        xname                   = form.name.value;
        client_id               = form.client_id.value;
        agency_id               = form.agency_id.value;
        description             = form.description.value;
        start_date              = form.start_date.value;
        stop_date               = form.stop_date.value;
        total                   = form.total.value;
        status_id               = form.status_id.value;
        currency                = form.currency.value;

        objProduct      = document.getElementsByName('product_id[]');
        objSaleModel    = document.getElementsByName('salemodel_id[]');
        objPrice        = document.getElementsByName('price[]');
        
        objQuantity     = document.getElementsByName('quantity[]');
        objProviderId   = document.getElementsByName('provider_id[]');

        locat       = window.location.hostname;
        if(locat.slice(-1) != '/')
            locat += '/';

        if(errors > 0){
            alert(message);
        } else{
            const requestURL = window.location.protocol+'//'+locat+'api/proposals/auth_proposal_add_new.php?auth_api='+authApi+'&name='+xname+'&pixel='+pixel+'&client_id='+client_id+'&agency_id='+agency_id+'&description='+description+'&start_date='+start_date+'&stop_date='+stop_date+'&status_id='+status_id;
            //alert(requestURL);
            const request = new XMLHttpRequest();
            request.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    // Typical action to be performed when the document is ready:
                    obj = JSON.parse(request.responseText);
                    proposal_id = obj[0].UUID;
                   
                    //alert('len: ' + objProduct.length);
                    virg            = '';
                    product_id      = '';
                    salemodel_id    = '';
                    price           = '';
                    quantity        = '';
                    provider_id     = '';

                    for(i=0; i < objProduct.length;i++)
                    {
                        if(i>0)
                            virg = ',';

                        xprice  = '';
                        axPrice = objPrice[i].value.split(",");
                        for(j=0;j < axPrice.length;j++){
                            apPrice     = axPrice[j].split(".");
                            for(k=0;k < apPrice.length;k++){
                                xprice      += apPrice[k];
                            }
                        }
                        product_id      += virg + objProduct[i].value;
                        salemodel_id    += virg + objSaleModel[i].value;
                        price           += virg + xprice;
                        quantity        += virg + objQuantity[i].value;
                        provider_id     += virg + objProviderId[i].value;
                        
                    }
                    addProduct('['+product_id+']','['+salemodel_id+']','['+price+']',currency,'['+quantity+']','['+provider_id+']',proposal_id);

                    form.btnSave.innerHTML = "Save";
                    //alert('Status: '+obj.status);
                    window.location.href = '?pr=Li9wYWdlcy9wcm9wb3NhbHMvdGtwL2luZGV4LnBocA==';
                }
                else{
                    form.btnSave.innerHTML = "Saving...";
                }
            };
            request.open('GET', requestURL, true);
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
            sett     += '&name='+name;
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
            console.log(requestURL);
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

function handleViewOnLoad(tid) {
    errors      = 0;
    authApi     = 'dasdasdkasdeewef';
    locat       = window.location.hostname;

    filters     = '&tid='+tid;

    if(locat.slice(-1) != '/')
        locat += '/';

    if(errors > 0){

    } else{
        const requestURL = window.location.protocol+'//'+locat+'api/proposals/auth_proposal_get.php?auth_api='+authApi+filters;
        //alert(requestURL);
        const request   = new XMLHttpRequest();
        position        = '*****';
        request.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                obj = JSON.parse(request.responseText);
                // Create our number formatter.
                var formatter = new Intl.NumberFormat(lang, {
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
        const requestURL = window.location.protocol+'//'+locat+'api/proposals/auth_proposal_get.php?auth_api='+authApi+filters;
        alert(requestURL);
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
        tableList   = document.getElementById('listProposals');
        const requestURL = window.location.protocol+'//'+locat+'api/proposals/auth_proposal_list.php?auth_api='+authApi+filters;
        //alert(requestURL);
        const request = new XMLHttpRequest();
        request.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                // Typical action to be performed when the document is ready:
                obj         = JSON.parse(request.responseText);
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
                    color_user_status = '#d60b0e';
                    if(obj[i].is_active == 'Y')
                        color_user_status = '#298c3d';
                    agency = '';
                    if(typeof(obj[i].agency_name) === 'string')
                        agency = ' / '+obj[i].agency_name;
                    amount = obj[i].amount;
                    start_date  = new Date(obj[i].start_date);
                    stop_date   = new Date(obj[i].stop_date);
                    html += '<tr><td>'+obj[i].offer_name+'</td><td nowrap>'+obj[i].client_name+agency+'</td><td nowrap>'+obj[i].username+'</td><td nowrap>'+formatter.format(amount)+'</td><td>'+start_date.toLocaleString(lang).split(" ")[0].replace(",","")+'</td><td>'+stop_date.toLocaleString(lang).split(" ")[0].replace(",","")+'</td><td style="text-align:center;"><span id="locked_status_'+obj[i].UUID+'" class="material-icons" style="color:'+color_user_status+'">attribution</span></td><td nowrap style="text-align:center;">';
                    // information card
                    html += '<a href="?pr=Li9wYWdlcy9wcm9wb3NhbHMvaW5mby5waHA=&tid='+obj[i].UUID+'"><span class="material-icons" style="font-size:1.5rem; color:black;" title="User Information Card '+obj[i].offer_name+'">info</span></a>';

                    // Edit form
                    html += '<a href="?pr=Li9wYWdlcy9wcm9wb3NhbHMvZm9ybWVkaXQucGhw&tid='+obj[i].UUID+'"><span class="material-icons" style="font-size:1.5rem; color:black;" title="Edit user '+obj[i].offer_name+'">edit</span></a>';

                    // Remove 
                    html += '<a href="javascript:void(0)" onclick="handleRemove(\''+obj[i].UUID+'\',\''+obj[i].is_active+'\')"><span class="material-icons" style="font-size:1.5rem; color:black;" title="Remove user '+obj[i].offer_name+'">delete</span></a>';

                    html += '</td></tr>';
                }
                tableList.innerHTML = html;
            }
            else{
                html = '<tr><td colspan="8"><div style="margin-left:45%; margin-right:45%;" class="spinner-border" style="text-align:center;" role="status">';
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
    const requestURL = window.location.protocol+'//'+locat+'api/proposals/auth_proposal_remove.php?auth_api='+authApi+filters;
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
        amount[index].value   = formatter.format(parseFloat(xprice.replace(",",".")) * parseInt(xquantity));

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

function newProductForm(copy,destination){
    
    //let divRow = document.createElement("div").setAttribute('class','form-row');
    //let divCol = document.createElement("div").setAttribute('class','col');
    //divRow.appendChild(divCol);
    
    //document.getElementById(destination).after(divRow);
    start_index++;
    document.getElementById(destination).innerHTML += (document.getElementById(copy).innerHTML.replace('proposal,0','proposal,'+start_index).replace('proposal,0','proposal,'+start_index).replace('product_0','product_'+start_index));
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
    authApi     = 'dasdasdkasdeewef';
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
        alert(requestURLGet);
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

function addProduct(product_id,salemodel_id,price,currency,quantity,provider_id,proposal_id){
    errors      = 0;
    authApi     = 'dasdasdkasdeewef';
    locat       = window.location.hostname;

    // filters     = '&tid='+tid
    //fields  = "product_id,salemodel_id,price,currency,quantity,provider_id,proposal_id";
    //values  = "'"+product_id+"','"+salemodel_id+"',"+price+",'"+currency+"',"+quantity+",'"+provider_id+"','"+proposal_id+"'";
    querystring = 'auth_api='+authApi+"&product_id="+product_id+"&salemodel_id="+salemodel_id+"&price="+price+"&currency="+currency+"&quantity="+quantity+"&provider_id="+provider_id+"&proposal_id="+proposal_id


    if(locat.slice(-1) != '/')
        locat += '/';

    if(errors > 0){

    } else{
        const requestURLAdd = window.location.protocol+'//'+locat+'api/products/auth_product_add_new.php';
        alert(requestURLAdd + "\nqs: "+querystring);
        const requestAdd = new XMLHttpRequest();
        requestAdd.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                
                obj = JSON.parse(requestAdd.responseText);
//                return false;
            }
            else{
                //form.btnSave.innerHTML = "Searching...";
            }
        };
        requestAdd.open('POST', requestURLAdd, true);
        requestAdd.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        //request.responseType = 'json';
        requestAdd.send(querystring);
    }
}