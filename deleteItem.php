<?php

	require "config.php";
	
	$response = file_get_contents('php://input');
	$IDnumber;
	
	function gettingIdAsInteger($fullID) {
		$numberAsString = substr($fullID, 9);
		$number = intval($numberAsString);
		return $number;
	}
	
	// CHECKING RESPONSE FOR SPECIFIC STRING - THEN REMOVING PROPER ITEM
	if (stripos($response,"Inc")) {
		$IDnumber = gettingIdAsInteger($response);
		
		$sql = "DELETE FROM przychody WHERE id='$IDnumber'";
		$stmt = $db_conn->prepare($sql);
		$stmt->execute();
	}
	
	if (stripos($response,"Exp")) {
		$IDnumber = gettingIdAsInteger($response);
		
		$sql = "DELETE FROM wydatki WHERE id='$IDnumber'";
		$stmt = $db_conn->prepare($sql);
		$stmt->execute();
	}
		
	if (stripos($response,"PM")) {
		$IDnumber = gettingIdAsInteger($response);
		
		$sql = "DELETE FROM sposoby_platnosci WHERE id='$IDnumber'";
		$stmt = $db_conn->prepare($sql);
		$stmt->execute();
	}	
	
	echo $response;

?>