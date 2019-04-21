<?php
	include 'db_operation.class.php';
	$db_obj = new DB_operation();
	if(!empty($_POST['email']) and !empty($_POST['name'])){
		$name = $_POST['name'];
		$email = $_POST['email'];
        $result = $db_obj->insert_data($name, $email);
        if($result){
            echo "Data inserted successfully";
        }else
            echo "Try again";
	}
?>

<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title>Crud using PHP OOP</title>
</head>
<body>
	<form action="insert.php" method ="post">
		<table>
			<tr>
				<td>Full Name</td>
				<td>: <input name = "name" type="text" /></td>
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
    <a href="view.php">View Results</a>
	<script src ="js/jquery.min.js" type="text/javascript"></script>
	<script src ="js/notify.min.js" type="text/javascript"></script>
</body>
</html>
