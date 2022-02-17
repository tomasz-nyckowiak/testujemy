<?php

	require "config.php";
	
	$response = file_get_contents('php://input');
	$responseDecoded = json_decode($response);
	
	$incomeID = $responseDecoded->data->id;
	$incomeName = $responseDecoded->data->categoryName;
		
	$sql = "SELECT name FROM przychody";
	$stmt = $db_conn->prepare($sql);
	$stmt->execute();
	
	$incomes = [];
	
	if ($stmt->rowCount() > 0) {
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {						
			$income = $row['name'];							
			array_push($incomes, "$income");		
		}		
	} else {
		echo "Brak kategorii!";
	}
	
	$size = count($incomes);
	
	require_once "validation.php";
	$result = inputNameValidation($incomeID, $incomeName, $incomes, $size);
	
	if ($result == "OK") {
		$userInput = properFormat($incomeName);
		
		$sql = "INSERT INTO przychody (name) VALUES ('$userInput')";
		$stmt = $db_conn->prepare($sql);
		$stmt->execute();
		
		$sql = "SELECT id FROM przychody WHERE name='$userInput'";
		$stmt = $db_conn->prepare($sql);
		$stmt->execute();
		
		$tempArray = [];
		
		if ($stmt->rowCount() > 0) {
			$row = $stmt->fetch(PDO::FETCH_ASSOC);						
			$temp = $row['id'];	
			array_push($tempArray, "$temp", "$userInput");
		}
		echo $tempArray[0].$tempArray[1];	
	} else echo $result;

?>