<?php
	
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
					<div id="messageAdd"></div>					
						<label for="inputNewCategory">Nazwa kategorii</label><br>
						<input type="text" name="inputNewCategory" id="inputNewCategory" onchange="jazda()"><br><br>
						<input type="checkbox" id="addCatLimit" name="addCatLimit">
						<label for="addCatLimit">Włącz limit dla kategorii</label><br>
						<label for="quantity">Ustaw miesięczny limit wydatków dla kategorii</label>
						<input type="number" id="quantity" name="quantity" disabled>
						<div class="mt-3">
							<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zamknij</button>
							<button type="button" class="btn btn-primary" onclick="go()">Zapisz</button>							
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
					<div id="messageEdit"></div>					
					<input type="text" name="editingCategory" id="inputEditCategory" placeholder="" onchange="jazda2()">					
					<div class="mt-3">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zamknij</button>
						<button type="button" class="btn btn-primary" onclick="goEdit()">Zapisz</button>
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
					<div id="messageDelete">
						<p>Usunięcie kategorii spowoduje utratę zapisanych w niej danych!</p>					
						<p>Czy kontynuować?</p>
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Nie</button>
						<button type="button" class="btn btn-primary" id="confirm">Tak</button>
					</div>					
				</div>				
			</div>
		</div>
	</div>	
	
	<script>
		
		var IdToRemember = "";
		var IdToRememberForEditingCategory = "";
		
		document.getElementById("categoryList").addEventListener("click", function(e) {
			if (e.target && e.target.nodeName == "BUTTON") {
				//alert(e.target.id);
				var clickedItemId = e.target.id;
				//IdToRemember = clickedItemId;
				var result = clickedItemId.includes("del");
				if (result) {
					IdToRemember = clickedItemId;
					$('#deleteCatModal').modal('show');
				}
				else {
					IdToRememberForEditingCategory = clickedItemId;
					$('#editCatModal').modal('show');					
					forPlaceholder(IdToRememberForEditingCategory);
				}
			}
		});
		
		// ADD NEW CATEGORY		
		$("#addCatLimit").click(function(){
			if ($(this).is(':checked')) {
				//alert("checked");
				$('#quantity').attr('disabled', false);
			}
			else {
				$('#quantity').attr('disabled', true);
			}
		})
		
		function jazda() {		
			const myInput = document.getElementById('inputNewCategory').value;			
			return myInput;			
		}
		
		function renderNewCategory(text) {						
			var myList = document.getElementById("categoryList");
			
			var li = document.createElement("LI");
			var btn = document.createElement("BUTTON");
			var btn2 = document.createElement("BUTTON");			

			let pattern = /\D/g;
			let result = text.match(pattern);
			let catName = "";
			let length = result.length;
			for (var i=0; i<length; i++) {
				catName += result[i];
			}
			
			var numb = text.match(/\d/g);
			idNumber = numb.join("");
			
			var name = document.createTextNode(catName);
			
			btn.innerHTML = "Edytuj";
			btn2.innerHTML = "Usuń";
			
			btn.className = "edit";
			btn2.className = "delete";
			
			li.id = "item"+idNumber;
			btn.id = "edit"+idNumber;
			btn2.id = "del"+idNumber;			
			
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
		
		function updateCategory(text) {
			var newName = document.createTextNode(text);
			var fullID = IdToRememberForEditingCategory;
			
			var numb = fullID.match(/\d/g);
			idNumber = numb.join("");
			var lookedListLine = "item"+idNumber;			
			var item = document.getElementById(lookedListLine);			
			item.replaceChild(newName, item.childNodes[0]);			
		}
		
		function forPlaceholder(fullID) {
			var numb = fullID.match(/\d/g);
			idNumber = numb.join("");
			var lookedListLine = "item"+idNumber;			
			var item = document.getElementById(lookedListLine);
			var previousName = item.childNodes[0].nodeValue;
			document.getElementById("inputEditCategory").placeholder = previousName;
		}
		
		function goEdit() {
			var x;
			x = jazda2();
			
			let data = {};
			data.id = IdToRememberForEditingCategory;
			data.categoryName = x;
			
			fetch('update.php', {
				
				method: 'post',
				body: JSON.stringify({data})
				
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
		
		const confirmButton = document.getElementById("confirm");
		
		confirmButton.addEventListener("click", delCat);
		
		// MESSAGE
		function showConfirmation() {
			//document.getElementById("messageDelete").innerHTML="Usunięto wybraną kategorię!";
			$("#messageDelete").load("replace.html #successDel");
		}
		
		function renderRemovingCategory(tempID) {
			var justNumber = tempID.substring(3);
			var listName = "item";
			var result = listName.concat(justNumber);
			
			var listItem = document.getElementById(result);
			listItem.remove();
			showConfirmation();
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
	<script type="text/javascript">
		
		// EVENTS WHEN CLOSING THE MODALS		
		$(document).ready(function() {	
			$('#deleteCatModal').on('hidden.bs.modal', function(e) {
				//alert('WORKS!');				
				//$("#messageDelete").load(" #messageDelete > *");
				$("#messageDelete").load("replace.html #messageDelete");
			})
			
			$('#addCatModal').on('hidden.bs.modal', function(e) {
				document.getElementById("inputNewCategory").value = "";
				document.getElementById("quantity").value = "";
				$('#quantity').attr('disabled', true);
				$('#addCatLimit').prop('checked', false);
			})
			
			
		})
		
	</script>
	
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
	<!--<script src="https://code.jquery.com/jquery-3.6.0.slim.min.js" integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI=" crossorigin="anonymous"></script>-->
	
</body>
</html>