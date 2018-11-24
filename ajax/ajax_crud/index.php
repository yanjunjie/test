<?php //require_once('connection/index.php');
	include('config.php');

	if(!empty($_POST['email']))
	{
		echo $_POST['email'];
	}
?>
<html>
	<head>
	<title>Ajax CRUD</title>
		<link rel="stylesheet" href="css/bootstrap.css">
	</head>
	<body>
	<div id="create_read">
		<div class="container">
			<div style="margin-top:5%;" class="col-sm-4 col-sm-offset-4 well" >
				<form role="form" id="rform" method="POST">
					<div class="form-group">
						<label>Name:</label>
						<input class="form-control" type="name" name="name" id="name">
					</div>
					<div class="form-group">
						<label>Email:</label>
						<input class="form-control" type="email" name="email" id="email">
					</div>
					<button id="submit" class="btn btn-danger acb"
                        data-action="insert.php" data-param="" data-action-type="i" data-env="raw">Submit</button>
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
							<td>
								<button class="btn btn-warning btn-xs acb"
                        data-action="update.php" data-param="<?php echo $row['id']?>" data-action-type="u" data-env="raw">Edit</button> | <button class="btn btn-danger btn-xs acb"
                        data-action="delete.php" data-param="<?php echo $row['id']?>" data-action-type="d" data-env="raw">Delete</button>
                    		</td>
						</tr>

				    <?php } ?>
						
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<script src="js/jquery.min.js"></script>
	<script type="module" src="js/common-1.0.js"></script>
	</body>
</html>