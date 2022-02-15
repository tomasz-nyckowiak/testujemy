// GLOBALS
const msgError = "Nie wprowadzono poprawnej nazwy! (Nazwa nie może zawierać cyfr oraz znaków specjalnych!)";
const msgCategoryExistsError = "Taka kategoria już istnieje!";
const msgMethodExistsError = "Taka metoda już istnieje!";
let IdToRemember = "";

// FOCUSING ON INPUT AFTER OPENING A MODAL
$(document).ready(function() {
	$("#itemModal").on('shown.bs.modal', function() {
		let inputs = document.getElementsByTagName("input");
		
		for (let i = 0; i < inputs.length; i++) {
			if (inputs[i].type == 'text') {
				inputs[i].focus();
				break;
			}
		}
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
		showingProperModal(IdToRemember);
	});
}

function showingProperModal(btnId) {
	if (btnId == "addInc") {
		$("#itemModalLabel").load("addIncome.html #addIncTitle");
		$("#itemBody").load("addIncome.html #addIncomeBody");
	}
	
	if (btnId == "addExp") {
		$("#itemModalLabel").load("modals.html #addExpTitle");
		$("#itemBody").load("modals.html #addExpenseBody");
	}
	
	if (btnId == "addPM") {
		$("#itemModalLabel").load("modals.html #addPMTitle");
		$("#itemBody").load("modals.html #addPaymentMethodBody");
	}
	
	$('#itemModal').modal('show');
}

// EDIT ITEM SECTION
let editBtns = document.getElementsByClassName("edit");

for (let i = 0; i < editBtns.length; i++) {
	editBtns[i].addEventListener("click", function(e) {
		let clickedButtonId = e.target.id;
		IdToRemember = clickedButtonId;
		showingProperEditingModal(IdToRemember);
	});
}

function focusWithValueInc(fullID) {
	let idNumber = itemIdNumber(fullID);
	let lookedListLine = "itemInc"+idNumber;			
	let item = document.getElementById(lookedListLine);
	let previousName = item.childNodes[0].nodeValue;
	document.getElementById("inputEditIncome").value = previousName;			
}

function showingProperEditingModal(btnId) {
	let editedID = btnId.slice(0, 7); //CUTTING OUT NAME
	
	if (editedID == "editInc") {
		$("#itemModalLabel").load("editIncome.html #editCatTitle");
		$("#itemBody").load("editIncome.html #editIncomeBody");		
	}

	if (editedID == "editExp") {
		$("#itemModalLabel").load("modals.html #editCatTitle");
		$("#itemBody").load("modals.html #editExpenseBody");
	}

	if (editedID == "editPMs") {
		$("#itemModalLabel").load("modals.html #editPMTitle");
		$("#itemBody").load("modals.html #editPaymentMethodBody");
	}
	
	$('#itemModal').modal('show');
	focusWithValueInc(btnId);
	//focusWithValue(btnId, editedID);
}

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

function focusWithValue(fullID, catName) {
	let idNumber = itemIdNumber(fullID);
	
	if (catName == "editInc") {
		let lookedListLine = "itemInc"+idNumber;			
		let item = document.getElementById(lookedListLine);
		let previousName = item.childNodes[0].nodeValue;
		document.getElementById("inputEditIncome").value = previousName;
	}
	
	if (catName == "editExp") {
		let lookedListLine = "itemExp"+idNumber;			
		let item = document.getElementById(lookedListLine);
		let itemNodesLength = item.childNodes.length;
		
		let previousName = item.childNodes[0].nodeValue;
		document.getElementById("inputEditExpense").value = previousName;
		
		// LIMIT EXISTS
		if (itemNodesLength > 4) {
			document.getElementById("editCatLimit").checked = true;
			//$('#quantityEdit').attr('disabled', false);
			
			let existingLimitAmount = item.childNodes[4].nodeValue;
			
			// SETTING LIMIT AMOUNT
			let amount = gettingLimitAmount(existingLimitAmount);
			document.getElementById("quantityEdit").value = amount;
		}	
	}
	
	if (catName == "editPMs") {
		let lookedListLine = "itemPMs"+idNumber;			
		let item = document.getElementById(lookedListLine);
		let previousName = item.childNodes[0].nodeValue;
		document.getElementById("inputEditPM").value = previousName;
	}	
}

// DELETE ITEM SECTION
let deleteBtns = document.getElementsByClassName("delete");

for (let i = 0; i < deleteBtns.length; i++) {
	deleteBtns[i].addEventListener("click", function(e) {
		let clickedButtonId = e.target.id;
		IdToRemember = clickedButtonId;
		showingProperDeleteModal(IdToRemember);
	});
}

function showingProperDeleteModal(btnId) {
	let editedID = btnId.slice(0, 9); //CUTTING OUT NAME
	
	if (editedID == "deletePMs") {
		$("#itemModalLabel").load("modals.html #deletePMTitle");
		$("#itemBody").load("modals.html #deletePaymentMethodBody");
	} else {
		$("#itemModalLabel").load("modals.html #deleteCatTitle");
		$("#itemBody").load("modals.html #deleteCategoryBody");
	}
	
	$('#itemModal').modal('show');
}
