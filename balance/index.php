<?php

include '../header.php';




if($vendor['user_type'] == 1) {
		// PRE PAID

		// Check Available CREDIT
		// Check for auto top up <- check distributor account
		$vendor_credit = getVendorBalance($vendor['vendor_id'],$mysqli);
			
		$output =  round($vendor_credit,2);
		$response['status'] = 200;
		$response['message'] = "Balance Enquiry Successful";
		$response['Balance'] = $output;
		vend_response($response);

} 

// TODO - Postpaid: calculate balance due for account
