<?php
	
	require "config.php";
	
	// INCOMES
	$sql = "SELECT * FROM przychody";
	$stmt = $db_conn->prepare($sql);
	$stmt->execute();
	
	$incomesIDArray = [];
	$incomesArray = [];
	
	if ($stmt->rowCount() > 0) {
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$temp1 = $row['id'];
			$temp2 = $row['name'];
			array_push($incomesIDArray, "$temp1");
			array_push($incomesArray, "$temp2");
		}
	} else {
		echo "Brak kategorii!";
	}	
	
	$incomesArraySize = count($incomesArray);
	
	// EXPENSES
	$sql = "SELECT id, name, amount_limit FROM wydatki";
	$stmt = $db_conn->prepare($sql);
	$stmt->execute();
	
	$expensesIDArray = [];
	$expensesArray = [];
	$limitsArray = [];
	
	if ($stmt->rowCount() > 0) {
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {						
			$temp3 = $row['id'];
			$temp4 = $row['name'];
			$temp5 = $row['amount_limit'];
			array_push($expensesIDArray, "$temp3");				
			array_push($expensesArray, "$temp4");				
			if (is_null($temp5)) {
				$fuckingZero = 0;
				array_push($limitsArray, "$fuckingZero");
			} else {
				array_push($limitsArray, "$temp5");
			}							
		}
	} else {
		echo "Brak kategorii!";
	}
	
	$expensesArraySize = count($expensesArray);
	
	// PAYMENT METHODS
	$sql = "SELECT * FROM sposoby_platnosci";
	$stmt = $db_conn->prepare($sql);
	$stmt->execute();
	
	$paymentMethodsIDArray = [];
	$paymentMethodsArray = [];
	
	if ($stmt->rowCount() > 0) {
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {						
			$temp6 = $row['id'];
			$temp7 = $row['method'];			
			array_push($paymentMethodsIDArray, "$temp6");				
			array_push($paymentMethodsArray, "$temp7");										
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

<body>
	
	<div class="accordion" id="accordionExample">
		<div class="accordion-item">
			<h2 class="accordion-header" id="headingOne">
				<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">Kategorie przychodów</button>
			</h2>
			<div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">				
				<div class="accordion-body">
					<p>Edytuj istniejące kategorie:</p>
					<ul id="categoryListIncomes">						 														
						<?php								
							for ($x = 0; $x < $incomesArraySize; $x++) {									
								$i = $incomesIDArray[$x];								
								echo "<li id='itemInc$i'>";
								echo $incomesArray[$x];
								echo "<button type='button' class='edit' id='editInc$i'>Edytuj</button>";
								echo "<button type='button' class='delete' id='deleteInc$i'>Usuń</button>";
								echo "</li>";
							}
						?>						
					</ul>
					<!-- Button trigger modal -->
					<div class="mt-2">
						<button type="button" id="addInc" class="btn btn-primary add" data-bs-toggle="modal" data-bs-target="#addIncModal">
							Dodaj kategorię
						</button>
					</div>
				</div>
			</div>
		</div>
		<div class="accordion-item">
			<h2 class="accordion-header" id="headingTwo">
				<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">Kategorie wydatków</button>
			</h2>
			<div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
				<div class="accordion-body">
					<p>Edytuj istniejące kategorie:</p>
					<ul id="categoryListExpenses">						 														
						<?php								
							for ($x = 0; $x < $expensesArraySize; $x++) {									
								$j = $expensesIDArray[$x];
								echo "<li id='itemExp$j'>";
								echo $expensesArray[$x];
								echo "<button type='button' class='edit' id='editExp$j'>Edytuj</button>";
								echo "<button type='button' class='delete' id='deleteExp$j'>Usuń</button>";
								echo "<br>";
								if ($limitsArray[$x] != 0) {
									echo "Limit: " . $limitsArray[$x] . "<br>";
								}
								echo "</li>";
							}
						?>						
					</ul>
					<!-- Button trigger modal -->
					<div class="mt-2">
						<button type="button" id="addExp" class="btn btn-primary add" data-bs-toggle="modal" data-bs-target="#addExpModal">
							Dodaj kategorię
						</button>
					</div>
				</div>
			</div>
		</div>
		<div class="accordion-item">
			<h2 class="accordion-header" id="headingThree">
				<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">Metody płatności</button>
			</h2>
			<div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
				<div class="accordion-body">
					<p>Edytuj istniejące metody płatności:</p>
					<ul id="paymentsMethodsList">
						<?php								
							for ($x = 0; $x < $paymentMethodsArraySize; $x++) {									
								$k = $paymentMethodsIDArray[$x];
								echo "<li id='itemPMs$k'>";
								echo $paymentMethodsArray[$x];
								echo "<button type='button' class='edit' id='editPMs$k'>Edytuj</button>";
								echo "<button type='button' class='delete' id='deletePMs$k'>Usuń</button>";
								echo "<br>";								
							}
						?>
					</ul>
					<!-- Button trigger modal -->
					<div class="mt-2">
						<button type="button" id="addPM" class="btn btn-primary add" data-bs-toggle="modal" data-bs-target="#addPaymentMethodModal">
							Dodaj metodę płatności
						</button>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<button><a href="dodajwydatek.php">Dodaj wydatek</a></button>
	
	<!-- MODALS -->
	<!-- ADD NEW INCOME -->
	<div class="modal fade" id="addIncModal" tabindex="-1" aria-labelledby="addIncModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="addIncModalLabel">Dodawanie nowej kategorii przychodu</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body" id="addIncBody">					
					<div id="addIncomeSection">
						<div id="errorMessageAddInc"></div>
						<label for="inputNewIncome">Nazwa kategorii</label><br>
						<input type="text" name="inputNewIncome" id="inputNewIncome" onchange="incomeInput()"><br><br>
						<div class="mt-3">
							<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zamknij</button>
							<button type="button" class="btn btn-primary" onclick="addingNewIncome()">Zapisz</button>						
						</div>
					</div>	
				</div>				
			</div>
		</div>
	</div>
	
	<!-- ADD NEW EXPENSE -->
	<div class="modal fade" id="addExpModal" tabindex="-1" aria-labelledby="addExpModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="addExpModalLabel">Dodawanie nowej kategorii wydatku</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body" id="addExpBody">
					<div id="addExpenseSection">
						<div id="errorMessageAddExp"></div>
						<label for="inputNewExpense">Nazwa kategorii</label><br>
						<input type="text" name="inputNewExpense" id="inputNewExpense" onchange="expenseInput()"><br><br>
						<input type="checkbox" id="addCatLimit" name="addCatLimit" onclick="showHideAddLimitSection(this)">
						<label for="addCatLimit">Włącz limit dla kategorii</label><br>
						<div id="addLimit" style="display: none">
							<label for="quantity">Ustaw miesięczny limit wydatków dla kategorii</label><br>
							<input type="number" id="quantity" name="quantity" min="0.01" step="0.01">
						</div>
						<div class="mt-3">
							<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zamknij</button>
							<button type="button" class="btn btn-primary" onclick="addingNewExpense()">Zapisz</button>						
						</div>
					</div>	
				</div>				
			</div>
		</div>
	</div>
	
	<!-- ADD NEW PAYMENT METHOD -->
	<div class="modal fade" id="addPaymentMethodModal" tabindex="-1" aria-labelledby="addPaymentMethodModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="addPaymentMethodModalLabel">Dodawanie nowej metody płatności</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body" id="addPaymentMethodBody">
					<div id="addPaymentMethodSection">
						<div id="errorMessageAddPM"></div>
						<label for="inputNewPaymentMethod">Nazwa metody</label><br>
						<input type="text" name="inputNewPaymentMethod" id="inputNewPaymentMethod" onchange="paymentMethodInput()"><br><br>						
						<div class="mt-3">
							<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zamknij</button>
							<button type="button" class="btn btn-primary" onclick="addingNewMethod()">Zapisz</button>							
						</div>
					</div>	
				</div>				
			</div>
		</div>
	</div>
	
	<!-- EDIT INCOME -->	
	<div class="modal fade" id="editIncModal" tabindex="-1" aria-labelledby="editIncModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="editIncModalLabel">Edycja kategorii</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body" id="editIncomeBody">
					<div id="editIncomeSection">					
						<div id="errorMessageEditInc"></div>
						<label for="inputEditIncome">Nazwa kategorii</label><br>
						<input type="text" name="inputEditIncome" id="inputEditIncome" onchange="editIncomeInput()">
						<div class="mt-3">
							<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zamknij</button>
							<button type="button" class="btn btn-primary" onclick="saveChangesIncome()">Zapisz</button>
						</div>
					</div>
				</div>				
			</div>
		</div>
	</div>
	
	<!-- EDIT EXPENSE -->	
	<div class="modal fade" id="editExpModal" tabindex="-1" aria-labelledby="editExpModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="editExpModalLabel">Edycja kategorii</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body" id="editExpenseBody">
					<div id="editExpenseSection">					
						<div id="errorMessageEditExp"></div>
						<label for="inputEditExpense">Nazwa kategorii</label><br>
						<input type="text" name="inputEditExpense" id="inputEditExpense" onchange="editExpenseInput()"><br><br>					
						<input type="checkbox" id="editCatLimit" name="editCatLimit" onclick="showHideEditLimitSection(this)">
						<label for="editCatLimit">Włącz limit dla kategorii</label><br>
						<div id="editLimit" style="display: none">
							<label for="quantityEdit">Ustaw miesięczny limit wydatków dla kategorii</label><br>
							<input type="number" id="quantityEdit" name="quantityEdit" min="0.01" step="0.01">
						</div>
						<div class="mt-3">
							<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zamknij</button>
							<button type="button" class="btn btn-primary" onclick="saveChangesExpense()">Zapisz</button>
						</div>
					</div>
				</div>				
			</div>
		</div>
	</div>
	
	<!-- EDIT PAYMENT METHOD -->	
	<div class="modal fade" id="editPMModal" tabindex="-1" aria-labelledby="editPMModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="editPMModalLabel">Edycja metody płatności</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body" id="editPMBody">
					<div id="editPaymentMethodSection">
						<div id="errorMessageEditPM"></div>
						<label for="inputEditPM">Nazwa metody</label><br>
						<input type="text" name="inputEditPM" id="inputEditPM" onchange="editPMInput()">
						<div class="mt-3">
							<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zamknij</button>
							<button type="button" class="btn btn-primary" onclick="saveChangesPM()">Zapisz</button>
						</div>
					</div>
				</div>				
			</div>
		</div>
	</div>
	
	<!-- DELETE CATEGORY -->
	<div class="modal fade" id="deleteCatModal" tabindex="-1" aria-labelledby="deleteCatModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="deleteCatModalLabel">Usuwanie kategorii</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body" id="deleteCatBody">
					<div id="deleteCategorySection">
						<input type="hidden" name="delCatID" id="delCatID" value="">					
						<p>Usunięcie kategorii spowoduje utratę zapisanych w niej danych!</p>					
						<p>Czy kontynuować?</p>
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Nie</button>
						<button type="button" class="btn btn-primary" id="confirmDeleteCat">Tak</button>
					</div>					
				</div>				
			</div>
		</div>
	</div>
	
	<!-- DELETE PAYMENT METHOD -->
	<div class="modal fade" id="deletePMModal" tabindex="-1" aria-labelledby="deletePMModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="deletePMModalLabel">Usuwanie metody płatności</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body" id="deletePMBody">
					<div id="deletePaymentMethodSection">
						<input type="hidden" name="delPMiD" id="delPMiD" value="">				
						<p>Czy na pewno chcesz usunąć wybraną metodę płatności?</p>					
						<p>(Będzie już niedostępna przy dodawaniu nowego wydatku!)</p>
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Nie</button>
						<button type="button" class="btn btn-primary" id="confirmDeletePM">Tak</button>
					</div>					
				</div>				
			</div>
		</div>
	</div>
	
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
	
	<script src="./scripts/main.js"></script>
	<script src="./scripts/addInc.js"></script>
	<script src="./scripts/addExp.js"></script>
	<script src="./scripts/addPM.js"></script>
	<script src="./scripts/editInc.js"></script>
	<script src="./scripts/editExp.js"></script>
	<script src="./scripts/editPM.js"></script>
	<script src="./scripts/deleteItem.js"></script>
	
</body>
</html>