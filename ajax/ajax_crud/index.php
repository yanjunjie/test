<?php //require_once('connection/index.php');
	include('config.php');
?>
<html>
	<head>
	<title>Ajax CRUD</title>
		<link rel="stylesheet" href="css/bootstrap.css">
	</head>
	<body>
	<div id="create_view">
		<div class="container">
			<div style="margin-top:5%;" class="col-sm-4 col-sm-offset-4 well" >
				<form role="form" action="ajax.php" id="rform" method="POST">
					<div class="form-group">
						<label>Name:</label>
						<input class="form-control" type="name" name="name" id="name">
					</div>
					<div class="form-group">
						<label>Email:</label>
						<input class="form-control" type="email" name="email" id="email">
					</div>
					<button id="submit" class="btn btn-danger submit">Submit </button>
				</form>
				<div style="color:green;" id="success"></div>
			</div>
		</div>

		<div class="container">
			<div class="table-responsive">
				<table class="table table-bordered table-hover">
					<thead>
						<tr>
							<th>Name</th>
							<th>Email</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>

					<?php
						
						$sql="select * from info";
						$result = mysqli_query($conn,$sql);
						while($row = mysqli_fetch_assoc($result))
					    { ?>
					      
						<tr>
							<td><?php echo $row['name']?></td>
							<td><?php echo $row['email']?></td>
							<td><a href="#">Edit</a> | <a href="#">Delete</a></td>
						</tr>

				    <?php } ?>
						
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<script src="js/jquery.min.js"></script>
	<script src="js/common-1.0.js"></script>
	</body>
</html>