<?php //require_once('connection/index.php');
	include('config.php');
?>

<?php
	$name=$_POST['name'];
	$email=$_POST['email'];
	
	$sql="INSERT INTO info VALUES('','$name','$email')";
	if(mysqli_query($conn,$sql))
	{
		echo "Insert Successfull!!";
	}
	else
	echo "Failed!!";
?>