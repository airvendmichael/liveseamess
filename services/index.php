<?php
include '../header.php';

function services($mysqli){
$query = "SELECT service_name, type_id, network_id, product, verify FROM service";
$result = mysqli_query($mysqli, $query);
 while($res = mysqli_fetch_assoc($result)){
 	$array[]= array("Service" => $res['service_name'],
 					"Type" => $res['type_id'],
 					"NetworkID" => $res['network_id'],
 					"Product" => $res['product'],
					"verify" => $res['verify']);
 
 }
 return $array;
}

if($vendor['user_type'] == 1) { 
		// PRE PAID

		// Check Available CREDIT
		// Check for auto top up <- check distributor account
		$response['status'] = 200;
		$response['message'] = services($mysqli);
		
		vend_response($response);

} 

// TODO - Postpaid: calculate balance due for account
