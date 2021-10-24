<?php

	include 'config.php';
	
	$name = $_POST['idName'];
	
	$numberAsString = substr($name, 3);
	$number = intval($numberAsString);
	
	$sql = "DELETE FROM przychody WHERE id='$number'";
	mysqli_query($conn, $sql);	

?>