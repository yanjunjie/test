<?php session_start();
	include 'db_operation.class.php';
	$db_obj = new DB_operation();
	
	if(isset($_GET['id'])){
		$result = $db_obj->select_data_row($_GET['id']);
		$row = mysqli_fetch_object($result);
	}
	
	if(!empty($_POST['email']) and !empty($_POST['name'])){
		$name = $_POST['name'];
		$email = $_POST['email'];
		$id = $_POST['id'];
		$result = $db_obj->update_data($name, $email, $id);
		if($result){
		    $_SESSION['success'] = 'Record updated successfully';
		} else {
            $_SESSION['error'] = 'Record not updated successfully';
        }
        header('location: view.php');
	}else{
?>

<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title>Crud using PHP OOP</title>
</head>
<body>
	<form action="update.php" method ="post">
		<table>
			<tr>
				<td>Full Name</td>
				<td>: <input name = "name" type="text" value="<?php echo $row->name?>" /></td>
			</tr>
			<tr>
				<td>E-maill Address</td>
				<td>: <input name = "email" type="text" value="<?php echo $row->email?>" /></td>
					<input type="hidden" name = "id" value = "<?php echo $row->id?>" />
			</tr>
			<tr>
				<td align = "center" colspan="2"><input name = "submit" type="submit" value = "submit" /></td>
			</tr>
		</table>
	</form>
    <a href="select.php">Go back to select page</a>
	<script src ="js/jquery.min.js" type="text/javascript"></script>
	<script src ="js/notify.min.js" type="text/javascript"></script>
</body>
</html>
<?php } ?>
