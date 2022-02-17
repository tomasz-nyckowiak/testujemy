<?php

	$amount = $_POST['expenseAmount'];
	$date = $_POST['expenseDate'];
	$paymentMethod = $_POST['paymentsMethods'];
	$chosenCategory = $_POST['gridRadios'];
	
	

?>

<!DOCTYPE HTML>
<html lang="pl">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">	
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
		
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
		<link rel="stylesheet" href="./css/style.css" type="text/css">
		
	</head>
	
	<body>
		<div>			
			<p>Dodano nowy wydatek!</p>					
		</div>
		<div>
			<?php
				echo "Kwota: " . $amount . "<br>";
				echo "Data: " . $date . "<br>";
				echo "Sposób płatności: " . $paymentMethod . "<br>";
				echo "Wybrana kategoria: " . $chosenCategory . "<br>";
				
			?>
		</div>
	</body>
	
</html>