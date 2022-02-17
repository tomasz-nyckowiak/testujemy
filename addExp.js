function expenseInput() {		
	let input = document.getElementById("inputNewExpense").value;			
	return input;
}

function limitInput() {		
	let input = document.getElementById("quantity").value;			
	return input;
}

function showHideAddLimitSection(checkLimit) {
    let dvLimit = document.getElementById("addLimit");
	
	if (checkLimit.checked) {
		dvLimit.style.display = "block";
	} else {
		dvLimit.style.display = "none";
		document.getElementById("quantity").value = null;
	}
}

function showMessageAddExpense() {			
	$("#addExpBody").load("alerts.html #successAddCategory");
}

function showErrorMessageExp(response) {		
	let err1 = msgError;
    let err2 = msgCategoryExistsError;
	
	if (response == err1) {
		$("#errorMessageAddExp").load("alerts.html #errorWrongName");	
	} else {
		$("#errorMessageAddExp").load("alerts.html #errorCategoryExists");	
	}
}

function renderNewExpense(text) {
	let myList = document.getElementById("categoryListExpenses");
	let li = document.createElement("li");
	let btn = document.createElement("button");
	let btn2 = document.createElement("button");
	
	btn.innerHTML = "Edytuj";
	btn2.innerHTML = "Usuń";	
	btn.className = "edit";
	btn2.className = "delete";
	
	let catName = nameOfItem(text);
	let catLength = catName.length; // WITH OR WITHOUT DOT
	let IDnumber = itemIdNumber(text);
	let idLength = IDnumber.length;
	
	// CHECKING IF TEXT (RESPONSE) CONTAINS LIMIT -
	// IT DOESN'T EXIST IF LAST CHARACTER IS NOT A NUMBER
	let lastChar = text.slice(-1);
	
	if (isNaN(lastChar)) {
		// LIMIT OFF		
		let name = document.createTextNode(catName);		
		
		li.id = "itemExp"+IDnumber;
		btn.id = "editExp"+IDnumber;
		btn2.id = "deleteExp"+IDnumber;			
		
		li.appendChild(name);
		li.appendChild(btn);
		li.appendChild(btn2);			

		myList.append(li);
	} else {
		// LIMIT ON
		let br = document.createElement("br");
		
		// IF TEXT CONTAINS DOT THEN AMOUNT IS OF DOUBLE TYPE OTHERWISE IS INTEGER
		let result = text.includes(".");
		let attachment;
		
		if (result) {
			let editedName = catName.slice(0, -1); // REMOVING DOT FROM NAME
			let position = idLength+catLength;
			let amountLimit = text.substr(position-1); // CUTTING OUT LIMIT
			let name = document.createTextNode(editedName);
			let newLine = "Limit: ";
			
			// CHECKING LENGTH OF STRING AFTER THE DOT
			let dotPosition = text.indexOf(".");
			let partOfTheStringAfterDot = text.substr(dotPosition+1);
			let afterTheDecimalPoint = partOfTheStringAfterDot.length;
			
			if (afterTheDecimalPoint == 1) {
				attachment = "0"; // WE NEED TO ADD THIS ATTACHMENT (FOR PROPER DATA SHOWING ON THE PAGE)
				newLine = "Limit: "+amountLimit+attachment;
			} else newLine = "Limit: "+amountLimit;			

			let limit = document.createTextNode(newLine);
			
			li.id = "itemExp"+IDnumber;
			btn.id = "editExp"+IDnumber;
			btn2.id = "deleteExp"+IDnumber;			
			
			li.appendChild(name);
			li.appendChild(btn);
			li.appendChild(btn2);
			li.appendChild(br);
			li.appendChild(limit);
			myList.append(li);
		} else {
			let name = document.createTextNode(catName);
			let position = idLength+catLength;
			let amountLimit = text.substr(position);
			attachment = ".00"; // WE NEED TO ADD THIS ATTACHMENT (FOR PROPER DATA SHOWING ON THE PAGE)
			let line = "Limit: "+amountLimit+attachment;
			let limit = document.createTextNode(line);
			
			li.id = "itemExp"+IDnumber;
			btn.id = "editExp"+IDnumber;
			btn2.id = "deleteExp"+IDnumber;			
			
			li.appendChild(name);
			li.appendChild(btn);
			li.appendChild(btn2);
			li.appendChild(br);
			li.appendChild(limit);
			myList.append(li);
		}
	}
	showMessageAddExpense();
}

function addingNewExpense() {
	let x, y;
	x = expenseInput();
	y = limitInput();
	
	let data = {};	
	data.id = IdToRemember;
	data.categoryName = x;
	data.limit = y;

	fetch('addExpense.php', {
		
		method: 'post',
		body: JSON.stringify({data})
			
	}).then (function(response) {
			return response.text();
	}).then (function(text) {				
		if (checkingIfNameIsValid(text)) {
			renderNewExpense(text);
		} else {
			showErrorMessageExp(text);				
		}				
	}).catch (function(error) {
			console.error(error);
	})	
}
