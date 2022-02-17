$(document).on("click", "#confirmDeleteCat", function(event) {
	deleteItem();
});

$(document).on("click", "#confirmDeletePM", function(event) {
	deleteItem();
});

function settingProperValue(itemID) {
	// CATEGORY
	let idLetters = nameOfItem(itemID);
	
	if (idLetters == "deletePMs") {
		let numberID = document.getElementById("delPMiD").value = itemID;
	} else {
		let numberID = document.getElementById("delCatID").value = itemID;
	}						
}

function showDeleteConfirmation(isItPMethod) {			
	if (isItPMethod) {
		$("#deletePMBody").load("alerts.html #successDeleteMethod");
	} else {
		$("#deleteCatBody").load("alerts.html #successDeleteCategory");
	}
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
