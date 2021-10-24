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
	
	for ($x = 0; $x < $size; $x++) {									
		$i = $IDnumbers[$x];
		$j = $IDnumbers[$x];
		echo "<li>";
		echo $categories[$x];
		echo "<button type='button' class='btn btn-primary edit' id='edit$i' data-bs-toggle='modal' data-bs-target='#editCatModal'>Edytuj</button>";
		echo "<button type='button' class='delete' id='del$j' data-bs-toggle='modal' data-bs-target='#deleteCatModal'>Usuń</button>";
		echo "</li>";
	}

?>
