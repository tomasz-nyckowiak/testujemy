<?php

	include 'config.php';
	
	$response = file_get_contents('php://input');
	
	$numberAsString = substr($response, 3);
	$number = intval($numberAsString);
	
	$sql = "UPDATE przychody SET name='$response' WHERE id='$number'";
	mysqli_query($conn, $sql);
	
	echo $response;

?>