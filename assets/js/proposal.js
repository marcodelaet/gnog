lang        = 'es-MX';
if(localStorage.getItem('ulang') == 'ptbr')
    lang    = 'pt-BR';
if(localStorage.getItem('ulang') == 'eng')
    lang    = 'en-US';

thousands       = ',';
if(lang     =='pt-BR')
    thousands       = '.';

cents           = '.';
if(thousands== '.'){
    cents           = ',';
}

var xrowsFiles  = 0;

/*******************************************************
 * Default Email Text
 **********************/
var invite_body = [];
invite_body['esp'] = "<p>Hola %user_fullname%, ¿Cómo estás?</p>"+
"<p>Soy del equipo de <b>GNog Media y Tecnologia</b>.</p>"+
"<p>Envio por aquí la liga de registro de nuestra plataforma de envío de facturas, y el acceso para el manual de usuario para que puedas entender cómo funciona el sistema y si tienes alguna duda, probablemente encuentres la respuesta en el documento, en cualquier caso estamos a tu disposición. para ayudarlos en lo que necesiten con respecto a la plataforma.</p>"+
"<p>Haga el copy de la liga abajo y péguela en su browser para registrar su nombre de usuario y registrar su contraseña de acceso:</p>"+
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

module      = 'proposal';
start_index = 0;
objGlobal   = '';
document.getElementById('nav-item-proposals').setAttribute('class',document.getElementById('nav-item-proposals').getAttribute('class').replace(' active','') + ' active');
var csrf_token = $('meta[name="csrf-token"]').attr('content');
//alert(csrf_token);
xcurrency = 'MXN';
proposal_id = '';

function handleUploadXLSX(form){
    /***************************************
     *  Recording file and data to database
     **********************************/
    var formData = new FormData(form);
    //formData.append("billboard_file", file);
    
    locat       = window.location.hostname;
    if(locat.slice(-1) != '/')
        locat += '/';

    if(errors > 0){

    } else{
        const requestURL = window.location.protocol+'//'+locat+'api/billboards/auth_billboard_xlsx_upload.php';
        const request = new XMLHttpRequest();
        request.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                // Typical action to be performed when the document is ready:
                console.log(request.responseText);
                obj = JSON.parse(request.responseText);

                form.btnSave.innerHTML = "Upload list of billboards";
                if(obj.status === "OK"){
                    alert(obj.total_lines+" líneas leídas.\n"+obj.new_billboards+" medios agregados.\n"+obj.updated_billboards+" medios actualizados.\n"+obj.new_providers+" proveedores agregados.\n");
                    return true;
                }else{
                    alert(obj.message);
                    return false;
                }
            }
        };
        request.open('POST', requestURL);
        //request.responseType = 'json';
        request.send(formData);
    }
}

async function handleSubmitFileProduct(form){
    file                = document.getElementById('proposal-file');
    proposal_id         = document.getElementById('ppid').value;
    proposalproduct_id  = document.getElementById('pppid').value;
    owner_id            = document.getElementById('ownerid').value;

    inputfile       = document.querySelector("input[type='file']");
    xfile           = inputfile.files[0];
    extensionFile   = xfile.name.split('.')[1];

    if(extensionFile == 'xlsx'){
        if(confirm('Este archivo es de Medias OOH?')){
            const blob      = new Blob([xfile], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;charset=utf-8' });
            const buffer    = await blob.arrayBuffer();
            const workbook  = new ExcelJS.Workbook();
            await workbook.xlsx.load(buffer);
    
            if(workbook.worksheets.length == 1){
                worksheet   = workbook.getWorksheet(workbook.worksheets[0].id);
                header      = worksheet.getRow(1).values;
                /*********************************************************** 
                 * Solving sheet issues - missing required columns / values
                 ********************* */ 
                if((providerIndex = header.indexOf("Proveedor")) < 0){
                    error_message += '- Columna de Proveedor es obligatoria para estar en la planilla\n';
                }
    
                if((keyIndex = header.indexOf("Clave")) < 0){
                    error_message += '- Columna de Clave es obligatoria para estar en la planilla\n';
                }
    
                if((iluminationIndex = header.indexOf("Iluminación")) < 0){
                    error_message += '- Columna de Iluminación es obligatoria para estar en la planilla\n';
                }
    
                if((coordenatesIndex = header.indexOf("Coordenadas")) < 0){
                    error_message += '- Columna de Coordenadas es obligatoria para estar en la planilla\n';
                }
    
                if((latitudeIndex = header.indexOf("Latitud")) < 0){
                    error_message += '- Columna de Latitud es obligatoria para estar en la planilla\n';
                }
    
                if((longitudeIndex = header.indexOf("Longitud")) < 0){
                    error_message += '- Columna de Longitud es obligatoria para estar en la planilla\n';
                }
    
                error_type_count  = 0;
                if((typeIndex = header.indexOf("Tipo")) < 0){
                    error_type_count++;
                    if((typeIndex = header.indexOf("Categoria")) < 0){
                        error_type_count++;
                    }
                }
                if(error_type_count == 2){
                    error_message += '- Columna de Tipo es obligatoria para estar en la planilla\n';
                }
    
                if((categoryIndex = header.indexOf("Categoría (NSE)")) < 0){
                    error_message += '- Columna de Categoría (NSE) es obligatoria para estar en la planilla\n';
                }
    
                if((priceIndex = header.indexOf("Tarifa Publicada")) < 0){
                    error_message += '- Columna de Tarifa Publicada es obligatoria para estar en la planilla\n';
                }
    
                if((costIndex = header.indexOf("Costo")) < 0){
                    error_message += '- Columna de Costo es obligatoria para estar en la planilla\n';
                }
    
                total_rows = worksheet.rowCount; //19612

                if(total_rows > 10){
                    confirmation = confirm('Agregar '+ (total_rows - 1) + ' líneas de Medios OOH para la propuesta '+document.getElementById('offer-name').innerText+'?');
                } else {
                    rowsText            = '';
                    for(row_index=1;row_index<=total_rows;row_index++){
                        typeValue       = worksheet.getRow(row_index).values[typeIndex];
                        providerValue   = worksheet.getRow(row_index).values[providerIndex];
                        keyValue        = worksheet.getRow(row_index).values[keyIndex];
                        costValue       = worksheet.getRow(row_index).values[costIndex];
                        priceValue      = worksheet.getRow(row_index).values[priceIndex];

                        rowsText += providerValue + '\t' + keyValue + '\t' + typeValue + '\t' + costValue + '\t' + priceValue + '\n';
                    }
                    confirmation = confirm('Agregar las seguintes '+ (total_rows - 1)+ ' líneas de Medios OOH para la propuesta '+document.getElementById('offer-name').innerText+'?\n\n'+rowsText);
                }
                if(confirmation){
                    inputFile = file.cloneNode(true);
                    inputFile.setAttribute('id','billboard-file');
                    inputFile.setAttribute('name','billboard_file');
                    inputFile.setAttribute('value',document.getElementById('proposal-file').value);

                    targetElement   = document.getElementsByClassName('custom-file')[0];
                    targetElement.appendChild(inputFile);

                    
                     // Uploading OOH Medias from XLSX
                    handleUploadXLSX(form);

                    // Adding OOH Medias to proposal (starting in line 2 from XLSX, 'cause line 1 is Header)
                    for(row_index_x=2;row_index_x<=total_rows;row_index_x++){
                        typeValue       = worksheet.getRow(row_index_x).values[typeIndex];
                        providerValue   = worksheet.getRow(row_index_x).values[providerIndex];
                        keyValue        = worksheet.getRow(row_index_x).values[keyIndex];
                        costValue       = worksheet.getRow(row_index_x).values[costIndex];
                        costValueInt    = costValue.toString().split('.')[0];
                        if(typeof(costValue.toString().split('.')[1]) != 'undefined'){
                            costValueInt += (costValue.toString().split('.')[1]+'00').substr(0,2);
                        }else{
                            
                        }
                        
                        priceValue      = worksheet.getRow(row_index_x).values[priceIndex];
                        priceValueInt   = priceValue.toString().split('.')[0];
                        +(priceValue.toString().split('.')[1]+'00').substr(0,2);

                        getIdFromTable('billboard','uuid as id','name|||'+keyValue);
                        billbord_id         = objGlobal.data[0].id;
                        //proposalproduct_id
                        addBillboardToProposal(billbord_id,proposalproduct_id,costValue,priceValue);

                    }

                    // Uploading XLSX file
                    //handleUploadFile(form)
                }
            } else {
                error_message += 'El archivo debe tener solo 1 planilla\n';
            }
            /*********************
            * END checking sheet
            ***************************/
            if(error_message != ''){
                alert('Errores: \n'+error_message);
            }
        }
    } else {

    }
/*

*/
}
function handleUploadFile(form){
    file                = document.getElementById('proposal-file');
    proposal_id         = document.getElementById('ppid').value;
    proposalproduct_id  = document.getElementById('pppid').value;
    owner_id            = document.getElementById('ownerid').value;
    btnSave             = form.btnSave;
    btnText             = btnSave.innerText;
    if(file.value !== '') {
        if (proposal_id.value !== '0'){
            errors      = 0;
            authApi     = csrf_token;
            token       = localStorage.getItem('tokenGNOG');
            user_id     = localStorage.getItem('uuid');

            var formData = new FormData(form);
            formData.append("authApi", authApi);
            formData.append("usrTk", token);
            formData.append("uid", user_id);
            
            locat       = window.location.hostname;
            if(locat.slice(-1) != '/')
                locat += '/';
 
            if(errors > 0){

            } else{
                const requestURL = window.location.protocol+'//'+locat+'api/proposals/auth_proposalfiles_file_upload.php';
                const request = new XMLHttpRequest();
                //console.log(requestURL);
                request.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        // Typical action to be performed when the document is ready:
                        obj = JSON.parse(request.responseText);
                        console.log(request.responseText);
                        btnSave.innerText = btnText;
                        if(obj.status === "OK")
                            window.location.href = '?pr=Li9wYWdlcy9wcm9wb3NhbHMvb3BlcmF0aW9uL2Zvcm1lZGl0LnBocA==&ppid='+proposal_id+'&pppid='+proposalproduct_id;
                        else
                            alert(obj.message);
                    }
                    else{
                        btnSave.innerText = "Uploading...";
                    }
                };
                request.open('POST', requestURL);
                request.send(formData);
            }
        } else {
            alert('Please, select the invoicing product from the list (*)');
        }
    } else {
        alert('Please, choose files to upload (*)');
    }
}


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
    objStartDate    = [];
    objStopDate     = [];
    objProductValue = [];
    objSaleModel    = [];
    objProviderId   = [];
    objCost         = [];
    objPrice        = [];
    objState        = [];
    objCity         = [];
    objCounty       = [];
    objColony       = [];
    objQuantity     = [];
    objBillboard    = [];
    indexed         = 0;

    locat       = window.location.hostname;
    if(locat.slice(-1) != '/')
        locat += '/';

    if(errors > 0){
        alert(message);
    } else {

        proposal_id = proposalId;
        virg            = '';
        product_start_date  = '';
        product_stop_date   = '';
        product_id      = '';
        salemodel_id    = '';
        provider_id     = '';
        state_id        = '';
        city_id         = '';
        county_id       = '';
        colony_id       = '';
        quantity        = '';
        cost            = '';
        price           = '';
        billboard_id    = '';
        

        for(p=0; p < objProduct.length;p++){    
            if(objProduct[p][objProduct[p].selectedIndex].innerText == 'OOH'){
                /**************************************
                 * OOH 
                 ************************************/
                
                qtdBillboard = document.getElementsByName('oohprice_'+p+'[]').length;
                for(pr=0; pr < qtdBillboard; pr++){
                    objStartDate.push(document.getElementsByName('start_date_product[]')[p].value);
                    objStopDate.push(document.getElementsByName('stop_date_product[]')[p].value);
                    objProductValue.push(document.getElementsByName('product_id[]')[p].value);
                    objSaleModel.push(document.getElementsByName('oohsalemodel_id[]')[pr].value);
                    objProviderId.push(document.getElementsByName('oohprovider_id[]')[pr].value);
                    objState.push(document.getElementsByName('oohstate[]')[pr].value);
                    objCity.push(document.getElementsByName('oohcity[]')[pr].value);
                    objCounty.push(document.getElementsByName('oohcounty[]')[pr].value); 
                    objColony.push(document.getElementsByName('oohcolony[]')[pr].value);
                    objQuantity.push(1);
                    objCost.push(document.getElementsByName('oohCost[]')[pr].value);
                    objPrice.push(document.getElementsByName('oohprice_'+p+'[]')[pr].value);
                    objBillboard.push(document.getElementsByName('oohbillboard_id[]')[pr].value);
                    indexed++;    
                }
            } else {
                /**************************************
                 * ANOTHER PRODUCT
                 ************************************/
                objStartDate.push(document.getElementsByName('start_date_product[]')[p].value);
                objStopDate.push(document.getElementsByName('stop_date_product[]')[p].value);
                objProductValue.push(document.getElementsByName('product_id[]')[p].value);
                objSaleModel.push(document.getElementsByName('salemodel_id[]')[p].value);
                objProviderId.push(document.getElementsByName('provider_id[]')[p].value);
                objState.push(document.getElementsByName('state_id[]')[p].value);
                objCity.push(document.getElementsByName('city_id[]')[p].value);
                objCounty.push(document.getElementsByName('county_id[]')[p].value);
                objColony.push(document.getElementsByName('colony_id[]')[p].value);
                objQuantity.push(document.getElementsByName('quantity[]')[p].value);
                objCost.push(document.getElementsByName('cost[]')[p].value);
                objPrice.push(document.getElementsByName('price[]')[p].value);
                objBillboard.push('0');
                indexed++;
            }
            virg = '';
            if(p>0)
                virg = ',';

            xcost  = '0';
            if((objCost[p] != '') || (objCost[p] >= 0)){
                axCost = objCost[p].split(",");
                for(j=0;j < axCost.length;j++){
                    apCost     = axCost[j].split(".");
                    for(k=0;k < apCost.length;k++){
                        xcost      += apCost[k];
                    }
                }    
            } 

            xprice  = '0';
            if((objPrice[p] != '') || (objPrice[p] >= 0)){
                axPrice = objPrice[p].split(",");
                for(j=0;j < axPrice.length;j++){
                    apPrice     = axPrice[j].split(".");
                    for(k=0;k < apPrice.length;k++){
                        xprice      += apPrice[k];
                    }
                }    
            } 

            product_start_date += virg + objStartDate[p];
            product_stop_date += virg + objStopDate[p];
            product_id      += virg + objProductValue[p];
            salemodel_id    += virg + objSaleModel[p];
            cost            += virg + xcost;
            price           += virg + xprice;
            xquantity       = 1;
            if((objQuantity[p] != '') || (objQuantity[p] > 0))
                xquantity = objQuantity[p];
            quantity        += virg + xquantity;
            provider_id     += virg + objProviderId[p];
            //if(objState[p])
            state_id        += virg + objState[p];
            city_id         += virg + objCity[p];
            county_id       += virg + objCounty[p];
            colony_id       += virg + objColony[p];
            billboard_id    += virg + objBillboard[p];
            //console.log('psdt['+p+']: '+product_start_date);

        }
        //console.log('psdt_url: '+product_start_date);
        addProduct('['+product_start_date+']','['+product_stop_date+']','['+product_id+']','['+salemodel_id+']','['+cost+']','['+price+']',currency,'['+quantity+']','['+provider_id+']',proposal_id,'['+state_id+']','['+city_id+']','['+county_id+']','['+colony_id+']','['+billboard_id+']');

        form.btnSave.innerHTML = ucfirst(translateText("save",localStorage.getItem('ulang')));
        window.location.href = '?pr=Li9wYWdlcy9wcm9wb3NhbHMvZm9ybWVkaXQucGhw&ppid='+proposalId;
    }
}

