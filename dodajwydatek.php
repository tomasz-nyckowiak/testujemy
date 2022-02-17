<?php

	include "config.php";	
	
	$sql = "SELECT * FROM wydatki";
	$stmt = $db_conn->prepare($sql);
	$stmt->execute();
	
	$expensesIDArray = [];
	$expensesArray = [];
	$limitsArray = [];
	$amountsArray = [];

	if ($stmt->rowCount() > 0) {
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {						
			$expId = $row['id'];
			$expName = $row['name'];
			$expLimit = $row['amount_limit'];
			$expAmount = $row['amount'];
			array_push($expensesIDArray, "$expId");				
			array_push($expensesArray, "$expName");				
			array_push($amountsArray, "$expAmount");							
			if (is_null($expLimit)) {
				$fuckingZero = 0;
				array_push($limitsArray, "$fuckingZero");
			} else {
				array_push($limitsArray, "$expLimit");
			}							
		}
	} else {
		echo "Brak kategorii!";
	}
	
	$expensesArraySize = count($expensesArray);
	
	// PAYMENT METHODS
	$sql = "SELECT method FROM sposoby_platnosci";
	$stmt = $db_conn->prepare($sql);
	$stmt->execute();

	$paymentMethodsArray = [];
	
	if ($stmt->rowCount() > 0) {
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$PMname = $row['method'];			
			array_push($paymentMethodsArray, "$PMname");										
		}
	} else {
		echo "Brak metod platności!";
	}
	
	$paymentMethodsArraySize = count($paymentMethodsArray);
?>

