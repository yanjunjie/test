<?php
	
	$conn = mysqli_connect("localhost", "root", '', "test");
	if($conn){
		echo "success";
	}

	if(!empty($_POST['full_name'])){
		$full_name	= $_POST['full_name'];
		$email		= $_POST['email'];
		$sql = "insert into test_table values('','$full_name','$email')";
		$result = $conn->query($sql);

		if ($result){
			echo "Data inserted successfully";
		}else
			echo "Try again";
	}

	
?>