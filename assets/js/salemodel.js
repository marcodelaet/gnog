ulang       = localStorage.getItem('ulang');
uid         = localStorage.getItem('uuid');

xlang        = 'es-MX';
if(ulang == 'ptbr')
    xlang    = 'pt-BR';
if(ulang == 'eng')
    xlang    = 'en-US';

document.getElementById('nav-item-users').setAttribute('class',document.getElementById('nav-item-users').getAttribute('class').replace(' active','') + ' active');
var csrf_token = $('meta[name="csrf-token"]').attr('content');
module  = 'salemodel';

xcurrency = 'MXN';

function handleSubmit(form) {
    if (form.name.value !== '') {
        errors      = 0;
        authApi     = csrf_token;
        message     = '';

        digital_product       = 'N';
        if(form.digital_product.checked)
            digital_product   = 'Y';

        var formData = new FormData(form);
        formData.append('auth_api',authApi);
        formData.append('uid',uid);
        formData.append('digital_product',digital_product);

        locat       = window.location.hostname;
        if(locat.slice(-1) != '/')
            locat += '/';

        if(errors > 0){
            alert(message);
        } else{
            const requestURL = window.location.protocol+'//'+locat+'api/salemodels/auth_salemodel_add_new.php';
            const request = new XMLHttpRequest();
            request.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    // Typical action to be performed when the document is ready:
                    obj = JSON.parse(request.responseText);
                    if(obj.status == 'OK'){
                        form.btnSave.innerHTML = "Save";                        
                        window.location.href = '?pr=Li9wYWdlcy9zYWxlbW9kZWxzL2luZGV4LnBocA==';
                    }
                }
                else{
                    form.btnSave.innerHTML = "Saving...";
                }
            };
            request.open('POST', requestURL,false);
            request.send(formData);
        }
    } else
        alert('Please, fill all required fields (*)');
}

