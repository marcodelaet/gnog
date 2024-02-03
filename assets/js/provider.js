document.getElementById('nav-item-providers').setAttribute('class',document.getElementById('nav-item-providers').getAttribute('class').replace(' active','') + ' active');
var csrf_token = $('meta[name="csrf-token"]').attr('content');
module  = 'provider';
//alert(csrf_token);

/*******************************************************
 * Default Email Text
 **********************/
var invite_body = [];
invite_body['esp'] = "<p>Hola %user_fullname%, ¿Cómo estás?</p>"+
"<p>Soy del equipo de <b>GNog Media y Tecnologia</b>.</p>"+
"<p>Envio por aquí la liga de registro de nuestra plataforma de envío de facturas, y el acceso para el manual de usuario para que puedas entender cómo funciona el sistema y si tienes alguna duda, probablemente encuentres la respuesta en el documento, en cualquier caso estamos a tu disposición. para ayudarlos en lo que necesiten con respecto a la plataforma.</p>"+
"<p>Haga el copy de la liga abajo y péguela en su browser para registrar su nombre de usuario y registrar su contraseña de acceso:</p>"+
"<p>- "+
//"<a id='contact-url-provider' target='_blank' href='%personal_url_to_register_href%'>"+
"%personal_url_to_register%"+
//"</a>"+
"</p>"+
"<p>Después de registrar su nombre de usuario y contraseña de acceso personal, puede iniciar sesión utilizando la siguiente dirección:</p>"+
"<p>- "+
//"<a href='https://providers.gnogmedia.com' target='_blank'>"+
"https://providers.gnogmedia.com"+
//"</a>"+
"</p>"+
"<p>Si tiene alguna pregunta, póngase en contacto para que podamos aclararla lo mejor posible.</p>"+
"<p>Si es necesario programar una llamada para hacer este primer envío juntos, también podemos hacerlo.</p>"+
"<p><div class='download-pdf-file'>"+
"<b>Archivo PDF - Download "+
"(Español) - Plataforma de Facturas:</b></p>"+
"</div>"+
"<div class='download-pdf-file'>-"+
//"<a href='http://crm.gnogmedia.com/public/providers_1.2_202306-es.pdf' target='_blank'>"+
"http://crm.gnogmedia.com/public/providers_1.2_202306-es.pdf"+
//"</a>"+
"</div></p>"+ 
"<p><div class='download-pdf-file'>"+
"<b>Arquivo PDF - Download "+
"(Português Brasil) - Plataforma de Faturas:</b></p>"+
"</div>"+
"<div class='download-pdf-file'>-"+
//"<a href='http://crm.gnogmedia.com/public/providers_1.2_202306-ptBR.pdf' target='_blank'>"+
"http://crm.gnogmedia.com/public/providers_1.2_202306-ptBR.pdf"+
//"</a>"+
"</div></p>"+ 
"<p>&nbsp;</p>"+
"<p>Saludos</p>";

invite_body['ptbr'] = "<p>Olá %user_fullname%, tudo bem?</p>"+
"<p>Sou da equipe da <b>GNog Media y Tecnologia</b>.</p>"+
"<p>Estamos enviando por aqui o acesso para registro em nossa plataforma de envío de faturas, e acceso ao manual de usuario para que possa entender como funciona nossa plataforma e caso tenha alguma dúvida, provavelmente encontrará respuestas neste documento, de qualquer modo estamos à disposición para ajudar no que for necessário em relação a plataforma.</p>"+
"<p>Copie abaixo e cole em seu navegador o link abaixo para registrar seu nome de usuário, e registrar sua senha de acesso:</p>"+
"<p>- "+
"<a id='contact-url-provider' target='_blank' href='%personal_url_to_register_href%'>"+
"%personal_url_to_register%"+
"</a>"+
"</p>"+
"<p>Depois de registrar seu nome de usuário e senha de acesso pessoal, pode iniciar sessão utilizando o seguinte link:</p>"+
"<p>- "+
"<a href='https://providers.gnogmedia.com' target='_blank'>"+
"https://providers.gnogmedia.com"+
"</a>"+
"</p>"+
"<p>Caso tenha alguma pergunta, entre em contacto para que possamos ajudar da melhor maneira possível.</p>"+
"<p>Se for necessário agendar uma call para fazermos este primeiro acesso e envio juntos, também podemos fazer.</p>"+
"<p><div class='download-pdf-file'>"+
"<b>Archivo PDF - Download "+
"(Español) - Plataforma de Facturas:</b></p>"+
"</div>"+
"<div class='download-pdf-file'>-"+
"<a href='http://crm.gnogmedia.com/public/providers_1.2_202306-es.pdf' target='_blank'>"+
"http://crm.gnogmedia.com/public/providers_1.2_202306-es.pdf"+
"</a>"+
"</div></p>"+ 
"<p><div class='download-pdf-file'>"+
"<b>Arquivo PDF - Download "+
"(Português Brasil) - Plataforma de Faturas:</b></p>"+
"</div>"+
"<div class='download-pdf-file'>-"+
"<a href='http://crm.gnogmedia.com/public/providers_1.2_202306-ptBR.pdf' target='_blank'>"+
"http://crm.gnogmedia.com/public/providers_1.2_202306-ptBR.pdf"+
"</a>"+ 
"</div></p>"+
"<p>&nbsp;</p>"+
"<p>Att</p>";

