function incomeInput() {		
	let input = document.getElementById("inputNewIncome").value;			
	return input;
}

function renderNewIncome(text) {
	let myList = document.getElementById("categoryListIncomes");
	let li = document.createElement("li");
	let btn = document.createElement("button");
	let btn2 = document.createElement("button");
	
	btn.innerHTML = "Edytuj";
	btn2.innerHTML = "Usuń";
	btn.className = "edit";
	btn2.className = "delete";	
			
	let catName = nameOfItem(text);
	let idNumber = itemIdNumber(text);	
	let name = document.createTextNode(catName);	
	
	li.id = "itemInc"+idNumber;
	btn.id = "editInc"+idNumber;
	btn2.id = "deleteInc"+idNumber;			
	
	li.appendChild(name);
	li.appendChild(btn);
	li.appendChild(btn2);			

	myList.append(li);
	showConfirmationMessage();
}

function addingNewIncome() {			
	let x;	
	x = incomeInput();
	
	let data = {};
	data.id = IdToRemember;
	data.categoryName = x;
	
	fetch('addIncome.php', {
		
		method: 'post',
		body: JSON.stringify({data})
			
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