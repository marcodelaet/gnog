document.getElementById('nav-item-advertisers').setAttribute('class',document.getElementById('nav-item-advertisers').getAttribute('class').replace(' active','') + ' active');
var csrf_token = $('meta[name="csrf-token"]').attr('content');
//alert(csrf_token);
module  = 'advertiser';

function handleSubmit(form) {
    if (form.corporate_name.value !== '') {
        //form.submit();
        errors      = 0;
        authApi     = csrf_token;
        user_token  = form.tku.value;
        user_id     = form.uid.value;
        
        agency      = 'N';
        if(form.agency_option.checked)
            agency              = 'Y';
        making_banners = 'N';
        if(form.making_banners_option.checked)
            making_banners      = 'Y';
        corporate_name          = encodeURIComponent(form.corporate_name.value);
        address                 = encodeURIComponent(form.address.value);
        executive_id            = form.executive_id.value;

        var formData = new FormData(form);
        formData.append("making_banners",making_banners);
        formData.append("agency",agency);
        formData.append("tk",user_token);

        
        locat       = window.location.hostname;
        if(locat.slice(-1) != '/')
            locat += '/';

        if(corporate_name == '')
        {
            errors++;
            alert('Please, type a corporate name');
        }

        if(errors > 0){

        } else{
            const requestURL = window.location.protocol+'//'+locat+'api/advertisers/auth_advertiser_add_new.php?auth_api='+authApi+'&tk='+user_token+'&uid='+user_id+'&agency='+agency+'&making_banners='+making_banners+'&corporate_name='+corporate_name+'&address='+address+'&executive_id='+executive_id;
            console.log(requestURL);
            const request = new XMLHttpRequest();
            request.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    // Typical action to be performed when the document is ready:
                    obj = JSON.parse(request.responseText);
                    if(obj.result=='OK'){
                        form.btnSave.innerHTML = ucfirst(translateText('continue',localStorage.getItem('ulang')));
                        if(confirm(translateText('do_you_want',localStorage.getItem('ulang'))+' '+translateText('add+',localStorage.getItem('ulang'))+' '+translateText('contact',localStorage.getItem('ulang'))+'s '+translateText('to_the_m',localStorage.getItem('ulang'))+' '+translateText(module,localStorage.getItem('ulang'))+' '+decodeURIComponent(corporate_name)+'?')){
                            window.location.href = '?pr=Li9wYWdlcy9hZHZlcnRpc2Vycy9jb250YWN0cy9mb3JtLnBocA==&md=Advertiser&aid='+obj.return_id;
                        } else {
                            window.location.href = '?pr=Li9wYWdlcy9hZHZlcnRpc2Vycy90a3AvaW5kZXgucGhw';
                        }
                    }
                }else{
                    form.btnSave.innerHTML = "Saving...";
                }
            };
            request.open('POST', requestURL);
            //request.responseType = 'json';
            request.send(formData);
        }
    } else
        alert('Please, fill all required fields (*)');
}

function handleSubmitCSV(form){
    if (form.advertiser_file.value !== '') {
        //form.submit();
        errors      = 0;
        authApi     = csrf_token;

        file        = form.advertiser_file;
        var formData = new FormData(form);
        //formData.append("advertiser_file", fileInputElement.advertiser_file);
        
        locat       = window.location.hostname;
        if(locat.slice(-1) != '/')
            locat += '/';

        if(file == '')
        {
            errors++;
            alert('Please, type a corporate name');
        }

        if(errors > 0){

        } else{
            const requestURL = window.location.protocol+'//'+locat+'api/advertisers/auth_advertiser_csv_upload.php';
            const request = new XMLHttpRequest();
            request.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    // Typical action to be performed when the document is ready:
                    console.log(request.responseText);
                    obj = JSON.parse(request.responseText);
                    form.btnSave.innerHTML = "Upload list of Advertisers";
                    if(obj.status === "OK")
                        window.location.href = '?pr=Li9wYWdlcy9hZHZlcnRpc2Vycy90a3BlZGl0L2luZGV4LnBocA==';
                    else
                        alert(obj.message);
                }
                else{
                    form.btnSave.innerHTML = "Uploading...";
                }
            };
            request.open('POST', requestURL);
            //request.responseType = 'json';
            request.send(formData);
        }
    } else
        alert('Please, fill all required fields (*)');
}

