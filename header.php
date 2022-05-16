<?php

error_reporting(~E_ALL);
ini_set('display_errors', 1); 

include 'function/db.inc.php';
include 'function/func.inc.php';
include 'function/json_func.php';


//The Server IP Address



$request_ip         = print_r($_SERVER['REMOTE_ADDR'],1);

//Treating the headers
$query_st = getallheaders();

$user = $query_st['Username'];
$pass = $query_st['Password'];
$hash = $query_st['Hash'];

//Getting the content
$data= file_get_contents('php://input');



//Verify Server Request Method
if($_SERVER['REQUEST_METHOD'] != "POST"){
	$response['status'] = 405;
	vend_response($response);
}

//Get If Vendor Exist now Includes IP Address.
//First Level Verification
$pass = get_Password($pass);


$vendor = getVendorAuth($user,$pass,$mysqli);
//print_r(mysqli_error($mysqli));
//exit();

$date = date("Y-m-d H:i:s");
$log_string = "\n***********************************\n\n" . $date.$hash.'REQUEST: ' . $request_ip .
                                "\n" . 'user: ' . $user ."\n".$pass.
                                "\n\n";

error_log($log_string,3,'/var/www/vhosts/api/secured/seamless/vend/request.log');

$date = date('Y-m-d');
if($vendor === FALSE) {
	$response['status'] = 401;
	$response['message'] = "Failed First Level Verification";

        $log_string = "\n\n" . $date .' AUTH FAILED: ' . $user  .  "\n\n";
        error_log($log_string,3,'/var/www/vhosts/api/secured/seamless/vend/request.log');
       vend_response($response);
}

//Second Level Verification
// $ipaddress = ipaddress($vendor['linked_id'],$request_ip,$mysqli);
// if($ipaddress == FALSE){
// 	$response['status'] = 403;
// 	$response['message'] = "Failed Second Level Verification";
// 	vend_response($response);
// }

//Test Hashing with hashing Key
$test = $data.$vendor['hash_key'];
$test = hash('sha512', $test);
if($test != $hash){
$response['status'] = 401;
	$response['message'] = "Failed Third Level Verification";
	vend_response($response);
}

$input= file_get_contents('php://input');
$data = json_decode($input, true);

$date = date("Y-m-d H:i:s");
$log_string = "\n***********************************\n\n" . $date." :" .json_encode($vendor)."\n\n Data: ".$input;

error_log($log_string,3,'/var/www/vhosts/api/secured/seamless/vend/request.log');