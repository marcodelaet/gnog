document.getElementById('nav-item-dashboard').setAttribute('class',document.getElementById('nav-item-dashboard').getAttribute('class').replace(' active','') + ' active');
var csrf_token = $('meta[name="csrf-token"]').attr('content');
module_dash = 'dashboard';
module_item = 'proposal';

function returnSelectedStatuses(statuses){
    var select = statuses; 
    var selected = [...select.selectedOptions]
        .map(option => option.value); 
        return(selected);
}


function handleListOnLoad(uid,status,month,year,search,currency) {
    errors      = 0;
    authApi     = csrf_token;
    locat       = window.location.hostname;

    // getting today's date
    var today       = new Date();
    var xday        = today.getDate();
    var xmonth      = today.getMonth()+1; // getMonth starts at 0
    var xyear       = today.getFullYear();
    var xcurrency   = 'MXN';

    var stringJsonDataProposals     = '';
    var arrayJsonDataProposals      = [];
    var stringJsonDataCost          = '';
    var stringJsonDataMargin        = '';
    var stringJsonDataName          = '';

    //month filter
    if((typeof month != 'undefined') && ((month !== '') && (month != 'undefined'))){
        xmonth     = month;
    } else {
        document.getElementById('month').value=xmonth;
    }
    //year filter
    if((typeof year != 'undefined') && ((year !== '') && (year != 'undefined'))){
        xyear     = year;
    } else {
        document.getElementById('year').value=xyear;
    }
    //currency filter
    if((typeof currency != 'undefined') && ((currency !== '') && (currency != 'undefined'))){
        xcurrency     = currency;
    } else {
        document.getElementById('rate_id').value=xcurrency;
    }

    // setting length of month string
    var xlenDate    = ('00'+ xmonth).length;
   
    //var mySQLFullDate = xyear+'-'+xmonth+'-'+xday;
    var xmonthfull  = ('00' + xmonth).substring(xlenDate-2,xlenDate);
    var yearMonth = xyear+xmonthfull;

    filters     = '&currency='+xcurrency;
    //uid
    if(typeof uid == 'undefined')
        uid  = '';
    if((uid !== '0') && (uid != 'undefined')){
        filters     += '&uid='+uid;
    }
    
    //search
    if(typeof search == 'undefined')
        search  = '';
    if((search !== '') && (search != 'undefined')){
        filters     += '&'+search;
    }
    filters += '&date='+yearMonth;

    if(locat.slice(-1) != '/')
        locat += '/';

    if(errors > 0){
        
    } else{
        tableList   = document.getElementById('listDashboard');
        const requestURL = window.location.protocol+'//'+locat+'api/'+module_dash+'/auth_'+module_dash+'_list.php?auth_api='+authApi+filters;
        console.log(requestURL);
        //alert(requestURL);
        const request = new XMLHttpRequest();
        request.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                // Typical action to be performed when the document is ready:
                obj         = JSON.parse(request.responseText);
                if(typeof obj[0].response != 'undefined'){
                    html = '<tr><td colspan="8"><div style="margin-left:30%; margin-right:30%;text-align:center;" role="status">';
                    html += '0 proposals';
                    html += '</td></tr>';
                    tableList.innerHTML = html;    
                    }else{
                    html        = '';
                    amount_total= 0;
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
                            color_letter = '#CCCCFF';
                        }
                        if(obj[i].status_percent == '25'){
                            color_status = '#fc3d03';
                            color_letter = '#CCCCFF';
                        }

                        agency = '';
                        if(typeof(obj[i].agency_name) === 'string')
                            agency = ' / '+obj[i].agency_name;
                        cost                = parseInt(obj[i].cost_int) / 100;
                        margin              = (parseInt(obj[i].amount_int) - parseInt(obj[i].cost_int))/100;
                        amount              = obj[i].amount_int / 100;
                        amount_month        = obj[i].amount_per_month_int / 100;
                        amount_total        += parseInt(obj[i].amount_int);
                        amount_total_show   = amount_total / 100;
                        percentGoalShow     = (100 * amount_total)/parseInt(document.getElementById('goal-2').innerText);
                        start_date  = new Date(obj[i].start_date);
                        stop_date   = new Date(obj[i].stop_date);
                        lastCurrency = obj[i].currency;
                        html += '<tr><td>'+obj[i].offer_name+'</td><td nowrap>'+obj[i].client_name+agency+'</td><td nowrap>'+obj[i].username+'</td><td nowrap><spam style="display:none;" class="currency-line" id="currency-'+(i)+'">'+obj[i].currency+'</spam><spam class="amount-line" id="amount-'+(i)+'">'+formatter.format(amount)+'</spam></td><td nowrap><spam class="amount-month-line" id="amount-month-'+(i)+'">'+formatter.format(amount)+'</spam></td><td style="text-align:center;"><span id="status_'+obj[i].UUID+'" class="material-icons" title="'+obj[i].status_percent+'% '+translateText(obj[i].status_name,localStorage.getItem('ulang'))+'" style="color:'+color_status+'">thermostat</span><BR><SPAN class="status-description" style="background-color:'+color_status+'; color:'+color_letter+'">&nbsp;&nbsp;'+obj[i].status_percent+'% '+translateText(obj[i].status_name,localStorage.getItem('ulang'))+'&nbsp;&nbsp;</SPAN></td><td nowrap style="text-align:center;">';
                        // information card
                        html += '<a href="?pr=Li9wYWdlcy9wcm9wb3NhbHMvaW5mby5waHA=&ppid='+obj[i].UUID+'"><span class="material-icons" style="font-size:1.5rem; color:black;" title="Information Card '+obj[i].offer_name+'">info</span></a>';

                        // Edit form
                        html += '<a href="?pr=Li9wYWdlcy9wcm9wb3NhbHMvZm9ybWVkaXQucGhw&ppid='+obj[i].UUID+'"><span class="material-icons" style="font-size:1.5rem; color:black;" title="Edit '+module_item + ' '+obj[i].offer_name+'">edit</span></a>';

                        // Remove 
                        //html += '<a href="javascript:void(0)" onclick="handleRemove(\''+obj[i].UUID+'\',\''+obj[i].is_active+'\')"><span class="material-icons" style="font-size:1.5rem; color:black;" title="Remove '+module_item + ' '+obj[i].offer_name+'">delete</span></a>';

                        html += '</td></tr>';
                        if(i == 0){
                            stringJsonDataCost      += '{"y":'+cost+',"label":"'+obj[i].offer_name+' ('+obj[i].username+') - '+ucfirst(translateText('cost',localStorage.getItem('ulang')))+'"}';
                            stringJsonDataMargin    += '{"y":'+margin+',"label":"'+obj[i].offer_name+' ('+obj[i].username+') - '+ucfirst(translateText('margin',localStorage.getItem('ulang')))+'"}';
                            stringJsonDataName      += '{"y":0,"label":"'+obj[i].offer_name+' ('+obj[i].username+')"}';
                        } else {
                            stringJsonDataCost      += ', {"y":'+cost+',"label":"'+obj[i].offer_name+' ('+obj[i].username+') - '+ucfirst(translateText('cost',localStorage.getItem('ulang')))+'"}';
                            stringJsonDataMargin    += ', {"y":'+margin+',"label":"'+obj[i].offer_name+' ('+obj[i].username+') - '+ucfirst(translateText('margin',localStorage.getItem('ulang')))+'"}';
                            stringJsonDataName      += ', {"y":0,"label":"'+obj[i].offer_name+' ('+obj[i].username+')"}';
                        }
                    }
                    graphType = 'stackedBar100';
                    arrayJsonDataProposals[0] = '['+stringJsonDataCost+']';
                    arrayJsonDataProposals[1] = '['+stringJsonDataMargin+']';
                    arrayJsonDataProposals[2] = '['+stringJsonDataName+']';
                    
                    //console.log(arrayJsonDataProposals[0]);
                   // createGraph(graphType,'graph-proposals',ucfirst(translateText('proposal',localStorage.getItem('ulang')))+'s - '+translateText('values_in',localStorage.getItem('ulang'))+' '+lastCurrency,ucfirst(translateText('list_of',localStorage.getItem('ulang')))+' '+translateText('proposal',localStorage.getItem('ulang'))+'s',arrayJsonDataProposals); // campaigns chart 
                    
                    //createGraph('multi2','graph-goals','Reached Goals','Proposals',data1,'Goals',data2); //goals chart
                    tableList.innerHTML = html;
                    document.getElementById('goal-1').innerHTML = formatter.format(amount_total_show);
                    document.getElementById('goal-percent').innerHTML = percentGoalShow.toFixed(2) + "%";
                }
            }
            else {
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



function handleListLastWeekOnLoad(uid,search,currency) {
    errors      = 0;
    authApi     = csrf_token;
    locat       = window.location.hostname;

    // getting today's date
    var today       = new Date();
    var xday        = today.getDate();
    var xmonth      = today.getMonth()+1; // getMonth starts at 0
    var xyear       = today.getFullYear();
    var xcurrency   = 'MXN';

    var stringJsonDataProposals     = '';
    var arrayJsonDataProposals      = [];
    var stringJsonDataCost          = '';
    var stringJsonDataMargin        = '';
    var stringJsonDataName          = '';

    //currency filter
    if((typeof currency != 'undefined') && ((currency !== '') && (currency != 'undefined'))){
        xcurrency     = currency;
    } else {
        document.getElementById('rate_id').value=xcurrency;
    }

    // setting length of month string
    var xlenDate    = ('00'+ xmonth).length;
   
    //var mySQLFullDate = xyear+'-'+xmonth+'-'+xday;
    var xmonthfull  = ('00' + xmonth).substring(xlenDate-2,xlenDate);
    
    var xlenDay    = ('00'+ xday).length;
    var xdayfull    = ('00' + xday).substring(xlenDay-2,xlenDay)
    var dateFull = xyear+xmonthfull+xdayfull;

    filters     = '&currency='+xcurrency;
    //uid
    if(typeof uid == 'undefined')
        uid  = '';
    if((uid !== '0') && (uid != 'undefined')){
        filters     += '&uid='+uid;
    }
    
    //search
    if(typeof search == 'undefined')
        search  = '';
    if((search !== '') && (search != 'undefined')){
        filters     += '&'+search;
    }
    filters += '&date='+dateFull;

    if(locat.slice(-1) != '/')
        locat += '/';

    if(errors > 0){
        
    } else{
        tableListLastWeek   = document.getElementById('listDashboardLastWeek');
        const requestURL = window.location.protocol+'//'+locat+'api/'+module_dash+'/auth_'+module_dash+'_lastweek_list.php?auth_api='+authApi+filters;
        //console.log(requestURL);
        //alert(requestURL);
        const request = new XMLHttpRequest();
        request.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                // Typical action to be performed when the document is ready:
                obj         = JSON.parse(request.responseText);
                if(obj[0].response == 'Error'){
                    html = '<tr><td colspan="8"><div style="margin-left:30%; margin-right:30%;text-align:center;" role="status">';
                    html += '0 proposals';
                    html += '</div></td></tr>';
                    tableListLastWeek.innerHTML = html;    
                } else {
                    html        = '';
                    amount_total= 0;
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
                            color_letter = '#CCCCFF';
                        }
                        if(obj[i].status_percent == '25'){
                            color_status = '#fc3d03';
                            color_letter = '#CCCCFF';
                        }

                        agency = '';
                        if(typeof(obj[i].agency_name) === 'string')
                            agency = ' / '+obj[i].agency_name;

                        cost                = parseInt(obj[i].cost_int / 100);
                        margin              = (obj[i].amount_int - obj[i].cost_int)/100;
                        amount              = obj[i].amount_int / 100;
                        amount_month        = obj[i].amount_per_month_int / 100;
                        amount_total        += parseInt(obj[i].amount_int);
                        amount_total_show   = amount_total / 100;
                        percentGoalShow     = (100 * amount_total)/parseInt(document.getElementById('goal-2').innerText);
                        start_date  = new Date(obj[i].start_date);
                        stop_date   = new Date(obj[i].stop_date);
                        lastCurrency = obj[i].currency;
                        html += '<tr><td>'+obj[i].offer_name+'</td><td nowrap>'+obj[i].client_name+agency+'</td><td nowrap>'+obj[i].username+'</td><td nowrap><spam style="display:none;" class="currency-line" id="currency-'+(i)+'">'+obj[i].currency+'</spam><spam class="amount-line" id="amount-'+(i)+'">'+formatter.format(amount)+'</spam></td><td nowrap><spam class="amount-month-line" id="amount-month-'+(i)+'">'+formatter.format(amount)+'</spam></td><td style="text-align:center;"><span id="status_'+obj[i].UUID+'" class="material-icons" title="'+obj[i].status_percent+'% '+translateText(obj[i].status_name,localStorage.getItem('ulang'))+'" style="color:'+color_status+'">thermostat</span><BR><SPAN class="status-description" style="background-color:'+color_status+'; color:'+color_letter+'">&nbsp;&nbsp;'+obj[i].status_percent+'% '+translateText(obj[i].status_name,localStorage.getItem('ulang'))+'&nbsp;&nbsp;</SPAN></td><td nowrap style="text-align:center;">';
                        // information card
                        html += '<a href="?pr=Li9wYWdlcy9wcm9wb3NhbHMvaW5mby5waHA=&ppid='+obj[i].UUID+'"><span class="material-icons" style="font-size:1.5rem; color:black;" title="Information Card '+obj[i].offer_name+'">info</span></a>';

                        // Edit form
                        html += '<a href="?pr=Li9wYWdlcy9wcm9wb3NhbHMvZm9ybWVkaXQucGhw&ppid='+obj[i].UUID+'"><span class="material-icons" style="font-size:1.5rem; color:black;" title="Edit '+module_item + ' '+obj[i].offer_name+'">edit</span></a>';

                        // Remove 
                        //html += '<a href="javascript:void(0)" onclick="handleRemove(\''+obj[i].UUID+'\',\''+obj[i].is_active+'\')"><span class="material-icons" style="font-size:1.5rem; color:black;" title="Remove '+module_item + ' '+obj[i].offer_name+'">delete</span></a>';

                        html += '</td></tr>';
                        if(i == 0){
                            stringJsonDataCost      += '{"y":'+cost+',"label":"'+obj[i].offer_name+' ('+obj[i].username+') - '+ucfirst(translateText('cost',localStorage.getItem('ulang')))+'"}';
                            stringJsonDataMargin    += '{"y":'+margin+',"label":"'+obj[i].offer_name+' ('+obj[i].username+') - '+ucfirst(translateText('margin',localStorage.getItem('ulang')))+'"}';
                            stringJsonDataName      += '{"y":0,"label":"'+obj[i].offer_name+' ('+obj[i].username+')"}';
                        } else {
                            stringJsonDataCost      += ', {"y":'+cost+',"label":"'+obj[i].offer_name+' ('+obj[i].username+') - '+ucfirst(translateText('cost',localStorage.getItem('ulang')))+'"}';
                            stringJsonDataMargin    += ', {"y":'+margin+',"label":"'+obj[i].offer_name+' ('+obj[i].username+') - '+ucfirst(translateText('margin',localStorage.getItem('ulang')))+'"}';
                            stringJsonDataName      += ', {"y":0,"label":"'+obj[i].offer_name+' ('+obj[i].username+')"}';
                        }
                    }
                    graphType = 'stackedBar100';
                    arrayJsonDataProposals[0] = '['+stringJsonDataCost+']';
                    arrayJsonDataProposals[1] = '['+stringJsonDataMargin+']';
                    arrayJsonDataProposals[2] = '['+stringJsonDataName+']';
                    
                    //console.log(stringJsonDataProposals);
                    //createGraph(graphType,'graph-last-proposals',ucfirst(translateText('proposal',localStorage.getItem('ulang')))+'s - '+translateText('values_in',localStorage.getItem('ulang'))+' '+lastCurrency,ucfirst(translateText('list_of',localStorage.getItem('ulang')))+' '+translateText('proposal',localStorage.getItem('ulang'))+'s '+translateText('of_the_week',localStorage.getItem('ulang')),arrayJsonDataProposals); // campaigns chart 

                    //createGraph('multi2','graph-goals','Reached Goals','Proposals',data1,'Goals',data2); //goals chart
                    tableListLastWeek.innerHTML = html;
                    // document.getElementById('goal-1').innerHTML = formatter.format(amount_total_show);
                    // document.getElementById('goal-percent').innerHTML = percentGoalShow.toFixed(2) + "%";
                }
            }
            else {
                html = '<tr><td colspan="8"><div style="margin-left:45%; margin-right:45%;" class="spinner-border" style="text-align:center;" role="status">';
                html += '<span class="sr-only">Loading...</span>';
                html += '</div></td></tr>';
                tableListLastWeek.innerHTML = html;
                //form.btnSave.innerHTML = "Searching...";
            }
        };
        request.open('GET', requestURL);
        //request.responseType = 'json';
        request.send();
    }
    // window.location.href = '?pr=Li9wYWdlcy91c2Vycy9saXN0LnBocA==';
}

