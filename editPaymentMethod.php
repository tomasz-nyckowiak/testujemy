<?php

	require "config.php";
	
	$response = file_get_contents('php://input');	
	$responseDecoded = json_decode($response);
	
	$paymentMethodID = $responseDecoded->data->id;
	$methodNewName = $responseDecoded->data->methodName;
	
	$numberAsString = substr($paymentMethodID, 7);	
	$number = intval($numberAsString);

	$sql = "SELECT method FROM sposoby_platnosci";
	$stmt = $db_conn->prepare($sql);
	$stmt->execute();
	
	$paymentMethods = [];
	
	if ($stmt->rowCount() > 0) {
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {						
			$pMethod = $row['method'];							
			array_push($paymentMethods, "$pMethod");	
		}		
	}
	
	$size = count($paymentMethods);
	
	require_once "validation.php";
	$result = inputNameValidation($paymentMethodID, $methodNewName, $paymentMethods, $size);

	if ($result == "OK") {
		$userInput = properFormat($methodNewName);
		
		$sql = "UPDATE sposoby_platnosci SET method='$userInput' WHERE id='$number'";
		$stmt = $db_conn->prepare($sql);
		$stmt->execute();
		
		echo $userInput;
	} else echo $result;

?>