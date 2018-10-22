<?php include('config.php');

	if(!empty($_POST['id']) && !empty($_POST['actionType']))
	{
		if($_POST['actionType']=='d')
		{
			$id=$_POST['id'];
			$sql="DELETE FROM info WHERE id='$id'";
			if(mysqli_query($conn,$sql))
			{
				echo "yes";
			}
			else
				echo "no";
		}
		else
		{
			echo '500';
		}
	}
	else
	{
		echo '404';
	}

	exit();
?>