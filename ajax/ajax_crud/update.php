<?php //require_once('connection/index.php');
	include('config.php');
?>

<?php
	if(!empty($_POST['name']))
	{
		//die(var_dump($_POST['id']));
		$name=$_POST['name'];
		$email=$_POST['email'];
		$sql="INSERT INTO info (name, email) VALUES('$name','$email')";
		if(mysqli_query($conn,$sql))
		{
			echo "yes";
		}
		else
			echo "no";

		exit();
	}
?>