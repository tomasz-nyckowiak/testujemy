function editIncomeInput() {		
	let input = document.getElementById("inputEditIncome").value;			
	return input;
}

function showMessageEditIncome() {			
	$("#editIncomeBody").load("alerts.html #successEdit");
}

function showErrorMessageEditInc(response) {		
	let err1 = msgError;
    let err2 = msgCategoryExistsError;
	
	if (response == err1) {
		$("#errorMessageEditInc").load("alerts.html #errorWrongName");	
	} else {
		$("#errorMessageEditInc").load("alerts.html #errorCategoryExists");	
	}
}

function renderEditingIncome(text) {
	let newName = document.createTextNode(text);
	let fullID = IdToRemember;
	let idNumber = itemIdNumber(fullID);
	let lookedListLine = "itemInc"+idNumber;			
	let item = document.getElementById(lookedListLine);			
	
	item.replaceChild(newName, item.childNodes[0]);
	showMessageEditIncome();
}

function saveChangesIncome() {			
	let x;	
	x = editIncomeInput();
	
	let data = {};
	data.id = IdToRemember;
	data.categoryName = x;
	
	fetch('editIncome.php', {
		
		method: 'post',
		body: JSON.stringify({data})
			
	}).then (function(response) {
			return response.text();
	}).then (function(text) {				
		if (checkingIfNameIsValid(text)) {
			renderEditingIncome(text);
		} else {
			showErrorMessageEditInc(text);				
		}				
	}).catch (function(error) {
			console.error(error);
	})	
}