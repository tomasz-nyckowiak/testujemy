<?php

	include 'config.php';
	
	$response = file_get_contents('php://input');
	
	$sql = "INSERT INTO przychody (name) VALUES ('$response')";
	mysqli_query($conn, $sql);
	
	echo $response;
	
	/*if (isset($_POST['newCategory'])) {		
		
		$category = $_POST['newCategory'];	
	
		$sql = "INSERT INTO przychody (name) VALUES ('$category')";
		mysqli_query($conn, $sql);
		
		echo $category;
	}
	else
		echo "ZONK!";*/

?>