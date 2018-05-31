<?php include("process.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
		<input type="text" name="book_name">
		<input type="submit" value="Find Book Price">
	</form>

	<br>

	<?php 
		echo "Book Price: ". (isset($result->data) ? $result->data : 'Not Found');
	?>

</body>
</html>