function handleEditSubmit(aid,form) {
    if (form.corporate_name.value !== '' && form.address.value !== '') {
        //form.submit();
   
        errors      = 0;
        authApi     = csrf_token;

        agency      = 'N';
        if(form.agency.checked)
            agency              = 'Y';
        
        making_banners    = 'N';
        if(form.making_banners.checked){
            making_banners = 'Y';
        }
        
        sett     = '&aid='+aid;
        sett     += '&agency='+agency;
        sett     += '&making_banners='+making_banners;

        corporate_name          = form.corporate_name.value;
        if(corporate_name !== ''){
            sett     += '&corporate_name='+encodeURIComponent(corporate_name);
        }
        address                 = form.address.value;
        if(address !== ''){
            sett     += '&address='+encodeURIComponent(address);
        }
        executive_id       = form.executive_id.value;
        if(executive_id !== '0'){
            sett     += '&executive_id='+executive_id;
        }
        
        console.log(sett);
        //alert('pausa');
        locat       = window.location.hostname;
        if(locat.slice(-1) != '/')
            locat += '/';

        if(errors > 0){
           
        } else{
            const requestURL = window.location.protocol+'//'+locat+'api/advertisers/auth_advertiser_edit.php?auth_api='+authApi+sett;
            //alert(requestURL);
            const request = new XMLHttpRequest();
            request.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                   // Typical action to be performed when the document is ready:
                   obj = JSON.parse(request.responseText);
                   form.btnSave.innerHTML = "Save";
                   window.location.href = '?pr=Li9wYWdlcy9hZHZlcnRpc2Vycy90a3BlZGl0L2luZGV4LnBocA==';
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

function handleViewOnLoad(aid) {
    errors      = 0;
    authApi     = csrf_token;
    locat       = window.location.hostname;

    filters     = '&aid='+aid;

    if(locat.slice(-1) != '/')
        locat += '/';

    if(errors > 0){

    } else{
        const requestURL = window.location.protocol+'//'+locat+'api/'+module+'s/auth_'+module+'_get.php?auth_api='+authApi+filters;
        //console.log(requestURL);
        const request   = new XMLHttpRequest();
        agency          = 'Direct';
        impressions     = 'no'; 
        position        = '*****';
        request.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                // Typical action to be performed when the document is ready:
                obj = JSON.parse(request.responseText);
                if(obj['data'][0].is_agency == 'Y')
                    agency = 'Agency';
                if(obj['data'][0].making_banners == 'Y')
                    impressions     = 'yes';
                if(obj['data'][0].phone_number !== null)
                    phone_number = obj['data'][0].phone_number.replace(" ","");
                if((obj['data'][0].phone_prefix!==null) && (obj['data'][0].phone_prefix!='0'))
                    phone_number = obj[0].phone_prefix+obj[0].phone_number.replace(" ","");
                document.getElementById('advertiser_name').innerHTML                    = obj['data'][0].corporate_name;
                document.getElementById('group').innerHTML                              = agency;
                address = translateText('no_address_information',localStorage.getItem('ulang'));
                if(obj['data'][0].address!==null){
                    address = obj['data'][0].address;
                }
                    
                document.getElementById('card-address').innerHTML                       = address;
                //document.getElementById('impressions').innerHTML                        = impressions;

                xhtml = '';
                for(i=0;i < obj['data'].length; i++){
                    xhtml += '<div class="space-blank">&nbsp;</div>';
                    if(obj['data'][i].contact_name !== null){
                        if(obj['data'][i].contact_position!='')
                        position = obj['data'][i].contact_position;
                        xhtml += '<div class="'+module+'-data">';
                        xhtml += '    <spam id="card-contact-fullname-and-position">'+obj['data'][i].contact_name + ' ' + obj['data'][i].contact_surname + ' ('+position+')</spam>';
                        xhtml += '</div>';
                    }
                    if(obj['data'][i].contact_email !== null){
                        xhtml += '<div class="'+module+'-data">';
                        xhtml += '    <spam class="material-icons icon-data">email</spam>';
                        xhtml += '    <spam id="card-email">'+obj['data'][i].contact_email+'</spam>';
                        xhtml += '</div>';
                    }
                    if(obj['data'][i].phone_international_code !== null){
                        xhtml += '<div class="'+module+'-data">';
                        xhtml += '    <spam class="material-icons icon-data">phone</spam>';
                        xhtml += '    <spam id="card-phone">+'+obj['data'][i].phone_international_code.replace(" ","") + phone_number+'</spam>';
                        xhtml += '</div>';
                    }
                }
                document.getElementById("list-contacts").innerHTML = xhtml;
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

function handleOnLoad(aid,form) {
    errors      = 0;
    authApi     = csrf_token;
    locat       = window.location.hostname;

    filters     = '&aid='+aid;
  
    if(locat.slice(-1) != '/')
        locat += '/';

    if(errors > 0){

    } else{
        const requestURL = window.location.protocol+'//'+locat+'api/advertisers/auth_advertiser_get.php?auth_api='+authApi+filters;
        //alert(requestURL);
        const request = new XMLHttpRequest();
        request.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                // Typical action to be performed when the document is ready:
                obj = JSON.parse(request.responseText);
                if(obj['data'][0].is_agency == 'Y')
                    form.agency.checked = true;
                if(obj['data'][0].making_banners == 'Y')
                    form.making_banners.checked = true;
                form.corporate_name.value           = obj['data'][0].corporate_name;
                form.address.value                  = obj['data'][0].address;
                if(obj['data'][0].executive_id !== null)
                    form.executive_id.value             = obj['data'][0].executive_id;
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

    groupby     = '&groupby=UUID';
    addColumn   = '&addcolumn=count(contact_client_id) as qty_contact';

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

    if(locat.slice(-1) != '/')
        locat += '/';

    if(errors > 0){

    } else{
        tableList   = document.getElementById('listAdvertisers');
        const requestURL = window.location.protocol+'//'+locat+'api/advertisers/auth_advertiser_view.php?auth_api='+authApi+filters+groupby+addColumn+pages;
        //console.log(requestURL);
        const request = new XMLHttpRequest();
        request.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                // Typical action to be performed when the document is ready:
                obj         = JSON.parse(request.responseText);
                if(obj.response == 'ZERO_RETURN'){
                    html = '<tr><td colspan="8"><div style="margin-left:45%; margin-right:45%;text-align:center;" role="status">';
                    html += '0 Results';
                    html += '</td></tr>';
                    pagesController(page,obj['pages']);
                    if(parseInt(page) > parseInt(obj['pages'])){
                        page        = 1;
                        filter.goto.value = 1;
                    }
                }else{
                    html        = '';
                    country     = '';
                    for(var i=0;i < obj['data'].length; i++){
                        color_status = '#d60b0e';
                        if(obj['data'][i].is_active == 'Y')
                            color_status = '#298c3d';
                        
                        advertiser_type = 'Direct';
                        if(obj['data'][i].is_agency == 'Y')
                            advertiser_type = 'Agency';

                            switch (obj['data'][i].phone_international_code) {
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
                        string_qty_contact = "No contacts";
                        if(obj['data'][i].qty_contact > 0)
                            string_qty_contact = obj['data'][i].qty_contact + ' contact';
                        if(obj['data'][i].qty_contact > 1)
                            string_qty_contact += 's';
                            
                        html += '<tr><td>'+obj['data'][i].corporate_name+'</td><td>'+advertiser_type+'</td><td nowrap>'+string_qty_contact+'</td><td style="text-align:center;"><span id="locked_status_'+obj['data'][i].uuid_full+'" class="material-icons" style="color:'+color_status+'">circle</span></td><td nowrap style="text-align:center;">';
                        // information card
                        html += '<a href="?pr=Li9wYWdlcy9hZHZlcnRpc2Vycy9pbmZvLnBocA==&aid='+obj['data'][i].uuid_full+'"><span class="material-icons" style="font-size:1.5rem; color:black;" title="Information Card '+obj['data'][i].corporate_name+'">info</span></a>';

                        // Edit form
                        html += '<a href="?pr=Li9wYWdlcy9hZHZlcnRpc2Vycy9mb3JtZWRpdC5waHA=&aid='+obj['data'][i].uuid_full+'"><span class="material-icons" style="font-size:1.5rem; color:black;" title="Edit '+module + ' '+obj['data'][i].corporate_name+'">edit</span></a>';

                        // Remove 
                        html += '<a href="javascript:void(0)" onclick="handleRemove(\''+obj['data'][i].uuid_full+'\',\''+obj['data'][i].is_active+'\')"><span class="material-icons" style="font-size:1.5rem; color:black;" title="Remove '+module + ' '+obj['data'][i].corporate_name+'">delete</span></a>';

                        // Add Contact
                        html += '<a href="?pr=Li9wYWdlcy9hZHZlcnRpc2Vycy9jb250YWN0cy9mb3JtLnBocA==&md=Advertiser&aid='+obj['data'][i].uuid_full+'"><span class="material-icons" style="font-size:1.5rem; color:black;" title="'+ucfirst(translateText('add+',localStorage.getItem('ulang')))+' '+translateText('a_m',localStorage.getItem('ulang'))+' '+translateText('contact',localStorage.getItem('ulang'))+' '+translateText('to_the_m',localStorage.getItem('ulang'))+' '+translateText(module,localStorage.getItem('ulang')) + ' '+obj['data'][i].corporate_name+'">contact_mail</span></a>';

                        html += '</td></tr>';
                    }
                    pagesController(page,obj['pages']);
                    if(parseInt(page) > parseInt(obj['pages'])){
                        page        = 1;
                        filter.goto.value = 1;
                    }    
                }
            }
            else{
                html = '<tr><td colspan="5"><div style="margin-left:45%; margin-right:45%;" class="spinner-border" style="text-align:center;" role="status">';
                html += '<span class="sr-only">Loading...</span>';
                html += '</div></td></tr>';
                //form.btnSave.innerHTML = "Searching...";
            }
            tableList.innerHTML = html;
        };
        request.open('GET', requestURL);
        //request.responseType = 'json';
        request.send();
    }
    // window.location.href = '?pr=Li9wYWdlcy91c2Vycy9saXN0LnBocA==';
}

function handleRemove(aid,locked_status){
    authApi     = csrf_token;
    filters     = '&aid='+aid+'&lk='+locked_status;
    
    locat       = window.location.hostname;
    if(locat.slice(-1) != '/')
        locat += '/';

    color_status = '#298c3d';
    if(locked_status == 'Y')
        color_status = '#d60b0e';
    const requestURL = window.location.protocol+'//'+locat+'api/advertisers/auth_advertiser_remove.php?auth_api='+authApi+filters;
    //alert(requestURL);
    const request = new XMLHttpRequest();
    request.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            // Typical action to be performed when the document is ready:
            obj = JSON.parse(request.responseText);
            document.getElementById('locked_status_'+aid).style = 'color:'+color_status;
        }
    };
    request.open('GET', requestURL);
    //request.responseType = 'json';
    request.send();
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
