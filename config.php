<?php

	$db_host = "localhost";
	$db_name = "test";
	$db_user = "root";
	$db_password = "";

	$db_conn = new PDO("mysql:host=".$db_host.";dbname=".$db_name, $db_user, $db_password);	

?>