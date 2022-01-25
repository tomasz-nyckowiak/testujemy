function incomeInput() {		
	let input = document.getElementById("inputNewIncome").value;			
	return input;
}

function showMessageAddCat() {			
	$("#messageAdd").load("incomesContent.html #successAddIncome");
}

function showErrorMessage(response) {		
	let err1 = "Nie wprowadzono poprawnej nazwy! (Nazwa nie może zawierać cyfr oraz znaków specjalnych!)";
    let err2 = "Taka kategoria już istnieje!";
	
	if (response == err1) {
		$("#messageAdd").load("incomesContent.html #failAddIncome");	
	} else {
		$("#messageAdd").load("incomesContent.html #failIncomeExists");	
	}
}

function checkingIfNameIsValid(response) {
	let isValid;
    let err1 = "Nie wprowadzono poprawnej nazwy! (Nazwa nie może zawierać cyfr oraz znaków specjalnych!)";
    let err2 = "Taka kategoria już istnieje!";
    
    if (response == err1 || response == err2) {
    	isValid = false;
		return isValid;    
    } else {
		isValid = true;
		return isValid;
	}
}

function renderNewIncome(text) {
	let myList = document.getElementById("categoryListIncomes");
	let li = document.createElement("li");
	let btn = document.createElement("button");
	let btn2 = document.createElement("button");
	
	btn.innerHTML = "Edytuj";
	btn2.innerHTML = "Usuń";	
			
	let pattern = /\D/g;
	let result = text.match(pattern);
	let catName = "";
	let length = result.length;
	for (let i=0; i<length; i++) {
		catName += result[i];
	}
	
	let numb = text.match(/\d/g);
	idNumber = numb.join("");
	
	let name = document.createTextNode(catName);
	
	btn.className = "edit";
	btn2.className = "delete";
	
	li.id = "itemInc"+idNumber;
	btn.id = "editInc"+idNumber;
	btn2.id = "deleteInc"+idNumber;			
	
	li.appendChild(name);
	li.appendChild(btn);
	li.appendChild(btn2);			

	myList.append(li);
	showMessageAddCat();
}

function addingNewIncome() {			
	let x;	
	x = incomeInput();	
	
	fetch('addIncome.php', {
		
		method: 'post',
		body: x
			
	}).then (function(response) {
			return response.text();
	}).then (function(text) {				
		if (checkingIfNameIsValid(text)) {
			renderNewIncome(text);
		} else {
			showErrorMessage(text);				
		}				
	}).catch (function(error) {
			console.error(error);
	})	
}

$(document).ready(function() {	
	// FOCUSING ON INPUT AFTER OPENING A MODAL
	$("#addIncModal").on('shown.bs.modal', function() {
		$(this).find('#inputNewIncome').focus();
	});
	
	// AFTER CLOSING THE MODAL
	$('#addIncModal').on('hidden.bs.modal', function(e) {
		$("#addIncBody").load("incomesContent.html #messageAdd");							
	});
});