function handleShowExecutiveGoalGraph(uid,status,month,year,search,currency){
    errors      = 0;
    authApi     = csrf_token;
    locat       = window.location.hostname;

    // getting today's date
    var today       = new Date();
    var xday        = today.getDate();
    var xmonth      = today.getMonth()+1; // getMonth starts at 0
    var xyear       = today.getFullYear();
    var xcurrency   = 'MXN';

    var arrayJsonDataProposals      = [];
    var stringJsonDataCost          = '';
    var stringJsonDataMargin        = '';
    var stringJsonDataName          = '';
    var stringJsonDataGoal          = '';

    DIVIDGraphExecutiveGoal         = document.getElementById('graph-executive-goals');

    //month filter
    if((typeof month != 'undefined') && ((month !== '') && (month != 'undefined'))){
        xmonth     = month;
    } else {
        document.getElementById('month').value=xmonth;
    }
    //year filter
    if((typeof year != 'undefined') && ((year !== '') && (year != 'undefined'))){
        xyear     = year;
    } else {
        document.getElementById('year').value=xyear;
    }
    //currency filter
    if((typeof currency != 'undefined') && ((currency !== '') && (currency != 'undefined'))){
        xcurrency     = currency;
    } else {
        document.getElementById('rate_id').value=xcurrency;
    }

    // setting length of month string
    var xlenDate    = ('00'+ xmonth).length;
   
    //var mySQLFullDate = xyear+'-'+xmonth+'-'+xday;
    var xmonthfull  = ('00' + xmonth).substring(xlenDate-2,xlenDate);
    
    var xlenDay     = ('00'+ xday).length;
    var xdayfull    = ('00' + xday).substring(xlenDay-2,xlenDay)
    var dateFull    = xyear+xmonthfull+xdayfull;
    var thedate     = new Date(xyear, xmonth - 1);
    var strmonth    = thedate.toLocaleString('default',{ month: 'long'});

    filters     = '&currency='+xcurrency;
    //uid
    if(typeof uid == 'undefined')
        uid  = '';
    if((uid !== '0') && (uid != 'undefined')){
        filters     += '&uid='+uid;
    }
    
    //search
    if(typeof search == 'undefined')
        search  = '';
    if((search !== '') && (search != 'undefined')){
        filters     += '&'+search;
    }
    filters += '&date='+dateFull;

    if(locat.slice(-1) != '/')
        locat += '/';

    if(errors > 0){
        
    } else{
        const requestURL = window.location.protocol+'//'+locat+'api/'+module_dash+'/auth_'+module_dash+'_executive_goals_list.php?auth_api='+authApi+filters;
        //console.log(requestURL);
        const request = new XMLHttpRequest();
        request.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                // Typical action to be performed when the document is ready:
                obj         = JSON.parse(request.responseText);
                if(typeof obj[0].response != 'undefined'){
                    }else{
                    amount_total= 0;
                    for(var i=0;i < obj.length; i++){
                        var formatter = new Intl.NumberFormat(lang, {
                            style: 'currency',
                            currency: obj[i].currency,
                            //maximumSignificantDigits: 2,
                    
                            // These options are needed to round to whole numbers if that's what you want.
                            //minimumFractionDigits: 2, // (this suffices for whole numbers, but will print 2500.10 as $2,500.1)
                            //maximumFractionDigits: 0, // (causes 2500.99 to be printed as $2,501)
                        });
                        agency = '';
                        if(typeof(obj[i].agency_name) === 'string')
                            agency = ' / '+obj[i].agency_name;

                        
                        // decimal must be .
                        lastCurrency        = obj[i].currency;
                        /***********************************
                         * taking goals from database
                         ************************************/
                        goal                = document.getElementById('goal-0').innerText.replace(lastCurrency,'').replace('$','');
                        if(document.getElementById('goal-0').innerText.substr(-3,1) == ","){
                            goal            = goal.replace(".","").replace(",",".");
                        } else {
                            goal            = goal.replace(",","");
                        }
                        /****************************
                         * end GOAL
                         *****************************/
                        cost_int            = parseInt(obj[i].cost_int);
                        margin_int          = parseInt(obj[i].utility_amount_int - obj[i].utility_cost_int);
                        margin_month_int    = parseInt(obj[i].utility_amount_per_month_int - obj[i].utility_cost_per_month_int);
                        amount_int          = parseInt(obj[i].pipe_amount_int - obj[i].pipe_cost_int);
                        amount_month_int    = parseInt(obj[i].pipe_amount_per_month_int - obj[i].pipe_cost_per_month_int);


                        goal                = obj[i].goal_amount_int / 100;
                        cost                = parseInt(cost_int / 100);
                        margin              = (margin_int)/100;
                        margin_month        = (margin_month_int)/100;
                        amount              = amount_int / 100;
                        amount_month        = amount_month_int / 100;
                        amount_total        += parseInt(amount_int);
                        amount_total_show   = amount_total / 100;
                        percentGoalShow     = (100 * amount_total)/parseInt(document.getElementById('goal-2').innerText);
                        start_date  = new Date(obj[i].start_date);
                        stop_date   = new Date(obj[i].stop_date);

                        if(i == 0){
                            stringJsonDataCost      += '{"y":'+amount_month+',"label":"'+obj[i].username+' - '+ucfirst(translateText('amount',localStorage.getItem('ulang')))+' '+ucfirst(translateText('total',localStorage.getItem('ulang')))+' ('+ucfirst(translateText('month',localStorage.getItem('ulang')))+' - '+ucfirst(strmonth)+')"}';
                            stringJsonDataMargin    += '{"y":'+margin_month+',"label":"'+obj[i].username+' - '+ucfirst(translateText('margin',localStorage.getItem('ulang')))+'"}';
                            stringJsonDataGoal      += '{"y":'+goal+',"label":"'+obj[i].username+' - '+ucfirst(translateText('goal',localStorage.getItem('ulang')))+'"}';
                            stringJsonDataName      += '{"y":0,"label":"'+obj[i].username+'"}';
                        } else {
                            stringJsonDataCost      += ', {"y":'+amount_month+',"label":"'+obj[i].username+' - '+ucfirst(translateText('amount',localStorage.getItem('ulang')))+' '+ucfirst(translateText('total',localStorage.getItem('ulang')))+' ('+ucfirst(translateText('month',localStorage.getItem('ulang')))+' - '+ucfirst(strmonth)+')"}';
                            stringJsonDataMargin    += ', {"y":'+margin_month+',"label":"'+obj[i].username+' - '+ucfirst(translateText('margin',localStorage.getItem('ulang')))+'"}';
                            stringJsonDataGoal      += ', {"y":'+goal+',"label":"'+obj[i].username+' - '+ucfirst(translateText('goal',localStorage.getItem('ulang')))+'"}';
                            stringJsonDataName      += ', {"y":0,"label":"'+obj[i].username+'"}';
                        }
                    }
                    graphType = 'column';
                    arrayJsonDataProposals[0] = '['+stringJsonDataCost+']';
                    arrayJsonDataProposals[1] = '['+stringJsonDataMargin+']';
                    arrayJsonDataProposals[2] = '['+stringJsonDataGoal+']';
                    arrayJsonDataProposals[3] = '['+stringJsonDataName+']';
                    createGraph(graphType,'graph-executive-goals',ucfirst(translateText('goal',localStorage.getItem('ulang')))+'s - '+translateText('values_in',localStorage.getItem('ulang'))+' '+lastCurrency+' ('+ucfirst(translateText('month',localStorage.getItem('ulang')))+': '+ucfirst(strmonth)+')',ucfirst(translateText('list_of',localStorage.getItem('ulang')))+' '+translateText('proposal',localStorage.getItem('ulang'))+'s '+translateText('of_the_week',localStorage.getItem('ulang')),arrayJsonDataProposals); // campaigns chart 
                }
            }
            else {
                html = '<tr><td colspan="8"><div style="margin-left:45%; margin-right:45%;" class="spinner-border" style="text-align:center; vertical-align:middle;" role="status">';
                html += '<span class="sr-only">Loading...</span>';
                html += '</div></td></tr>';
                DIVIDGraphExecutiveGoal.innerHTML = html;
            }
        };
        request.open('GET', requestURL);
        //request.responseType = 'json';
        request.send();
    }
    // window.location.href = '?pr=Li9wYWdlcy91c2Vycy9saXN0LnBocA==';
}
    
