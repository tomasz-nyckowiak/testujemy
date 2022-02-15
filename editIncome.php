<?php

	require "config.php";
	
	$response = file_get_contents('php://input');	
	$responseDecoded = json_decode($response);
	
	$incomeID = $responseDecoded->data->id;
	$incomeNewName = $responseDecoded->data->categoryName;
	
	$numberAsString = substr($incomeID, 7);	
	$number = intval($numberAsString);

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
	$result = inputNameValidation($incomeID, $incomeNewName, $incomes, $size);
	
	if ($result == "OK") {
		$userInput = properFormat($incomeNewName);
		
		$sql = "UPDATE przychody SET name='$userInput' WHERE id='$number'";
		$stmt = $db_conn->prepare($sql);
		$stmt->execute();
		
		echo $userInput;
	} else echo $result;

?>