invite_body['eng'] = "<p>Hello %user_fullname%, how are you?</p>"+
"<p>We are from <b>GNog Media y Tecnologia</b> team.</p>"+
"<p>We are sending to you the registration link to our platform where you can send your invoices, and sending too an access to the user's manual about this platform, then you can see how to use our platform and send invoices correctly. If you have any questions, probably you can found the answer on this manual.</p>"+
"<p>Copy the link below and paste on your browser to register your credentials (username and password):</p>"+
"<p>- "+
"<a id='contact-url-provider' target='_blank' href='%personal_url_to_register_href%'>"+
"%personal_url_to_register%"+
"</a>"+
"</p>"+
"<p>Later you register your credentials you can login on our platform using your personal username and password accessing the link:</p>"+
"<p>- "+
"<a href='https://providers.gnogmedia.com' target='_blank'>"+
"https://providers.gnogmedia.com"+
"</a>"+
"</p>"+
"<p>If you have any question, contact us please.</p>"+
"<p><div class='download-pdf-file'>"+
"<b>Archivo PDF - Download "+
"(Español) - Plataforma de Facturas:</b></p>"+
"</div>"+
"<div class='download-pdf-file'>-"+
"<a href='http://crm.gnogmedia.com/public/providers_1.2_202306-es.pdf' target='_blank'>"+
"http://crm.gnogmedia.com/public/providers_1.2_202306-es.pdf"+
"</a>"+
"</div></p>"+ 
"<p><div class='download-pdf-file'>"+
"<b>Arquivo PDF - Download "+
"(Português Brasil) - Plataforma de Faturas:</b></p>"+
"</div>"+
"<div class='download-pdf-file'>-"+
"<a href='http://crm.gnogmedia.com/public/providers_1.2_202306-ptBR.pdf' target='_blank'>"+
"http://crm.gnogmedia.com/public/providers_1.2_202306-ptBR.pdf"+
"</a>"+
"</div></p>"+ 
"<p>&nbsp;</p>"+
"<p>Best regards</p>";