function handleShowExecutiveGoalGraphYearly(uid,status,year,search,currency){
    errors      = 0;
    authApi     = csrf_token;
    locat       = window.location.hostname;

    // getting today's date
    var today       = new Date();
    var xday        = today.getDate();
    var xmonth      = today.getMonth()+1; // getMonth starts at 0
    var xyear       = today.getFullYear();
    var xcurrency   = 'MXN';

    var arrayJsonDataProposals      = [];
    var stringJsonDataCost          = '';
    var stringJsonDataMargin        = '';
    var stringJsonDataName          = '';
    var stringJsonDataGoal          = '';

    DIVIDGraphExecutiveGoalYearly   = document.getElementById('graph-executive-goals-yearly');

    //year filter
    if((typeof year != 'undefined') && ((year !== '') && (year != 'undefined'))){
        xyear     = year;
    } else {
        document.getElementById('year').value=xyear;
    }
    //currency filter
    if((typeof currency != 'undefined') && ((currency !== '') && (currency != 'undefined'))){
        xcurrency     = currency;
    } else {
        document.getElementById('rate_id').value=xcurrency;
    }

    // setting length of month string
    var xlenDate    = ('00'+ xmonth).length;
   
    //var mySQLFullDate = xyear+'-'+xmonth+'-'+xday;
    var xmonthfull  = ('00' + xmonth).substring(xlenDate-2,xlenDate);
    
    var xlenDay     = ('00'+ xday).length;
    var xdayfull    = ('00' + xday).substring(xlenDay-2,xlenDay)
    var dateFull    = xyear+xmonthfull+xdayfull;

    //var groupby     = '';
    var groupby     = '&groupby=month';

    var filters     = '&currency='+xcurrency;
    //uid
    if(typeof uid == 'undefined')
        uid  = '';
    if((uid !== '0') && (uid != 'undefined')){
        filters     += '&uid='+uid;
    }
    
    //search
    if(typeof search == 'undefined')
        search  = '';
    if((search !== '') && (search != 'undefined')){
        filters     += '&'+search;
    }
    filters += '&date='+dateFull+'&type=yearly';

    if(locat.slice(-1) != '/')
        locat += '/';

    if(errors > 0){
        
    } else{
        const requestURL = window.location.protocol+'//'+locat+'api/'+module_dash+'/auth_'+module_dash+'_executive_goals_list.php?auth_api='+authApi+filters+groupby;
        //console.log(requestURL);
        const request = new XMLHttpRequest();
        request.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                // Typical action to be performed when the document is ready:
                obj         = JSON.parse(request.responseText);
                if(typeof obj[0].response != 'undefined'){
                } else {
                    amount_total        = 0;
                    oldMonth            = 0;
                    var cost_int        = 0;
                    var goal_int        = 0;
                    margin_int          = 0;
                    margin_month_int    = 0;
                    amount_int          = 0;
                    amount_month_int    = 0;
                    for(var i=0;i < obj.length; i++){
                        var formatter = new Intl.NumberFormat(lang, {
                            style: 'currency',
                            currency: obj[i].currency,
                            //maximumSignificantDigits: 2,
                    
                            // These options are needed to round to whole numbers if that's what you want.
                            //minimumFractionDigits: 2, // (this suffices for whole numbers, but will print 2500.10 as $2,500.1)
                            //maximumFractionDigits: 0, // (causes 2500.99 to be printed as $2,501)
                        });
                        agency = '';
                        if(typeof(obj[i].agency_name) === 'string')
                            agency = ' / '+obj[i].agency_name;

                        
                        // decimal must be .
                        lastCurrency        = obj[i].currency;
                        /***********************************
                         * taking goals from database
                         ************************************/
                        /*goal                = document.getElementById('goal-0').innerText.replace(lastCurrency,'').replace('$','');
                        if(document.getElementById('goal-0').innerText.substr(-3,1) == ","){
                            goal            = goal.replace(".","").replace(",",".");
                        } else {
                            goal            = goal.replace(",","");
                        }*/
                        /****************************
                         * end GOAL
                         *****************************/
                        
                        start_date  = new Date(obj[i].start_date);
                        stop_date   = new Date(obj[i].stop_date);
                        var strmonth    = '???';
                        if(obj[i].goal_month != null){
                            var thedate     = new Date(obj[i].goal_year, obj[i].goal_month - 1);
                            strmonth    = thedate.toLocaleString('default',{ month: 'long'});

                            if(oldMonth != obj[i].goal_month){
                                if(obj[i].goal_amount_int != null){
                                    goal_int            = parseInt(obj[i].goal_amount_int);
                                }
                                else{
                                    goal_int            = 0;
                                }
                                cost_int            = parseInt(obj[i].cost_int);
                                margin_int          = parseInt(obj[i].utility_amount_int - obj[i].utility_cost_int);
                                margin_month_int    = parseInt(obj[i].utility_amount_per_month_int - obj[i].utility_cost_per_month_int);
                                amount_int          = parseInt(obj[i].pipe_amount_int - obj[i].pipe_cost_int);
                                amount_month_int    = parseInt(obj[i].pipe_amount_per_month_int - obj[i].pipe_cost_per_month_int);
                            } else {
                                if(obj[i].goal_amount_int != null){
                                    goal_int            += parseInt(obj[i].goal_amount_int);
                                }
                                else{
                                    goal_int            += 0;
                                }
                                cost_int            += parseInt(obj[i].cost_int);
                                margin_int          += parseInt(obj[i].utility_amount_int - obj[i].utility_cost_int);
                                margin_month_int    += parseInt(obj[i].utility_amount_per_month_int - obj[i].utility_cost_per_month_int);
                                amount_int          += parseInt(obj[i].pipe_amount_int - obj[i].pipe_cost_int);
                                amount_month_int    += parseInt(obj[i].pipe_amount_per_month_int - obj[i].pipe_cost_per_month_int);
                            }
                            goal                = (goal_int / 100).toFixed(2);
                            cost                = (cost_int / 100).toFixed(2);
                            margin              = (margin_int/100).toFixed(2);
                            margin_month        = (margin_month_int/100).toFixed(2);
                            amount              = (amount_int / 100).toFixed(2);
                            amount_month        = (amount_month_int / 100).toFixed(2);
                            amount_total        += (amount_int).toFixed(2);
                            amount_total_show   = (amount_total / 100).toFixed(2);

                            percentGoalShow     = (100 * amount_total)/parseInt(document.getElementById('goal-2').innerText);
                            if(obj[i].goal_month == 1){
                                stringJsonDataCost      = '{"y":'+amount_month+',"label":"'+ucfirst(strmonth)+' - '+ucfirst(translateText('amount',localStorage.getItem('ulang')))+' '+ucfirst(translateText('total',localStorage.getItem('ulang')))+'"}';
                                stringJsonDataMargin    = '{"y":'+margin_month+',"label":"'+ucfirst(strmonth)+' - '+ucfirst(translateText('margin',localStorage.getItem('ulang')))+'"}';
                                stringJsonDataGoal      = '{"y":'+goal+',"label":"'+ucfirst(strmonth)+' - '+ucfirst(translateText('goal',localStorage.getItem('ulang')))+'"}';
                                stringJsonDataName      = '{"y":0,"label":"'+ucfirst(strmonth)+'"}';
                            } else {
                                if((oldMonth != obj[i].goal_month) && (cost_int > 0)){
                                    stringJsonDataCost      += ', {"y":'+amount_month+',"label":"'+ucfirst(strmonth)+' - '+ucfirst(translateText('amount',localStorage.getItem('ulang')))+' '+ucfirst(translateText('total',localStorage.getItem('ulang')))+'"}';
                                    stringJsonDataMargin    += ', {"y":'+margin_month+',"label":"'+ucfirst(strmonth)+' - '+ucfirst(translateText('margin',localStorage.getItem('ulang')))+'"}';
                                    stringJsonDataGoal      += ', {"y":'+goal+',"label":"'+ucfirst(strmonth)+' - '+ucfirst(translateText('goal',localStorage.getItem('ulang')))+'"}';
                                    stringJsonDataName      += ', {"y":0,"label":"'+ucfirst(strmonth)+'"}';
                                }
                            }
                            oldMonth = obj[i].goal_month;
                        }
                    }
                    graphType = 'column';
                    arrayJsonDataProposals[0] = '['+stringJsonDataCost+']';
                    arrayJsonDataProposals[1] = '['+stringJsonDataMargin+']';
                    arrayJsonDataProposals[2] = '['+stringJsonDataGoal+']';
                    arrayJsonDataProposals[3] = '['+stringJsonDataName+']';
                    if(stringJsonDataCost != ''){
                        createGraph(graphType,'graph-executive-goals-yearly',ucfirst(translateText('goal',localStorage.getItem('ulang')))+'s - '+translateText('values_in',localStorage.getItem('ulang'))+' '+lastCurrency+' ('+ucfirst(translateText('year',localStorage.getItem('ulang')))+': '+xyear+')',ucfirst(translateText('list_of',localStorage.getItem('ulang')))+' '+translateText('proposal',localStorage.getItem('ulang'))+'s '+translateText('of_the_week',localStorage.getItem('ulang')),arrayJsonDataProposals); // campaigns chart 
                    } else {
                        html = '<tr><td colspan="8"><div style="margin-left:45%; margin-right:45%;" style="text-align:center; vertical-align:middle;" role="status">';
                        html += '<span ">No hay metas registradas para los ejecutivos</span>';
                        html += '</div></td></tr>';
                        DIVIDGraphExecutiveGoalYearly.innerHTML = html;
                    }
                }
            }
            else {
                html = '<tr><td colspan="8"><div style="margin-left:45%; margin-right:45%;" class="spinner-border" style="text-align:center; vertical-align:middle;" role="status">';
                html += '<span class="sr-only">Loading...</span>';
                html += '</div></td></tr>';
                DIVIDGraphExecutiveGoalYearly.innerHTML = html;
            }
        };
        request.open('GET', requestURL);
        //request.responseType = 'json';
        request.send();
    }
    // window.location.href = '?pr=Li9wYWdlcy91c2Vycy9saXN0LnBocA==';
}


