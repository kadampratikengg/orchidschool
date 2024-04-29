<html>
<body onLoad='document.subFrm.submit();'>
<form id='subFrm' name='subFrm' action="<?php echo base_url('initiate_tpsl_pay/process'); ?>" method="post">
	<input type="hidden" name="reqType" value="T">
    <input type="hidden" name="mrctCode" value="L2519"> 
    <input type="hidden" name="mrctTxtID" value="<?php echo $unique_t_id;?>"> 
    <input type="hidden" name="currencyType" value="INR"/>
    <input type="hidden" name="amount" value="<?php echo $amount; ?>"/>
    <input type="hidden" name="itc" value=""/>
    <input type="hidden" name="reqDetail" value="<?php echo "PNES_".$amount."_0.0"?>"/>
    <input type="hidden" name="txnDate" value="<?php echo date('d-m-Y'); ?>"/>
    <input type="hidden" name="bankCode" value=""/>
    <input type="hidden" name="locatorURL" value="https://www.tpsl-india.in/PaymentGateway/TransactionDetailsNew.wsdl">
   	<input type="hidden" name="s2SReturnURL" value=""/>
    <input type="hidden" name="tpsl_txn_id" value=""/>
    <input type="hidden" name="cardID" value=""/>
    <input type="hidden" name="custID" value="<?php echo $student_id; ?>"/>
    <input type="hidden" name="custname" value="<?php echo $student_name; ?>"/>
    <input type="hidden" name="timeOut" value=""/>
    <input type="hidden" name="mobNo" value=""/>
    <input type="hidden" name="accNo" value=""/>
    <input type="hidden" name="tpvAccntNo" value=""/>
    <input type="hidden" name="mmid" value=""/>
    <input type="hidden" name="otp" value=""/>
    <input type="hidden" name="TxnType" value=""/>
    <input type="hidden" name="TxnSubType" value=""/>
    <input type="hidden" name="cardName" value=""/>
    <input type="hidden" name="cardNo" value=""/>
    <input type="hidden" name="cardCVV" value=""/>
    <input type="hidden" name="cardExpMM" value=""/>
    <input type="hidden" name="cardExpYY" value=""/>
    <input type="hidden" name="key" value="7224680793ATMCUT">
    <input type="hidden" name="iv" value="9202438472RWCCDO">
    <input type="hidden" name="returnURL" value='<?php echo base_url("initiate_tpsl_pay/payment_response"); ?>'/>
</form>
<center>
    <h3>
    <br> Redirecting to TechProcess Payment Services, <br> <br> <br> 
    Please wait and Do not Press Back or Refresh </h3>
    If you are not redirected to TechProcess Payment Services 3 sec 
    <a href='javascript:void(0);' onClick='document.subFrm.submit();'>Click here to redirect</a> <br> <br>
        <img src="<?php echo images_path.'loading.gif'; ?>">
</center>

</body>
</html>