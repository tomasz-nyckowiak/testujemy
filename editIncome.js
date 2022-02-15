function editIncomeInput() {		
	let input = document.getElementById("inputEditIncome").value;			
	return input;
}

function renderEditingIncome(text) {
	let newName = document.createTextNode(text);
	let fullID = IdToRemember;
	let idNumber = itemIdNumber(fullID);
	let lookedListLine = "itemInc"+idNumber;			
	let item = document.getElementById(lookedListLine);			
	
	item.replaceChild(newName, item.childNodes[0]);
	changesSavedMessage();
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
			showErrorMessage(text);				
		}				
	}).catch (function(error) {
			console.error(error);
	})	
}