function createGraph(chartType,divName,strText,name1,data1,name2,data2,name3,data3) {
    var chart = '';
    if(chartType == 'multi2'){
        chart = new CanvasJS.Chart(divName, {
            animationEnabled: true,
            exportEnabled: true,
            theme: "light2", // "light1", "light2", "dark1", "dark2"
            title:{
                text: strText
            },
            axisX:{
                reversed: true
            },
            axisY:{
                includeZero: true
            },
            toolTip:{
                shared: true
            },
            data: [
                {
                type: "stackedBar",
                name: name1,
                dataPoints: JSON.parse(data1)
            },{
                type: "stackedBar",
                name: name2,
                indexLabel: "#total",
                indexLabelPlacement: "outside",
                indexLabelFontSize: 15,
                indexLabelFontWeight: "bold",
                dataPoints:JSON.parse(data2)
            }]
        });
    }

    if(chartType == 'multi3'){
        chart = new CanvasJS.Chart(divName, {
            animationEnabled: true,
            exportEnabled: true,
            theme: "light2", // "light1", "light2", "dark1", "dark2"
            title:{
                text: strText
            },
            axisX:{
                reversed: true
            },
            axisY:{
                includeZero: true
            },
            toolTip:{
                shared: true
            },
            data: [
                {
                type: "stackedBar",
                name: name1,
                dataPoints: JSON.parse(data1)
            },{
                type: "stackedBar",
                name: name2,
                dataPoints:JSON.parse(data2)
            },{
                type: "stackedBar",
                name: name3,
                indexLabel: "#total",
                indexLabelPlacement: "outside",
                indexLabelFontSize: 15,
                indexLabelFontWeight: "bold",
                dataPoints: JSON.parse(data3)
            }]
        });
    }

    if(chartType == 'horizontalBars'){
        chart = new CanvasJS.Chart(divName, {
            animationEnabled: true,
            title:{
                text: strText
            },
            axisY: {
                title: name1,
                includeZero: true,
                prefix: "$",
                suffix:  "k"
            },
            data: [{
                type: "bar",
                yValueFormatString: "$#,##0K",
                indexLabel: "{y}",
                indexLabelPlacement: "inside",
                indexLabelFontWeight: "bolder",
                indexLabelFontColor: "white",
                dataPoints: JSON.parse(data1)
            }]
        });
    }

    if(chartType == 'stackedBar100'){
        chart = new CanvasJS.Chart(divName, {
            animationEnabled: true,
            title:{
                text: strText
            },
            data: [
                {
                    type: "stackedBar100",
                    dataPoints: JSON.parse(data1[0])
                },
                {
                    type: "stackedBar100",
                    dataPoints: JSON.parse(data1[1])
                },
                {
                    type: "stackedBar100",
                    dataPoints: JSON.parse(data1[2])
                }
            ]
        });
    }

    if(chartType == 'column'){
        chart = new CanvasJS.Chart(divName, {
            animationEnabled: true,
            title:{
                text: strText
            },
            data: [
                {
                    dataPoints: JSON.parse(data1[0])
                },
                {
                    dataPoints: JSON.parse(data1[1])
                },
                {
                    dataPoints: JSON.parse(data1[2])
                },
                {
                    dataPoints: JSON.parse(data1[3])
                }
            ]
        });
    }

    chart.render();
}


