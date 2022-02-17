// GLOBALS
const msgError = "Nie wprowadzono poprawnej nazwy! (Nazwa nie może zawierać cyfr oraz znaków specjalnych!)";
const msgCategoryExistsError = "Taka kategoria już istnieje!";
const msgMethodExistsError = "Taka metoda już istnieje!";
let IdToRemember = "";

$(document).ready(function() {
	// FOCUSING ON INPUT AFTER OPENING A MODAL
	$("#addIncModal").on('shown.bs.modal', function() {
		$(this).find('#inputNewIncome').focus();
	});
	
	$("#addExpModal").on('shown.bs.modal', function() {
		$(this).find('#inputNewExpense').focus();
	});
	
	$("#addPaymentMethodModal").on('shown.bs.modal', function() {
		$(this).find('#inputNewPaymentMethod').focus();
	});
	
	$("#editIncModal").on('shown.bs.modal', function() {
		$(this).find('#inputEditIncome').focus();
	});
	
	$("#editExpModal").on('shown.bs.modal', function() {
		$(this).find('#inputEditExpense').focus();
	});
	
	$("#editPMModal").on('shown.bs.modal', function() {
		$(this).find('#inputEditPM').focus();
	});
	
	// AFTER CLOSING A MODAL
	$('#addIncModal').on('hidden.bs.modal', function(e) {
		$("#addIncBody").load("default_Content.html #addIncomeSection");							
	});
	
	$('#addExpModal').on('hidden.bs.modal', function(e) {
		$("#addExpBody").load("default_Content.html #addExpenseSection");							
	});
	
	$('#addPaymentMethodModal').on('hidden.bs.modal', function(e) {
		$("#addPaymentMethodBody").load("default_Content.html #addPaymentMethodSection");							
	});
	
	$('#editIncModal').on('hidden.bs.modal', function(e) {
		$("#editIncomeBody").load("default_Content.html #editIncomeSection");							
	});
	
	$('#editExpModal').on('hidden.bs.modal', function(e) {
		$("#editExpenseBody").load("default_Content.html #editExpenseSection");							
	});
	
	$('#editPMModal').on('hidden.bs.modal', function(e) {
		$("#editPMBody").load("default_Content.html #editPaymentMethodSection");							
	});
	
	$('#deleteCatModal').on('hidden.bs.modal', function(e) {
		$("#deleteCatBody").load("default_Content.html #deleteCategorySection");
	});
	
	$('#deletePMModal').on('hidden.bs.modal', function(e) {
		$("#deletePMBody").load("default_Content.html #deletePaymentMethodSection");
	});
	
});

// NAME VALIDATION
function checkingIfNameIsValid(response) {
	let isValid;
    
    if (response == msgError || response == msgCategoryExistsError || response == msgMethodExistsError) {
    	isValid = false;    
    } else isValid = true;
	
	return isValid;
}

// GETTING NAME
function nameOfItem(response) {
	let itemName = "";
	let pattern = /\D/g;
	let result = response.match(pattern);
	let length = result.length;
	for (let i=0; i<length; i++) {
		itemName += result[i];
	}
	
	return itemName;
}

// GETTING ID NUMBER
function itemIdNumber(response) {
	let pattern = /\d+/u;
	let result = response.match(pattern);
	let idNumber = result.join("");
	
	return idNumber;
}

// ADD ITEM SECTION
let addBtns = document.getElementsByClassName("add");

for (let i = 0; i < addBtns.length; i++) {
	addBtns[i].addEventListener("click", function(e) {
		let clickedButtonId = e.target.id;
		IdToRemember = clickedButtonId;
	});
}

// EDIT & DELETE INCOME
function focusWithIncValue(fullID) {
	let idNumber = itemIdNumber(fullID);
	let lookedListLine = "itemInc"+idNumber;			
	let item = document.getElementById(lookedListLine);
	let previousName = item.childNodes[0].nodeValue;
	
	document.getElementById("inputEditIncome").value = previousName;			
}

document.getElementById("categoryListIncomes").addEventListener("click", function(e) {
	let clickedButtonId = e.target.id;	
	let isItEdit = clickedButtonId.includes("edit");
	let isItDelete = clickedButtonId.includes("delete");
	
	if (isItEdit) {
		IdToRemember = clickedButtonId;
		$('#editIncModal').modal('show');					
		focusWithIncValue(IdToRemember);
	}
	
	if (isItDelete) {
		IdToRemember = clickedButtonId;
		$('#deleteCatModal').modal('show');
	}
});

// EDIT & DELETE EXPENSE
function gettingLimitAmount(amount) {
	let pattern = /\d/g;
	let result = amount.match(pattern);
	let num = result.join("");
	let strLength = num.length;
	let littleMath = strLength-2;
	let part1 = num.slice(0, littleMath);
	let part2 = num.slice(littleMath, strLength);

	if (num[strLength-1] == "0") {	
		if (num[strLength-2] == "0") {
			let finalResult = parseInt(part1);
			return finalResult;
		} else {
			let editedAmount = part1+"."+part2;
			let part3 = editedAmount.slice(0, -1);
			let finalResult = parseFloat(part3);
			return finalResult;
		}
	} else {    
		let editedAmount = part1+"."+part2;
		let finalResult = parseFloat(editedAmount);
		return finalResult;
	}
}

function focusWithExpValue(fullID) {
	let idNumber = itemIdNumber(fullID);	
	let lookedListLine = "itemExp"+idNumber;			
	let item = document.getElementById(lookedListLine);
	let itemNodesLength = item.childNodes.length;	
	let previousName = item.childNodes[0].nodeValue;
	
	document.getElementById("inputEditExpense").value = previousName;
	
	// LIMIT EXISTS
	if (itemNodesLength > 4) {
		document.getElementById("editCatLimit").checked = true;
		 document.getElementById("editLimit").style.display = "block";
		
		let existingLimitAmount = item.childNodes[4].nodeValue;
		
		// SETTING LIMIT AMOUNT
		let amount = gettingLimitAmount(existingLimitAmount);
		document.getElementById("quantityEdit").value = amount;
	}		
}

document.getElementById("categoryListExpenses").addEventListener("click", function(e) {
	let clickedButtonId = e.target.id;	
	let isItEdit = clickedButtonId.includes("edit");
	let isItDelete = clickedButtonId.includes("delete");
	
	if (isItEdit) {
		IdToRemember = clickedButtonId;
		$('#editExpModal').modal('show');					
		focusWithExpValue(IdToRemember);
	}
	
	if (isItDelete) {
		IdToRemember = clickedButtonId;
		$('#deleteCatModal').modal('show');
	}
});

// EDIT & DELETE PAYMENT METHOD
function focusWithPMValue(fullID) {
	let idNumber = itemIdNumber(fullID);
	let lookedListLine = "itemPMs"+idNumber;			
	let item = document.getElementById(lookedListLine);
	let previousName = item.childNodes[0].nodeValue;
	
	document.getElementById("inputEditPM").value = previousName;			
}

document.getElementById("paymentsMethodsList").addEventListener("click", function(e) {
	let clickedButtonId = e.target.id;
	let isItEdit = clickedButtonId.includes("edit");
	let isItDelete = clickedButtonId.includes("delete");
	
	if (isItEdit) {
		IdToRemember = clickedButtonId;
		$('#editPMModal').modal('show');					
		focusWithPMValue(IdToRemember);
	}
	
	if (isItDelete) {
		IdToRemember = clickedButtonId;
		$('#deletePMModal').modal('show');		
	}
});
