<?php
	
	$conn = mysqli_connect("localhost", "root", '', "test");


	if(!empty($_POST['field_name'])){

		$field_name		= $_POST['field_name'];
		$value 			= $_POST['value'];
		$id				= $_POST['id'];
		$sql 			= "UPDATE test_table SET $field_name = '$value' where id = '$id'";
		$result			= $conn->query($sql);

		if ($result){
			echo "Data inserted successfully";
		}else
			echo "Try again";
	}
	
?>