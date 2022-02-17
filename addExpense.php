<?php

	require "config.php";
	
	$response = file_get_contents('php://input');
	$responseDecoded = json_decode($response);
	
	$expenseID = $responseDecoded->data->id;
	$expenseName = $responseDecoded->data->categoryName;
	$limit = $responseDecoded->data->limit;

	$sql = "SELECT name FROM wydatki";
	$stmt = $db_conn->prepare($sql);
	$stmt->execute();
	
	$expenses = [];
	
	if ($stmt->rowCount() > 0) {
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {						
			$expense = $row['name'];							
			array_push($expenses, "$expense");
		}		
	}
	
	$size = count($expenses);
	
	require_once "validation.php";
	$result = inputNameValidation($expenseID, $expenseName, $expenses, $size);
	
	if ($result == "OK") {
		$userInput = properFormat($expenseName);
		
		if ($limit == null) {
			$sql = "INSERT INTO wydatki (name) VALUES ('$userInput')";
			$stmt = $db_conn->prepare($sql);
			$stmt->execute();	
			
			$sql = "SELECT id FROM wydatki WHERE name='$userInput'";
			$stmt = $db_conn->prepare($sql);
			$stmt->execute();
			
			$tempArray = [];
			
			if ($stmt->rowCount() > 0) {
				$row = $stmt->fetch(PDO::FETCH_ASSOC);						
				$temp = $row['id'];		
				array_push($tempArray, "$temp", "$userInput");
			} else {
				echo "Brak kategorii!";
			}		
			echo $tempArray[0].$tempArray[1];
		} else {
			$sql = "INSERT INTO wydatki (name, amount_limit) VALUES ('$userInput', $limit)";
			$stmt = $db_conn->prepare($sql);
			$stmt->execute();	
			
			$sql = "SELECT id, amount_limit FROM wydatki WHERE name='$userInput'";
			$stmt = $db_conn->prepare($sql);
			$stmt->execute();
			
			$tempArray = [];
			
			if ($stmt->rowCount() > 0) {
				$row = $stmt->fetch(PDO::FETCH_ASSOC);						
				$temp1 = $row['id'];
				$temp2 = $row['amount_limit'];			
				array_push($tempArray, "$temp1", "$userInput", "$temp2");
			}		
			echo $tempArray[0].$tempArray[1].$tempArray[2];
		}		
	} else echo $result;

?>