function updateRates() {
    errors      = 0;
    authApi     = csrf_token;
    locat       = window.location.hostname;

    // getting today's date
    var today   = new Date();
    var xday    = today.getDate();
    var xmonth   = today.getMonth()+1; // getMonth starts at 0
    var xyear    = today.getFullYear();

    //month filter
    if((typeof month != 'undefined') && ((month !== '') && (month != 'undefined'))){
        xmonth     = month;
    }
    //year filter
    if((typeof year != 'undefined') && ((year !== '') && (year != 'undefined'))){
        xyear     = year;
    }
    var mySQLFullDate = xyear+'-'+xmonth+'-'+xday;

    filters     = '';
    
    //filters += '&date='+mySQLFullDate;

    if(locat.slice(-1) != '/')
        locat += '/';

    if(errors > 0){

    } else{
        const requestURL = window.location.protocol+'//'+locat+'api/rates/auth_rate_update.php?auth_api='+authApi+filters;
        console.log(requestURL);
        const request = new XMLHttpRequest();
        request.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                // Maybe important to notify user about rates update
                var obj = JSON.parse(request.responseText);
                if( (obj.status === 'OK') || (obj.status = "ALREADY_UPDATED") ){
                    document.getElementById('last-update-date').innerHTML = obj.updated_at;
                }
            }
        };
        request.open('GET', requestURL);
        request.send();
    }
}