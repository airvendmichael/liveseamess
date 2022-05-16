<?php


include '../header.php';

function transaction($transactionid, $mysqli){
$query = "SELECT status_code, transaction_id, client_reference, destination, transaction_date, value, product_type FROM transaction_log WHERE transaction_id = $transactionid";
$result = mysqli_query($mysqli, $query);
 while($res = mysqli_fetch_assoc($result)){
 	$array[]= array("status" => $res['status_code'],
 					"destination" => $res['destination'],
 					"date" => $res['transaction_date'],
 					"amount" => $res['value'],
 					"type" => $res['product_type'],
 					"ref"=> $res['client_reference'],
 					"trans" => $res['transaction_id']);

 
 }
 return $array;
}

function referenceTransaction($tran, $mysqli){

$query = "SELECT status_code, transaction_id, client_reference, destination, transaction_date, value, product_type FROM transaction_log WHERE client_reference = '".$tran."'";
$result = mysqli_query($mysqli, $query);

 while($res = mysqli_fetch_assoc($result)){
 	$array[]= array("status" => $res['status_code'],
 					"destination" => $res['destination'],
 					"date" => $res['transaction_date'],
 					"amount" => $res['value'],
 					"type" => $res['product_type'],
 					"ref"=> $res['client_reference'],
 					"trans" => $res['transaction_id']);

 
 }

 return $array;
}


//IF DATA BUNDLE
$transactionid = $data['details']['transactionid'];
$ref = $data['details']['ref'];
if(empty($ref)){
$trans = transaction($transactionid, $mysqli);
}
else{
$trans = referenceTransaction($ref, $mysqli);
}

if($trans['0']['status'] === '0'){
//
			$response['status'] = 200;
		$response['message'] = "Successful Transaction ".$trans['0']['date'];
		$response['amount'] = $trans['0']['amount'];
		$response['type'] = $trans['0']['type'];
		$response['account'] = $trans['0']['destination'];
		$response['TransactionID'] = $trans['0']['trans'];
		$response['referenceID'] = $trans['0']['ref'];
}

elseif($trans['0']['status'] > "0"){
		$response['status'] = 501;
		$response['message'] = "Failed Transaction ".$trans['0']['date'];
		$response['amount'] = $trans['0']['amount'];
		$response['type'] = $trans['0']['type'];
		$response['account'] = $trans['0']['destination'];
		$response['TransactionID'] = $trans['0']['trans'];
		$response['referenceID'] = $trans['0']['ref'];
}

else{
			$response['status'] = 404;
			$response['message'] = "Transaction not Found on Server";
		}

vend_response($response);

// TODO - Postpaid: calculate balance due for account
