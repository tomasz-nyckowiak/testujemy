<?php

	include 'config.php';
	
	$response = file_get_contents('php://input');
	
	$responseDecoded = json_decode($response);
	//var_dump($responseDecoded->data);
	$temp1 = $responseDecoded->data->id;
	$temp2 = $responseDecoded->data->categoryName;
	
	$numberAsString = substr($temp1, 4);
	//echo $numberAsString;
	$number = intval($numberAsString);
	
	$sql = "UPDATE przychody SET name='$temp2' WHERE id='$number'";
	mysqli_query($conn, $sql);
	
	//echo $response;
	echo $temp2;

?>