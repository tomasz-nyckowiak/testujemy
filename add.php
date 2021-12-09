<?php

	include 'config.php';
	
	$response = file_get_contents('php://input');
	
	$sql = "INSERT INTO przychody (name) VALUES ('$response')";
	mysqli_query($conn, $sql);	
	
	//echo $response;
	
	$sql2 = "SELECT id FROM przychody WHERE name='$response'";
	$result = mysqli_query($conn, $sql2);
	
	$test = [];
	
	if (mysqli_num_rows($result) > 0) {
		$row = mysqli_fetch_assoc($result);						
		$temp = $row['id'];		
		array_push($test, "$temp", "$response");
	} else {
		echo "Brak kategorii!";
	}
	
	echo $test[0].$test[1];

?>