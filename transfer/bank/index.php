<?php



include '../../header.php';
include '../function.php';
include '../providus.php';
include '../provider.php';
include '../lib/shagoPay.php';
//The Server IP Address


if($provider ==1){
	//Call Banks Payant

		$output = bankCall();
		$output = json_decode($output, TRUE);
		if($output['status'] == "success"){
			$status = TRUE;
			$data =$output['data'];
		}
	
}elseif($provider == 2){
	//Call Bank Providus
	$mx = new ProvidusTransfer;
	$output = $mx->getBankList();
	$output = json_decode($output, TRUE);
	if($output["responseCode"]=="00")
	{
		$status = TRUE;
		$data = $output['banks'];
	}

}else{
	$type = 1000;

$tx = new SHAGOAPI($type, 0);
$data  =  $tx->product();
$data = json_decode($data, true);

$response = [];


foreach($data as $d){
    $response[] = ["bankName"=>$d["name"], "bankCode"=>$d["bin"]];


}
	$status = TRUE;
	$data = $response;
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
