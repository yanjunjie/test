<?php
	include 'db_operation.class.php';
	$db_obj = new DB_operation();
	$result = $db_obj->select_data();
?>

<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title>Select, Insert, Update and Delete operation using PHP OOP</title>
</head>
<body>
	<form action="insert.php" method ="post">
		<table cellpadding="1" border="1">
			<tr>
				<td>Full Name</td>
				<td>E-maill</td>
				<td>Update</td>
				<td>Delete</td>
				
			</tr>
			<?php
				while ($row = mysql_fetch_array($result)) {
					echo "<tr>";
						echo "<td>$row[full_name]</td>";
						echo "<td>$row[email]</td>";
						echo "<td><a href='update.php?id=$row[id]'>Update</a></td>";
						echo "<td><a href='delete.php?id=$row[id]'>Delete</a></td>";
					echo "</tr>";
				}
			?>

		</table>
	</form>
	<script src ="js/jquery.min.js" type="text/javascript"></script>
	<script src ="js/notify.min.js" type="text/javascript"></script>
</body>
</html>
