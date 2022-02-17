<?php
	
	function properFormat($userInput) {
		$allSmall = mb_strtolower($userInput, 'UTF-8');
		$finalResult = ucfirst($allSmall);
		
		return $finalResult;
	}
	
	function checkingTypeOfInput($ID) {				
		if (stripos($ID,"PM")) {
			$isItMethod = true;
		} else $isItMethod = false;
		
		return $isItMethod;
	}
	
	function inputNameValidation($ID, $name, $array, $arraySize) {		
		$message = "";
		$err1 = "Nie wprowadzono poprawnej nazwy! (Nazwa nie może zawierać cyfr oraz znaków specjalnych!)";
		
		if (checkingTypeOfInput($ID)) {
			$err2 = "Taka metoda już istnieje!";
		} else $err2 = "Taka kategoria już istnieje!";
		
		$valid = "OK";
		
		$pattern = "/[^\p{L} -]/ui";
		$regexResult = preg_match($pattern, $name);
		
		// CHECKING NAME FOR DIGITS AND SPECIAL CHARACTERS
		if ($regexResult == 1) {
			$message = $err1;
		} else {
			// CHECKING IF NAME ISN'T EMPTY STRING
			if (empty($name)) {
			  $message = $err1;
			} else {			
				// SETTING PROPER FORMAT FOR USER INPUT			
				$userInput = properFormat($name);
				
				// CHECKING IF CATEGORY/METHOD ALREADY EXISTS
				for ($x = 0; $x < $arraySize; $x++) {									
					if ($array[$x] == $userInput) {
						$message = $err2;
						break;
					} else {
						$message = $valid;
					}
				}			
			}		
		}
		
		return $message;
	}
?>