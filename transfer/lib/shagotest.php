<?php
include "shagoPay.php";

$type = 1000;

$tx = new SHAGOAPI($type, 0);
$data  =  $tx->product();
$data = json_decode($data, true);

$response = [];


foreach($data as $d){
    $response[] = ["bankName"=>$d["name"], "bankCode"=>$d["bin"]];
}
print_r(json_encode($response));

$data = ["amount" =>"100",
        "bin"=> "058",
        "bank_account"=>"0037297975",
        "bank_name" => "GT Bank"];

$tm = new SHAGOAPI($type, 1);

$response =  $tm->verify($data);
$response = json_decode($response, true);
if($response["status"]== "200"){
    $status =TRUE;
    $data = array('settlement_bank'=>$response["bin"], 'account_number'=>$account, "account_name"=>$response['customerName']);
}
print_r(json_encode($response));

$tm = new SHAGOAPI($type, 1);

$data = ["amount" =>"100",
        "bin"=> "058",
        "bank_account"=>"0037297975",
        "bank_name" => "GT Bank"];


$response =  $tm->verify($data);
print_r($response);
$resp = json_decode($response);

$data["reference"] = $resp->reference;
$data["transaction_id"] = uniqid();

$tn = new SHAGOAPI($type, 2);
$response =  $tn->vendMoney($data);

print_r($response);