<!DOCTYPE HTML>
<html lang="pl">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">	
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
		
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
		<link rel="stylesheet" href="./css/style.css" type="text/css">
		
	</head>
	<!--<body onload="displayData()">-->
	<body>

	<div class="container">
		
		<div>
			<div class="row mt-5">
				<p id="infoAboutLimit">Informacja o limicie: Wpisz kwotę</p>			
			</div>
		</div>
		
		<div id="limitDetails" style="display: none;">
			<div class="floatThisShit" style="float: left; padding-right: 10px;">
				Limit:
				<p id="detailNR1"></p>
			</div>
			<div class="floatThisShit" style="float: left; padding-right: 10px;">
				Dotychczas wydano:
				<p id="detailNR2"></p>
			</div>
			<div class="floatThisShit" style="float: left; padding-right: 10px;">
				Wpisana kwota:
				<p id="detailNR3"></p>
			</div>
			<div class="floatThisShit" style="float: left; padding-right: 10px;">
				Wydatki+Wpisana kwota:
				<p id="detailNR4"></p>
			</div>
			<div class="floatThisShit">
				Różnica:
				<p id="detailNR5"></p>
			</div>
		</div>
		
		<div class="row mt-5 form">					
			<form action="dodanowydatek.php" method="POST">					
				<div class="row my-1 p-2">					
					<div class="col-auto">
						<label for="inputAmount" class="col-form-label">Kwota:</label>
					</div>					
					<div class="col-auto">
						<input type="number" name="expenseAmount" id="inputAmount" class="form-control" min="0.01" step="0.01" onchange="addingAmount()" required>
					</div>					
				</div>
				
				<div class="row my-1 p-2">					
					<div class="col-auto">
						<label for="inputDate" class="col-form-label">Data:</label>
					</div>					
					<div class="col-auto">
						<input type="date" name="expenseDate" value="<?php echo date('Y-m-d');?>" id="inputDate" class="form-control" required>
					</div>					
				</div>
				
				<div class="row my-1 p-2">
					<div class="col-auto">
						<label for="payments" class="col-form-label">Sposób płatności:</label>
					</div>						
					<div class="col-auto">
						<select class="form-select" id="payments" name="paymentsMethods" aria-label="Sposób płatności">
							<?php
								for ($x = 0; $x < $paymentMethodsArraySize; $x++) {
									echo "<option name='paymentOptions' value='$paymentMethodsArray[$x]'>$paymentMethodsArray[$x]</option>";
								}								
							?>
						</select>							
					</div>					
				</div>

				<fieldset class="row my-1 p-2">					
					<legend class="col-form-label">Kategoria:</legend>				
					<div class="col-auto">						
						<div class="form-check">
							<?php
								for ($y = 0; $y < $expensesArraySize; $y++) {
									$ID = $expensesIDArray[$y];
									echo "<input class='form-check-input' type='radio' name='gridRadios' id='gridRadios$ID' value='$expensesArray[$y]'>";
									echo "<label class='form-check-label' for='gridRadios$ID'>$expensesArray[$y]</label>";
									echo "<br>";
									if ($limitsArray[$y] != 0) {
										echo "Limit: " . $limitsArray[$y] . "<br>";
									}
								}
							?>
						</div>												
					</div>			
				</fieldset>
				
				<div class="row my-1 p-2">				
					<div class="col-auto">						
						<label for="CommentForExpense" class="col-form-label">Komentarz (opcjonalnie):</label>
						<textarea class="form-control" name="expComment" id="CommentForExpense" rows="3" cols="60" minlength="10"></textarea>
					</div>				
				</div>				
				
				<div class="row my-1 p-2">					
					<div class="d-flex justify-content-start">						
						<input type="submit" value="Dodaj wydatek">
					</div>								
				</div>	

				<div class="row my-1 p-2">				
					<div class="d-flex justify-content-end">						
						<input class="btn btn-light" id="resetFormButton" type="reset" value="Wyczyść">
					</div>				
				</div>				
			</form>				
		</div>
		
	</div>
	
	<script type="text/javascript">
		
		const justInfo0 = "Informacja o limicie: Wpisz kwotę";
		const justInfo1 = "Informacja o limicie: Brak ustawionego limitu!";
		const justInfo2 = "Informacja o limicie: Nie wybrano kategorii";
		let clickedRadioButton = "";
		let wasClicked = false;

		function amountInput() {
			let myInput = document.getElementById("inputAmount").value;			
			return myInput;
		}
		
		function forProperShowing(myString) {
			let attachment = "";
			let result = "";
			let isThereDot = myString.includes(".");
			
			if (isThereDot) {
				// CHECKING LENGTH OF STRING AFTER THE DOT
				let dotPosition = myString.indexOf(".");
				let partOfTheStringAfterDot = myString.substr(dotPosition+1);
				let afterTheDecimalPoint = partOfTheStringAfterDot.length;
				
				if (afterTheDecimalPoint == 1) {
					attachment = "0"; // WE NEED TO ADD THIS ATTACHMENT (FOR PROPER DATA SHOWING ON THE PAGE)
					result = myString+attachment;
				} else result = myString;
			} else {
				attachment = ".00";
				result = myString+attachment;
			}
			return result;
		}
		
		function convertStrToNum(myString) {
			let result = parseFloat(myString);
			return result;
		}
		
		function convertNumToStr(myNum) {
			let myString = myNum.toString();
			return myString;
		}

		function details(limitAmount, expense, amount, result1, result2) {
			document.getElementById("limitDetails").removeAttribute("style");
			document.getElementById("detailNR1").innerHTML = limitAmount;
			document.getElementById("detailNR2").innerHTML = expense;
			document.getElementById("detailNR3").innerHTML = amount;
			document.getElementById("detailNR4").innerHTML = result1;
			document.getElementById("detailNR5").innerHTML = result2;			
		}

		function addingAmount() {			
			let amount = amountInput();
			let limitAmount = 0;
			let expense = 0;
			let limitExists = true;
			
			// CHECKING IF AMOUNT DOESN'T CROSS LIMIT
			const arrayCategories = <?php echo json_encode($expensesArray); ?>;
			const arrayLimits = <?php echo json_encode($limitsArray); ?>;
			const arrayAmounts = <?php echo json_encode($amountsArray); ?>;
			
			let list = arrayCategories.length;
			
			for (let i = 0; i < list; i++) {
				if (arrayCategories[i] == clickedRadioButton) {
					if (arrayLimits[i] != 0) {
						limitAmount = arrayLimits[i];
						expense = arrayAmounts[i];
						break;
					}
					else {
						limitExists = false;
					}
				}
			}
			
			if (limitExists) {				
				let dtl3 = forProperShowing(amount);
				
				// CONVERTING STRINGS TO FLOATS
				let kwota0 = convertStrToNum(limitAmount);
				let kwota1 = convertStrToNum(expense);
				let kwota2 = convertStrToNum(dtl3);				
				
				let result1 = kwota1 + kwota2; // Wydatki+Wpisana kwota as FLOAT
				let step1 = convertNumToStr(result1);				
				let dtl4 = forProperShowing(step1);
				
				let result2 = kwota0 - result1; // Różnica (Limit - (Wydatki+Wpisana kwota))
				let finalResult = parseFloat(result2).toFixed(2);
				let step2 = convertNumToStr(finalResult);				
				let dtl5 = forProperShowing(step2);
				
				if (amount === "") {
					document.getElementById('infoAboutLimit').innerHTML = justInfo0;
				} else {
					if (wasClicked) {
						if (finalResult < 0) {
							let temp = finalResult.substr(1); // REMOVING MINUS SIGN
							let justInfo3 = "Informacja o limicie: Przekroczono limit w kategorii "+clickedRadioButton+" o "+temp+" zł";
							document.getElementById('infoAboutLimit').innerHTML = justInfo3;
							details(limitAmount, expense, dtl3, dtl4, dtl5); // SHOWING ON THE PAGE
							document.getElementById("limitDetails").style.backgroundColor = "darkred";
							
						} else {
							let justInfo3 = "Informacja o limicie: Możesz jeszcze wydać "+finalResult+" zł w kategorii "+clickedRadioButton;
							document.getElementById('infoAboutLimit').innerHTML = justInfo3;
							details(limitAmount, expense, dtl3, dtl4, dtl5); // SHOWING ON THE PAGE
							document.getElementById("limitDetails").style.backgroundColor = "green";
						}
					}
					else {
						document.getElementById('infoAboutLimit').innerHTML = justInfo2;
						document.getElementById("limitDetails").setAttribute("style","display:none");
					}
				}
			}
			else {
				document.getElementById('infoAboutLimit').innerHTML = justInfo1;
				document.getElementById("limitDetails").setAttribute("style","display:none");
			}									
		}

		$(document).ready(function() {
			$('input:radio[name="gridRadios"]').change(function() {
				clickedRadioButton = $(this).val();
				wasClicked = true;
				addingAmount();				
			});			
		});

		$(document).on("click", "#resetFormButton", function(event) {
			document.getElementById('infoAboutLimit').innerHTML = justInfo0;
			wasClicked = false;
			document.getElementById("limitDetails").setAttribute("style","display:none");
		});

	</script>
	
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>	

	</body>
</html>