<?php

//include "../function/func.inc.php";
include "../function/db.inc.php";

function failure($networkid='', $type, $status, $mysqli)
{
	//Select error count from table
	$ty = "type = $type";
	if(!empty($networkid)){$ty = "type = $networkid";}

	$sql =  "SELECT * FROM failure_report WHERE $ty";
	$query = mysqli_query($mysqli, $sql);
	
	
	$row = mysqli_fetch_assoc($query);
	print_r($row["count"]);
	if($status == 0){
		$sql = "UPDATE failure_report SET count = 0 WHERE $ty";
		$query = mysqli_query($mysqli, $sql);
	}
	else{
		print_r($row);
		if($row['count'] < 5){
			$sql = "UPDATE failure_report SET count = count + 1 WHERE $ty";
			$query = mysqli_query($mysqli, $sql);
			print_r($query);
		}
		if($row['count'] >=5){
			$sql = "UPDATE failure_report SET count = 0 WHERE $ty";
			$query = mysqli_query($mysqli, $sql);

			//send Mail

			$service = $row['description'];
			$date =date('Y-m-d H:i:s');
			$message = "SERVICE DOWN TIME Suspected for {$service} at {$date} ";
			$message .= "Suspecte Time: {$date}";
			$subject = "DOWN TIME Suspected";

			$email = "michael@airvend.ng";
			
			sendMail($email, $subject, $message);
			callSlack($message);
		}
	}


}


 failure(1, 1, 12312, $mysqli);
