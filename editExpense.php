<?php

	require "config.php";
	
	$response = file_get_contents('php://input');	
	$responseDecoded = json_decode($response);
	
	$expenseID = $responseDecoded->data->id;
	$expenseNewName = $responseDecoded->data->categoryName;
	$limit = $responseDecoded->data->limit;
	$limitExists = $responseDecoded->data->limitExists;
	
	$numberAsString = substr($expenseID, 7);	
	$number = intval($numberAsString);

	$sql = "SELECT name FROM wydatki";
	$stmt = $db_conn->prepare($sql);
	$stmt->execute();
	
	$arrayExpenses = [];
	
	if ($stmt->rowCount() > 0) {
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {						
			$category = $row['name'];														
			array_push($arrayExpenses, "$category");	
		}		
	}
	
	$size = count($arrayExpenses);
	
	require_once "validation.php";
	$result = inputNameValidation($expenseID, $expenseNewName, $arrayExpenses, $size);
	
	$catAlreadyExists = "Taka kategoria już istnieje!";
	
	if ($result == "OK") {
		$userInput = properFormat($expenseNewName);
		
		if ($limit == null) {
			$sql = "UPDATE wydatki SET name='$userInput' WHERE id='$number'";
			$stmt = $db_conn->prepare($sql);
			$stmt->execute();
			
			echo $userInput;
		} else {
			$sql = "UPDATE wydatki SET name='$userInput', amount_limit='$limit' WHERE id='$number'";		
			$stmt = $db_conn->prepare($sql);
			$stmt->execute();
			
			echo $userInput.$limit;	
		}
		
	} else if ($result == $catAlreadyExists) {		
		$userInput = properFormat($expenseNewName);
		
		// THE SAME NAME WILL BE VALID IF:
		// LIMIT EXISTED BEFORE AND USER WANTS TO REMOVE IT FROM CATEGORY
		// OR USER WANTS TO CHANGE AMOUNT LIMIT  
		if ($limit == null) {
			if ($limitExists) {
				// CHANGE LIMIT AMOUNT TO NULL BUT CATEGORY NAME STAYS THE SAME			
				$sql = "UPDATE wydatki SET amount_limit=NULL WHERE id='$number'";
				$stmt = $db_conn->prepare($sql);
				$stmt->execute();
				
				echo $userInput;
			} else {
				echo $result;
			}			
		} else {
			// CHANGE LIMIT AMOUNT BUT CATEGORY NAME STAYS THE SAME			
			$sql = "UPDATE wydatki SET amount_limit='$limit' WHERE id='$number'";
			$stmt = $db_conn->prepare($sql);
			$stmt->execute();
			
			echo $userInput.$limit;
		}
	} else echo $result;

?>