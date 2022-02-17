function editPMInput() {		
	let input = document.getElementById("inputEditPM").value;			
	return input;
}

function showMessageEditPM() {			
	$("#editPMBody").load("alerts.html #successEdit");
}

function showErrorMessageEditPM(response) {		
	let err1 = msgError;
    let err2 = msgMethodExistsError;
	
	if (response == err1) {
		$("#errorMessageEditPM").load("alerts.html #errorWrongName");	
	} else {
		$("#errorMessageEditPM").load("alerts.html #errorMethodExists");	
	}
}

function renderEditingPM(text) {	
	let newName = document.createTextNode(text);
	let fullID = IdToRemember;
	let idNumber = itemIdNumber(fullID);
	let lookedListLine = "itemPMs"+idNumber;			
	let item = document.getElementById(lookedListLine);
	
	item.replaceChild(newName, item.childNodes[0]);
	showMessageEditPM();
}

function saveChangesPM() {			
	let x;	
	x = editPMInput();
	
	let data = {};
	data.id = IdToRemember;
	data.methodName = x;
	
	fetch('editPaymentMethod.php', {
		
		method: 'post',
		body: JSON.stringify({data})
			
	}).then (function(response) {
			return response.text();
	}).then (function(text) {				
		if (checkingIfNameIsValid(text)) {
			renderEditingPM(text);
		} else {
			showErrorMessageEditPM(text);				
		}				
	}).catch (function(error) {
			console.error(error);
	})	
}
