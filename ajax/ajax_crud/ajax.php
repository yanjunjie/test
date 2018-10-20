<?php //require_once('connection/index.php');
	include('config.php');
?>

<?php
	if(!empty($_POST['name']))
	{
		$name=$_POST['name'];
		$email=$_POST['email'];
		$sql="INSERT INTO info VALUES('','$name','$email')";
		if(mysqli_query($conn,$sql))
		{
			echo "yes";
		}
		else
			echo "no";

		exit();
	}
?>