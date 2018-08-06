<?php
	include "config.php";

	if (!empty($_POST["name"])) {

		$name	=	$_POST["name"];
		$password	=	$_POST["password"];
		$email	=	$_POST["email"];
		
		$sql = "insert into user (name, email, password) values('$name','$email','$password')";
		$result = $conn->query($sql);
		if($result){
			echo "Data inserted successfully";
		}else
			echo "Data not inserted";
	}
?>


