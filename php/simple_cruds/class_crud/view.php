<?php session_start();

    include 'db_operation.class.php';
    $db_obj = new DB_operation();
    $result = $db_obj->select_data();

    // status msg display
    if(!empty($_SESSION['success'])){
        echo $_SESSION['success'];
        unset($_SESSION['success']);
    }
    if(!empty($_SESSION['error'])){
        echo $_SESSION['error'];
        unset($_SESSION['error']);
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
		<table cellpadding="1" border="1">
			<tr>
				<th>Full Name</th>
				<th>E-maill</th>
				<th colspan="2">Action</th>
				
			</tr>
			<?php
				while ($row = mysqli_fetch_array($result)) {
					echo "<tr>";
						echo "<td>$row[name]</td>";
						echo "<td>$row[email]</td>";
						echo "<td><a href='update.php?id=$row[id]'>Update</a></td>";
						echo "<td><a href='delete.php?id=$row[id]'>Delete</a></td>";
					echo "</tr>";
				}
			?>

		</table>
	</form>
    <a href="insert.php">Add New</a>
	<script src ="js/jquery.min.js" type="text/javascript"></script>
	<script src ="js/notify.min.js" type="text/javascript"></script>
</body>
</html>
