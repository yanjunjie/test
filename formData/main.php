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
//FormData
/*echo $_POST['userid']."<br>";
echo $_POST['filelabel']."<br>";
echo $_POST['CustomField']."<br>";
$temp = $_FILES['userpic']['tmp_name'];
$img_name = $_FILES['userpic']['name'];
$destination = "images/".$img_name;
move_uploaded_file($temp, $destination)*/
//echo '<img "src='.$destination.'>"';

print_r($_FILES);

?>