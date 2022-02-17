function paymentMethodInput() {		
	let myInput = document.getElementById('inputNewPaymentMethod').value;			
	return myInput;			
}

function showMessageAddMethod() {			
	$("#addPaymentMethodBody").load("alerts.html #successAddPM");
}

function showErrorMessagePM(response) {
	let err1 = msgError;
    let err2 = msgMethodExistsError;
	
	if (response == err1) {
		$("#errorMessageAddPM").load("alerts.html #errorWrongName");	
	} else {
		$("#errorMessageAddPM").load("alerts.html #errorMethodExists");	
	}
}

function renderNewMethod(text) {						
	let myList = document.getElementById("paymentsMethodsList");	
	let li = document.createElement("li");
	let btn1 = document.createElement("button");
	let btn2 = document.createElement("button");		

	let methodName = nameOfItem(text);
	let idNumber = itemIdNumber(text);
	
	let name = document.createTextNode(methodName);
	
	btn1.innerHTML = "Edytuj";
	btn2.innerHTML = "Usuń";	
	btn1.className = "edit";
	btn2.className = "delete";
	
	li.id = "itemPMs"+idNumber;
	btn1.id = "editPMs"+idNumber;
	btn2.id = "deletePMs"+idNumber;			
	
	li.appendChild(name);
	li.appendChild(btn1);
	li.appendChild(btn2);			

	myList.append(li);
	showMessageAddMethod();
}

function addingNewMethod() {	
	let x;	
	x = paymentMethodInput();
		
	let data = {};
	data.id = IdToRemember;
	data.methodName = x;
	
	fetch('addPaymentMethod.php', {
	
	method: 'post',
	body: JSON.stringify({data})
	
	}).then (function(response) {
			return response.text();
	}).then (function(text) {			
		if (checkingIfNameIsValid(text)) {
			renderNewMethod(text);			
		} else {
			showErrorMessagePM(text);				
		}									
	}).catch (function(error) {
			console.error(error);
	})			
}