function handleEditSubmit(smid,form) {
    price   = form.price.value;
    cost    = form.cost.value;
    if (price != '0' && cost != '0') {
        //form.submit();
   
        errors      = 0;
        authApi     = csrf_token;
        
        sett     = '&smid='+smid;

        price_int       = price.replace('MX','').replace('$','').replace(' ','').replace('US','').replace('BRL','').replace('R$','').replace('USD','').replace('MXN','');
        cost_int        = cost.replace('MX','').replace('$','').replace(' ','').replace('US','').replace('BRL','').replace('R$','').replace('USD','').replace('MXN','');

        // PRICE ***************************
        decimalPoint    = price_int.substr(-3,1);
        millePoint      = '.';
        if(decimalPoint == '.'){
            millePoint      = ',';
        }
        IntegerValue        = '';
        decimalValue        = price_int.split(decimalPoint)[1];
        arrayIntegerValue   = price_int.split(decimalPoint)[0].split(millePoint);
        for(m=0;m<arrayIntegerValue.length; m++){
            IntegerValue += arrayIntegerValue[m];
        }
        if(parseInt(decimalValue) > 0){
            IntegerValue = IntegerValue + decimalValue;
        } else {
            IntegerValue = IntegerValue + '00';
        }
        price_int = IntegerValue.replace(' ','');

        // COST ***************************
        decimalPoint    = cost_int.substr(-3,1);
        millePoint      = '.';
        if(decimalPoint == '.'){
            millePoint      = ',';
        }
        IntegerValue        = '';
        decimalValue        = cost_int.split(decimalPoint)[1];
        arrayIntegerValue   = cost_int.split(decimalPoint)[0].split(millePoint);
        for(m=0;m<arrayIntegerValue.length; m++){
            IntegerValue += arrayIntegerValue[m];
        }
        if(parseInt(decimalValue) > 0){
            IntegerValue = IntegerValue + decimalValue;
        } else {
            IntegerValue = IntegerValue + '00';
        }
        cost_int = IntegerValue.replace(' ','');

        //console.log(sett);
        //alert('pausa');
        locat       = window.location.hostname;
        if(locat.slice(-1) != '/')
            locat += '/';

        if((parseInt(price_int) > 0) && (parseInt(cost_int) > 0)){
            if(parseInt(price_int) > 0){
                sett     += '&price_int='+price_int;
            }
            if(parseInt(cost_int) > 0){
                sett     += '&cost_int='+cost_int;
            }
            
            //errors = 1;
            if(errors > 0){
            
            } else{
                const requestURL = window.location.protocol+'//'+locat+'api/salemodels/auth_salemodel_edit.php?auth_api='+authApi+sett.replace(' ','').replace(' ','');
                console.log(requestURL);
                const request = new XMLHttpRequest();
                request.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                    // Typical action to be performed when the document is ready:
                    obj = JSON.parse(request.responseText);
                    form.btnSave.innerHTML = "Save";
                    window.location.href = '?pr=Li9wYWdlcy9iaWxsYm9hcmRzL2luZGV4LnBocA==';
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

        }
    } else
        alert('Please, fill all required fields (*)');
}

function handleViewOnLoad(smid) {
    errors      = 0;
    authApi     = csrf_token;
    locat       = window.location.hostname;

    filters     = '&smid='+smid;

    if(locat.slice(-1) != '/')
        locat += '/';

    if(errors > 0){

    } else{
        const requestURL = window.location.protocol+'//'+locat+'api/salemodels/auth_salemodel_get.php?auth_api='+authApi+filters;
        //alert(requestURL);
        const request   = new XMLHttpRequest();
        request.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                obj = JSON.parse(request.responseText);
                if(obj['response'] == 'OK'){
                    // Create our number formatter.
                    var formatter = new Intl.NumberFormat('pt-BR', {
                        style: 'currency',
                        currency: 'MXN',
                        //maximumSignificantDigits: 2,

                        // These options are needed to round to whole numbers if that's what you want.
                        //minimumFractionDigits: 2, // (this suffices for whole numbers, but will print 2500.10 as $2,500.1)
                        //maximumFractionDigits: 0, // (causes 2500.99 to be printed as $2,501)
                    });
                    document.getElementById('field-key').innerHTML          = obj['data'][0].name;
                    document.getElementById('field-address').innerHTML      = obj['data'][0].address;
                    document.getElementById('field-salemodel').innerHTML    = obj['data'][0].salemodel_name;
                    document.getElementById('field-viewpoint').innerHTML    = obj['data'][0].viewpoint_name;
                    document.getElementById('field-coordenates').innerHTML  = obj['data'][0].coordenates;
                    document.getElementById('field-dimension').innerHTML    = (parseInt(obj['data'][0].height)/100).toFixed(1) + 'x' + (parseInt(obj['data'][0].width)/100).toFixed(1);
                    document.getElementById('field-image-photo').src  = '/assets/img/logo_gnog_media_y_tecnologia.svg';
                } else {
                    alert(obj['response']);
                }
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

function handleOnLoad(smid,form) {
    errors      = 0;
    authApi     = csrf_token;
    locat       = window.location.hostname;

    filters     = '&smid='+smid;
  
    if(locat.slice(-1) != '/')
        locat += '/';

    if(errors > 0){

    } else{
        const requestURL = window.location.protocol+'//'+locat+'api/salemodels/auth_salemodel_get.php?auth_api='+authApi+filters;
        //console.log('trekkk - '+requestURL);
        const request = new XMLHttpRequest();
        request.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                
                obj         = JSON.parse(request.responseText);
                //xcurrency   = 'BRL';
                //xlang        = 'en-US';

                    // Create our number formatter.
                    var formatter = new Intl.NumberFormat(xlang, {
                        //style: 'currency',
                        //currency: xcurrency,
                        //maximumSignificantDigits: 2,

                        // These options are needed to round to whole numbers if that's what you want.
                        minimumFractionDigits: 2, // (this suffices for whole numbers, but will print 2500.10 as $2,500.1)
                        //maximumFractionDigits: 0, // (causes 2500.99 to be printed as $2,501)
                    });

                form.name_key.value                 = obj.data[0].name;
                form.address.value                  = obj.data[0].address;
                form.category.value                 = obj.data[0].category;
                form.coordenates.value              = obj.data[0].coordenates;
                form.salemodel.value                = obj.data[0].salemodel_name;
                form.viewpoint.value                = obj.data[0].viewpoint_name;
                xiluminated                         = translateText('is_iluminated',ulang);
                if(obj.data[0].is_iluminated == 'N')
                    xiluminated                     = translateText('is_not_iluminated',ulang);
                form.iluminated.value               = xiluminated.charAt(0).toUpperCase() + xiluminated.substring(1);
                form.dimensions.value               = parseInt(obj.data[0].height) + 'x' + parseInt(obj.data[0].width);
                form.provider.value                 = obj.data[0].provider_name;
                form.price.value                    = formatter.format(obj.data[0].price/100);
                form.cost.value                     = formatter.format(obj.data[0].cost/100);
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

function handleListOnLoad(search,page) {
    errors      = 0;
    authApi     = csrf_token;
    locat       = window.location.hostname;

    groupby     = '';
    orderby     = '&orderby=product_name,name';
    addColumn   = '';

    filters     = '';
    if(typeof search == 'undefined')
        search  = '';
    if(search !== ''){
        filters     += '&search='+search;
    }

    pages       = '';
    if(typeof page == 'undefined')
        page  = '1';
    if(page !== '1'){
        pages     += '&p='+(parseInt(page)-1);
    }

    lines       = 50; // quantity of lines to return on JSON result query
    
    strlines    = '&returninglines='+lines;
    if(locat.slice(-1) != '/')
        locat += '/';

    if(errors > 0){

    } else{
        tableList   = document.getElementById('listSalemodels');
        const requestURL = window.location.protocol+'//'+locat+'api/salemodels/auth_salemodel_view.php?auth_api='+authApi+filters+groupby+orderby+addColumn+pages+strlines;
        console.log(requestURL);
        const request = new XMLHttpRequest();
        request.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                // Typical action to be performed when the document is ready:
                obj         = JSON.parse(request.responseText);

                if(obj.response == 'ZERO_RETURN'){
                    html = '<tr><td colspan="6" style="text-align:center;">'+translateText('0_results',ulang)+'</td></tr>';
                    tableList.innerHTML = html;
                    pagesController(page,obj['pages']);
                    if(parseInt(page) > parseInt(obj['pages'])){
                        page        = 1;
                        filter.goto.value = 1;
                    }
                    return false;
                }
                if(obj.response == 'OK'){
                    html        = '';
                    country     = '';
                    
                    for(var i=0;i < obj['data'].length; i++){
                        color_status_active = '#d60b0e';
                        if(obj['data'][i].is_active == 'Y') {
                            color_status_active = '#298c3d';
                        }
                        
                        isDigitalImage  = 'memory';
                        isDigitalText   = translateText('is_digital',ulang);
                        if(obj['data'][i].is_digital == 'N'){
                            isDigitalImage  ='crop_square';
                            isDigitalText   =translateText('is_not_digital',ulang);
                        }

                        product_name = ucfirst(translateText('all',ulang));
                        if(obj['data'][i].product_name != null){
                            product_name = obj['data'][i].product_name;
                        }

                        html += '<tr><td>'+product_name+'</td><td>'+obj['data'][i].name+'</td>';
                        html += '<td style="text-align: center;" nowrap><span class="material-icons" style="font-size:1.5rem; color:black;" title="'+product_name+' / '+obj['data'][i].name+' '+isDigitalText+'">'+isDigitalImage+'</span></td>';
                        //html += '<td nowrap>'+obj['data'][i].viewpoint_name+'</td><td nowrap>'+parseFloat(obj['data'][i].height).toFixed(2)+' x '+parseFloat(obj['data'][i].width).toFixed(2)+'</td><td nowrap>'+obj['data'][i].salemodel_name+'</td>';
                        html += '<td>&nbsp</td>';
                        html += '<td style="text-align:center;"><span id="locked_status_'+obj['data'][i].uuid_full+'" class="material-icons" style="color:'+color_status_active+'">circle</span></td>';
                    //  html += '<tr><td>'+obj['data'][i].provider_name+'</td><td>'+obj['data'][i].name+'</td><td >'+obj['data'][i].address+'</td><td nowrap>'+obj['data'][i].salemodel_name+'</td>';
                        // information card
                        html += '<td nowrap style="text-align:center;"><a onclick=\'window.open("./pages/salemodels/info.php?smid='+obj['data'][i].uuid_full+'","salemodel-'+obj['data'][i].uuid_full+'","height=510.2,width=652,resizable=0,scrollbars=0,status=0,titlebar=0,toolbar=0,location=0,menubar=0")\'><span class="material-icons" style="font-size:1.5rem; color:black;" title="Information Card -> '+product_name+' - '+obj['data'][i].name+'">info</span></a>';

                        // Edit form
                       // html += '<a href="?pr=Li9wYWdlcy9iaWxsYm9hcmRzL2Zvcm1lZGl0LnBocA==&smid='+obj['data'][i].uuid_full+'"><span class="material-icons" style="font-size:1.5rem; color:black;" title="Edit -> '+product_name+' - '+obj['data'][i].name+'">edit</span></a>';

                        // Remove 
                      //  html += '<a href="javascript:void(0)" onclick="handleRemove(\''+obj['data'][i].uuid_full+'\',\''+obj['data'][i].is_active+'\')"><span class="material-icons" style="font-size:1.5rem; color:black;" title="Remove -> '+product_name+' - '+obj['data'][i].name+'">delete</span></a>';

                        html += '</td></tr>';
                    }
                    tableList.innerHTML = html;
                    pagesController(page,obj['pages']);
                    if(parseInt(page) > parseInt(obj['pages'])){
                        page        = 1;
                        filter.goto.value = 1;
                    }
                }
            }
            else {
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

function refilterProductsType(typeInt){
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
        productList   = document.getElementById('selectproduct');
        const requestURL = window.location.protocol+'//'+locat+'api/'+submodule+'s/auth_'+submodule+'_list.php?auth_api='+authApi+filters;
        //console.log(requestURL);
        const request = new XMLHttpRequest();
        request.onreadystatechange = function() {
            html    = '';
            if (this.readyState == 4 && this.status == 200) {
                // Typical action to be performed when the document is ready:
                obj = JSON.parse(request.responseText);
                if( (obj.response != 'error') && (obj.response != 'ZERO_RETURN')){
                    //html += '<OPTION value="0"/>'+translateText('please_select',localStorage.getItem('ulang'))+' '+ucfirst(translateText('product',localStorage.getItem('ulang')));
                    for(var i=0;i < obj.length; i++){
                        /*if(obj[i].name == 'OOH'){
                            html += '<option value="'+obj[i].uuid_full+'" >'+obj[i].name+' ('+translateText('no_keys',localStorage.getItem('ulang'))+')</option>';
                        }*/
                        html += '<OPTION value="'+obj[i].uuid_full+'"/>'+obj[i].name;
                    }
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


function pagesController(actualpage,totalpages){
    document.getElementById('btn_firstpage').disabled=false;
    document.getElementById('btn_beforepage').disabled=false;
    document.getElementById('btn_nextpage').disabled=false;
    document.getElementById('btn_lastpage').disabled=false;

    if(parseInt(filter.goto.value) <= 1){ 
        document.getElementById('btn_firstpage').disabled=true;
        document.getElementById('btn_beforepage').disabled=true;
    }
    if(parseInt(filter.goto.value) >= totalpages){ 
        document.getElementById('btn_nextpage').disabled=true;
        document.getElementById('btn_lastpage').disabled=true;
    }

    filter.totalpages.value = totalpages;
    document.getElementById('text-totalpages').innerText = totalpages;

}

function gotoLast(){
    totalpages = filter.totalpages.value;
    if(parseInt(filter.goto.value) <= totalpages){
        handleListOnLoad(filter.search.value,totalpages); 
        filter.goto.value = totalpages;
    }else{
        document.getElementById('btn_lastpage').disabled=true;
    }
}

function handleRemove(tid,locked_status){
    authApi     = csrf_token;
    filters     = '&tid='+tid+'&lk='+locked_status;
    
    locat       = window.location.hostname;
    if(locat.slice(-1) != '/')
        locat += '/';

    color_status = '#298c3d';
    if(locked_status == 'Y')
        color_status = '#d60b0e';
    const requestURL = window.location.protocol+'//'+locat+'api/salemodels/auth_salemodel_remove.php?auth_api='+authApi+filters;
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