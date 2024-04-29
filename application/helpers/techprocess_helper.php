<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	function process_payment($val)
	{
		$CI =& get_instance();
		
		require_once ("techprocess/TransactionRequestBean.php");


		$transactionRequestBean = new TransactionRequestBean();

    //Setting all values here
    $transactionRequestBean->setMerchantCode($val['mrctCode']);
    $transactionRequestBean->setAccountNo($val['tpvAccntNo']);
    $transactionRequestBean->setITC($val['itc']);
    $transactionRequestBean->setMobileNumber($val['mobNo']);
    $transactionRequestBean->setCustomerName($val['custname']);
    $transactionRequestBean->setRequestType($val['reqType']);
    $transactionRequestBean->setMerchantTxnRefNumber($val['mrctTxtID']);
    $transactionRequestBean->setAmount($val['amount']);
    $transactionRequestBean->setCurrencyCode($val['currencyType']);
    $transactionRequestBean->setReturnURL($val['returnURL']);
    $transactionRequestBean->setS2SReturnURL($val['s2SReturnURL']);
    $transactionRequestBean->setShoppingCartDetails($val['reqDetail']);
    $transactionRequestBean->setTxnDate($val['txnDate']);
    $transactionRequestBean->setBankCode($val['bankCode']);
    $transactionRequestBean->setTPSLTxnID($val['tpsl_txn_id']);
    $transactionRequestBean->setCustId($val['custID']);
    $transactionRequestBean->setCardId($val['cardID']);
    $transactionRequestBean->setKey($val['key']);
    $transactionRequestBean->setIv($val['iv']);
    $transactionRequestBean->setWebServiceLocator($val['locatorURL']);
    $transactionRequestBean->setMMID($val['mmid']);
    $transactionRequestBean->setOTP($val['otp']);
    $transactionRequestBean->setCardName($val['cardName']);
    $transactionRequestBean->setCardNo($val['cardNo']);
    $transactionRequestBean->setCardCVV($val['cardCVV']);
    $transactionRequestBean->setCardExpMM($val['cardExpMM']);
    $transactionRequestBean->setCardExpYY($val['cardExpYY']);
    $transactionRequestBean->setTimeOut($val['timeOut']);

   // $url = $transactionRequestBean->getTransactionToken();

    $responseDetails = $transactionRequestBean->getTransactionToken();
    $responseDetails = (array)$responseDetails;
    $response = $responseDetails[0];

    if(is_string($response) && preg_match('/^msg=/',$response)){
        $outputStr = str_replace('msg=', '', $response);
        $outputArr = explode('&', $outputStr);
        $str = $outputArr[0];

        $transactionResponseBean = new TransactionResponseBean();
        $transactionResponseBean->setResponsePayload($str);
        $transactionResponseBean->setKey($val['key']);
        $transactionResponseBean->setIv($val['iv']);

        $response = $transactionResponseBean->getResponsePayload();
        echo "<pre>";
        print_r($response);
        exit;
    }elseif(is_string($response) && preg_match('/^txn_status=/',$response)){
		echo "<pre>";
        print_r($response);
        exit;
	}

    echo "<script>window.location = '".$response."'</script>";

	}
	
	function process_response($response){
		
		require_once ("techprocess/TransactionResponseBean.php");

    if(is_array($response)){
        $str = $response['msg'];
    }else if(is_string($response) && strstr($response, 'msg=')){
        $outputStr = str_replace('msg=', '', $response);
        $outputArr = explode('&', $outputStr);
        $str = $outputArr[0];
    }else {
        $str = $response;
    }

    $transactionResponseBean = new TransactionResponseBean();

    $transactionResponseBean->setResponsePayload($str);
    $transactionResponseBean->setKey("7224680793ATMCUT");
    $transactionResponseBean->setIv("9202438472RWCCDO");

    $response = $transactionResponseBean->getResponsePayload();
    return $response;

	}
	
?>