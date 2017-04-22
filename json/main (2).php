<?php
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "test";

	$conn = mysqli_connect($servername, $username, $password);
	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	}
	$result = mysqli_select_db($conn,"test");
	if(!$result){
		echo "Success";
	}

	//$content = $_POST["content"];
	//$content_obj = json_decode($content);
	//$sql = "SELECT name FROM ".$content_obj->$table." LIMIT ".$content_obj->$limit";
	$sql = "select * from oop_test_table limit 5";
	$result = mysqli_query($conn,$sql);
	if($result){
		$outp = $result->fetch_all(MYSQLI_ASSOC);
		echo json_encode($outp); //For looping in client side
		//echo '{"id":"8","full_name":"Rahim","email":"bablukpik@gmail.com"}'; //without loop in client side
	}
	
	//For Array
	/*
	$myArr = array("John", "Mary", "Peter", "Sally");
	$myJSON = json_encode($myArr);
	echo $myJSON;
	*/
?>