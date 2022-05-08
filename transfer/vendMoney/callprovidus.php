<?php

include "../providus.php"; 

$amount = $_REQUEST['amount'];
$mx = new ProvidusTransfer;
	//$account = "2027341441";
	//$code = "000016";
	
	//$account = "1300385392";
	//$code = "000023";
	
	$account = "0150776434";
	$code = "000013";
        $data =  ["accountNumber"=>$account, "bankCode"=>$code];
        $resp = $mx->verifyAccount($data);
        $resp = json_decode($resp, TRUE);
        print_r($resp);
//exit(); 
	$data =  ["name"=>$resp["accountName"],"amount"=>$amount, "narration"=>"Callphone Money", "accountNumber"=>$account, "bankCode"=>$code, "ref"=>"CPL-".uniqid()];
        $output = $mx->transferFund($data);
        $output = json_decode($output, TRUE);
        $load = $mx->load;
        print_r($output);
	if($output["responseCode"] === "00" || empty($output)){
                $status = TRUE;

                $response = array("settlement_bank"=>$bank,
                        "transaction_id"=>$transaction_id,
                        "account_name"=>$data["name"],
                        "account_number"=>$account,
                        );
        }
