<?php
error_reporting(E_ALL);
ini_set('display_errors', 0);

if($type <= 4 || $type == 27){
	if($network_id == 1){
        	include '/var/www/vhosts/api/airtel/ussd/processor/airtel_sender.php';
	}
	else{

        	include '/var/www/vhosts/api/airtel/ussd/processor/'. $net['airtime_processor'];
	}
	if(strlen($result) == 0) {
	$result = 99999999;
}

// Catch unset product type (airtime/Data)

		
} 



if($type == 10) {
	$transactionid = "CPL-".$transaction_id;
	require "/var/www/vhosts/api/secured/seamless/vend/newitex.php";
	//$output =api_call($requestIEvend, "http://vas.itexapp.com/vas/ie/purchase");
	$tx = new itexService($type);
	$payload = array("channel"=>$tx->channel,
							"meterNo" =>$account,
							"amount"=>strval($amount),
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

	$output = $tx->api_call($requestvend,"http://197.253.19.76:8019/api/v1/vas/electricity/payment");

	$response = $output;
	$output = json_decode($output, true);
	if($output['responseCode'] == "00"){
		$result = 0;
		$out = $output["data"];
		$token = $out['token'];
		$unit = $out['unit_value'].$out['unit'];
		$transref = $out["transactionUniqueNumber"];
	}
	else {
		$result = '99999999';
		$error = $tx->error;
		
		}
}

		//Ikeja Prepaid
if($type==11) {		

	$transactionid = "CPL-".$transaction_id;
	require "/var/www/vhosts/api/secured/seamless/vend/newitex.php";
	//$output =api_call($requestIEvend, "http://vas.itexapp.com/vas/ie/purchase");
	$tx = new itexService($type);
	$payload = array("channel"=>$tx->channel,
							"meterNo" =>$account,
							"amount"=>strval($amount),
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

	$output = $tx->api_call($requestvend,"http://197.253.19.76:8019/api/v1/vas/electricity/payment");
	$response = $output;
	$output = json_decode($output, true);

	if($output['responseCode'] == "00"){
		$result = 0;
		$out = $output["data"];
		$token = $out['token'];
		$unit = $out['unit_value'].$out['unit'];
		$transref = $out["transactionUniqueNumber"];
	}
	else {
		$result = '99999999';
		$error = $tx->error;
		
		}
}


//Ibadan Pretpaid
if($type==12){

       require '/var/www/vhosts/api/vas/electricity/fet.php';

			$ret = callibedc($amount,$destination,$transaction_id, 2);
			$output = $ret;
			$vxdata = $ret;
			$response = $output;

			if(isset($ret['success'])){
				if($ret['success']== true){
					$result = '0';
					if(isset($ret['creditToken'])){
						$token = $ret['creditToken'];
					}
				}
			}
			else {
	$result = '99999999';
	$error  = $json_data['code'] . '|' . $json_data['message'];		
	}
}

if($type == 23) {
	$transactionid = "CPL-".$transaction_id;
	require "/var/www/vhosts/api/secured/seamless/vend/newitex.php";
	//$output =api_call($requestIEvend, "http://vas.itexapp.com/vas/ie/purchase");
	$tx = new itexService($type);
	$payload = array("channel"=>$tx->channel,
							"meterNo" =>$account,
							"amount"=>strval($amount),
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

	$output = $tx->api_call($requestvend,"http://197.253.19.76:8019/api/v1/vas/electricity/payment");
	$response = $output;
	$output = json_decode($output, true);
	
	if($output['status'] == 1){
		$result = 0;
		$token = $output['token'];
		$unit = $output['unit_value'].$output['unit'];
		$transref = $output["transactionUniqueNumber"];
	}
	else {
		$result = '99999999';
		$error = $tx->error;
		
		}
}



if($type==13) {
	
//	echo '<pre>';this is Eko prepaid
//	print_r($vendData);
//	echo '</pre>'

	// 				require '/var/www/vhosts/api/vas/electricity/req_abuja_electric.php';

	// 		$ctype = "Pre Paid";
		
		

	// 	$output = vend_eko($destination, $amount, $customername, $customerphone, $ctype);
	// 	$response = json_encode(mysqli_real_escape_string($mysqli, $output));

	// 	if($output['responseCode'] == 0){
	    
	//     $vendData = $output;
	//     $result = 0;
	// }
	// else {
	// 	$result = '99999999';
	// 	$error  = $output['responseCode']. '|' . $output['message'];		
	// 	}

	$transactionid = "CPL-".$transaction_id;
	$transactionid = "CPL-".$transaction_id;
	require "/var/www/vhosts/api/secured/seamless/vend/newitex.php";
	//$output =api_call($requestIEvend, "http://vas.itexapp.com/vas/ie/purchase");
	$tx = new itexService($type);
	$payload = array("channel"=>$tx->channel,
							"meterNo" =>$account,
							"amount"=>strval($amount),
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

	$output = $tx->api_call($requestvend,"http://197.253.19.76:8019/api/v1/vas/electricity/payment");
	$response = $output;
	$output = json_decode($output, true);

	if($output['responseCode'] == "00"){
		$result = 0;
		$out = $output["data"];
		$token = $out['token'];
		$unit = $out['unit_value'].$out['unit'];
		$transref = $out["transactionUniqueNumber"];
	}
	else {
		$result = '99999999';
		$error = $tx->error;
		
		}
	
}


if ($type == 14) {
	//eko postpaid

			// require '/var/www/vhosts/api/vas/electricity/req_abuja_electric.php';
				

			// 		$ctype = "Post Paid";

			// 	$output = vend_eko($destination, $amount, $customername, $customerphone, $ctype);
			// 	$response = json_encode(mysqli_real_escape_string($mysqli, $output));
			// 	if($output['responseCode'] == 0){
			    
			//     $vendData = $output;
			//     $result = 0;
			// }
			// else {
			// 	$result = '99999999';
			// 	$error  = $output['responseCode']. '|' . $output['message'];		
			// }

	$transactionid = "CPL-".$transaction_id;
	require "/var/www/vhosts/api/secured/seamless/vend/newitex.php";
	//$output =api_call($requestIEvend, "http://vas.itexapp.com/vas/ie/purchase");
	$tx = new itexService($type);
	$payload = array("channel"=>$tx->channel,
							"meterNo" =>$account,
							"amount"=>strval($amount),
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

	$output = $tx->api_call($requestvend,"http://197.253.19.76:8019/api/v1/vas/electricity/payment");
	$response = $output;
	$output = json_decode($output, true);

	if($output['responseCode'] == "00"){
		$result = 0;
		$out = $output["data"];
		$token = $out['token'];
		$unit = $out['unit_value'].$out['unit'];
		$transref = $out["transactionUniqueNumber"];
	}
	else {
		$result = '99999999';
		$error = $tx->error;
		
		}

}


//PHEDC

    if($type==15 || $type==16){
	$payment = $amount * 100;
	$transactionid = "CPL-".$transaction_id;
	$account = $destination;
	$customerphone = "09032878128";
	$customername = "Michael";
	$transactionid = "CPL-".$transaction_id;
	require "/var/www/vhosts/api/secured/seamless/vend/newitex.php";
	//$output =api_call($requestIEvend, "http://vas.itexapp.com/vas/ie/purchase");
	$tx = new itexService($type);
	$payload = array("channel"=>$tx->channel,
							"meterNo" =>$account,
							"amount"=>strval($amount),
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

	$output = $tx->api_call($requestvend,"http://197.253.19.76:8019/api/v1/vas/electricity/payment");
	$output = json_decode($output, true);
	$response = $output;
	if($output['responseCode'] == "00"){
		$result = 0;
		$out = $output["data"];
		$token = $out['token'];
		$unit = $out['unit_value'];
		$transref = $out["reference"];
	}
	else {
	$result = '99999999';
	$error = $tx->error;	
	}
}


if($product_type == 17 || $product_type == 18 || $product_type == 19 || $product_type == 20 || $product_type == 26 || $product_type == 27){
	require '/var/www/vhosts/api/lib/serviceProvider/buyPower.php';
	$tx = new ByPower();
	$output = $tx->vendMeter(["account"=>$account, "type"=>$product_type, "amount"=>$amount, "transaction_id"=>$transaction_id]);
	$response = $output;
	print_r($tx->payload.$response);

	exit();
	$output = json_decode($output, true);
	if($output['status']== true){
		$result = 0;
		$out = $output["data"];
		$token = $out["token"];
		$unit = $out["units"];
		$transref = $out["vendRef"];
	}
	else {
			$result = '99999999';
			$error  = $output['message'];		
	}

}

//Enugu Prepaid
	
if($type==21) {
	require '/var/www/vhosts/api/lib/serviceProvider/EEDC.php';

	$tx = new EEDC(21);
	$resp = $tx->verify(["account"=>$account]);
	
	$resp = json_decode($resp);
	error_log("Verify EEDC\n".$account.json_encode($resp), 3, 'vtu2_request.log');
	$cap = $tx->EEDCMaximumPurchase($resp->customer->tariffCode);
	if($amount > $cap){
	    $response['status'] = 417;
		$response['message'] = "Amount is greater than Cap of ".$cap;
		vend_response($response);

	}
	$demand_type = $tx->EEDCEarnings($resp->customer->tariffCode);

	$data = [];
	$data["accountNumber"]=$resp->customer->accountNumber;
	$data["account"] = $resp->customer->meterNumber;
	$data["amount"] = $amount;
	$data["transaction_id"] = $transaction_id;
	$data["customernumber"] = $resp->customer->tariffCode;
	$data["customername"] = $resp->customer->firstName.$resp->customer->lastName;
	$data["customerphone"] = $customerphone;
	$data['district'] = $resp->customer->district;
	$resp = $tx->vend($data);
	$response = $resp;
	$resp = json_decode($resp);
	error_log("EEDC\n".$account.json_encode($resp), 3, 'vtu2_request.log');
	if($resp->responseCode == 200){
		$result = '0';
		$vat =$resp->vat ;
		$unit = $resp->units;
		$token = $resp->token;
		$externalId = $resp->transactionId;
	}else{
		$resp = $tx->query($transaction_id);
		$resp = json_decode($resp);
		if($resp->responseCode == 200){
			$result = '0';
			$vat =$resp->vat; 
			$unit = $resp->units;
			$token = $resp->token;
			$externalId = $resp->transactionId;
		}
		else{
			$result = '99999999';
		}
	}
 //    $presentProvider = getPresentProvider($type, $mysqli);
 //    $pProvider = $presentProvider[0]['provider_id'];
 //    if($pProvider == 4){
 //    require '/var/www/vhosts/api/vas/electricity/fet.php';
	// if(empty($customerphone)&& strlen($customerphone) < 2){
	// 	$customerphone = "09032878128";
	// 	}
	// 	if($type == 21){
	// 		$ret = callenugudc($amount,$destination,$transaction_id, 2,$customerphone,'PRE',$customernumber);
	// 		$output = $ret;
	// 		$response = $ret;
	// 	}
	// 	if(is_array($ret)){
	// 		$vxdata = $ret;
	// 		if(isset($ret['success'])){
	// 			if($ret['success']== true){
	// 				$result = '0';
	// 				if(isset($ret['creditToken'])){
	// 					$token = $ret['creditToken'];
	// 				}
	// 			}
	// 			else {
	// 	$result = '99999999';
	// 	}
	// 		}
			
	// 	}

 //    }
 //    if($pProvider == 5){
 //        include '/var/www/vhosts/api/vas/electricity/shagoapi.php';
        
 //        if($type == 21){$meterType = "PREPAID";}
 //        if($type == 22){$meterType = "POSTPAID";}
 //        $content = array("request_id"=>$transaction_id,"amount"=>$amount,"address"=>$customeraddress, 
 //        "name"=>$customername,"serviceCode"=>"AOB","disco"=>"EEDC","meterNo"=>$account,"type"=>$meterType);
 //        $output = shagoApi($content);
 //        $response = $output;
 //        $resp = json_decode($output, true);
 //        if($resp['status']== 200){
 //            $result = '0';
 //            $token = $resp['token'];
 //            $unit = $resp['unit'];
 //            $transref = $resp['transId'];
 //        }else{
 //            $return = '99999999';
 //        }
 //    }

} 

//EEDC Post paid
if($type==22) {
	require '/var/www/vhosts/api/lib/serviceProvider/EEDC.php';

	$tx = new EEDC($type);
	$resp = $tx->verify(["account"=>$account]);
	
	$resp = json_decode($resp);

	$cap = $tx->EEDCMaximumPurchase($resp->customer->tariffCode);
	if($amount > $cap){
	    $response['status'] = 417;
		$response['message'] = "Amount is greater than Cap of ".$cap;
		vend_response($response);

	}
	//Confirm if MD
	 $demand_type = $tx->EEDCEarnings($resp->customer->tariffCode);

	
	$data = [];
	$data["accountNumber"]=$account;
	$data["account"] = $account;
	$data["amount"] = $amount;
	$data["transaction_id"] = $transaction_id;
	$data["customernumber"] = $resp->customer->tariffCode;
	$data["customerphone"] = $customerphone;
	$data['district'] = $resp->customer->district;
	$data["customername"] = $resp->customer->firstName.$resp->customer->lastName;
	$resp = $tx->vend($data);
	$response = $resp;
	$resp = json_decode($resp);
	
	error_log("EEDC\n".$account.json_encode($resp), 3, 'vtu2_request.log');
	if($resp->responseCode == 200){
		$result = '0';
		$vat =$resp->vat ;
		// $unit = $resp->units;
		// $token = $resp->token;
		$externalId = $resp->transactionId;
	}else{
		$resp = $tx->query($transaction_id);
		$resp = json_decode($resp);
		if($resp->responseCode == 200){
			$result = '0';
			$vat =$resp->vat; 
			$unit = $resp->units;
			$token = $resp->token;
			$externalId = $resp->transactionId;
		}
		else{
			$result = '99999999';
		}
	}
 //    $presentProvi
 //    $presentProvider = getPresentProvider($type, $mysqli);
 //    $pProvider = $presentProvider[0]['provider_id'];
 //    if($pProvider == 4){
	// require '/var/www/vhosts/api/vas/electricity/fet.php';
	// if(empty($customerphone)&& strlen($customerphone) < 2){
		
	// 	$customerphone = "09032878128";
	// 	}
		
	// 	if($type == 22){
	// 		$ret = callenugudc($amount,$destination,$transaction_id, 2,$customerphone,'POST',$customernumber);
	// 		$output = $ret;
	// 		$response = $ret;
	// 	}
		
	// 	if(is_array($ret)){
	// 		$vxdata = $ret;
	// 		if(isset($ret['success'])){
	// 			if($ret['success']== true){
	// 				$result = '0';
	// 				if(isset($ret['creditToken'])){
	// 					$token = $ret['creditToken'];
	// 				}
	// 			}
	// 			else {
	// 	$result = '99999999';
		
	// 	}
	// 		}
			
	// 	}
 //    }
 //    if($pProvider == 5){
 //        include '/var/www/vhosts/api/vas/electricity/shagoapi.php';
        
 //        if($type == 21){$meterType = "PREPAID";}
 //        if($type == 22){$meterType = "POSTPAID";}
 //        $content = array("request_id"=>$transaction_id,"amount"=>$amount,"address"=>$customeraddress, 
 //        "name"=>$customername,"serviceCode"=>"AOB","disco"=>"EEDC","meterNo"=>$account,"type"=>$meterType);
 //        $output = shagoApi($content);
 //        $response = $output;
 //        $resp = json_decode($output, true);
 //        if($resp['status']== 200){
 //            $result = '0';
 //            $token = $resp['token'];
 //            $unit = $resp['unit'];
 //            $transref = $resp['transId'];
 //        }else{
 //            $return = '99999999';
 //        }
 //    }
	

} 



//Abuja Prepaid
if($type == 24){
	error_log('AEDC',3,'vtu2_request.log');
	$presentProvider = getPresentProvider($type, $mysqli);
    $pProvider = $presentProvider[0]['provider_id'];
	if($pProvider == 3){
		// require '/var/www/vhosts/api/vas/electricity/req_abuja_electric.php';
		// $output = vend_abuja($destination, $amount, $customername, $customerphone);
		// $response = json_encode(mysqli_real_escape_string($mysqli, $output));
		// if($output['responseCode'] === 0){
		
		// 	$vendData = $output;
		// 	$message =  $vendData['details']['errorCode'];
		// 	$token = $vendData['confirmationCode'];
		// 	$unit = $vendData['unit'];
		// 	$transref= $vendData['transactionId'];

		// 	$result = 0;
		// }
		// else {
		// 	$result = '99999999';
		// 	$error  = $output['responseCode'] . '|' . $output['message'];		
		// }

		error_log("AEDC",3,'request.log');
		require '/var/www/vhosts/api/lib/serviceProvider/byPower.php';
		$tx = new ByPower();
		$data = ["account"=>$account,"type"=>$type, "amount"=>$amount, "transaction_id"=>$transaction_id];
		$output = $tx->VendMeter($data);
		$response = $output;
		error_log("AEDC".$response,3,'request.log');
		$out = json_decode($output, true);
		if($out['responseCode'] == 200){
			$token = $out['data']['token'];
			$unit = $out["data"]["unit"];
			$transref = $out["vendRef"];


			$result = 0;
		}
		else {
			$result = '99999999';
			$error  = $out['responseMessage'];		
		}

	}

	if($pProvider == 2){
		/*
		if($type==24){$meterType = "0";}
		if($type==25){$meterType = "2";}
		$payment = $amount * 100;
		$transactionid = "CPL-".$transaction_id;
		$account = $destination;
		require "/var/www/vhosts/api/vas/electricity/itex.php";
		$verify = api_call($requestABverify, "http://197.253.19.75:8029/vas/abuja/validation");
		$verify = json_decode($verify, true);
		$customernumber = $verify['productCode'];

		$requestABvend = array("wallet"=>WALLETID,
						"username"=>USERNAME,
						"password"=>PASSWORD,
						"requestType"=>"1",
						"meterType"=>$meterType,
						"meterNo"=>$account,
						"phone"=>"09032878128",
						"channel"=>CHANNEL,
						"amount"=>$payment,
						"pin"=>pin(),
						"productCode"=>$customernumber,
						"paymentMethod"=>"cash",
						"clientReference"=>$transactionid);
		$input = $requestABvend;
		$output =api_call($input, "http://197.253.19.75:8029/vas/abuja/payment");
		$response = $output;
		$output = json_decode($output, true);
		if($output['status'] == 1){
			$result = 0;
			$token = $output['token'];
			$unit = $output['units'];
			$transref = $output["transactionUniqueNumber"];
			$transref = $output["externalReference"];
		}
		else{
			$result = '99999999';
		}
		*/

		$transactionid = "CPL-".$transaction_id;
		require "/var/www/vhosts/api/secured/seamless/vend/newitex.php";
		//$output =api_call($requestIEvend, "http://vas.itexapp.com/vas/ie/purchase");
		$tx = new itexService($type);
		$payload = array("channel"=>$tx->channel,
								"meterNo" =>$account,
								"amount"=>strval($amount),
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

		$output = $tx->api_call($requestvend,"http://197.253.19.76:8019/api/v1/vas/electricity/payment");
		$response = $output;
		$output = json_decode($output, true);

		if($output['responseCode'] == "00"){
			$result = 0;
			$out = $output["data"];
			$token = $out['token'];
			$unit = $out['unit_value'].$out['unit'];
			$transref = $out["transactionUniqueNumber"];
		}
		else {
			$result = '99999999';
			$error = $tx->error;
			
			}
	}

}


//DSTV

	if($type == 30){
	require '/var/www/vhosts/api/vas/airVend/baxi/req_dstv.php';
	$json_data   = json_decode($output,true);
	$response = $output;
	if($json_data['details']['status'] == 'ACCEPTED') {	
	$result = '0';
	
} else {
	$result = '99999999';
	$error  = $json_data['code'] . '|' . $json_data['message'];		
}

}

//GOTV

if($type == 40){
	require '/var/www/vhosts/api/vas/airVend/baxi/req_gotv.php';
	$json_data   = json_decode($output,true);
	$response = $output;
	if($json_data['details']['status'] == 'ACCEPTED') {	
	$result = '0';
	
	} else {
	$result = '99999999';
	$error  = $json_data['code'] . '|' . $json_data['message'];		
	}

		}


//STARTIMES
if($type == 70){
	require '/var/www/vhosts/api/vas/airVend/baxi/req_startimes.php';
	$json_data   = json_decode($output,true);
	$response = $output;
		if($json_data['details']['status'] == 'ACCEPTED') {	
		$result = '0';
	
		} else {
			$result = '99999999';
		$error  = $json_data['details']['status'] . '|' . $json_data['details']['returnMessage'];		
		}

}


//SPECTRANET
if($type == 90){

	require '/var/www/vhosts/api/vas/airVend/baxi/req_spectranet.php';
	
                        $output = VendSpectranet($pincount, $amount, $pinvalue, $transaction_id);
                         $json_data = json_decode($output, true);
                         $response =$output;
	if ($json_data['details']['status'] == 'ACCEPTED') {
                            //if($json_data['details']['status'] == '0' ) {
                            $result = '0';
                        } else {
                            $result = '99999999';
                            $error = $json_data['code'] . '|' . $json_data['message'];
                        }

                    }
                          

//WAEC
if($type == 80){
	require '/var/www/vhosts/api/vas/airVend/baxi/req_waec.php';
	$response = $output;
	$json_data   = json_decode($output,true);
	if($json_data['details']['status'] == 'ACCEPTED') {	
	$result = '0';
	
	} else {
	$result = '99999999';
	$error  = $json_data['code'] . '|' . $json_data['message'];		
	}
				
}

//JAMB
if($type == 81){
	require '/var/www/vhosts/api/vas/electricity/req_abuja_electric.php';
	$output = vendJamb($account, $code, $amount, $transaction_id);
	$j   = json_decode($output,true);
	$response = $output;
	if($j['responseCode'] == 0){
    
    $result = 0;

	} else {
	$result = '99999999';
	$error  = $j['responseCode'] . '|' . $j['message'];		
	}

}

//SMILE RECHARGE
if($type == 50){
	require '/var/www/vhosts/api/vas/airVend/baxi/req_smile.php';
	$json_data   = json_decode($output,true);
	$response = $output;
						if($json_data['details']['status'] == 'ACCEPTED') {	
	$result = '0';
	
} else {
	$result = '99999999';
	$error  = $json_data['code'] . '|' . $json_data['message'];		
}

					
}


//SMILE BUNDLE
if($type == 60){

	require '/var/www/vhosts/api/vas/airVend/baxi/req_smilebundle.php';
	$response = $output;
	$json_data   = json_decode($output,true);					
	if($json_data['details']['status'] == 'ACCEPTED') {	
	$result = '0';
	
	} else {
	$result = '99999999';
		$error  = $json_data['code'] . '|' . $json_data['message'];		
	}
}

//BET9JA
if($type==100){

       require '/var/www/vhosts/api/vas/electricity/fet.php';

			$ret = callbet9ja($amount,$destination,$transaction_id,2);
			$output = $ret;
			$vxdata = $ret;
			$response = $output;
			print_r($ret);
			exit();
			if(isset($ret['success'])){
				if($ret['success']== true){
					$result = '0';
					if(isset($ret['creditToken'])){
						$token = $ret['creditToken'];
					}
				}
			}
			else {
	$result = '99999999';
	$error  = $json_data['code'] . '|' . $json_data['message'];		
}
}

