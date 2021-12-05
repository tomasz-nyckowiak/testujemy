<?php
	
	//session_start();
	
	include 'config.php';	
	
	$sql = "SELECT * FROM przychody";
	$result = mysqli_query($conn, $sql);
	$IDnumbers = [];
	$categories = [];
	if (mysqli_num_rows($result) > 0) {
		while ($row = mysqli_fetch_assoc($result)) {						
			$temp1 = $row['id'];
			$temp2 = $row['name'];
			array_push($IDnumbers, "$temp1");				
			array_push($categories, "$temp2");				
		}
	} else {
		echo "Brak kategorii!";
	}
	
	$size = count($categories);

?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">	
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">			
</head>

<body>
	
	<div class="accordion" id="accordionExample">
		<div class="accordion-item">
			<h2 class="accordion-header" id="headingOne">
				<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">Kategorie przychodów</button>
			</h2>
			<div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
				<div class="accordion-body">
					<ul id="categoryList">						 														
						<?php								
							for ($x = 0; $x < $size; $x++) {									
								$i = $IDnumbers[$x];
								$j = $IDnumbers[$x];
								$k = $IDnumbers[$x];
								echo "<li id='item$k'>";
								echo $categories[$x];
								echo "<button type='button' class='edit' id='edit$i'>Edytuj</button>";
								echo "<button type='button' class='delete' id='del$j'>Usuń</button>";
								echo "</li>";
							}
						?>						
					</ul>
					<!-- Button trigger modal -->
					<div class="mt-2">
						<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCatModal">
							Dodaj nową kategorię
						</button>
					</div>
				</div>
			</div>
		</div>
		<div class="accordion-item">
			<h2 class="accordion-header" id="headingTwo">
				<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">Kategorie wydatków</button>
			</h2>
			<div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
				<div class="accordion-body">
					Item 2
				</div>
			</div>
		</div>
		<div class="accordion-item">
			<h2 class="accordion-header" id="headingThree">
				<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">Metody płatności</button>
			</h2>
			<div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
				<div class="accordion-body">
					Item 3
				</div>
			</div>
		</div>
	</div>
	
	<!-- Modals -->
	<!-- Add new category -->
	<div class="modal fade" id="addCatModal" tabindex="-1" aria-labelledby="addCatModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="addCatModalLabel">Dodawanie nowej kategorii</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body run">
					<div id="message"></div>
					
						<input type="text" name="newCategory" id="inputNewCategory" onchange="jazda()">					
						<div class="mt-3">
							<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zamknij</button>							
							<button type="button" class="btn btn-primary" onclick="go()">Zapisz</button>
							<!--<input type="submit" class="btn btn-primary" value="Zapisz">-->
						</div>
					
				</div>				
			</div>
		</div>
	</div>
	
	<!-- Edit category -->	
	<div class="modal fade" id="editCatModal" tabindex="-1" aria-labelledby="editCatModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="editCatModalLabel">Edycja kategorii</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body run">
					<div id="message"></div>
					
					<input type="text" name="editingCategory" id="inputEditCategory" onchange="jazda2()">					
					<div class="mt-3">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zamknij</button>
						<button type="button" class="btn btn-primary" onclick="goEdit()">"Zapisz"</button>
					</div>
					
				</div>				
			</div>
		</div>
	</div>
	
	<!-- Delete category -->
	<div class="modal fade" id="deleteCatModal" tabindex="-1" aria-labelledby="deleteCatModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="deleteCatModalLabel">Usuwanie kategorii</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<input type="hidden" name="custID" id="custID" value="">
					<div id="messageDel">
						<p>Usunięcie kategorii spowoduje utratę zapisanych w niej danych!</p>					
						<p>Czy kontynuować?</p>
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Nie</button>
						<button type="button" class="btn btn-primary" id="confirm">Tak</button>
					</div>
					<!--<form id="deleteCatModalForm" method="post">
						<p>Usunięcie kategorii spowoduje utratę zapisanych w niej danych!</p>					
						<p>Czy kontynuować?</p>					
						<div class="mt-3">
							<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Nie</button>
							<input type="submit" class="btn btn-primary" value="Tak">
						</div>
					</form>-->
				</div>				
			</div>
		</div>
	</div>
	
	<script>

		// ADD NEW CATEGORY		
		function jazda() {		
			const myInput = document.getElementById('inputNewCategory').value;			
			return myInput;			
		}
		
		function getIDNumber() {
			//var fullList = document.getElementById("categoryList").getElementsByTagName("LI");
			//var listLength = fullList.length;
			//var lastItemOnList = listLength - 1;
			var x;
			var IDNumber;
			x = jazda();

			fetch('getID.php', {
				
				method: 'post',
				body: x
				
			}).then (function(response) {
					return response.text();
			}).then (function(text) {
					IDNumber = text					
			}).catch (function(error) {
					console.error(error);
			})
			
			return IDNumber;
			//var container = document.getElementsByTagName("ul")[0];
			//var lastchild = container.lastElementChild;
			//document.getElementsByTagName("LI")[lastchild].setAttribute("id", "democlass");
		}
		
		function renderNewCategory(text) {						
			var myList = document.getElementById("categoryList");
			
			var li = document.createElement("LI");
			var btn = document.createElement("BUTTON");
			var btn2 = document.createElement("BUTTON");
			
			var name = document.createTextNode(text);			
			btn.innerHTML = "Edytuj";
			btn2.innerHTML = "Usuń";

			var container = document.getElementsByTagName("LI");
			var lastchild = container.lastElementChild;
			document.getElementsByTagName("LI")[lastchild].setAttribute("class", "delete");
			//btn2.setAttribute("class", "delete");
						
			//var allSelects = document.getElementsByTagName("LI");
			//var lastSelect = allSelects[allSelects.length-1];
			
			//document.getElementsByTagName("LI")[4].setAttribute("class", "delete");
			
			//kolejnyTest = getIDNumber();
			//var justName = "edit";
			//var properName = justName + number;
			
			//li.setAttribute("class", "edit");
			//btn2.setAttribute("class", "delete");			
			//var container = document.getElementsByTagName("ul")[0];
			//var lastchild = container.lastElementChild;
			//document.getElementsByTagName("LI")[lastchild].setAttribute("class", "delete");
			
			//document.getElementsByTagName("LI")[0].setAttribute("type", "button");
			//document.getElementsByTagName("LI")[1].setAttribute("class", "edit");
			//document.getElementsByTagName("LI")[2].setAttribute("id", properName);
			
			li.appendChild(name);
			li.appendChild(btn);
			li.appendChild(btn2);			

			myList.append(li);
		};
		
		function go() {
			var x;
			x = jazda();

			fetch('add.php', {
				
				method: 'post',
				body: x
				
			}).then (function(response) {
					return response.text();
			}).then (function(text) {
					renderNewCategory(text)					
			}).catch (function(error) {
					console.error(error);
			})
		}
		
		// EDIT CATEGORY
		function jazda2() {		
			const editInput = document.getElementById('inputEditCategory').value;			
			return editInput;			
		}
		
		var editItems = document.getElementsByClassName("edit");
		
		var IdToRememberForEdit = "";
		
		var test2 = function() {
			var attribute = this.getAttribute("id");
			IdToRememberForEdit = attribute;
			$('#editCatModal').modal('show');
			//alert(attribute);
		};

		for (var i = 0; i < editItems.length; i++) {
			editItems[i].addEventListener('click', test2, false);
		}
		
		function goEdit() {
			var x;
			x = jazda2();

			fetch('update.php', {
				
				method: 'post',
				body: x
				
			}).then (function(response) {
					return response.text();
			}).then (function(text) {
					updateCategory(text)					
			}).catch (function(error) {
					console.error(error);
			})
		}
		
		
		// DELETE CATEGORY
		function settingProperValue(categoryID) {		
			var numberID = document.getElementById('custID').value = categoryID;			
			//return numberID;			
		}
		
		var deleteItems = document.getElementsByClassName("delete");
		
		var IdToRemember = "";
		
		var test3 = function() {
			var attribute = this.getAttribute("id");
			IdToRemember = attribute;			
			$('#deleteCatModal').modal('show');			
			//alert(attribute);
		};

		for (var i = 0; i < deleteItems.length; i++) {
			deleteItems[i].addEventListener('click', test3, false);
		}
		
		const confirmButton = document.getElementById("confirm");
		
		confirmButton.addEventListener('click', delCat);
		
		function renderRemovingCategory(tempID) {
			var justNumber = tempID.substring(3);
			var listName = "item";
			var result = listName.concat(justNumber);
			
			var listItem = document.getElementById(result);
			listItem.remove();
		}
		
		function delCat() {			
			var z;
			z = IdToRemember;
			settingProperValue(z);
						
			fetch('remove.php', {
				
				method: 'post',
				body: z
				
			}).then (function(response) {
					return response.text();
			}).then (function(text) {
					text = z;
					renderRemovingCategory(text)					
			}).catch (function(error) {
					console.error(error);
			})
			//alert(IdToRemember);
		}
		
		

	</script>
	
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
	<script src="https://code.jquery.com/jquery-3.6.0.slim.min.js" integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI=" crossorigin="anonymous"></script>
	
</body>
</html>