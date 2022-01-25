function paymentMethodInput() {		
	let myInput = document.getElementById('inputNewPaymentMethod').value;			
	return myInput;			
}

function showMessageAddMethod() {			
	$("#messageAddPaymentMethod").load("paymentMethodsContent.html #successAddPM");
}

function showErrorMessage(response) {
	let err1 = "Nie wprowadzono poprawnej nazwy! (Nazwa nie może zawierać cyfr oraz znaków specjalnych!)";
    let err2 = "Taka metoda już istnieje!";
	
	if (response == err1) {
		$("#messageAddPaymentMethod").load("paymentMethodsContent.html #failAddPM");	
	} else {
		$("#messageAddPaymentMethod").load("paymentMethodsContent.html #methodExists");	
	}
}

function checkingIfNameIsValid(response) {
	let isValid;
    let err1 = "Nie wprowadzono poprawnej nazwy! (Nazwa nie może zawierać cyfr oraz znaków specjalnych!)";
    let err2 = "Taka metoda już istnieje!";
    
    if (response == err1 || response == err2) {
    	isValid = false;
		return isValid;    
    } else {
		isValid = true;
		return isValid;
	}
}

function renderNewMethod(text) {						
	let myList = document.getElementById("paymentsMethodsList");
	
	let li = document.createElement("li");
	let btn1 = document.createElement("button");
	let btn2 = document.createElement("button");		

	let pattern = /\D/g;
	let result = text.match(pattern);
	let methodName = "";
	let length = result.length;
	for (let i=0; i<length; i++) {
		methodName += result[i];
	}
	
	let numb = text.match(/\d/g);
	idNumber = numb.join("");
	
	let name = document.createTextNode(methodName);
	
	btn1.innerHTML = "Edytuj";
	btn2.innerHTML = "Usuń";
	
	btn1.className = "edit";
	btn2.className = "delete";
	
	li.id = "itemPM"+idNumber;
	btn1.id = "editPM"+idNumber;
	btn2.id = "deletePM"+idNumber;			
	
	li.appendChild(name);
	li.appendChild(btn1);
	li.appendChild(btn2);			

	myList.append(li);
	showMessageAddMethod();
}

function addingNewMethod() {	
	let x;	
	x = paymentMethodInput();
		
	fetch('addPaymentMethod.php', {
	
	method: 'post',
	body: x
	
	}).then (function(response) {
			return response.text();
	}).then (function(text) {			
		if (checkingIfNameIsValid(text)) {
			renderNewMethod(text);
		} else {
			showErrorMessage(text);				
		}									
	}).catch (function(error) {
			console.error(error);
	})			
}

$(document).ready(function() {
	// FOCUSING ON INPUT AFTER OPENING A MODAL
	$("#addPaymentMethodModal").on('shown.bs.modal', function() {
		$(this).find('#inputNewPaymentMethod').focus();
	});
	
	// AFTER CLOSING THE MODAL
	$('#addPaymentMethodModal').on('hidden.bs.modal', function(e) {
		$("#addPaymentMethodBody").load("paymentMethodsContent.html #messageAddPaymentMethod");							
	});
});
