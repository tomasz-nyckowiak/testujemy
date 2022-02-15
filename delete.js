$(document).on("click", "#confirm", function(event) {
	deleteItem();
});

function settingProperValue(itemID) {
	let numberID = document.getElementById("custID").value = itemID;					
}

function renderRemovingItem(tempID) {
	let removedItemIsPaymentMethod = false;
	
	// CATEGORY
	let idLetters = nameOfItem(tempID);
	
	// ID
	let idDigits = itemIdNumber(tempID);
	
	if (idLetters == "deleteInc") {
		let lookedListLine = "itemInc"+idDigits;
		let item = document.getElementById(lookedListLine);
		item.remove();
	}
	
	if (idLetters == "deleteExp") {
		let lookedListLine = "itemExp"+idDigits;
		let item = document.getElementById(lookedListLine);
		item.remove();
	}
	
	if (idLetters == "deletePMs") {
		let lookedListLine = "itemPMs"+idDigits;
		let item = document.getElementById(lookedListLine);
		item.remove();
		removedItemIsPaymentMethod = true;
	}	
	
	showDeleteConfirmation(removedItemIsPaymentMethod);
}

function deleteItem() {			
	let x;
	x = IdToRemember;
	settingProperValue(x);
				
	fetch('deleteItem.php', {
		
		method: 'post',
		body: x
		
	}).then (function(response) {
			return response.text();
	}).then (function(text) {
			text = x;
			renderRemovingItem(text)					
	}).catch (function(error) {
			console.error(error);
	})			
}
