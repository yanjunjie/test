<?php
	include 'db_operation.class.php';
	$db_obj = new DB_operation();
	if(!empty($_POST['email']) and !empty($_POST['full_name'])){
		$full_name = $_POST['full_name'];
		$email = $_POST['email'];
		$db_obj->insert_data($full_name, $email);
	}else
		echo "You have to input something";
?>

<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title>Select, Insert, Update and Delete operation using PHP OOP</title>
</head>
<body>
	<form action="insert.php" method ="post">
		<table>
			<tr>
				<td>Full Name</td>
				<td>: <input name = "full_name" type="text" /></td>
			</tr>
			<tr>
				<td>E-maill Address</td>
				<td>: <input name = "email" type="text" /></td>
			</tr>
			<tr>
				<td align = "center" colspan="2"><input name = "submit" type="submit" value = "submit" /></td>
			</tr>
		</table>
	</form>
	<script src ="js/jquery.min.js" type="text/javascript"></script>
	<script src ="js/notify.min.js" type="text/javascript"></script>
</body>
</html>
