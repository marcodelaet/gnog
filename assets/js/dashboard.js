document.getElementById('nav-item-dashboard').setAttribute('class',document.getElementById('nav-item-dashboard').getAttribute('class').replace(' active','') + ' active');
var csrf_token = $('meta[name="csrf-token"]').attr('content');
module_dash  = 'dashboard';
function handleListOnLoad(search) {
    errors      = 0;
    authApi     = csrf_token;
    locat       = window.location.hostname;

    // getting today's date
    var today   = new Date();
    var day    = today.getDate();
    var month   = today.getMonth()+1; // getMonth starts at 0
    var year    = today.getFullYear();
    var mySQLFullDate = year+'-'+month+'-'+day;

    filters     = '';
    if(typeof search == 'undefined')
        search  = '';
    if(search !== ''){
        filters     += '&search='+search;
    }

    filters += '&date='+mySQLFullDate;

    if(locat.slice(-1) != '/')
        locat += '/';

    if(errors > 0){

    } else{
        tableList   = document.getElementById('listDashboard');
        const requestURL = window.location.protocol+'//'+locat+'api/'+module_dash+'/auth_'+module_dash+'_list.php?auth_api='+authApi+filters;
        //alert(requestURL);
        const request = new XMLHttpRequest();
        request.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                // Typical action to be performed when the document is ready:
                obj         = JSON.parse(request.responseText);
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
                    if(obj[i].status_percent == '100')
                        color_status = '#298c3d';
                    if(obj[i].status_percent == '90')
                        color_status = '#03fc84';
                    if(obj[i].status_percent == '75')
                        color_status = '#77fc03';
                    if(obj[i].status_percent == '50')
                        color_status = '#ebfc03';
                    if(obj[i].status_percent == '25')
                        color_status = '#fc3d03';
                        

                    agency = '';
                    if(typeof(obj[i].agency_name) === 'string')
                        agency = ' / '+obj[i].agency_name;
                    amount = obj[i].amount_int / 100;
                    amount_month = obj[i].amount_per_month_int / 100;
                    amount_total+= parseInt(obj[i].amount_per_month_int);
                    amount_total_show   = amount_total / 100;
                    percentGoalShow     = (100 * amount_total)/parseInt(document.getElementById('goal-2').innerText);
                    start_date  = new Date(obj[i].start_date);
                    stop_date   = new Date(obj[i].stop_date);
                    html += '<tr><td>'+obj[i].offer_name+'</td><td nowrap>'+obj[i].client_name+agency+'</td><td nowrap>'+obj[i].username+'</td><td nowrap><spam style="display:none;" class="currency-line" id="currency-'+(i)+'">'+obj[i].currency+'</spam><spam class="amount-line" id="amount-'+(i)+'">'+formatter.format(amount)+'</spam></td><td nowrap><spam class="amount-month-line" id="amount-month-'+(i)+'">'+formatter.format(amount_month)+'</spam></td><td style="text-align:center;"><span id="locked_status_'+obj[i].UUID+'" class="material-icons" title="'+obj[i].status_percent+'% '+obj[i].status_name+'" style="color:'+color_status+'">thermostat</span></td><td nowrap style="text-align:center;">';
                    // information card
                    html += '<a href="?pr=Li9wYWdlcy9wcm9wb3NhbHMvaW5mby5waHA=&tid='+obj[i].UUID+'"><span class="material-icons" style="font-size:1.5rem; color:black;" title="Information Card '+obj[i].offer_name+'">info</span></a>';

                    // Edit form
                    html += '<a href="?pr=Li9wYWdlcy9wcm9wb3NhbHMvZm9ybWVkaXQucGhw&tid='+obj[i].UUID+'"><span class="material-icons" style="font-size:1.5rem; color:black;" title="Edit '+module + ' '+obj[i].offer_name+'">edit</span></a>';

                    // Remove 
                    html += '<a href="javascript:void(0)" onclick="handleRemove(\''+obj[i].UUID+'\',\''+obj[i].is_active+'\')"><span class="material-icons" style="font-size:1.5rem; color:black;" title="Remove '+module + ' '+obj[i].offer_name+'">delete</span></a>';

                    html += '</td></tr>';
                }
                tableList.innerHTML = html;
                document.getElementById('goal-1').innerHTML = formatter.format(amount_total_show);
                document.getElementById('goal-percent').innerHTML = percentGoalShow.toFixed(2) + "%";
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