function handleSubmitEditProduct(form){
    errors      = 0;
    authApi     = csrf_token;
    message     = '';

    var formData = new FormData(form);
    formData.append('auth_api',authApi);
    ppid = form.ppid.value;

    locat       = window.location.hostname;
    if(locat.slice(-1) != '/')
        locat += '/';

    if(errors > 0){
        alert(message);
    } else {
        const requestURL = window.location.protocol+'//'+locat+'api/proposals/auth_proposalproduct_edit.php';
        console.log(requestURL);
        const request = new XMLHttpRequest();
        request.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                // Typical action to be performed when the document is ready:
                console.log(request.responseText);                    
                obj = JSON.parse(request.responseText);


                form.btnSave.innerHTML = ucfirst(translateText("save",localStorage.getItem('ulang')));
                window.location.href = '?pr=Li9wYWdlcy9wcm9wb3NhbHMvZm9ybWVkaXQucGhw&ppid='+ppid;
            }
            else{
                form.btnSave.innerHTML = ucfirst(translateText("saving",localStorage.getItem('ulang')));
            }
        };
        request.open('POST', requestURL, false);
        //request.responseType = 'json';
        request.send(formData);
    }
}


function handleSubmit(form) {
    errors      = 0;
    authApi     = csrf_token;
    message     = '';
    if (((form.name.value !== '' && form.client_id.value !== '0') || (form.client_id.value !== '0' && form.agency_id.value !== '0')) && (form.start_date.value !== '' && form.executive_id.value !== '0') ) {
        //form.submit();
        if(proposal.start_date.value > proposal.stop_date.value){
            alert('la Fecha de inicio no puede ser mayor que la fecha final');
        } else {
            pixel       = 'N';
            if(form.pixel.checked)
                pixel   = 'Y';
    
            taxable     = 'N';
            if(form.taxable.checked)
                taxable = 'Y';
    
            if(form.contains(form.contact_id) !== true){
                errors++;
                message     = 'No hay contactos del cliente / agencia en la propuesta';
            }
    
            var formData = new FormData(form);
            formData.append('auth_api',authApi);
            formData.append('office_id',form.officeDropdownMenuButton.value);
            formData.append('pixel_option',pixel);
            formData.append('taxable_option',taxable);
    
            //total                   = form.total.value;
            //status_id               = form.status_id.value;
            currency                = form.currency.value;
    
            objProduct      = document.getElementsByName('product_id[]');
            objStartDate    = [];
            objStopDate     = [];
            objProductValue = [];
            objNotes        = [];
            //objSaleModel    = [];
            //objProviderId   = [];
            //objCost         = [];
            //objPrice        = [];
            objState        = [];
            objCity         = [];
            objCounty       = [];
            objColony       = [];
            //objQuantity     = [];
            //objBillboard    = [];
            indexed         = 0;
            for(p=0; p < objProduct.length;p++){
                //if(objProduct[p][objProduct[p].selectedIndex].innerText == 'OOH'){
                    /**************************************
                     * OOH 
                     ************************************/
                    /*
                    qtdBillboard = document.getElementsByName('oohprice_'+p+'[]').length;
                    for(pr=0; pr < qtdBillboard; pr++){
                        objStartDate.push(document.getElementsByName('start_date_product[]')[p].value);
                        objStopDate.push(document.getElementsByName('stop_date_product[]')[p].value);
                        objProductValue.push(document.getElementsByName('product_id[]')[p].value);
                        objNotes.push(document.getElementsByName('notes[]')[pr].value);
                        //objSaleModel.push(document.getElementsByName('oohsalemodel_id[]')[pr].value);
                        //objProviderId.push(document.getElementsByName('oohprovider_id[]')[pr].value);
                        objState.push(document.getElementsByName('oohstate[]')[pr].value);
                        objCity.push(document.getElementsByName('oohcity[]')[pr].value);
                        objCounty.push(document.getElementsByName('oohcounty[]')[pr].value); 
                        objColony.push(document.getElementsByName('oohcolony[]')[pr].value);
                        //objQuantity.push(1);
                        //objCost.push(document.getElementsByName('oohCost[]')[pr].value);
                        //objPrice.push(document.getElementsByName('oohprice_'+p+'[]')[pr].value);
                        //objBillboard.push(document.getElementsByName('oohbillboard_id[]')[pr].value);
                        indexed++;    
                    }
                } else*/ {
                    /**************************************
                     * ANOTHER PRODUCT
                     ************************************/
                    objStartDate.push(document.getElementsByName('start_date_product[]')[p].value);
                    objStopDate.push(document.getElementsByName('stop_date_product[]')[p].value);
                    objProductValue.push(document.getElementsByName('product_id[]')[p].value);
                    objNotes.push(document.getElementsByName('notes[]')[p].value);
                    //objSaleModel.push(document.getElementsByName('salemodel_id[]')[p].value);
                    //objProviderId.push(document.getElementsByName('provider_id[]')[p].value);
                    objState.push(document.getElementsByName('state_id[]')[p].value);
                    objCity.push(document.getElementsByName('city_id[]')[p].value);
                    objCounty.push(document.getElementsByName('county_id[]')[p].value);
                    objColony.push(document.getElementsByName('colony_id[]')[p].value);
                    //objQuantity.push(document.getElementsByName('quantity[]')[p].value);
                    //objCost.push(document.getElementsByName('cost[]')[p].value);
                    //objPrice.push(document.getElementsByName('price[]')[p].value);
                    //objBillboard.push('0');
                    indexed++;
                }
            }
    
            locat       = window.location.hostname;
            if(locat.slice(-1) != '/')
                locat += '/';
    
            if(errors > 0){
                alert(message);
            } else {
                const requestURL = window.location.protocol+'//'+locat+'api/proposals/auth_proposal_add_new.php';
                console.log('ln 315 PROPOSAL ADD: '+ requestURL);
                const request = new XMLHttpRequest();
                request.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        // Typical action to be performed when the document is ready:
                        //console.log(request.responseText);                    
                        obj = JSON.parse(request.responseText);
    
                        proposal_id     = obj[0].id;
                        virg            = '';
                        product_start_date  = '';
                        product_stop_date   = '';
                        product_id      = '';
                        notes           = '';
                        //salemodel_id    = '';
                        //provider_id     = '';
                        state_id        = '';
                        city_id         = '';
                        county_id       = '';
                        colony_id       = '';
                        //quantity        = '';
                        //cost            = '';
                        //price           = '';
                        //billboard_id    = '';
    
                        for(i=0; i < objProductValue.length;i++){
                            if(i>0)
                                virg = ',';
    
                            /****** COST  */
                            /*
                            xcost  = '0';
                            if((objCost[i] != '') || (objCost[i] >= 0)){
                                axCost = objCost[i].split(",");
                                for(j=0;j < axCost.length;j++){
                                    apCost     = axCost[j].split(".");
                                    for(k=0;k < apCost.length;k++){
                                        xcost      += apCost[k];
                                    }
                                }    
                            } 
                            */
    
                            /***** PRICE */
                            /*
                            xprice  = '0';
                            if((objPrice[i] != '') || (objPrice[i] >= 0)){
                                axPrice = objPrice[i].split(",");
                                for(j=0;j < axPrice.length;j++){
                                    apPrice     = axPrice[j].split(".");
                                    for(k=0;k < apPrice.length;k++){
                                        xprice      += apPrice[k];
                                    }
                                }    
                            } 
                            */

                            product_start_date += virg + objStartDate[i];
                            product_stop_date += virg + objStopDate[i];
                            product_id      += virg + objProductValue[i];
                            notes           += virg + decodeURIComponent(objNotes[i]);

                            //salemodel_id    += virg + objSaleModel[i];
                            //cost            += virg + xcost;
                            //price           += virg + xprice;
                            /***** QUANTITY */
                            /*
                            xquantity       = 1;
                            if((objQuantity[i] != '') || (objQuantity[i] > 0))
                                xquantity = objQuantity[i];
                            quantity        += virg + xquantity;
                            */

                            //provider_id     += virg + objProviderId[i];
                            //if(objState[i])
                            state_id        += virg + objState[i];
                            city_id         += virg + objCity[i];
                            county_id       += virg + objCounty[i];
                            colony_id       += virg + objColony[i];
                            //billboard_id    += virg + objBillboard[i];
                        }
    
                        //addProduct('['+product_start_date+']','['+product_stop_date+']','['+product_id+']','['+salemodel_id+']','['+cost+']','['+price+']',currency,'['+quantity+']','['+provider_id+']',proposal_id,'['+state_id+']','['+city_id+']','['+county_id+']','['+colony_id+']','['+billboard_id+']','['+notes+']');
                        addProductWhithoutAmounts('['+product_start_date+']','['+product_stop_date+']','['+product_id+']',currency,proposal_id,'['+state_id+']','['+city_id+']','['+county_id+']','['+colony_id+']','['+notes+']');
                        // alert('['+product_id+']'+'['+salemodel_id+']'+'['+cost+']'+'['+price+']'+currency+'['+quantity+']'+'['+provider_id+']'+proposal_id+'['+state_id+']'+'['+city_id+']'+'['+county_id+']'+'['+colony_id+']'+'['+billboard_id+']');
    
                        form.btnSave.innerHTML = ucfirst(translateText("save",localStorage.getItem('ulang')));
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
        objCost        = document.getElementsByName('cost[]');
        objQuantity     = document.getElementsByName('quantity[]');
        objProviderId   = document.getElementsByName('provider_id[]');
        objStartDate    = [];
        objStopDate     = [];

        if(errors > 0){
            alert(message);
        } else{
            virg            = '';
            start_date      = '';
            stop_date       = '';
            product_id      = '';
            salemodel_id    = '';
            cost            = '';
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
                xcost  = '0';
                if((objCost[i].value != '') || (objCost[i].value >= 0)){
                    axCost = objCost[i].value.split(",");
                    for(c=0;c < axCost.length;c++){
                        apCost     = axCost[c].split(".");
                        for(d=0;d < apCost.length;d++){
                            xcost      += apCost[d];
                        }
                    }    
                } 
                objStartDate.push(document.getElementsByName('start_date_product[]')[i].value);
                objStopDate.push(document.getElementsByName('stop_date_product[]')[i].value);

                start_date      += virg + objStartDate[i];
                stop_date       += virg + objStopDate[i];
                product_id      += virg + product;
                salemodel_id    += virg + saleModel;
                cost            += virg + xcost;
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
            addProduct('['+start_date+']','['+stop_date+']','['+product_id+']','['+salemodel_id+']','['+cost+']','['+price+']',currency,'['+quantity+']','['+provider_id+']',proposal_id,'['+state_id+']','['+city_id+']','['+county_id+']','['+colony_id+']');

            form.btnSave.innerHTML = ucfirst(translateText("save",localStorage.getItem('ulang')));
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
         console.log('xsjoe: \n'+requestURL);
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

                xrows=0;
                // products list for statement
                oldProduct = 'xxxx';
                for(var i=0;i<obj['data'].length;i++){
                    deleted_line='';
                    xpppid = obj['data'][i].proposalproduct_id;
                    if(obj['data'][i].is_proposalproduct_active == "N")
                        deleted_line='deleted-billboard';
                    productName = obj['data'][i].product_name;
                    if(obj['data'][i].salemodel_id != null)
                        productName += ' / '+ obj['data'][i].salemodel_name;
                    if(oldProduct != productName){
                        xxhtml += '<spam class="product-line '+deleted_line+'">'+obj['data'][i].quantity + ' x ' + productName +' - '+formatter.format(obj['data'][i].amount)+'</spam><br />';
                        oldProduct = productName;
                        handleListProductFilesOnLoad(ppid,xpppid);
                        checkIfProposalFileExists(ppid,xpppid);
                        xrows += xrowsFiles;
                        //alert(xrows);
                    }
                }
                classStatus = document.getElementsByClassName('dropdown-item status'); 
                for(var cs=0; cs < classStatus.length; cs++){
                    classStatus[cs].setAttribute('onclick',classStatus[cs].getAttribute('onclick').replace(",'');",",'"+obj['data'][0].status_id+"');"));
                }

                xcopy   = '';
                if(xrows > 0){
                    contact_fullname    = ucfirst(obj['data'][0].advertiser_contact_name) + ' ' + ucfirst(obj['data'][0].advertiser_contact_surname);
                    contact_email       = obj['data'][0].advertiser_contact_email;
                    textHTML = invite_body['esp'];
                    xcopy += '&nbsp;<spam role="button" title="Send message / files to Advertiser"  data-toggle="modal" data-target="#sendEmailModal" data-whatever="@mdo" onclick="document.getElementById(\'modal-sendbutton\').classList.remove(\'disabled\'); document.getElementById(\'advertiser_contact_email\').innerText=\''+contact_email+'\'; document.getElementById(\'aemail\').value=\''+contact_email+'\'; document.getElementById(\'advertiser_contact_name\').innerText=\''+contact_fullname+'\'; document.getElementById(\'aname\').value=\''+contact_fullname+'\'; document.getElementById(\'bodytext-html\').value =  textHTML.replace(\'%user_fullname%\',\''+contact_fullname+'\'); document.getElementById(\'language-option\').value=\'esp\'; document.getElementById(\'bodyText\').innerHTML = textHTML.replace(\'%user_fullname%\',\''+contact_fullname+'\');"><spam class="material-icons icon-data">send</spam></a>';
                }

                document.getElementById('products-list').innerHTML          = xxhtml;
                document.getElementById('div-sendbutton').innerHTML         = xcopy;
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

function checkIfProposalFileExists(ppid,pppid){
    errors      = 0;
    authApi     = csrf_token;
    locat       = window.location.hostname;
    xrowsFiles  = 0;

    orderby     = '';
    filters     = '&ppid='+ppid;
    if(pppid !==null)
        filters += '&pppid='+pppid;
    if(locat.slice(-1) != '/')
        locat += '/';

    if(errors > 0) {

    } else {
        const requestURL = window.location.protocol+'//'+locat+'api/proposals/auth_proposal_files_counter.php?auth_api='+authApi+filters+orderby;
        console.log('getNumFiles- '+requestURL);
        const request = new XMLHttpRequest();
        request.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                objFile         = JSON.parse(request.responseText);
                xrowsFiles      += parseInt(objFile.rows);
                //alert(xrowsFiles);
                //tableID = document.getElementById('listIProposalFiles');
                return parseInt(xrowsFiles);
            }
        };
        request.open('GET', requestURL,false);
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
                formattedStartDate  = startDate.toLocaleDateString(lang);
                stopDate            = new Date(obj['data'][0].stop_date);
                formattedStopDate   = stopDate.toLocaleDateString(lang);
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
                strStartDateMonth                                       = '00'+(startDate.getMonth()+1);
                strStopDateMonth                                        = '00'+(stopDate.getMonth()+1);
                strStartDateDay                                         = '00'+(startDate.getDate());
                strStopDateDay                                          = '00'+(stopDate.getDate());
                document.getElementById('start-date-input').value       = startDate.getFullYear()+'-'+strStartDateMonth.substr(-2,2)+'-'+strStartDateDay.substr(-2,2);
                document.getElementById('stop-date-input').value        = stopDate.getFullYear()+'-'+strStopDateMonth.substr(-2,2)+'-'+strStopDateDay.substr(-2,2);
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

                document.getElementById('offer-name').innerText         = obj['data'][0].offer_name;
                document.getElementById('advertiser-name').innerText    = advertiser_name;
                document.getElementById('info-currency').innerText      = obj['data'][0].currency_c;
                document.getElementById('start-date').innerText         = startDate.toLocaleDateString(lang);
                document.getElementById('stop-date').innerText          = stopDate.toLocaleDateString(lang);
                document.getElementById('currency').value               = obj['data'][0].currency_c;
                strStartDateMonth                                       = '00'+(startDate.getMonth()+1);
                strStopDateMonth                                        = '00'+(stopDate.getMonth()+1);
                strStartDateDay                                         = '00'+(startDate.getDate());
                strStopDateDay                                          = '00'+(stopDate.getDate());
                document.getElementById('start-date-input').value       = startDate.getFullYear()+'-'+strStartDateMonth.substr(-2,2)+'-'+strStartDateDay.substr(-2,2);
                document.getElementById('stop-date-input').value        = stopDate.getFullYear()+'-'+strStopDateMonth.substr(-2,2)+'-'+strStopDateDay.substr(-2,2);
                document.getElementById('currency-input').value         = obj['data'][0].currency_c;
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

function handleListProductFilesOnLoad(ppid,pppid){
    errors      = 0;
    authApi     = csrf_token;
    locat       = window.location.hostname;

    orderby     = '';
    filters     = '&ppid='+ppid+'&pppid='+pppid;
    if(locat.slice(-1) != '/')
        locat += '/';

    if(errors > 0) {

    } else {
        const requestURL = window.location.protocol+'//'+locat+'api/proposals/auth_proposal_files_list.php?auth_api='+authApi+filters+orderby;
        //console.log('getFiles- '+requestURL);
        const request = new XMLHttpRequest();
        request.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                obj     = JSON.parse(request.responseText);
                var row             = null;
                var link            = null;
                var cellFileName    = null;
                var cellFileDate    = null;
                tableID = document.getElementById('listIProposalFiles');
                if(obj.response != 'ZERO_RETURN'){
                    for(var i=0;i < obj['data'].length; i++){
                        row             = tableID.insertRow();
                        cellFileName    = row.insertCell(0);
                        cellFileDate    = row.insertCell(1);
    
                        cellFileName.classList.add('table-column-Filename');
                        cellFileDate.classList.add('table-column-Date');
    
                        link        = document.createElement('A');
                        link.setAttribute('href',obj['data'][i].file_location+obj['data'][i].file_name);
                        link.setAttribute('target','_blank');
    
                        textNode    = document.createTextNode(obj['data'][i].file_name);
                        link.appendChild(textNode);
    
                        cellFileName.appendChild(link);
                        cellFileDate.innerText = new Date(obj['data'][i].file_updated_at).toLocaleDateString(lang) + ' ' + new Date(obj['data'][i].file_updated_at).toLocaleTimeString(lang);
                    }
                }
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

function handleListEditProductOnLoad(ppid,pppid){
    errors      = 0;
    authApi     = csrf_token;
    locat       = window.location.hostname;

    filters     = '&ppid='+ppid+'&pppid='+pppid;
    if(locat.slice(-1) != '/')
        locat += '/';

    if(errors > 0){

    } else{
        const requestURL = window.location.protocol+'//'+locat+'api/proposals/auth_proposal_get.php?auth_api='+authApi+filters+orderby;
        console.log('getPPP- '+requestURL);
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

                document.getElementById('offer-name').innerText         = obj['data'][0].offer_name;
                document.getElementById('advertiser-name').innerText    = advertiser_name;
                document.getElementById('info-currency').innerText      = obj['data'][0].currency_c;
                document.getElementById('start-date').innerText         = startDate.toLocaleDateString(lang);
                document.getElementById('stop-date').innerText          = stopDate.toLocaleDateString(lang);
                document.getElementById('currency').value               = obj['data'][0].currency_c;
                document.getElementById('div-note').innerText           = obj['data'][0].notes;
                strStartDateMonth                                       = '00'+(startDate.getMonth()+1);
                strStopDateMonth                                        = '00'+(stopDate.getMonth()+1);
                strStartDateDay                                         = '00'+(startDate.getDate());
                strStopDateDay                                          = '00'+(stopDate.getDate());
                document.getElementById('start-date-input').value       = startDate.getFullYear()+'-'+strStartDateMonth.substr(-2,2)+'-'+strStartDateDay.substr(-2,2);
                document.getElementById('stop-date-input').value        = stopDate.getFullYear()+'-'+strStopDateMonth.substr(-2,2)+'-'+strStopDateDay.substr(-2,2);
                document.getElementById('currency-input').value         = obj['data'][0].currency_c;
                xcurrency = obj['data'][0].currency_c;

                product = obj['data'][0].product_name;
                if(obj['data'][0].salemodel_name != null)
                    product += ' / '+obj['data'][0].salemodel_name;

                // Create our number formatter.
                var formatter = new Intl.NumberFormat(lang, {
                    //style: 'currency',
                    //currency: xcurrency, // believing every currency will be MXN
                    //maximumSignificantDigits: 2,

                    // These options are needed to round to whole numbers if that's what you want.
                    minimumFractionDigits: 2, // (this suffices for whole numbers, but will print 2500.10 as $2,500.1)
                    //maximumFractionDigits: 0, // (causes 2500.99 to be printed as $2,501)
                });

                /*****************************
                 * FORM FILL- AREA
                 */
                is_digital = false;
                if(obj['data'][0].is_digital == 'Y')
                    is_digital = true;

                unique = false;
                if(obj['data'][0].stop_date_for_product == null)
                    unique = true;
    
                provider_id = 0;
                if(obj['data'][0].provider_id != null)
                    provider_id = obj['data'][0].provider_id;

                
                if(document.getElementById('digital_product-0') != null){
                    document.getElementById('digital_product-0').checked      = is_digital;
                }
                if(document.getElementById('datetype_option-0') != null){
                    document.getElementById('datetype_option-0').checked      = unique;
                }
                if(document.getElementById('div-productname') != null){
                    document.getElementById('div-productname').innerHTML      = product;
                }
                if(document.getElementById('ownerid') != null){
                    document.getElementById('ownerid').value                = obj['data'][0].user_id;
                }
                    
                digital_int = '1';
                if(is_digital === true){
                    document.getElementById('digital_product-0').value      = 1;
                    digital_int = '0';
                    //refilterProductsType(0);
                }

                //refilterProductsType(digital_int,0);
                refilterProductsType(digital_int,0,obj['data'][0].product_id);
                if(document.getElementById('digital_product-0') != null){
                    refilterSaleModel(document.getElementById('digital_product-0').value,obj['data'][0].product_id,0,obj['data'][0].salemodel_id);
                }

                if(unique === true){
                    document.getElementById('div-stopDate-product').style   ='display:none';
                }
                if(document.getElementById('start_date_product_0') != null)
                    document.getElementById('start_date_product_0').value   = obj['data'][0].start_date_for_product;
                if(document.getElementById('stop_date_product_0') != null)
                    document.getElementById('stop_date_product_0').value    = obj['data'][0].stop_date_for_product;
                if(document.getElementById('selectproduct_0') != null){
                    document.getElementById('selectproduct_0').value        = obj['data'][0].product_id;
                    checkOOHSelection(obj['data'][0].product_name,0);
                }
                if(document.getElementById('selectsalemodel_0') != null)
                    document.getElementById('selectsalemodel_0').value      = obj['data'][0].salemodel_id;
                
                if(document.getElementById('cost') != null)
                    document.getElementById('cost').value                   = formatter.format(obj['data'][0].cost);
                if(document.getElementById('price') != null)
                    document.getElementById('price').value                  = formatter.format(obj['data'][0].price);
                if(document.getElementById('quantity') != null)
                    document.getElementById('quantity').value               = obj['data'][0].quantity;
                if(document.getElementById('amount') != null)
                    document.getElementById('amount').value                 = formatter.format(obj['data'][0].amount);
                if(document.getElementById('selectprovider') != null)
                    document.getElementById('selectprovider').value         = provider_id;

                /************
                 * SEND EMAIL BUTTOM
                 */
                contact_email   = obj['data'][0].contact_email;
                xhtml           = '';
                full_name       = "Teste";
                //xcopy += '&nbsp;<a style="color: #212529" href="javascript:void(0)" title="'+translateText('send_user_crt_url_to',localStorage.getItem('ulang'))+' '+obj['data'][i].contact_email+'" onclick=""><spam class="material-icons icon-data">send</spam></a>';
                xeffect         = 'insider'; 
                xuser           = 'https://providers.gnogmedia.com?pr=Li9wYWdlcy91c2Vycy9mb3JtLnBocA==&cpid='+obj['data'][0].contact_provider_id;
                xcopy           = '&nbsp;&nbsp;&nbsp;<a style="color: #212529" href="javascript:void(0)" title="'+translateText('copy_user_crt_url',localStorage.getItem('ulang'))+' ('+obj['data'][0].contact_email+')" onclick="copyStringToClipboard(\''+xuser+'\'\)"><spam class="material-icons icon-data">content_copy</spam></a>';
                textHTML        = invite_body['esp'];
                xcopy           += '&nbsp;<a style="color: #212529; cursor: pointer;" title="'+translateText('send_user_crt_url_to',localStorage.getItem('ulang'))+' '+obj['data'][0].contact_email+'"  data-toggle="modal" data-target="#sendmailModal" data-whatever="@mdo" onclick="document.getElementById(\'sendbutton\').disabled = false; document.getElementById(\'sendbutton\').innerText = translateText(\'send_message\',localStorage.getItem(\'ulang\')); document.getElementById(\'provider_contact_email\').innerText=\''+contact_email+'\'; document.getElementById(\'pemail\').value=\''+contact_email+'\'; document.getElementById(\'pname\').value=\''+full_name+'\'; document.getElementById(\'plink\').value=\''+xuser+'\'; document.getElementById(\'bodytext-html\').value =  textHTML.replace(\'%personal_url_to_register%\',\''+xuser+'\').replace(\'%personal_url_to_register_href%\',\''+xuser+'\').replace(\'%user_fullname%\',\''+full_name+'\'); document.getElementById(\'language-option\').value=\'esp\'; document.getElementById(\'bodyText\').innerHTML = textHTML.replace(\'%personal_url_to_register%\',\''+xuser+'\').replace(\'%personal_url_to_register_href%\',\''+xuser+'\').replace(\'%user_fullname%\',\''+full_name+'\');"><spam class="material-icons icon-data">send</spam></a>';

                xhtml           += xcopy;

                //BUTTON 
                //document.getElementById('div-specialbuttons').value         = provider_id;


                //console.log(obj['data'][0].product_id +' - '+ obj['data'][0].product_name);
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
    groupby     = '&groupby=proposalproduct_id';
  
    if(locat.slice(-1) != '/')
        locat += '/';

    if(errors > 0){

    } else{
        const requestURL = window.location.protocol+'//'+locat+'api/proposals/auth_proposal_get.php?auth_api='+authApi+filters+groupby+orderby;
        console.log('ln 968 get proposal - '+requestURL);
        const request = new XMLHttpRequest();
        request.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                
                //console.log(request.responseText);
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

                linkType    = '-alink';
                if(obj['data'][0].status_id == '6'){
                    linkType = '';
                }

                document.getElementById('offer-name').innerText         = obj['data'][0].offer_name;
                document.getElementById('advertiser-name').innerText    = advertiser_name;
                startYear   = obj['data'][0].start_date.substr(0,4);
                startMonth  = obj['data'][0].start_date.substr(5,2);
                startDay    = obj['data'][0].start_date.substr(8,2);
                startDate   = new Date(parseInt(startYear),parseInt(startMonth)-1,parseInt(startDay),0,0,0);
                document.getElementById('start-date'+linkType).innerText   = startDate.toLocaleDateString();

                stopYear   = obj['data'][0].stop_date.substr(0,4);
                stopMonth  = obj['data'][0].stop_date.substr(5,2);
                stopDay    = obj['data'][0].stop_date.substr(8,2);
                stopDate   = new Date(parseInt(stopYear),parseInt(stopMonth)-1,parseInt(stopDay),0,0,0);
                document.getElementById('stop-date-alink').innerText    = stopDate.toLocaleDateString();
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
                    actualProduct = obj['data'][i].product_name+obj['data'][i].salemodel_name + obj['data'][i].state;
                    product = obj['data'][i].product_name+obj['data'][i].salemodel_name + obj['data'][i].state;
                    if(product != productOld){
                        providerOld     = 0;
                        numberProducts++;
                       // if(showLine == 1){
                            // showing only actived products
                            if(obj['data'][i].is_proposalproduct_active=="Y"){
                                salemodel_name         = '';
                                salemodel_name_bar     = '';
                                if(typeof(obj['data'][i].salemodel_name) == 'undefined'){
                                    salemodel_name     = obj['data'][i].salemodel_name;
                                    salemodel_name_bar = ' / '+obj['data'][i].salemodel_name;
                                }
                                //alert(typeof(obj['data'][i].salemodel_name));
                                    
                                html += '<div class="row list-products-row" id="product-'+obj['data'][i].proposalproduct_id+'-row">';
                                html += '<div class="col-sm-1">'+(numberProducts)+'</div>';
                                html += '<div class="col-sm-3">'+obj['data'][i].product_name+salemodel_name+'</div>';
                                html += '<div class="col-sm-2">'+obj['data'][i].state+'</div>'; 
                                //'<div class="col-sm-2">Rate % All</div>' +
                                /********************************************
                                 * PRODUCT AREA                             * 
                                 */
                                if(aBillboards.indexOf(obj['data'][i].salemodel_name) != -1){ // is a billboard (OFFLINE MEDIA LOCATIONS - CHOOSE LOCATION ON MAP OPTION)
                                //if(obj[i].billboard_salemodel_name != null){
                                    html += '<div class="col-sm-2" style="text-align:center; white-space: nowrap;"><a title="'+ucfirst(translateText('choose',localStorage.getItem('ulang')))+' '+obj['data'][i].product_name+salemodel_name_bar+' '+translateText('on_map',localStorage.getItem('ulang'))+'" href="?pr=Li9wYWdlcy9tYXBzL2luZGV4LnBocA==&smid='+obj['data'][i].salemodel_id+'&ppid='+ppid+'&pppid='+obj['data'][i].proposalproduct_id+'&state='+obj['data'][i].state+'&city='+obj['data'][i].city+'&county='+obj['data'][i].county+'&colony='+obj['data'][i].colony+'"><span class="material-icons" style="font-size:1.2rem;">map</span><br/><span style="font-size:0.8rem">'+ucfirst(translateText('choose',localStorage.getItem('ulang')))+' '+salemodel_name+' '+translateText('on_map',localStorage.getItem('ulang'))+'</span></a></div>';
                                } else { // IS NOT AN OFFLINE MEDIA LOCATION - ADD PROVIDER OPTION
                                    html += '<div class="col-sm-2" style="text-align:center; white-space: nowrap;"><a title="'+ucfirst(translateText('add+',localStorage.getItem('ulang')))+' '+translateText('provider',localStorage.getItem('ulang'))+'" href="?pr=Li9wYWdlcy9wcm9wb3NhbHMvcHJvdmlkZXIvZm9ybWFkZC5waHA=&smid='+obj['data'][i].salemodel_id+'&ppid='+ppid+'&pppid='+obj['data'][i].proposalproduct_id+'&state='+obj['data'][i].state+'&city='+obj['data'][i].city+'&county='+obj['data'][i].county+'&colony='+obj['data'][i].colony+'"><span class="material-icons" style="font-size:1.2rem;">add_business</span> <br/><span style="font-size:0.8rem">'+ucfirst(translateText('add+',localStorage.getItem('ulang')))+' '+translateText('provider',localStorage.getItem('ulang'))+'</span></a></div>';
                                }

                                /***************************************************************
                                 * ### AVAILABLE OPTION ONLY WHEN IS NOT A PROVIDER INCLUDED ###
                                 *************************** */ 
                                if(obj['data'][i].provider_id == null){

                                /************************************
                                 * UPLOAD PRODUCT INFORMATION FILE (OPERATION)
                                 ************************************/ 
                                html += '<div class="col-sm-1" style="text-align:center; white-space: nowrap;">';
                                html += '<a href="?pr=Li9wYWdlcy9wcm9wb3NhbHMvb3BlcmF0aW9uL2Zvcm1lZGl0LnBocA==&ppid='+ppid+'&pppid='+obj['data'][i].proposalproduct_id+'"><span class="material-icons-round" style="font-size:1.5rem; color:black;" title="Upload operational files to '+obj['data'][i].product_name+salemodel_name+' in the '+module + ' '+obj['data'][i].offer_name+'">upload_file</span></a>';


                                /************************************
                                 * EDIT PRODUCT OPTION 
                                 ************************************/ 
                                
                                //html += '<div class="col-sm-1" style="text-align:center; white-space: nowrap;">';
                                html += '<a title="'+ucfirst(translateText('add+',localStorage.getItem('ulang')))+' '+translateText('provider',localStorage.getItem('ulang'))+'" href="?pr=Li9wYWdlcy9wcm9wb3NhbHMvcHJvZHVjdC9mb3JtZWRpdC5waHA=&ppid='+ppid+'&pppid='+obj['data'][i].proposalproduct_id+'&state='+obj['data'][i].state+'&city='+obj['data'][i].city+'&county='+obj['data'][i].county+'&colony='+obj['data'][i].colony+'">';
                                html += '<span class="material-icons" style="font-size:1.5rem; color:black;" title="'+ucfirst(translateText('edit',localStorage.getItem('ulang')))+' '+translateText('product',localStorage.getItem('ulang'))+' '+obj['data'][i].product_name+salemodel_name_bar+'">edit</span>';
                                html += '</a>';
                                //html += '</div>';

                                /**************************************** 
                                 * REMOVE PRODUCT OPTION 
                                 * *************************************/ 
                                // alert(obj['data'][i].provider_id);

                                
                                    //html +='<div class="col-sm-1" id="button-delete-'+obj['data'][i].proposalproduct_id+'">';
                                    html +='<a href="javascript:void(0);" onclick="if(confirm(\''+translateText('confirm',localStorage.getItem('ulang'))+' '+translateText('to_remove',localStorage.getItem('ulang'))+' '+obj['data'][i].product_name+salemodel_name_bar+' '+translateText('from_the_list',localStorage.getItem('ulang'))+'?\')){handleRemoveProductFromProposal(\''+obj['data'][i].proposalproduct_id+'\');}">';
                                    html +='<span class="material-icons" style="font-size:1.5rem; color:black;" title="'+translateText('remove',localStorage.getItem('ulang'))+' '+obj['data'][i].product_name+salemodel_name_bar+' '+translateText('from_the_list',localStorage.getItem('ulang'))+'">delete</span></a></div>';
                                }
                                html += '</div>';  
                            } else { product = "reset"; numberProducts--; }
                        //}
                        // listing files
                        handleListProductFilesOnLoad(ppid,obj['data'][i].proposalproduct_id);
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
                    if((obj['data'][i].is_proposalbillboard_active === null) && ((provider == null) || (provider =='111'))){
                        provider_name = "";// "Sin proveedor";
                        if((aProviders.indexOf(provider) >= 0) && (aBillboards.indexOf(salemodel_name) != -1)){
                            showLine = 0;
                        }
                        provider = '111';
                    }

                    if(provider != providerOld){
                        numberProviders++;
                        html += '<div class="row provider-description">' +
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
                                '<div class="col-sm-3 line-list-'+obj['data'][i].billboard_id+' '+deletedbillboard+'">'+formatter.format(obj['data'][i].productbillboard_cost)+' / <span id="price-'+obj['data'][i].billboard_id+'">'+formatter.format(obj['data'][i].billboard_price)+'</span>' +//' / <span id="cost-'+obj['data'][i].billboard_id+'">'+formatter.format(obj['data'][i].production_cost)+'</span>' +
                                '</div>'+ 
                            '<div class="input-group col-sm-3" id="rate-delete-'+obj['data'][i].billboard_id+'">';
                                if(deletedbillboard == '') {
                                    //html += '<label for="fee-'+obj[i].billboard_id+'">Fee rate</label>' +
                                    html += $impression_cost_line + 
                                    '<a href="javascript:void(0);" onclick="calculatorFee(\''+obj['data'][i].proposalproduct_id+'\',\''+obj['data'][i].billboard_id+'\','+obj['data'][i].productbillboard_cost_int+',\''+obj['data'][i].billboard_name+'\',\''+xcurrency+'\');">'+
                                    '<span class="material-icons" style="font-size:1.5rem; color:black;" title="Informe de costo del fee de '+obj['data'][i].billboard_salemodel_name+' '+obj['data'][i].billboard_name+'">price_change</span>'+
                                    '</a>'+
                                    '<input name="fee-'+obj['data'][i].billboard_id+'" id="fee-'+obj['data'][i].billboard_id+'" placeholder="% Fee" title="Percent (%) fee" aria-label="Percent (%) fee" value="30" class="form-control" style="height:1.5rem !important; width:3.5rem !important;" type="percent" maxlength="2" autocomplete="fee" />'+
                                    '<div class="input-group-append" style="height:1.5rem !important; width:3.5rem !important;"><span class="input-group-text">% ' +
                                    '<a href="javascript:void(0);" onclick="executeFeeOnPrice(\''+obj['data'][i].proposalproduct_id+'\',\''+obj['data'][i].billboard_id+'\','+obj['data'][i].productbillboard_cost_int+',\''+obj['data'][i].billboard_name+'\',\''+xcurrency+'\');">'+
                                    '<span class="material-icons" style="font-size:1.5rem; color:black;" title="Calcula Fee para '+obj['data'][i].billboard_salemodel_name+' '+obj['data'][i].billboard_name+'">calculate</span>'+
                                    '</a>'+
                                    '</span></div>';
                                }
                                html += '</div>';// + 
                                //'<div class="col-sm-1" id="button-delete-'+obj['data'][i].billboard_id+'">';

                        if(deletedbillboard == ''){
                            html += '<div class="col-sm-1" id="button-delete-'+obj['data'][i].billboard_id+'">'+
                            '<a href="javascript:void(0);" onclick="if(confirm(\''+translateText('confirm',localStorage.getItem('ulang'))+' '+translateText('to_remove',localStorage.getItem('ulang'))+' '+obj['data'][i].salemodel_name+' '+translateText('key',localStorage.getItem('ulang'))+' '+obj['data'][i].billboard_name+' '+translateText('on_the_list',localStorage.getItem('ulang'))+' '+translateText('from_the_state_of',localStorage.getItem('ulang'))+' '+obj['data'][i].state+'?\')){handleRemoveFromList(\''+obj['data'][i].proposalproduct_id+'\',\''+obj['data'][i].billboard_id+'\');}">'+
                            '<span class="material-icons" style="font-size:1.5rem; color:black;" title="'+translateText('remove',localStorage.getItem('ulang'))+' '+obj['data'][i].billboard_salemodel_name+' '+obj['data'][i].billboard_name+' '+translateText('from_the_list',localStorage.getItem('ulang'))+'">delete</span></a></div>';
                        }
                        html += '</div>' +
                        '</div>' +
                        '</div>';    
                    }

                    productOld = product;
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

function handleListOnLoad(search,page) {
    errors      = 0;
    authApi     = encodeURIComponent(csrf_token);
    locat       = window.location.hostname;

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
        tableList   = document.getElementById('listProposals');
        const requestURL = window.location.protocol+'//'+locat+'api/proposals/auth_proposal_list.php?auth_api='+authApi+filters+pages;
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
                    for(var i=0;i < obj['data'].length; i++){
                        var formatter = new Intl.NumberFormat(lang, {
                            style: 'currency',
                            currency: obj['data'][i].currency,
                            //maximumSignificantDigits: 2,
                    
                            // These options are needed to round to whole numbers if that's what you want.
                            //minimumFractionDigits: 2, // (this suffices for whole numbers, but will print 2500.10 as $2,500.1)
                            //maximumFractionDigits: 0, // (causes 2500.99 to be printed as $2,501)
                        });
                        color_status = '#d60b0e';
                        if(obj['data'][i].is_active == 'Y')
                            color_status = '#298c3d';



                        color_status = '#d60b0e';
                        color_letter = '#CCCCFF';
                        if(obj['data'][i].status_percent == '100'){
                            color_status = '#298c3d';
                            color_letter = '#CCCCFF';
                        }
                        if(obj['data'][i].status_percent == '90'){
                            color_status = '#03fc84';
                            color_letter = '#000000';
                        }
                        if(obj['data'][i].status_percent == '75'){
                            color_status = '#77fc03';
                            color_letter = '#000000';
                        }
                        if(obj['data'][i].status_percent == '50'){
                            color_status = '#ebfc03';
                            color_letter = '#6666FF';
                        }
                        if(obj['data'][i].status_percent == '25'){
                            color_status = '#fc3d03';
                            color_letter = '#CCCCFF';
                        }
                            
                        agency = '';
                        if(typeof(obj['data'][i].agency_name) === 'string')
                            agency = ' / '+obj['data'][i].agency_name;
                        amount = obj['data'][i].amount;
                        start_date  = new Date(obj['data'][i].start_date);
                        stop_date   = new Date(obj['data'][i].stop_date);
                        execute_CheckFiles = checkIfProposalFileExists(obj['data'][i].UUID,null);
                        
                        files_yn = ucfirst(translateText('no',localStorage.getItem('ulang')));
                        if(xrowsFiles > 0)
                            files_yn = ucfirst(translateText('yes',localStorage.getItem('ulang')));
                        
                        html += '<tr><td>'+obj['data'][i].offer_name+'</td><td nowrap>'+obj['data'][i].client_name+agency+'</td><td nowrap>'+obj['data'][i].username+'</td><td nowrap>'+formatter.format(amount)+'</td><td>'+start_date.toLocaleString(lang).split(" ")[0].replace(",","")+'</td><td>'+stop_date.toLocaleString(lang).split(" ")[0].replace(",","")+'</td><td class="text-center">'+files_yn+'</td><td class="text-center" ><span id="status_'+obj['data'][i].UUID+'" class="material-icons" title="'+obj['data'][i].status_percent+'% '+translateText(obj['data'][i].status_name,localStorage.getItem('ulang'))+'" style="color:'+color_status+'">thermostat</span><br/><span class="status-description" style="background-color:'+color_status+'; color:'+color_letter+'">&nbsp;&nbsp;'+obj['data'][i].status_percent+'% '+translateText(obj['data'][i].status_name,localStorage.getItem('ulang'))+'&nbsp;&nbsp;</span></td><td nowrap class="text-center">';
                        // information card
                        html += '<a href="?pr=Li9wYWdlcy9wcm9wb3NhbHMvaW5mby5waHA=&ppid='+obj['data'][i].UUID+'"><span class="material-icons" style="font-size:1.5rem; color:black;" title="Information Card '+obj['data'][i].offer_name+'">info</span></a>';

                        // Edit form
                        html += '<a href="?pr=Li9wYWdlcy9wcm9wb3NhbHMvZm9ybWVkaXQucGhw&ppid='+obj['data'][i].UUID+'"><span class="material-icons" style="font-size:1.5rem; color:black;" title="Edit '+module + ' '+obj['data'][i].offer_name+'">edit</span></a>';

                        // Remove 
                        html += '<a href="javascript:void(0)" onclick="handleRemove(\''+obj['data'][i].UUID+'\',\''+obj['data'][i].status_percent+'\')"><span class="material-icons" style="font-size:1.5rem; color:black;" title="Remove '+module + ' '+obj['data'][i].offer_name+'">delete</span></a>';

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
                html = '<tr><td colspan="8"><div style="margin-left:45%; margin-right:45%;" class="spinner-border text-center" role="status">';
                //html += '<span class="sr-only">Loading...</span>';
                html += '<span class="sr-only">0 results</span>';
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

/*****************************************************************
 * Changing elements in the message
 *************************/
function changeMessageLanguage(language,xname){
    document.getElementById('bodyText').innerHTML = invite_body[language].replace('%personal_url_to_register_href%',xlink).replace('%user_fullname%',xname);
    document.getElementById('bodytext-html').value = document.getElementById('bodyText').innerHTML;
}


/***************************************************************
 * Pages Controller
 **************************/
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

function handleRemoveProductFromProposal(proposalproduct_id){
    authApi     = csrf_token;
    filters     = '&pppid='+proposalproduct_id;
    
    locat       = window.location.hostname;
    if(locat.slice(-1) != '/')
        locat += '/';

    const requestURL = window.location.protocol+'//'+locat+'api/proposals/auth_proposalxproduct_remove.php?auth_api='+authApi+filters;
    //alert(requestURL);
    const request = new XMLHttpRequest();
    request.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            // Typical action to be performed when the document is ready:
            //console.log(request.responseText);
            obj = JSON.parse(request.responseText);
            if(obj.response == 'OK'){
                product_line = document.getElementById('product-'+proposalproduct_id+'-row');
                product_line.innerHTML='';
            }
        }
    };
    request.open('GET', requestURL);
    //request.responseType = 'json';
    request.send();
 
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

function calcAmountTotal(form,index,specialid){
    currency    = document.getElementsByName('currency');
    xcurrency   = currency[0].value;
    var formatter = new Intl.NumberFormat(lang, {
        //style: 'currency',
        //currency: xcurrency,
        //maximumSignificantDigits: 3,

        // These options are needed to round to whole numbers if that's what you want.
        //minimumFractionDigits: 2, // (this suffices for whole numbers, but will print 2500.10 as $2,500.1)
        //maximumFractionDigits: 0, // (causes 2500.99 to be printed as $2,501)
    });
    //xproduction = 0;
    if(typeof(index)=='undefined'){
        index=0;
        IDPrice     = 'price';
        IDQuantity  = 'quantity';
        NAMEOoh     = 'oohprice[]';
        NAMEAmount  = 'amount[]';
    }else{
        IDPrice = 'price_'+index;
        IDQuantity  = 'quantity_'+index;
        NAMEOoh     = 'oohprice_'+index+'[]';
        NAMEAmount  = 'amount[]';
    }

    xprice      = 0;
    if(typeof(specialid)=='undefined'){
        price       = document.getElementById(IDPrice);

        xprice=0;
        if(price){
            xprice      = price.value;
        }
        //alert(price+ ' - ' +xprice+ ' - '+'price_'+index);
        quantity    = document.getElementById(IDQuantity);
        xquantity=1;
        if(quantity){
            xquantity   = quantity.value;
        }
    } else { 
        price      = document.getElementsByName(NAMEOoh);
        
        if(price){
            for(p=0;p < price.length;p++){
                if(price[p].value !== ''){
/*                    if(String(parseFloat(price[p].value)).length <= 3){
                        price[p].value += '00'; 
                    }*/
                    xprice  = parseInt(xprice) + parseInt(transformToInt(price[p].value));
                }
            }
            xprice = formatter.format(xprice);
        }

        xquantity=1; 
/*        production  = document.getElementsByName('oohproduction_price_'+index+'[]');
        if(production){
            for(pr=0;pr < production.length;pr++){
                if(production[pr].value !== ''){
                    xproduction = parseInt(xproduction) + parseInt(transformToInt(production[pr].value));
                }                
               // alert(production[pr].value + '\n'+ String(parseFloat(production[pr].value)).length + '\n' + String(xproduction).length+ '\n' + String(xproduction));
            }
            xproduction = formatter.format(xproduction);
    
        }*/
        //alert(xproduction);
    }

    if(xprice > '0' && xquantity > '0'){
        if((xprice.charAt(xprice.length - 4) == thousands) || (xprice.length <= 3)){
            xprice += cents+'00';
        }
        arrayValue  = xprice.split(cents);
        xprice      = arrayValue[0] + cents + (arrayValue[1]+'00').substring(0,2);

/*        if(xproduction > 0){
            if((xproduction.charAt(xproduction.length - 4) == thousands) || (xproduction.length <= 3)){
                xproduction += cents+'00';
            }
    
            arrayProd   = xproduction.split(cents);
            xproduction = arrayProd[0] + cents + (arrayProd[1]+'00').substring(0,2);
        }*/


    
        amount = document.getElementsByName(NAMEAmount);
        formattedAmount = formatter.format(parseFloat( ((transformToInt(xprice)) * parseInt(xquantity))));
        if((formattedAmount.charAt(formattedAmount.length - 4) == thousands) || (formattedAmount.length <= 3)){
            formattedAmount += cents+'00';
        }
        arrayValue = formattedAmount.split(cents);
        formattedAmount = arrayValue[0] + cents + (arrayValue[1]+'00').substring(0,2);

        //alert("price: "+xprice+"\nquantity: "+xquantity+'\nFormattedAmount: '+formattedAmount+'\nIndex: '+index);
        amount[index].value   = formattedAmount;
        //alert("price: "+xprice+"\nquantity: "+xquantity+'\nFormattedAmount: '+formattedAmount+'\nLocal Amount: '+amount[index].value);
        total = 0;
        for(i=0;i < amount.length; i++){
            xaAmount        = amount[i].value.split(" ");
            if(xaAmount.length <= 1){
                xaAmount        = amount[i].value.split("$");
                if(xaAmount.length <= 1){
                    aAmountValue1   = xaAmount[0];
                }else{
                    aAmountValue1   = xaAmount[1];
                }
            }
            //aAmountValue1   = xaAmount[1];
            //alert("value: "+ amount[i].value + "\n\nxaAmount: " + xaAmount + "\n0: " + xaAmount[0] + "\n1: " + xaAmount[1])
            axAmountS       = aAmountValue1.split(thousands);
            xVAmount        = '';
            for(j=0;j < axAmountS.length; j++){
                xVAmount        += axAmountS[j];
            }
            axAmountFinal   = xVAmount.split(cents);
            xVAmountFinal   = '';
            for(k=0;k < axAmountFinal.length; k++){
                xVAmountFinal    += axAmountFinal[k];
            }
            realAmount  = (parseInt(xVAmountFinal) * 1) / 100;
            total = (parseFloat(total) * 1)+ (parseFloat(realAmount) * 1);
            //alert(total);
        }
        formattedTotal = formatter.format(total);
        if((formattedTotal.charAt(formattedTotal.length - 4) == thousands) || (formattedTotal.length <= 3)){
            formattedTotal += cents+'00';
        }
        arrayValue = formattedTotal.split(cents);
        formattedTotal = arrayValue[0] + cents + (arrayValue[1]+'00').substring(0,2);

        form.total.value = formattedTotal;
    }
}

function transformToInt(value){
    finalValue = 0;
    if(value > '0')
    {
        arrayValue = value.split(thousands);
        lenArrayValue = arrayValue.length;
        stringValue = '';
        for(i = 0;i < lenArrayValue; i++){
            stringValue += arrayValue[i];
        }
    
        arrayValue = stringValue.split(cents);
        lenArrayValue = arrayValue.length;
        stringValue = '';
        if(lenArrayValue > 0){
            for(j = 0;j < lenArrayValue; j++){
                stringValue = arrayValue[0] + ((arrayValue[1]+'00').substring(0,2));
            }
                finalValue = parseInt(stringValue) / 100;
        } else {
            finalValue = arrayValue[0]+ '00';
        }
    }
    return finalValue;
}

function newProductForm(copy,destination,items){
    start_index++;
    document.getElementById(destination).innerHTML += (document.getElementById(copy).innerHTML.replace('proposal,0','proposal,'+start_index).replace('proposal,0','proposal,'+start_index).replace('product_0','product_'+start_index).replace('state_0','state_'+start_index).replace('price_0','price_'+start_index).replace('amount_0','amount_'+start_index).replace('DropdownMenuButton_0','DropdownMenuButton_'+start_index).replace(",'0');",",'"+start_index+"');").replace('div-selectcolony_0','div-selectcolony_'+start_index).replace('div-selectcounty_0','div-selectcounty_'+start_index).replace('div-selectcity_0','div-selectcity_'+start_index).replace('notes_0','notes_'+start_index).replace('div-selectState_0','div-selectState_'+start_index).replace('div-datetype-option_0','div-datetype-option_'+start_index));

    for(iteration=0; iteration <= items; iteration++){
        document.getElementById(destination).innerHTML = document.getElementById(destination).innerHTML.replace('Value_0','Value_'+start_index).replace('Name_0','Name_'+start_index).replace('Id_0','Id_'+start_index).replace('DropdownMenuButton_0','DropdownMenuButton_'+start_index).replace(",'0');",",'"+start_index+"');").replace('product_0','product_'+start_index).replace('salemodel_0','salemodel_'+start_index).replace('provider_0','provider_'+start_index).replace('oohproviders_0','oohproviders_'+start_index).replace('oohkeys_0','oohkeys_'+start_index).replace('oohsalemodels_0','oohsalemodels_'+start_index).replace('oohcost_0','oohcost_'+start_index).replace('oohprice_0','oohprice_'+start_index).replace('oohstate_0','oohstate_'+start_index).replace('oohcolony_0','oohcolony_'+start_index).replace('oohcity_0','oohcity_'+start_index).replace('oohcounty_0','oohcounty_'+start_index).replace('div-quantity_0','div-quantity_'+start_index).replace('div-price_0','div-price_'+start_index).replace('quantity_0','quantity_'+start_index).replace('price_0','price_'+start_index).replace('cost_0','cost_'+start_index).replace('digital_product-0','digital_product-'+start_index).replace('datetype-option-0','datetype-option-'+start_index).replace('digital_product-0','digital_product-'+start_index).replace('datetype-option-0','datetype-option-'+start_index).replace('start_date_product_0','start_date_product_'+start_index).replace('start_date_product_0','start_date_product_'+start_index).replace('start_date_product_0','start_date_product_'+start_index).replace('stop_date_product_0','stop_date_product_'+start_index).replace('stop_date_product_0','stop_date_product_'+start_index).replace('stop_date_product_0','stop_date_product_'+start_index).replace('ooh-list-form-0','ooh-list-form-'+start_index).replace('div-stopDate-product-0','div-stopDate-product-'+start_index).replace('div-startDate-product-0','div-startDate-product-'+start_index).replace('datetype_option-0','datetype_option-'+start_index).replace('notes_0','notes_'+start_index).replace('datetype_option-0','datetype_option-'+start_index);
    }
    htmlRemoveButton = '<div class="form-row" id="btnRemove_'+start_index+'" >';
    htmlRemoveButton += '<div class="col" style="text-align:right;">';
    htmlRemoveButton += '<button class="btn-danger material-icons-outlined" type="button" onclick="removeProductForm('+start_index+');">remove_circle_outline</button>';
    htmlRemoveButton += '</div>';
    htmlRemoveButton += '</div>';

    if(document.getElementById('ooh-list-form-'+start_index)!=null){
        document.getElementById('ooh-list-form-'+start_index).innerHTML="";
    }

    d_start.push(0);
    d_stop.push(0);

    document.getElementById(destination).innerHTML += htmlRemoveButton;

    if(document.getElementById('digital_product-'+start_index) != null){
        document.getElementById('digital_product-'+start_index).value = document.getElementById('digital_product-0').value;
    }
    if(document.getElementById('datetype_option-'+start_index) != null){
        document.getElementById('datetype_option-'+start_index).value = document.getElementById('datetype_option-0').value;
    }
    

    /**************************************************************************
     * Checking options
     ************************************************************************/
    for(opt_number=0;opt_number <= start_index;opt_number++){
        if(document.getElementById('digital_product-'+start_index) != null){
            document.getElementById('digital_product-'+opt_number).checked = false;
            if(document.getElementById('digital_product-'+opt_number).value == '1'){
                document.getElementById('digital_product-'+opt_number).checked = true;
            } 
        }        
        if(document.getElementById('datetype_option-'+start_index) != null){
            document.getElementById('datetype_option-'+opt_number).checked = false;
            if(document.getElementById('datetype_option-'+opt_number).value == '1'){
                document.getElementById('datetype_option-'+opt_number).checked = true;
            }
        }
    }
    
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

function addProductWhithoutAmounts(start_date,stop_date,product_id,currency,proposal_id,state,city,county,colony,notes){
    errors      = 0;
    authApi     = csrf_token;
    locat       = window.location.hostname;

    querystring = 'auth_api='+authApi+"&start_date="+start_date+"&stop_date="+stop_date+"&product_id="+product_id+"&currency="+currency+"&proposal_id="+proposal_id+"&state="+state+"&city="+city+"&county="+county+"&colony="+colony+"&notes="+notes;

    if(locat.slice(-1) != '/')
        locat += '/';

    if(errors > 0){

    } else{
        const requestURLAdd = window.location.protocol+'//'+locat+'api/products/auth_product_add_new.php';
        console.log('\naddProduct: ' + requestURLAdd+'?'+querystring);
        const requestAdd = new XMLHttpRequest();
        requestAdd.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                
                obj = JSON.parse(requestAdd.responseText);
                pppid = 0;
                if(obj.status == 'OK'){
                }
            }
            else{
            }
        };
        requestAdd.open('POST', requestURLAdd, false);
        requestAdd.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        //request.responseType = 'json';
        requestAdd.send(querystring);
    }
}

function addProduct(start_date,stop_date,product_id,salemodel_id,cost,price,currency,quantity,provider_id,proposal_id,state,city,county,colony,billboard_id){
    errors      = 0;
    authApi     = csrf_token;
    locat       = window.location.hostname;

    querystring = 'auth_api='+authApi+"&start_date="+start_date+"&stop_date="+stop_date+"&product_id="+product_id+"&salemodel_id="+salemodel_id+"&billboard_id="+billboard_id+"&cost="+cost+"&price="+price+"&currency="+currency+"&quantity="+quantity+"&provider_id="+provider_id+"&proposal_id="+proposal_id+"&state="+state+"&city="+city+"&county="+county+"&colony="+colony;

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
                pppid = 0;
                if(obj.status == 'OK'){
                    /*
                    pppid           = obj.pppid;
                    provider_id     = provider_id.replace('[','').replace(']','');
                    billboard       = billboard_id.replace('[','').replace(']','');
                    price           = price.replace('[','').replace(']','');

                    arrayBillboard  = billboard.split(',');
                    arrayProvider   = provider_id.split(',');
                    arrayPrice      = price.split(',');

                    for(pk=0;pk < arrayBillboard.length; pk++){
                        bb_billboard_id = arrayBillboard[pk];
                        bb_provider_id  = arrayProvider[pk];
                        bb_price        = arrayPrice[pk];
                        //if(bb_billboard_id != '0')
                            //addBillboardOnList(bb_billboard_id, pppid,bb_price,bb_provider_id);
                    }*/
                }
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

function addBillboardOnList(billboard_id, proposalproduct_id,price,provider_id){
    if (billboard_id !== '' && proposalproduct_id !== '' && price !== '') {
    
        errors      = 0;
        authApi     = csrf_token;
        message     = '';

        locat       = window.location.hostname;
        if(locat.slice(-1) != '/')
            locat += '/';

        querystring = 'auth_api='+authApi+'&bid='+billboard_id+'&pppid='+proposalproduct_id+'&pc='+price+'&pid='+provider_id;

        if(errors > 0){
            alert(message);
        } else {
            const requestURL = window.location.protocol+'//'+locat+'api/billboards/auth_billboard_add_to_proposal.php';
            //console.log(requestURL);
            const request = new XMLHttpRequest();
            request.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                   // Typical action to be performed when the document is ready:
                   obj = JSON.parse(request.responseText);
                   if(obj.response == 'OK'){
                        // add number of selected billboards to cart
                   }
                }
                else{
                    //form.btnSave.innerHTML = "Saving...";
                }
            };
            request.open('POST', requestURL, false);
            //request.responseType = 'json';
            request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            request.send(querystring);
        }
    } else
        alert('Please, fill all required fields (*)');
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
                getMainExecutive(aid);
                //form.btnSave.innerHTML = "Searching...";
            }
        };
        request.open('GET', requestURL);
        //request.responseType = 'json';
        request.send();
    } 
}

function getMainExecutive(aid){
    errors      = 0;
    authApi     = csrf_token;
    locat       = window.location.hostname;
    submodule   = 'advertiser';

    if(locat.slice(-1) != '/')
        locat += '/';

    filters     = '&aid='+aid;

    if(errors > 0){

    } else{
        selectInput   = document.getElementById('selectexecutive');
        const requestURL = window.location.protocol+'//'+locat+'api/'+submodule+'s/auth_'+submodule+'_get.php?auth_api='+authApi+filters;
        //console.log('ln 2008 (executive): '+requestURL);
        const request = new XMLHttpRequest();
        request.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                // Typical action to be performed when the document is ready:
                obj = JSON.parse(request.responseText);
                if( (obj.response != 'error') || (obj.response != 'ZERO_RETURN')){
                    if(obj.data[0].executive_id != null)
                        selectInput.value = obj.data[0].executive_id;
                    else
                        selectInput.value = 0;
                }
            }
        };
        request.open('GET', requestURL);
        //request.responseType = 'json';
        request.send();
    } 
}

function remakeDateField(typeInt,indexValue){
    typeInt++;
    if(typeInt > 1)
        typeInt = 0;
    document.getElementById('datetype_option-'+indexValue).value = typeInt;

    
    if(typeInt == 1){
        document.getElementById('div-stopDate-product-'+indexValue).style   ='display:none;';
        document.getElementById('stop_date_product_'+indexValue).value     = '';
        document.getElementById('label-start_date_product_'+indexValue).innerText = ucfirst(translateText('event_date',localStorage.getItem('ulang')));
    } else {
        document.getElementById('div-stopDate-product-'+indexValue).style   ='display:block;';
        d_stop[indexValue] = 0;
        document.getElementById('label-start_date_product_'+indexValue).innerText = translateText('start_date',localStorage.getItem('ulang'));
    }

}

function refilterProductsType(typeInt,indexValue,valueOpt){
    typeInt++;
    if(typeInt > 1)
        typeInt = 0;
    if(typeof(indexValue) != 'undefined'){
        idCheckName             = 'digital_product-'+indexValue;
        idDivSelecProductName   = 'div-selectproduct_'+indexValue;
        idFieldProduct          = 'selectproduct_'+indexValue;
        fieldProductName        = 'product_id[]';
        takeINDEX               = 'this.id.split(\'_\')[1]';
    } else {
        idCheckName             = 'digital_product';
        idDivSelecProductName   = 'div-selectproduct';
        idFieldProduct          = 'selectproduct';
        fieldProductName        = 'product_id';
        takeINDEX               = null;
    }
    if(document.getElementById(idCheckName) != null){
        document.getElementById(idCheckName).value = typeInt;
    }
    
    
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
        if(document.getElementById(idDivSelecProductName) != null){
            productList   = document.getElementById(idDivSelecProductName);
            const requestURL = window.location.protocol+'//'+locat+'api/'+submodule+'s/auth_'+submodule+'_list.php?auth_api='+authApi+filters;
            //console.log(requestURL);
            const request = new XMLHttpRequest();
            request.onreadystatechange = function() {
                html    = '<label for="'+fieldProductName+'">'+ucfirst(translateText('product',localStorage.getItem('ulang')))+'</label>';
                html   += '<spam id="sproduct">';
                if(typeof(valueOpt)!=='undefined'){
                    html   += '<SELECT id="'+idFieldProduct+'" name="'+fieldProductName+'" onchange="refilterSaleModel(document.getElementById(\''+idCheckName+'\').value,this.value,'+takeINDEX+'); checkOOHSelection(this[this.selectedIndex].innerText,'+takeINDEX+');" title="product_id" class="form-control" autocomplete="product_id"  required>';
                }else{
                    html   += '<SELECT id="'+idFieldProduct+'" name="'+fieldProductName+'" title="product_id" class="form-control" autocomplete="product_id"  required>';
                }
                if (this.readyState == 4 && this.status == 200) {
                    // Typical action to be performed when the document is ready:
                    obj = JSON.parse(request.responseText);
                    if( (obj.response != 'error') && (obj.response != 'ZERO_RETURN')){
                        html += '<OPTION value="0"/>'+translateText('please_select',localStorage.getItem('ulang'))+' '+ucfirst(translateText('product',localStorage.getItem('ulang')));
                        for(var i=0;i < obj.length; i++){
                            checkedOption= '';
                            if(valueOpt == obj[i].uuid_full)
                                checkedOption = 'selected';
                            /*if(obj[i].name == 'OOH'){
                                html += '<option value="'+obj[i].uuid_full+'" >'+obj[i].name+' ('+translateText('no_keys',localStorage.getItem('ulang'))+')</option>';
                            }*/
                            html += '<OPTION value="'+obj[i].uuid_full+'" '+checkedOption+'/>'+obj[i].name;
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
    }
    //refilterSaleModel(typeInt);
}


function refilterSaleModel(typeInt,productCode,indexValue,valueOpt){
    errors      = 0;
    authApi     = csrf_token;
    locat       = window.location.hostname;
    submodule   = 'salemodel';
    //alert(productCode);

    //if((typeof(indexValue) != 'undefined') || (typeof(indexValue) != null)){
        DIVSelectSalemodel      = "div-selectsalemodel_"+indexValue;
        DIVOohKeys              = "div-oohkeys_"+indexValue;
        OohListForm             = "ooh-list-form-"+indexValue;
        DIVProvider             = "div-provider_"+indexValue;
        DIVCost                 = "div-cost_"+indexValue;
        DIVPrice                = "div-price_"+indexValue;
        DIVQuantity             = "div-quantity_"+indexValue;
        FieldNameSaleModel      = 'salemodel_id[]';
        FieldIDSaleModel        = 'selectsalemodel_'+indexValue;
    /*} else {
        DIVSelectSalemodel      = "div-selectsalemodel";
        DIVOohKeys              = "div-oohkeys";
        OohListForm             = "ooh-list-form";
        DIVProvider             = "div-provider";
        DIVCost                 = "div-cost";
        DIVPrice                = "div-price";
        DIVQuantity             = "div-quantity";
        FieldNameSaleModel      = 'salemodel_id';
        FieldIDSaleModel        = 'selectsalemodel';
    }*/
    
    salemodelElement = document.getElementById(DIVSelectSalemodel);
    if(salemodelElement){
        if(document.getElementById(DIVSelectSalemodel).style.display === "none"){
            document.getElementById(DIVOohKeys).style.display = 'none';
            oohlist = document.getElementById(OohListForm);
            if(oohlist)
                oohlist.innerHTML = '';
            document.getElementById(DIVProvider).style.display = 'block';
            document.getElementById(DIVSelectSalemodel).style.display = 'block';
            document.getElementById(DIVCost).style.display = 'block';
            document.getElementById(DIVPrice).style.display = 'block';
            document.getElementById(DIVQuantity).style.display = 'block';
        }    
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

    } else {
        salemodelList   = document.getElementById(DIVSelectSalemodel);
        
        if(salemodelList){
            const requestURL = window.location.protocol+'//'+locat+'api/'+submodule+'s/auth_'+submodule+'_view.php?auth_api='+authApi+filters;
            console.log(requestURL);
            const request = new XMLHttpRequest();
            request.onreadystatechange = function() {
                html    = '<label for="'+FieldNameSaleModel+'">' + ucfirst(translateText('sale_model',localStorage.getItem('ulang'))) + '</label>';
                html   += '<spam id="ssalemodel">'
                html   += '<SELECT id="'+FieldIDSaleModel+'"  name="'+FieldNameSaleModel+'" title="salemodel_id" class="form-control" autocomplete="salemodel_id" required>';
                if (this.readyState == 4 && this.status == 200) {
                    // Typical action to be performed when the document is ready:
                    obj = JSON.parse(request.responseText);
                    if( (obj.response != 'error') && (obj.response != 'ZERO_RETURN')){
                        html += '<OPTION value="0"/>' + translateText('please_select',localStorage.getItem('ulang')) + ' ' + ucfirst(translateText('sale_model',localStorage.getItem('ulang'))) + '';
                        for(var i=0;i < obj['data'].length; i++){
                            checkedOption= '';
                            if(valueOpt == obj['data'][i].uuid_full)
                                checkedOption = 'selected';
                                html += '<OPTION value="'+obj['data'][i].uuid_full+'" '+checkedOption+'/>'+obj['data'][i].name;
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
}


function checkOOHSelection(stringValue,indexValue){
    xhtml = "";
    if(stringValue == "OOH"){
        xhtml += '<label for="oohkeys[]">'+ucfirst(translateText('key',localStorage.getItem('ulang')))+ '(s) - '+stringValue+'</label><br/>';
        xhtml += '<TEXTAREA id="oohkeys_'+indexValue+'" name="oohkeys[]" rows="5" placeholder="'+ucfirst(translateText('key',localStorage.getItem('ulang')))+ '(s) - '+stringValue+'" class="form-control" id="oohkeys_0" onblur="getBillboardIds(this.value,'+indexValue+'); "></TEXTAREA>';
        /*
        xhtml += '<INPUT type="HIDDEN" id="ids-oohkeys_'+indexValue+'" name="ids_oohkeys[]"/>';
        xhtml += '<INPUT type="HIDDEN" id="ids-oohproviders_'+indexValue+'" name="ids_oohproviders[]"/>';
        xhtml += '<INPUT type="HIDDEN" id="ids-oohsalemodels_'+indexValue+'" name="ids_oohsalemodels[]"/>';
        xhtml += '<INPUT type="HIDDEN" id="oohcost_'+indexValue+'" name="oohcost[]"/>';
        xhtml += '<INPUT type="HIDDEN" id="oohstate_'+indexValue+'" name="oohstate[]"/>';
        xhtml += '<INPUT type="HIDDEN" id="oohcity_'+indexValue+'" name="oohcity[]"/>';
        xhtml += '<INPUT type="HIDDEN" id="oohcounty_'+indexValue+'" name="oohcounty[]"/>';*/
        if(document.getElementById("div-oohkeys_"+indexValue).style.display === "none"){
            document.getElementById("div-selectsalemodel_"+indexValue).style.display = 'none';
            document.getElementById("div-provider_"+indexValue).style.display = 'none';
            document.getElementById("div-cost_"+indexValue).style.display = 'none';
            document.getElementById("div-price_"+indexValue).style.display = 'none';
            document.getElementById("div-quantity_"+indexValue).style.display = 'none';
            document.getElementById("div-oohkeys_"+indexValue).style.display = 'block';
            oohlist = document.getElementById("ooh-list-form-"+indexValue);
            if(oohlist)
                oohlist.style.display = 'block';

        }
    }
    document.getElementById("div-oohkeys_"+indexValue).innerHTML = xhtml;
}
/*<select name="product_id[]" id="selectproduct_0" title="product_id" class="form-control" autocomplete="product_id" onchange="refilterSaleModel(document.getElementById('digital_product-'+indexValue).value,this.value,this.id.split('_')[1]); checkOOHSelection(this[this.selectedIndex].innerText,this.id.split('_')[1])" required="" data-gtm-form-interact-field-id="0">
<select name="product_id[]" id="selectproduct_0" title="product_id" class="form-control" autocomplete="product_id" onchange="document.getElementById('digital_product-'+indexValue).value,this.value,this.id.split('_')[1]); checkOOHSelection(this[this.selectedIndex].innerText,this.id.split('_')[1]);" required="">
*/

function getBillboardIds(oohlist,indexValue){
    // reseting objGlobal
    objGlobal   = '';
    aOOHlist    = oohlist.split(",");
    xoohlist    = '';

    var formatter = new Intl.NumberFormat(lang, {
        //style: 'currency',
        //currency: xcurrency,
        //maximumSignificantDigits: 2,

        // These options are needed to round to whole numbers if that's what you want.
        //minimumFractionDigits: 2, // (this suffices for whole numbers, but will print 2500.10 as $2,500.1)
        //maximumFractionDigits: 0, // (causes 2500.99 to be printed as $2,501)
    });

    tableDivID  = document.getElementById('ooh-list-form-'+indexValue);
    // removing all table if exists
    if(tableDivID){
        tableDivID.remove();
    }
    tableDiv    = document.createElement('table');
    tableDiv.classList.add('table');
    tableDiv.classList.add('table-hover');
    tableDiv.classList.add('table-sm');
    tableDiv.setAttribute('id','ooh-list-form-'+indexValue);
    document.getElementById('div-oohkeys_'+indexValue).parentElement.after(tableDiv);
    captionDiv  = document.createElement('caption');
    captionText = document.createTextNode("Listado de Medios - OOH");
    tableDiv.appendChild(captionDiv);
    captionDiv.appendChild(captionText);

    newThead    = document.createElement('thead');
    tableDiv.appendChild(newThead);
    newRow      = document.createElement('tr');
    newThead.appendChild(newRow);

    // key
    newHeadCol      = document.createElement('th');
    newHeadCol.setAttribute('scope','col');
    keyText         = document.createTextNode(translateText('key',localStorage.getItem('ulang')));
    newRow.appendChild(newHeadCol);
    newHeadCol.appendChild(keyText);

    // provider
    newHeadCol      = document.createElement('th');
    newHeadCol.setAttribute('scope','col');
    priceText       = document.createTextNode(translateText('provider',localStorage.getItem('ulang')));
    newRow.appendChild(newHeadCol);
    newHeadCol.appendChild(priceText);

    // salemodel
    newHeadCol      = document.createElement('th');
    newHeadCol.setAttribute('scope','col');
    salemodelText   = document.createTextNode(translateText('sale_model',localStorage.getItem('ulang')));
    newRow.appendChild(newHeadCol);
    newHeadCol.appendChild(salemodelText);

    // cost
    newHeadCol      = document.createElement('th');
    newHeadCol.setAttribute('scope','col');
    costText        = document.createTextNode(translateText('cost',localStorage.getItem('ulang')));
    newRow.appendChild(newHeadCol);
    newHeadCol.appendChild(costText);

    // price
    newHeadCol      = document.createElement('th');
    newHeadCol.setAttribute('scope','col');
    priceText       = document.createTextNode(translateText('price',localStorage.getItem('ulang')));
    newRow.appendChild(newHeadCol);
    newHeadCol.appendChild(priceText);

    // production 
/*    newHeadCol      = document.createElement('th');
    newHeadCol.setAttribute('scope','col');
    productionText  = document.createTextNode(translateText('production',localStorage.getItem('ulang')));
    newRow.appendChild(newHeadCol);
    newHeadCol.appendChild(productionText); */

    // locale
    newHeadCol      = document.createElement('th');
    newHeadCol.setAttribute('scope','col');
    stateText       = document.createTextNode(translateText('state',localStorage.getItem('ulang'))+ ' - ' +translateText('city',localStorage.getItem('ulang'))+ ' - ' +translateText('county',localStorage.getItem('ulang')));
    newRow.appendChild(newHeadCol);
    newHeadCol.appendChild(stateText);

    newTbody    = document.createElement('tbody');
    newThead.after(newTbody);

    for(l=0;l<aOOHlist.length;l++){
        if(l>0){
            xoohlist += '\n';
        }
        xoohlist += aOOHlist[l];
    }
    rows = xoohlist.split("\n");
    billboard_id    = '';
    bb_provider_id  = '';
    bb_salemodel_id = '';
    cost_int        = '';
    price_int       = '';
    state           = '';
    city            = '';
    county          = '';
    colony          = '';
    totalPrice      = 0;

    for(r=0;r < rows.length;r++){
    // busca na tabela billboards: billboard_id (id), bb_provider_id (provider_id), bb_salemodel_id (salemodel_id), cost_int, price_int, state, city, county
        if(rows[r].trim() != ''){
            getIdFromTable('billboard','uuid as id,name,provider_id,provider_name,salemodel_id,salemodel_name,cost_int,price_int,state,city,county,colony','name|||'+rows[r].trim());
            if(objGlobal.response=='ERROR'){
                alert(rows[r].trim() + ' no encontrado. No es posible añadir en la lista de OOHs');
            } else {
                if(r > 0){
                    billboard_id    += ',';
                    bb_provider_id  += ',';
                    bb_salemodel_id += ',';
                    cost_int        += ',';
                    price_int       += ',';
                    state           += ',';
                    city            += ',';
                    county          += ',';
                    colony          += ',';
                }
                billboard_id    += objGlobal.data[0].id;
                bb_provider_id  += objGlobal.data[0].provider_id;
                bb_salemodel_id += objGlobal.data[0].salemodel_id;
                cost_int        += objGlobal.data[0].cost_int;
                price_int       += objGlobal.data[0].price_int;
                state           += objGlobal.data[0].state;
                city            += objGlobal.data[0].city;
                county          += objGlobal.data[0].county;
                colony          += objGlobal.data[0].colony;
    
                newRow          = document.createElement('tr');
                newTbody.appendChild(newRow);
    
                // key
                newCol          = document.createElement('td');
                keyText         = document.createTextNode(objGlobal.data[0].name);
                newRow.appendChild(newCol);
                newCol.appendChild(keyText);
    
                // provider
                newCol          = document.createElement('td');
                providerText   = document.createTextNode(objGlobal.data[0].provider_name);
                newRow.appendChild(newCol);
                newCol.appendChild(providerText);
    
                // salemodel
                newCol          = document.createElement('td');
                salemodelText   = document.createTextNode(objGlobal.data[0].salemodel_name);
                newRow.appendChild(newCol);
                newCol.appendChild(salemodelText);
    
                // cost
                newCol          = document.createElement('td');
                newInput        = document.createElement('input');
                costValue       = formatter.format((parseInt(objGlobal.data[0].cost_int)/100));
                // including ,00 when don´t having it on the value
                if((costValue.charAt(costValue.length - 4) == thousands) || (costValue.length <= 3)){
                    costValue += cents+'00';
                }
                newInput.classList.add('form-control');
                newInput.setAttribute('id','cost-'+indexValue+'-'+objGlobal.data[0].id);
                newInput.setAttribute('name','oohCost[]');
                newInput.setAttribute('type','currency');
                newInput.setAttribute('maxlength','20');
                newInput.setAttribute('autocomplete','cost');
                newInput.setAttribute('placeholder','999,99');
                newInput.setAttribute('value',costValue);
                newInput.setAttribute('title',translateText('cost',localStorage.getItem('ulang')));
                newInput.setAttribute('onkeypress',"$(this).mask('#"+thousands+"###"+thousands+"##0"+cents+"00', {reverse: true});");
                newRow.appendChild(newCol);
                newCol.appendChild(newInput);
    
                // price
                newCol          = document.createElement('td');
                newInput        = document.createElement('input');
                priceValue      = formatter.format((parseInt(objGlobal.data[0].price_int)/100));
                // including ,00 when don´t having it on the value
                if((priceValue.charAt(priceValue.length - 4) == thousands) || (priceValue.length <= 3)){
                    priceValue += cents+'00';
                }
                newInput.classList.add('form-control');
                newInput.setAttribute('id','price-'+indexValue+'-'+objGlobal.data[0].id);
                newInput.setAttribute('name','oohprice_'+indexValue+'[]');
                newInput.setAttribute('type','currency');
                newInput.setAttribute('maxlength','20');
                newInput.setAttribute('autocomplete','price');
                newInput.setAttribute('placeholder','999,99');
                newInput.setAttribute('value',priceValue);
                newInput.setAttribute('title',translateText('unit_price',localStorage.getItem('ulang')));
                newInput.setAttribute('onkeypress',"$(this).mask('#"+thousands+"###"+thousands+"##0"+cents+"00', {reverse: true});");
                newInput.setAttribute('onblur',"calcAmountTotal(proposal,"+indexValue+",'"+objGlobal.data[0].id+"')");
                newRow.appendChild(newCol);
                newCol.appendChild(newInput);
    
                // impression / production
    /*            newCol          = document.createElement('td');
                newInput        = document.createElement('input');
                newInput.classList.add('form-control');
                newInput.setAttribute('id','production-price-'+indexValue+'-'+objGlobal.data[0].id);
                newInput.setAttribute('name','oohproduction_price_'+indexValue+'[]');
                newInput.setAttribute('type','currency');
                newInput.setAttribute('maxlength','20');
                newInput.setAttribute('autocomplete','production-price');
                newInput.setAttribute('placeholder','9'+thousands+'999'+cents+'99');
                newInput.setAttribute('title',translateText('production',localStorage.getItem('ulang')));
                newInput.setAttribute('onkeypress',"$(this).mask('#"+thousands+"###"+thousands+"##0"+cents+"00', {reverse: true});");
                newInput.setAttribute('onblur',"calcAmountTotal(proposal,"+indexValue+",'"+objGlobal.data[0].id+"')");
                newRow.appendChild(newCol);
                newCol.appendChild(newInput); */
    
                // locale
                newCol          = document.createElement('td');
                stateText       = document.createTextNode(objGlobal.data[0].state + ' - ' + objGlobal.data[0].city + ' - ' + objGlobal.data[0].county);
                newRow.appendChild(newCol);
                newCol.appendChild(stateText);
    
                //total Price
                totalPrice += parseInt(objGlobal.data[0].price_int)/100;
    
                /********************************** 
                 * HIDDEN INPUT AREA  
                 ******************************** */ 
    
                // billboard_id
                newCol          = document.createElement('td');
                newInput        = document.createElement('input');
                newInput.setAttribute('name','oohbillboard_id[]');
                newInput.setAttribute('type','hidden');
                newInput.setAttribute('value',objGlobal.data[0].id);
                newRow.appendChild(newCol);
                newCol.appendChild(newInput);
    
                // salemodel_id
                newInput        = document.createElement('input');
                newInput.setAttribute('name','oohsalemodel_id[]');
                newInput.setAttribute('type','hidden');
                newInput.setAttribute('value',objGlobal.data[0].salemodel_id);
                newRow.appendChild(newCol);
                newCol.appendChild(newInput);
    
                // provider_id
                newInput        = document.createElement('input');
                newInput.setAttribute('name','oohprovider_id[]');
                newInput.setAttribute('type','hidden');
                newInput.setAttribute('value',objGlobal.data[0].provider_id);
                newRow.appendChild(newCol);
                newCol.appendChild(newInput);
    
                // state
                newInput        = document.createElement('input');
                newInput.setAttribute('name','oohstate[]');
                newInput.setAttribute('type','hidden');
                newInput.setAttribute('value',objGlobal.data[0].state);
                newRow.appendChild(newCol);
                newCol.appendChild(newInput);
    
                // city
                newInput        = document.createElement('input');
                newInput.setAttribute('name','oohcity[]');
                newInput.setAttribute('type','hidden');
                newInput.setAttribute('value',objGlobal.data[0].city);
                newRow.appendChild(newCol);
                newCol.appendChild(newInput);
    
                // county
                newInput        = document.createElement('input');
                newInput.setAttribute('name','oohcounty[]');
                newInput.setAttribute('type','hidden');
                newInput.setAttribute('value',objGlobal.data[0].county);
                newRow.appendChild(newCol);
                newCol.appendChild(newInput);
    
                // colony
                newInput        = document.createElement('input');
                newInput.setAttribute('name','oohcolony[]');
                newInput.setAttribute('type','hidden');
                newInput.setAttribute('value',objGlobal.data[0].colony);
                newRow.appendChild(newCol);
                newCol.appendChild(newInput);
            }            
        }
    }
    totalPrice = formatter.format(totalPrice);
    if((totalPrice.charAt(totalPrice.length - 4) == thousands) || (totalPrice.length <= 3)){
        totalPrice += cents+'00';
    }
/*
    document.getElementById('ids-oohkeys_'+indexValue).value = billboard_id;
    document.getElementById('ids-oohproviders_'+indexValue).value = bb_provider_id;
    document.getElementById('ids-oohsalemodels_'+indexValue).value = bb_salemodel_id;
    document.getElementById('oohcost_'+indexValue).value = cost_int;
    document.getElementById('oohstate_'+indexValue).value = state;
    document.getElementById('oohcity_'+indexValue).value = city;
    document.getElementById('oohcounty_'+indexValue).value = county;*/
    document.getElementById('amount_'+indexValue).value = totalPrice;
    //calcAmountTotal(document.getElementsByName(module)[0]);
}

function getIdFromTable(table,bringColumns,searchValue){
    errors      = 0;
    authApi     = csrf_token;
    locat       = window.location.hostname;

    if(searchValue == 'name|||'){return false; } else {
        // filters     = '&tid='+tid;
        xfilters    = '';
        filters     = '';
        if(typeof(searchValue)!='undefined'){
            filters += "&where="+encodeURIComponent(searchValue);
        }

        cols = '';
        if(typeof(bringColumns) != 'undefined'){
            cols    = '&cln='+bringColumns;
        }

        if(locat.slice(-1) != '/')
            locat += '/';

        if(errors > 0){

        } else{
            const requestURLGet = window.location.protocol+'//'+locat+'api/'+table+'s/auth_'+table+'_get.php?auth_api='+authApi+filters+cols;
            //alert(requestURLGet);
            //console.log(requestURLGet);
            const requestGet = new XMLHttpRequest();
            requestGet.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    
                    objGlobal = JSON.parse(requestGet.responseText);
                    //alert(objGet.data[0].id);
                    //alert(getResponseText);
                    //proposal_id = objGet[0].UUID;
                    //callback(objGlobal);
                    //return objGET;
                }
                else{
                    //form.btnSave.innerHTML = "Searching...";
                }
            };
            requestGet.open('GET', requestURLGet,false);
            //request.responseType = 'json';
            requestGet.send();
        }
    } 
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

function changeDateForm(dateType,stringDate,proposalId){
    // getting user Locale setting
    const userLocale =
    navigator.languages && navigator.languages.length
      ? navigator.languages[0]
      : navigator.language; 

    // dateType: stop / start

    divDate     = document.getElementById(dateType+"-date");

    // cleaning DIV
    divDate.innerHTML = '';

    // showing INPUT
    newInput    = document.createElement('input');
    dateValue   = stringDate;

    // locales using day on the middle of the date
    localeMiddleDay = 'es-DO,es-HN,lv-LV,es-NI,es-PA,en-PH,es-PR,en-SG,es-SV,en-US,es-US';
    
    aDate       = dateValue.split('/');
    if(dateValue.search('-') >= 0 )
        aDate       = dateValue.split('-');
    if(aDate[0].length > 3){
        year        = aDate[0];
        month       = aDate[1];
        day         = aDate[2];
        if(localeMiddleDay.search(userLocale)  >= 0){
            month       = aDate[2];
            day         = aDate[1];    
        }
    }
      
    if(aDate[2].length > 3){
        year        = aDate[2];
        month       = aDate[1];
        day         = aDate[0];
        if(localeMiddleDay.search(userLocale) >= 0){
            month       = aDate[0];
            day         = aDate[1];                
        }
    }
    
    dateValue   = year+'-'+month+'-'+day;

    newInput.classList.add('form-control');
    newInput.setAttribute('id',dateType+'date');
    newInput.setAttribute('name',dateType+'date');
    newInput.setAttribute('type','date');
    newInput.setAttribute('maxlength','8');
    newInput.setAttribute('autocomplete',dateType+'-date');
    newInput.setAttribute('placeholder','31/10/2023');
    newInput.setAttribute('value',dateValue);
    newInput.setAttribute('title',translateText(dateType+'_date',localStorage.getItem('ulang')));
    newInput.setAttribute('onblur',"executeDatechange('"+dateType+"',this.value,'"+dateValue+"','"+proposalId+"')");
    divDate.appendChild(newInput);

    document.getElementById(dateType+'date').focus();

}

function executeDatechange(dateType,newDateValue,oldDateValue,proposalId){
    authApi     = csrf_token;

    // show date (changing or not)
    year   = newDateValue.substr(0,4);
    month  = newDateValue.substr(5,2);
    day    = newDateValue.substr(8,2);
    date   = new Date(parseInt(year),parseInt(month)-1,parseInt(day),0,0,0);

    html= '<a id="'+dateType+'-date-alink" title="'+translateText('change',localStorage.getItem('ulang')).charAt(0).toUpperCase() + translateText('change',localStorage.getItem('ulang')).slice(1) +' '+ translateText(dateType+'_date',localStorage.getItem('ulang'))+'" type="button" onClick="changeDateForm(\''+dateType+'\',document.getElementById(this.id).innerText,\''+proposalId+'\');">'+date.toLocaleDateString()+'</a>';

    document.getElementById(dateType+'-date').innerHTML    = html;

    ///////////////////////////

    if(newDateValue != oldDateValue){
        msg = '';
        if(msg != ''){
            alert(msg);
            return false;
        }
    } else {return false;}


    locat       = window.location.hostname;
    if(locat.slice(-1) != '/')
        locat += '/';


    let uid = localStorage.getItem('uuid');
    filters = '&uid='+uid+'&ppid='+proposalId;
    
    nameDateField = 'newDate';
    if(dateType == 'start'){
        nameDateField = 'newStartDate';
    }

    filters += '&'+nameDateField+'='+newDateValue+'&oldDate='+oldDateValue;
    const requestURL = window.location.protocol+'//'+locat+'api/proposals/auth_proposal_changeDate.php?auth_api='+authApi+filters;
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