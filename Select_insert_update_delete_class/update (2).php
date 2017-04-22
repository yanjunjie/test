<?php
	include 'db_operation.class.php';
	$db_obj = new DB_operation();
	
	if(isset($_GET['id'])){
		$result = $db_obj->select_data_row($_GET['id']);
		$row = mysql_fetch_array($result);
	}
	
	if(!empty($_POST['email']) and !empty($_POST['full_name'])){
		$full_name = $_POST['full_name'];
		$email = $_POST['email'];
		$id = $_POST['id'];
		$result = $db_obj->update_data($full_name, $email, $id);
		if($result){
			header('location: select.php');
		}
	}else{
?>

<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title>Select, Insert, Update and Delete operation using PHP OOP</title>
</head>
<body>
	<form action="update.php" method ="post">
		<table>
			<tr>
				<td>Full Name</td>
				<td>: <input name = "full_name" type="text" value="<?php echo $row['full_name']?>" /></td>
			</tr>
			<tr>
				<td>E-maill Address</td>
				<td>: <input name = "email" type="text" value="<?php echo $row['email']?>" /></td>
					<input type="hidden" name = "id" value = "<?php echo $row['id']?>" />
			</tr>
			<tr>
				<td align = "center" colspan="2"><input name = "submit" type="submit" value = "submit" /></td>
			</tr>
			<a href="select.php">Go back to select page</a>
		</table>
	</form>
	<script src ="js/jquery.min.js" type="text/javascript"></script>
	<script src ="js/notify.min.js" type="text/javascript"></script>
</body>
</html>
<?php } ?>