function handleSubmit(form) {
    if (form.name.value !== '' && form.address.value !== '' || product_id != '0' || salemodel_id != '0') {
        //form.submit();
        errors      = 0;
        authApi     = csrf_token;
        message     = '';

        user_token  = form.tku.value;
        user_id     = form.uid.value;
        xname       = encodeURIComponent(form.name.value);
        address     = encodeURIComponent(form.address.value);
        webpage_url = encodeURIComponent(form.webpage_url.value);
        product_id  = form.product_id.value;
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
            const requestURL = window.location.protocol+'//'+locat+'api/providers/auth_provider_add_new.php?auth_api='+authApi+'&tk='+user_token+'&uid='+user_id+'&name='+xname+'&webpage_url='+webpage_url+'&address='+address+'&product_id='+product_id+'&salemodel_id='+salemodel_id+'&product_price='+product_price+'&currency='+currency;
            console.log(requestURL);
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

function handleSubmitCSV(form){
    if (form.provider_file.value !== '') {
        //form.submit();
        errors      = 0;
        authApi     = csrf_token;

        file        = form.provider_file;
        var formData = new FormData(form);
        //formData.append("provider_file", fileInputElement.provider_file);
        
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
            const requestURL = window.location.protocol+'//'+locat+'api/providers/auth_provider_csv_upload.php';
            const request = new XMLHttpRequest();
            request.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    // Typical action to be performed when the document is ready:
                    console.log(request.responseText);
                    obj = JSON.parse(request.responseText);

                    form.btnSave.innerHTML = "Upload list of Providers";
                    //alert('Status: '+obj.status);
                    if(obj.status === "OK")
                        window.location.href = '?pr=Li9wYWdlcy9wcm92aWRlcnMvdGtwZWRpdC9pbmRleC5waHA=';
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

function handleEditSubmit(pid,form) {
    if (form.name.value !== '' && form.address.value !== '' && (product_id != '0' || salemodel_id != '0')) {
        //form.submit();
   
        errors      = 0;
        authApi     = csrf_token;
        
        sett     = '&pid='+pid;
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
        }/*
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
        }*/
        /*phone_ddi  = form.mobile_ddi.value;
        if(phone_ddi !== ''){
            sett     += '&phone_ddi='+phone_ddi.replace(' ','');
        }*/
        phone                   = form.phone.value;
        if(phone !== ''){
            sett     += '&phone='+phone.replace(" ","");
        }
        /*main_contact_position   = form.main_contact_position.value;
        if(main_contact_position !== ''){
            sett     += '&main_contact_position='+main_contact_position;
        }*/
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

function handleLoadProposals(pid){
    errors      = 0;
    authApi     = csrf_token;
    locat       = window.location.hostname;

    filters     = '&pid='+pid;

    if(locat.slice(-1) != '/')
        locat += '/';

    if(errors > 0){

    } else{ 
        const requestURL = window.location.protocol+'//'+locat+'api/'+module+'s/auth_'+module+'_list_proposals.php?auth_api='+authApi+filters;
        console.log(requestURL);
        const request   = new XMLHttpRequest();
        request.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                // Typical action to be performed when the document is ready:
                propobj = JSON.parse(request.responseText);
                xhtmllist = '';
                if(propobj['result'] == 'OK'){
                    for(pi=0;pi < propobj['data'].length; pi++){
                        xhtmllist += '<li>'+propobj['data'][pi].product_full_name+'</li>';
                    }
                } else {
                    xhtmllist = '<i>'+translateText('0_proposals',localStorage.getItem('ulang'))+'</i>';
                }

                document.getElementById('card-proposal-name').innerHTML = xhtmllist;
            }
            else{
                //form.btnSave.innerHTML = "Searching...";
            }
        };
        request.open('GET', requestURL, true);
        //request.responseType = 'json';
        request.send();
    }
}


function handleViewOnLoad(pid) {
    errors      = 0;
    authApi     = csrf_token;
    locat       = window.location.hostname;

    filters     = '&pid='+pid;

    if(locat.slice(-1) != '/')
        locat += '/';

    if(errors > 0){

    } else{ 
        const requestURL = window.location.protocol+'//'+locat+'api/'+module+'s/auth_'+module+'_get.php?auth_api='+authApi+filters;
        console.log('user:\n'+requestURL);
        const request   = new XMLHttpRequest();
        email           = 'no_email';
        address         = 'no_address';
        webpage         = 'no_webpage';
        request.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                // Typical action to be performed when the document is ready:
                obj = JSON.parse(request.responseText);
                phone_number = obj['data'][0].phone_number.replace(" ","");
                if((obj['data'][0].phone_prefix!='') && (obj['data'][0].phone_prefix!='0'))
                    phone_number = obj['data'][0].phone_prefix+obj['data'][0].phone_number.replace(" ","");
                if(obj['data'][0].address!=''){
                    address = obj['data'][0].address;     
                }
                if(obj['data'][0].webpage_url!=''){
                    webpage = obj['data'][0].webpage_url;     
                }
                document.getElementById('provider_name').innerHTML                      = obj['data'][0].name;
                document.getElementById('webpage').innerHTML                            = webpage;
                document.getElementById('card-address').innerHTML                       = address;

                xuser       = '';
                position    = '*****';
                xhtml       = '';
                if(obj['result'] == 'OK'){
                    for(i=0;i < obj['data'].length; i++){
                        xuserIcon   = 'person';
                        xcopy       = '';
                        full_name   = obj['data'][i].contact_name + ' ' + obj['data'][i].contact_surname;
                        if(obj['data'][i].contact_position!='')
                            position = obj['data'][i].contact_position;
                        
                        if((obj['data'][i].username!='') && (typeof(obj['data'][i].username)!='object')){
                            xeffect     = '';
                            xuser       = obj['data'][i].username;
                        } else {
                            contact_email   = obj['data'][i].contact_email;

                            xeffect = 'insider'; 
                            xuser = 'https://providers.gnogmedia.com?pr=Li9wYWdlcy91c2Vycy9mb3JtLnBocA==&cpid='+obj['data'][i].contact_provider_id;
                            xcopy = '&nbsp;&nbsp;&nbsp;<a style="color: #212529" href="javascript:void(0)" title="'+translateText('copy_user_crt_url',localStorage.getItem('ulang'))+' ('+obj['data'][i].contact_email+')" onclick="copyStringToClipboard(\''+xuser+'\'\)"><spam class="material-icons icon-data">content_copy</spam></a>';
                            //xcopy += '&nbsp;<a style="color: #212529" href="javascript:void(0)" title="'+translateText('send_user_crt_url_to',localStorage.getItem('ulang'))+' '+obj['data'][i].contact_email+'" onclick=""><spam class="material-icons icon-data">send</spam></a>';
                            textHTML = invite_body['esp'];
                            xcopy += '&nbsp;<a style="color: #212529; cursor: pointer;" title="'+translateText('send_user_crt_url_to',localStorage.getItem('ulang'))+' '+obj['data'][i].contact_email+'"  data-toggle="modal" data-target="#sendmailModal" data-whatever="@mdo" onclick="document.getElementById(\'sendbutton\').disabled = false; document.getElementById(\'sendbutton\').innerText = translateText(\'send_message\',localStorage.getItem(\'ulang\')); document.getElementById(\'provider_contact_email\').innerText=\''+contact_email+'\'; document.getElementById(\'pemail\').value=\''+contact_email+'\'; document.getElementById(\'pname\').value=\''+full_name+'\'; document.getElementById(\'plink\').value=\''+xuser+'\'; document.getElementById(\'bodytext-html\').value =  textHTML.replace(\'%personal_url_to_register%\',\''+xuser+'\').replace(\'%personal_url_to_register_href%\',\''+xuser+'\').replace(\'%user_fullname%\',\''+full_name+'\'); document.getElementById(\'language-option\').value=\'esp\'; document.getElementById(\'bodyText\').innerHTML = textHTML.replace(\'%personal_url_to_register%\',\''+xuser+'\').replace(\'%personal_url_to_register_href%\',\''+xuser+'\').replace(\'%user_fullname%\',\''+full_name+'\');"><spam class="material-icons icon-data">send</spam></a>';
                        }
                        xhtml += '<div class="space-blank">&nbsp;</div>';
                        xhtml += '<div class="'+module+'-data">';
                        xhtml += '    <spam id="card-contact-fullname-and-position">'+full_name + ' ('+position+')</spam>';
                        xhtml += '</div>';
                        xhtml += '<div class="'+module+'-data">';
                        xhtml += '    <spam class="material-icons icon-data">email</spam>';
                        xhtml += '    <spam id="card-email">'+obj['data'][i].contact_email+'</spam>';
                        xhtml += '</div>';
                        xhtml += '<div class="'+module+'-data">';
                        xhtml += '    <spam class="material-icons icon-data">phone</spam>';
                        xhtml += '    <spam id="card-phone">+'+obj['data'][i].phone_international_code.replace(" ","") + phone_number+'</spam>';
                        xhtml += '</div>';
                        xhtml += '<div class="'+module+'-data">';
                        xhtml += '    <spam class="material-icons icon-data">'+xuserIcon+'</spam>';
                        xhtml += '    <spam id="card-user-'+obj['data'][i].contact_provider_id+'" class="card-user '+xeffect+'">'+xuser+'</spam>';
                        xhtml += xcopy;
                        xhtml += '</div>';

                        
                    }
                } else {
                    xhtml = '<div class="'+module+'-data"><spam id="card-user-000000" class="card-user ">0_contacts</spam></div>';
                }
                document.getElementById("list-contacts").innerHTML = xhtml;
            }
            else{
                //form.btnSave.innerHTML = "Searching...";
            }
        };
        request.open('GET', requestURL, true);
        //request.responseType = 'json';
        request.send();
    }
}

function handleOnLoad(pid,form) {
    errors      = 0;
    authApi     = csrf_token;
    locat       = window.location.hostname;

    filters     = '&pid='+pid;
  
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
                /*form.main_contact_name.value        = obj[0].main_contact_name;
                form.main_contact_surname.value     = obj[0].main_contact_surname;
                form.main_contact_email.value       = obj[0].main_contact_email;*/
                //form.phone_ddi.value              = obj[0].phone_international_code.replace(" ","");
                /*form.phone.value                    = obj[0].phone_number.replace(" ","");
                form.main_contact_position.value    = obj[0].main_contact_position;*/
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
    authApi     = csrf_token;
    locat       = window.location.hostname;

    groupby     = '&groupby=UUID';
    addColumn   = '&addcolumn=count(contact_provider_id) as qty_contact';

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
        const requestURL = window.location.protocol+'//'+locat+'api/providers/auth_provider_view.php?auth_api='+authApi+filters+groupby+addColumn;
        console.log(requestURL);
        const request = new XMLHttpRequest();
        request.onreadystatechange = function() {
            //console.log(this.readyState + '/n' + this.status);
            if (this.readyState == 4 && this.status == 200) {
                // Typical action to be performed when the document is ready:
                obj         = JSON.parse(request.responseText);
                html        = '';
                country     = '';
                console.log(obj);
                if(obj.rows > 0){
                    for(var i=0;i < obj['data'].length; i++){
                        
                        color_status = '#d60b0e';
                        if(obj['data'][i].is_active == 'Y')
                            color_status = '#298c3d';

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
                        phone_number    = "";
                        contact         = "-------";
                    //alert(typeof(obj['data'][i].contact));
                    phone_number = "--------"
                        if((obj['data'][i].contact !== 'null') && (obj['data'][i].contact !== null)){
                            phone_number    = obj['data'][i].phone;
                            contact         = obj['data'][i].contact;
                            if((obj['data'][i].phone_prefix!='') && (obj['data'][i].phone_prefix !== 'null') && (obj['data'][i].phone_prefix !== null))
                                phone_number = '+'+obj['data'][i].phone_international_code+obj['data'][i].phone_prefix+obj['data'][i].phone_number.replace(" ","");

                            if((obj['data'][i].phone_prefix == 'null') || (obj['data'][i].phone_prefix == null))
                                phone_number = '+'+obj['data'][i].phone_international_code+obj['data'][i].phone_number.replace(" ","");
                        }
                        webpage = '-------';
                        if( (obj['data'][i].webpage_url !== 'null') && (obj['data'][i].webpage_url !== null))
                            webpage = obj['data'][i].webpage_url;
                        string_qty_contact = "No contacts";
                        if(obj['data'][i].qty_contact > 0)
                            string_qty_contact = obj['data'][i].qty_contact + ' contact';
                        if(obj['data'][i].qty_contact > 1)
                            string_qty_contact += 's';
                        html += '<tr><td>'+obj['data'][i].name+'</td><td>'+webpage+'</td><td nowrap>'+string_qty_contact+'</td><td style="text-align:center;"><span id="locked_status_'+obj['data'][i].uuid_full+'" class="material-icons" style="color:'+color_status+'">circle</span></td><td nowrap style="text-align:center;">';
                        // information card
                        html += '<a href="?pr=Li9wYWdlcy9wcm92aWRlcnMvaW5mby5waHA=&pid='+obj['data'][i].uuid_full+'"><span class="material-icons" style="font-size:1.5rem; color:black;" title="Information Card '+obj['data'][i].name+'">info</span></a>';

                        // Edit form
                        html += '<a href="?pr=Li9wYWdlcy9wcm92aWRlcnMvZm9ybWVkaXQucGhw&pid='+obj['data'][i].uuid_full+'"><span class="material-icons" style="font-size:1.5rem; color:black;" title="Edit '+module + ' '+obj['data'][i].name+'">edit</span></a>';

                        // Remove 
                        html += '<a href="javascript:void(0)" onclick="handleRemove(\''+obj['data'][i].uuid_full+'\',\''+obj['data'][i].is_active+'\')"><span class="material-icons" style="font-size:1.5rem; color:black;" title="Remove '+module + ' '+obj['data'][i].name+'">delete</span></a>';

                        // Add Contact
                        html += '<a href="?pr=Li9wYWdlcy9hZHZlcnRpc2Vycy9jb250YWN0cy9mb3JtLnBocA==&md=Provider&tid='+obj['data'][i].uuid_full+'"><span class="material-icons" style="font-size:1.5rem; color:black;" title="Add a contact to '+module + ' '+obj['data'][i].name+'">contact_mail</span></a>';

                        html += '</td></tr>';
                    }
                } else {
                    html = '<tr><td colspan="5"><div style="text-align:center;" role="status">';
                    html += '<span class="returning_zero">0 results</span>';
                    html += '</div></td></tr>';
                }
                tableList.innerHTML = html;
            }
            else{
                html = '<tr><td colspan="5"><div style="margin-left:45%; margin-right:45%;text-align:center;" class="spinner-border" role="status">';
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

function handleRemove(pid,locked_status){
    authApi     = csrf_token;
    filters     = '&pid='+pid+'&lk='+locked_status;
    
    locat       = window.location.hostname;
    if(locat.slice(-1) != '/')
        locat += '/';

    color_status = '#298c3d';
    if(locked_status == 'Y')
        color_status = '#d60b0e';
    const requestURL = window.location.protocol+'//'+locat+'api/providers/auth_provider_remove.php?auth_api='+authApi+filters;
    //alert(requestURL);
    const request = new XMLHttpRequest();
    request.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            // Typical action to be performed when the document is ready:
            obj = JSON.parse(request.responseText);
            document.getElementById('locked_status_'+pid).style = 'color:'+color_status;
        }
    };
    request.open('GET', requestURL);
    //request.responseType = 'json';
    request.send();
}

function changeMessageLanguage(language,xname,xlink){
    document.getElementById('bodyText').innerHTML = invite_body[language].replace('%personal_url_to_register%',xlink).replace('%personal_url_to_register_href%',xlink).replace('%user_fullname%',xname);
    document.getElementById('bodytext-html').value = document.getElementById('bodyText').innerHTML;
}

function sendmailToProviderContact(form){
    //form.submit();
    errors          = 0;
    authApi         = csrf_token;
    message         = '';

    user_token      = form.tku.value;
    user_id         = form.uid.value;
    provider_id     = form.pid.value;
    provider_email  = form.pemail.value;
    provider_name   = form.pname.value;
    bodytext_html   = encodeURIComponent(form.bodytext.value);
    if(bodytext_html == ''){
        bodytext_html = encodeURIComponent(document.getElementById('bodyText').innerHTML);
    }

    querystring = 'auth_api='+authApi+'&tku='+user_token+'&pid='+provider_id+'&uid='+user_id+'&name='+provider_name+'&email='+provider_email+'&bodytext='+bodytext_html;
    locat       = window.location.hostname;
    if(locat.slice(-1) != '/')
        locat += '/';

    if(errors > 0){
        alert(message);
    } else{
        const requestURL = window.location.protocol+'//'+locat+'api/providers/auth_provider_sendmail.php';
        console.log(requestURL+'?'+querystring);
        const request = new XMLHttpRequest();
        request.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                // Typical action to be performed when the document is ready:
                obj = JSON.parse(request.responseText);
                document.getElementById('sendbutton').innerText = translateText('sent',localStorage.getItem('ulang'));
                //alert('Status: '+obj.status);
                //window.location.href = 'pr=Li9wYWdlcy9wcm92aWRlcnMvaW5mby5waHA=&pid='+provider_id;
            }
            else{
                document.getElementById('sendbutton').disabled = true;
                document.getElementById('sendbutton').innerText = "Sending...";
            }
        };
        request.open('POST', requestURL, true);
        request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        //request.responseType = 'json';
        request.send(querystring);
    }
}
