<?php

	include 'config.php';
	
	$response = file_get_contents('php://input');
	
	$sql = "INSERT INTO przychody (name) VALUES ('$response')";
	mysqli_query($conn, $sql);
	
	echo $response;	

?>