<?php
//REQUIRE GLOBAL conf
require_once('../../database/.config');

// REQUIRE conexion class
require_once('../../database/connect.database.php');

if(!isset($DB)){
    $DB = new MySQLDB($DATABASE_HOST,$DATABASE_USER,$DATABASE_PASSWORD,$DATABASE_NAME);

    // call conexion instance
    $con = $DB->connect();
}

// REQUIRE utils functions
require_once('../../assets/lib/translation.php');

// call conexion instance
$con = $DB->connect();
$message    = '';
$errors     = 0;

// check authentication / local Storage
if(array_key_exists('auth_api',$_POST)){
    // check auth_api === local storage
    //if($localStorage == $_POST['auth_api']){}

    // setting query
    $tableOrView    = "invoices";

    $auth_api   = $_POST['auth_api'];
    
    // filters
    $filters        = '';

    $uuid           = '';
    if(array_key_exists('iid',$_POST)){
        if($_POST['iid']!==''){
            if($filters != '')
                $filters .= " AND ";
            $uuid         = $_POST['iid'];
            $filters    .= " id = '$uuid'";
            $invoice_id = $uuid;
        }
    } else {
        $errors++;
        $message .= "\n-no_id_information";
    }

    $option         = '';
    if(array_key_exists('option',$_POST)){ // options - pay, approval, deny
        $option     = $_POST['option'];
    }    

    $user_id = '';
    if(array_key_exists('uid',$_POST)){
        if($_POST['uid']!==''){
            $user_id    = $_POST['uid'];
        }
    } else {
        $errors++;
        $message .= "\n-no_user_information";
    }

    $user_token = '';
    if(array_key_exists('tku',$_POST)){
        if($_POST['tku']!==''){
            $user_token    = $_POST['tku'];
        }
    } else {
        $errors++;
        $message .= "\n-no_token_information";
    }


    $status = 'waiting_approval'; // status
    if(array_key_exists('sts',$_POST)){
        $status = $_POST['sts'];
    } else {
        $errors++;
        $message .= "\n-no_status_information";
    }


    $newStatus = 'waiting_approval'; // new status
    if(array_key_exists('newstatus',$_POST)){
        $newStatus = $_POST['newstatus'];
    } else {
        $errors++;
        $message .= "\n-no_newstatus_information";
    }

    $motive = ''; // utilizar urldecode / urlencode (motive)
    if($option == 'deny'){
        if((array_key_exists('motive',$_POST)) && strlen($_POST['motive'])>20){
            $motive = $_POST['motive'];
        } else {
            $errors++;
            $message .= "\n-no_motive_information";
        }
    }

    $changes = '';
    if($option == 'pay'){ //only on pay options the database will change columns
        if(array_key_exists('currency',$_POST))
        {
            if(trim($_POST['currency']) != ''){
                $changes .= ", invoice_amount_currency = '".$_POST['currency']."'";
            } else {
                $errors++;
                $message .= "\n-no_currency_information";
            }
        }

        $amount_paid_int = 0;
        if(array_key_exists('invoice_value',$_POST))
        {
            if((trim($_POST['invoice_value']) != '') && (floatval(trim($_POST['invoice_value'])) > 0.00)){
                $amount_paid_int    = str_replace(",","",$_POST['invoice_value']);
                $aAmount_paid_int   = explode(".",$amount_paid_int);
                $amount_paid_int    = $aAmount_paid_int[0] . $aAmount_paid_int[1]; // 0 = int | 1 = cents
                // sum total paid at base with the new (or not new) amount
                if(array_key_exists('paid_amount',$_POST)) {
                    $amount_paid_int += intval($_POST['paid_amount']);
                }
                $changes .= ", invoice_amount_paid_int = '$amount_paid_int'";
            } else {
                $errors++;
                $message .= "\n-no_paidamount_information";
            }
        }

        if(floatval(($amount_paid_int / 100)) >= floatval($_POST['invoice_amount']) ){
            $newStatus = 'paid';
        }

        // somar valor da base invoice_amount_paid_int com post de invoice_value 
        // e comparar com o valor da base invoice_amount_int. Se a soma >= valor 
        // a pagar, muda status para pago
        
        if(array_key_exists('payment_date',$_POST))
        {
            if(trim($_POST['payment_date']) != ''){
                $payment_date   = date("Y-m-d", strtotime($_POST['payment_date']));
                $changes .= ", invoice_last_payment_date = '$payment_date'";
            } else {
                $errors++;
                $message .= "\n-no_paymentdate_information";
            }
        }
    }
    
    $newStatus1 = 'invoice_approved';
    
    $approval_text_en   = json_decode(translateTextInLanguage($newStatus1,'eng'),true)['translation'];
    $approval_text_es   = json_decode(translateTextInLanguage($newStatus1,'esp'),true)['translation'];
    $approval_text_ptbr = json_decode(translateTextInLanguage($newStatus1,'ptbr'),true)['translation'];

    if($errors <= 0){
        // Query creation
        $sql = "UPDATE $tableOrView SET invoice_status = '$newStatus', updated_at = now() $changes WHERE $filters";
        // LIST data
        // echo $sql;

        $message .= $sql;
        $response = json_encode(["status" => "Error","message" => $message]);
        
        $rs = $DB->executeInstruction($sql);

        if($rs){
            /*****************************************************************
             * recording historylog | if $newStatus1 <> waiting_approval, 
             * record $newStatus1 and later $newStatus
             ********************************************************* */ 
            // default: approved option
            $description_en     = $approval_text_en;
            $description_es     = $approval_text_es;
            $description_ptbr   = $approval_text_ptbr;

            // deny option
            if($option == 'deny'){
                $description_en     = json_decode(translateTextInLanguage($newStatus,'eng'),true)['translation'] . ' - reason: ' .$motive;
                $description_es     = json_decode(translateTextInLanguage($newStatus,'esp'),true)['translation'] . ' - motivo: ' .$motive;
                $description_ptbr   = json_decode(translateTextInLanguage($newStatus,'ptbr'),true)['translation'] . ' - motivo: ' .$motive;
            }

            // pay option
            if($option == 'pay'){
                if($status == "waiting_approval"){ // if paid on approval -> set history to approval first
                    setHistory($user_id,'invoices',$invoice_id,$description_en,$description_es,$description_ptbr,$user_token,$auth_api,'text');
                    // creating description text about payment
                }
                $description_en     = 'invoice '.json_decode(translateTextInLanguage($newStatus,'eng'),true)['translation'] . ', paid value $'.$_POST['invoice_value']. ' (currency: '.$_POST['currency'].')';
                $description_es     = 'factura '.json_decode(translateTextInLanguage($newStatus,'esp'),true)['translation'] . ', monto del pago $'.$_POST['invoice_value']. ' (moneda: '.$_POST['currency'].')';
                $description_ptbr   = 'fatura '.json_decode(translateTextInLanguage($newStatus,'ptbr'),true)['translation'] . ', valor pago $'.$_POST['invoice_value']. ' (moeda: '.$_POST['currency'].')';
        }
                
            //$message = "setHistory($user_id,'invoices',$description,$user_token,$form_token,'text')";
            setHistory($user_id,'invoices',$invoice_id,$description_en,$description_es,$description_ptbr,$user_token,$auth_api,'text');

            /*****************************************************************
             * sending email | if $newStatus1 <> waiting_approval, send 
             * $newStatus1 and later $newStatus 
             ********************************************************* */ 
            $message .= "\n- data record successfully";
            //$return = json_encode(["status" => "Error","message" => $message]);
            $response = json_encode(["status" => "OK","message" => $message]);
        } else {
            $response = json_encode(["status" => "Error","message" => $message]);
        } 
    } else {
        // message sent
        $response = json_encode(["status" => "Error","message" => $message]);
    }
} else {
    $message .= "\n- no authorization";
    $response = json_encode(["status" => "Error","message" => $message]);
}

header('Content-type: application/json');
echo $response;

//close connection
$DB->close();

?>



