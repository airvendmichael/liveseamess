<?php

include '../header.php';
include '../function.php';
include '../providus.php';
include '../provider.php';
include '../lib/shagoPay.php';
//The Server IP Address
$input= file_get_contents('php://input');
$data = json_decode($input, true);
//Call Banks
$bank = $data['details']['settlementBank'];
$account = $data['details']['account'];
if($provider == 1){
//Payant
	$payload = array("settlement_bank"=>$bank, "account_number"=>$account);
	$payload = json_encode($payload);
	$output = verifyAcc($payload);
	$output = json_decode($output, TRUE);
	if($output['status'] == "success"){
		$status = TRUE;
		$data = $output['data'];
	}
}
elseif($provider ==2){
	//Providus
	$mx = new ProvidusTransfer;
	$data =  ["accountNumber"=>$account, "bankCode"=>$bank];
	$output = $mx->verifyAccount($data);
	$output = json_decode($output, TRUE);
	if($output["responseCode"]=="00"){
		$status = TRUE;
		$data = array('settlement_bank'=>$bank, 'account_number'=>$account, "account_name"=>$output['accountName']);
	}
}
else{
	$type = 1000;
	$tx = new SHAGOAPI($type, 0);
	$data  =  $tx->product();
	$data = json_decode($data, true);

	$data = ["amount" =>"100",
        "bin"=> $bank,
        "bank_account"=>$account,
        "bank_name" => "GT Bank"];

$tm = new SHAGOAPI($type, 1);

$response =  $tm->verify($data);
//$response = json_decode($response, true);
error_log($response,3 , 'request.log');
$response = json_decode($response, true);
if($response["status"]== "200"){
    $status =TRUE;
    $data = array('settlement_bank'=>$response["bin"], 'account_number'=>$account, "account_name"=>$response['customerName']);
}

}


	


if($status == TRUE){
				$resd['status'] = 200;
				$resd['message'] = $data;
				vend_response($resd);
}
else{
	$resd['status'] = 417;
	$resd['message'] = $output;
	vend_response($resd);
}
