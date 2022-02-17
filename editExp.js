function editExpenseInput() {		
	let input = document.getElementById("inputEditExpense").value;			
	return input;
}

function limitInput() {		
	let input = document.getElementById("quantityEdit").value;			
	return input;
}

function showMessageEditExpense() {			
	$("#editExpenseBody").load("alerts.html #successEdit");
}

function showErrorMessageEditExp(response) {		
	let err1 = msgError;
    let err2 = msgCategoryExistsError;
	
	if (response == err1) {
		$("#errorMessageEditExp").load("alerts.html #errorWrongName");	
	} else {
		$("#errorMessageEditExp").load("alerts.html #errorCategoryExists");	
	}
}

function showHideEditLimitSection(checkLimit) {
    let dvLimit = document.getElementById("editLimit");
	
	if (checkLimit.checked) {
		dvLimit.style.display = "block";
	} else {
		dvLimit.style.display = "none";
		document.getElementById("quantityEdit").value = null;
	}
}

function selectingParentOfTheChosenItem() {
	let fullID = IdToRemember;	
	let idNumber = itemIdNumber(fullID);
	let lookedListLine = "itemExp"+idNumber;
	
	return lookedListLine;
}

function isLimitAlreadyExists() {
	let limitExists = false;	
	let searchedItem = selectingParentOfTheChosenItem();			
	let item = document.getElementById(searchedItem);
	let itemNodesLength = item.childNodes.length;
	
	if (itemNodesLength > 4) {
		limitExists = true;
	}
	
	return limitExists;
}

function renderEditingExpense(text) {
	// CHECKING IF TEXT(RESPONSE) CONTAINS LIMIT -
	// IT DOESN'T EXIST IF LAST CHARACTER IS NOT A NUMBER
	let lastChar = text.slice(-1);
	let limitIsOn = true;
	
	if (isNaN(lastChar)) {
		limitIsOn = false;
	}
	
	let limitAlreadyExists = isLimitAlreadyExists();
	
	// SETTING PARENT ITEM
	let searchedItem = selectingParentOfTheChosenItem();			
	let item = document.getElementById(searchedItem);

	if (!limitIsOn) {
		// LIMIT OFF
		let newName = document.createTextNode(text);
		
		if (limitAlreadyExists) {
			// UNCHECKING EXISTING LIMIT THEREFORE REMOVING IT			
			item.replaceChild(newName, item.childNodes[0]);
			item.removeChild(item.lastChild.previousSibling);
			item.removeChild(item.lastChild);
		} else {			
			item.replaceChild(newName, item.childNodes[0]);
		}
	} else {
		// LIMIT ON
		let catName = nameOfItem(text);
		let length = catName.length;
		let position = length; // ITS CATNAME LENGTH (WITH OR WITHOUT DOT) 
		
		// IF TEXT CONTAINS DOT THEN AMOUNT IS OF DOUBLE TYPE OTHERWISE IS INTEGER
		let result = text.includes(".");
		
		if (result) {
			let editedName = catName.slice(0, -1); // REMOVING DOT FROM NAME
			let amountLimit = text.substr(position-1); // CUTTING OUT LIMIT
			
			if (limitAlreadyExists) {
				let newName = document.createTextNode(editedName);				
				let line = "Limit: "+amountLimit;
				let newLimit = document.createTextNode(line);
				
				item.replaceChild(newName, item.childNodes[0]);
				item.replaceChild(newLimit, item.lastChild.previousSibling);
			} else {
				// ADDING NEW ELEMENT (LIMIT) IF IT DIDN'T EXIST BEFORE 
				let newName = document.createTextNode(editedName);
				let line = "Limit: "+amountLimit;
				let newlimit = document.createTextNode(line);
				
				item.replaceChild(newName, item.childNodes[0]);
				item.appendChild(newlimit);
			}
			
		} else {
			let amountLimit = text.substr(position);
				
			// WE NEED TO ADD THIS ATTACHMENT
			// TO PROPER DATA SHOWING ON THE PAGE
			let attachment = ".00";
			
			if (limitAlreadyExists) {
				let newName = document.createTextNode(catName);				
				let line = "Limit: "+amountLimit+attachment;
				let newLimit = document.createTextNode(line);
				
				item.replaceChild(newName, item.childNodes[0]);
				item.replaceChild(newLimit, item.lastChild.previousSibling);
			} else {
				// ADDING NEW ELEMENT (LIMIT) IF IT DIDN'T EXIST BEFORE 
				let newName = document.createTextNode(catName);
				let line = "Limit: "+amountLimit+attachment;
				let newlimit = document.createTextNode(line);
				
				item.replaceChild(newName, item.childNodes[0]);
				item.appendChild(newlimit);
			}
		}
	}
	showMessageEditExpense();
}

function saveChangesExpense() {			
	let x, y;	
	x = editExpenseInput();
	y = limitInput();
	
	let data = {};
	data.id = IdToRemember;
	data.categoryName = x;
	data.limit = y;
	data.limitExists = isLimitAlreadyExists();
	
	fetch('editExpense.php', {
		
		method: 'post',
		body: JSON.stringify({data})
			
	}).then (function(response) {
			return response.text();
	}).then (function(text) {				
		if (checkingIfNameIsValid(text)) {
			renderEditingExpense(text);
		} else {
			showErrorMessageEditExp(text);				
		}				
	}).catch (function(error) {
			console.error(error);
	})	
}
