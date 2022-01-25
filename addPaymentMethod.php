<?php

	require "config.php";
	
	$response = file_get_contents('php://input');
	
	// WALIDACJA	
	$sql = "SELECT method FROM sposoby_platnosci";
	$stmt = $db_conn->prepare($sql);
	$stmt->execute();
	
	$paymentMethods = [];
	
	if ($stmt->rowCount() > 0) {
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {						
			$temp1 = $row['method'];							
			array_push($paymentMethods, "$temp1");			
		}		
	}
	
	$size = count($paymentMethods);
		
	$message = "";
	$err1 = "Nie wprowadzono poprawnej nazwy! (Nazwa nie może zawierać cyfr oraz znaków specjalnych!)";
	$err2 = "Taka metoda już istnieje!";
	
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
			
			// STEP 4 (Sprawdzamy, czy dana metoda już istnieje)
			for ($x = 0; $x < $size; $x++) {									
				if ($paymentMethods[$x] == $finalString)	{					
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
		$sql = "INSERT INTO sposoby_platnosci (method) VALUES ('$response')";
		$stmt = $db_conn->prepare($sql);
		$stmt->execute();	
		
		$sql = "SELECT id FROM sposoby_platnosci WHERE method='$response'";
		$stmt = $db_conn->prepare($sql);
		$stmt->execute();
		
		$tempArray = [];
		
		if ($stmt->rowCount() > 0) {
			$row = $stmt->fetch(PDO::FETCH_ASSOC);						
			$temp2 = $row['id'];		
			array_push($tempArray, "$temp2", "$response");
		} else {
			echo "Brak metod płatności!";
		}		
		echo $tempArray[0].$tempArray[1];
	}
	
?>