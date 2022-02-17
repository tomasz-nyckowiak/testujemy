<?php

	require "config.php";
	
	$response = file_get_contents('php://input');
	$responseDecoded = json_decode($response);
	
	$methodID = $responseDecoded->data->id;
	$methodName = $responseDecoded->data->methodName;
			
	$sql = "SELECT method FROM sposoby_platnosci";
	$stmt = $db_conn->prepare($sql);
	$stmt->execute();
	
	$paymentMethods = [];
	
	if ($stmt->rowCount() > 0) {
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {						
			$pMethod = $row['method'];							
			array_push($paymentMethods, "$pMethod");		
		}		
	} else {
		echo "Brak metod płatności!";
	}
	
	$size = count($paymentMethods);
	
	require_once "validation.php";
	$result = inputNameValidation($methodID, $methodName, $paymentMethods, $size);

	if ($result == "OK") {
		$userInput = properFormat($methodName);
		
		$sql = "INSERT INTO sposoby_platnosci (method) VALUES ('$userInput')";
		$stmt = $db_conn->prepare($sql);
		$stmt->execute();	
		
		$sql = "SELECT id FROM sposoby_platnosci WHERE method='$userInput'";
		$stmt = $db_conn->prepare($sql);
		$stmt->execute();
		
		$tempArray = [];
		
		if ($stmt->rowCount() > 0) {
			$row = $stmt->fetch(PDO::FETCH_ASSOC);						
			$temp = $row['id'];		
			array_push($tempArray, "$temp", "$userInput");
		} else {
			echo "Brak metod płatności!";
		}		
		
		echo $tempArray[0].$tempArray[1];	
	} else echo $result;
	
?>