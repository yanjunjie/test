<?php include('config.php');

	if(!empty($_POST['id']) && !empty($_POST['actionType']))
	{
		if($_POST['actionType']=='d')
		{
			$id=$_POST['id'];
			$sql="DELETE FROM info WHERE id='$id'";
			if(mysqli_query($conn,$sql))
			{
				echo "200"; //OK
			}
			else
            {
                echo "500"; //Internal Server Error
            }
		}
		else
		{
			echo '205'; //Reset Content
		}
	}
	else
	{
		echo '204'; //No Content
	}
	exit();
?>