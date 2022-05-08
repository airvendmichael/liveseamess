<?php
include "./newitex.php";
$type = 10;
$account = "0100347711";
$amount = "100";
$transactionid= uniqid();
$tx = new itexService($type);

//$requestverify = array("channel"=>$tx->channel,
//        "meterNo" =>$account,
//        "amount"=>"200",
//        "accountType"=>$tx->ty,
//        "service"=>$tx->service
//        );

//$output = $tx->api_call($requestverify, "http://197.253.19.76:8019/api/v1/vas/electricity/validation");

$payload = array("channel"=>$tx->channel,
							"meterNo" =>$account,
							"amount"=>$amount,
							"accountType"=>$tx->ty,
							"service"=>$tx->service
							);
//Ikeja Electric Vending

$product = $tx->productVerify($payload);
$report = $tx->output;
$requestvend = array(
				    "meterNo"=>$account,
					"customerPhoneNumber"=>$customerphone,
                    "paymentMethod"=>"cash",
					"channel"=>$tx->channel,
					"pin"=>$tx->pin(),
					"productCode"=>$product,
					"service"=>$tx->service,
					"clientReference"=>$transactionid);
$query_trans = array("wallet"=>$tx->walletid,
						"clientReference"=>$transactionid);

$output = $tx->api_call($requestvend,"http://197.253.19.76:8019/api/v1/vas/electricity/payment");
print_r($report);
print_r($output);
