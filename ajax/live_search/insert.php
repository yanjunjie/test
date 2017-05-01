<?php
	include "config.php";

	if (!empty($_POST["search"])) {

		$search	=	$_POST["search"];
		$sql = "select * from user where name like '$search%' or email like '$search%'";
		$result = $conn->query($sql);
		$count = $result->num_rows;
		if($result){
			echo "Result Found:".$count;
		?>
		<table class="table table-striped table-bordered">
			<tr>
				<th>Name</th>
				<th>Email</th>
			</tr>
			<?php
			while ($row = $result->fetch_array()) {
					/* # code...
				}
				foreach ($result as $row) {
				*/
				echo "<tr>";
					echo "<td>".$row["name"]."</td>";
					echo "<td>".$row["email"]."</td>";
				echo "</tr>";
			} ?>
		</table>
		<?php
		}else{
			echo "Result not found";
		}
	}else{
			echo "Please type something";
		}
	?>