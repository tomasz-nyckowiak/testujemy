function showConfirmationMessage() {
	let id = nameOfItem(IdToRemember);
	
	if (id == "addPM") {
		$("#itemBody").load("alerts.html #successAddPM");
	} else {
		$("#itemBody").load("alerts.html #successAddCategory");
	}	
}

function changesSavedMessage() {
	$("#itemBody").load("alerts.html #successEdit");
}

function showErrorMessage(response) {
	let err1 = msgError;
	let err2 = msgCategoryExistsError;
	let err3 = msgMethodExistsError;
	
	if (response == err1) {
		$("#errorMessage").load("alerts.html #errorWrongName");
	}
	
	if (response == err2) {
		$("#errorMessage").load("alerts.html #errorCategoryExists");
	}
	
	if (response == err3) {
		$("#errorMessage").load("alerts.html #errorMethodExists");
	}
}

function showDeleteConfirmation(isItPMethod) {			
	if (isItPMethod) {
		$("#itemBody").load("alerts.html #successDeleteMethod");
	} else {
		$("#itemBody").load("alerts.html #successDeleteCategory");
	}
}
