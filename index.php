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
								echo "<li>";
								echo $categories[$x];
								echo "<button type='button' class='btn btn-primary edit' id='edit$i' data-bs-toggle='modal' data-bs-target='#editCatModal'>Edytuj</button>";
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
	<!--<div class="modal fade" id="editCatModal" tabindex="-1" aria-labelledby="editCatModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="editCatModalLabel">Edycja kategorii</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body run">
					<div id="message"></div>
					<form id="editCatModalForm" method="post">
						<input type="text" name="editingCategory" id="inputEditCategory">					
						<div class="mt-3">
							<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zamknij</button>
							<input type="submit" class="btn btn-primary" value="Zapisz">
						</div>
					</form>
				</div>				
			</div>
		</div>
	</div>-->
	
	<!-- Delete category -->
	<!--<div class="modal fade" id="deleteCatModal" tabindex="-1" aria-labelledby="deleteCatModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="deleteCatModalLabel">Usuwanie kategorii</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<div id="messageDel">
						<p>Usunięcie kategorii spowoduje utratę zapisanych w niej danych!</p>					
						<p>Czy kontynuować?</p>
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Nie</button>
						<button type="button" class="btn btn-primary" id="confirm" onclick="delCat()">Tak</button>
					</div>
					<!--<form id="deleteCatModalForm" method="post">
						<p>Usunięcie kategorii spowoduje utratę zapisanych w niej danych!</p>					
						<p>Czy kontynuować?</p>					
						<div class="mt-3">
							<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Nie</button>
							<input type="submit" class="btn btn-primary" value="Tak">
						</div>
					</form>
				</div>				
			</div>
		</div>
	</div>-->
	
	<script>

		function jazda() {
		
			const myInput = document.getElementById('inputNewCategory').value;			
			return myInput;
			
		}

		
		function go() {
			var x;
			x = jazda();
			//alert("Dodano nową kategorię: " + x);
			
			fetch('add.php', {
				
				method: 'post',
				body: x
				
			}).then (function(response) {
					return response.text();
			}).then (function(text) {
					function renderNewCategory(text) {						
						let element = document.getElementById('categoryList');
						element.appendChild(text);					
					};
			}).catch (function(error) {
					console.error(error);
			})
		}		
		
	</script>
	
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
	<script src="https://code.jquery.com/jquery-3.6.0.slim.min.js" integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI=" crossorigin="anonymous"></script>
	
</body>
</html>