<?php

	require "config.php";
	
	$response = file_get_contents('php://input');
	
	// WALIDACJA	
	$sql = "SELECT name FROM przychody";
	$stmt = $db_conn->prepare($sql);
	$stmt->execute();
	
	$incomes = [];
	
	if ($stmt->rowCount() > 0) {
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {						
			$temp1 = $row['name'];							
			array_push($incomes, "$temp1");		
		}		
	} else {
		echo "Brak kategorii!";
	}
	
	$size = count($incomes);
		
	$message = "";
	$err1 = "Nie wprowadzono poprawnej nazwy! (Nazwa nie może zawierać cyfr oraz znaków specjalnych!)";
	$err2 = "Taka kategoria już istnieje!";
	
	$pattern = "/[^\p{L} -]/ui";
	$regexResult = preg_match($pattern, $response);
	
	// STEP 1 (Sprawdzamy, czy nazwa nie zawiera cyfr oraz znaków specjalnych)
	if ($regexResult == 1) {
		$allOK = false;
		$message = $err1;
		echo $message;
	} else {
		// STEP 2 (Sprawdzamy, czy nazwa nie jest pustym łańcuchem)
		if (empty($response)) {
		  $allOK = false;
		  $message = $err1;
		  echo $message;
		} else {
			// STEP 3 (Ustalamy odpowiedni format - pierwsza litera duża, reszta mała)
			$allSmall = strtolower($response);
			$finalString = ucfirst($allSmall);
			
			// STEP 4 (Sprawdzamy, czy dana kategoria już istnieje)
			for ($x = 0; $x < $size; $x++) {									
				if ($incomes[$x] == $finalString)	{					
					$allOK = false;
					$message = $err2;
					echo $message;
					break;
				} else {
					$allOK = true;
				}
			}			
		}		
	}
	
	if ($allOK) {
		$sql = "INSERT INTO przychody (name) VALUES ('$response')";
		$stmt = $db_conn->prepare($sql);
		$stmt->execute();
		
		$sql = "SELECT id FROM przychody WHERE name='$response'";
		$stmt = $db_conn->prepare($sql);
		$stmt->execute();
		
		$tempArray = [];
		
		if ($stmt->rowCount() > 0) {
			$row = $stmt->fetch(PDO::FETCH_ASSOC);						
			$temp2 = $row['id'];	
			array_push($tempArray, "$temp2", "$response");
		} else {
			echo "Brak kategorii!";
		}		
		echo $tempArray[0].$tempArray[1];
	}	

?>