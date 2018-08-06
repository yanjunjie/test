<!DOCTYPE html>
<html>
<head>
	<title>Demo Codeigniter Pagination with Bootstrap CSS Style</title>
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<style type="text/css">
		body {
			margin-top: 50px;
		}
	</style>
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<h1>Demo Codeigniter Pagination with Bootstrap CSS Style</h1>
				<table class="table table-bordered table-striped">
					<thead>
						<tr class="info">
							<th>Nama Depan</th>
							<th>Nama Belakang</th>
							<th>Email</th>
							<th>Jenis Kelamin</th>
						</tr>
					</thead>
					<tbody>
						<?php if(count($result)):?>
						<?php foreach($result as $row): ?>
						<tr>
							<td><?php echo $row->first_name;?></td>
							<td><?php echo $row->last_name;?></td>
							<td><?php echo $row->email;?></td>
							<td><?php echo $row->gender;?></td>
						</tr>
						<?php endforeach; ?>
						<?php else: ?>
						<!-- jika tidak ada data -->
						<tr>
							<td colspan="4">tidak ada data</td>
						</tr>
						<?php endif; ?>
					</tbody>
				</table>
			</div>	
			<div class="col-md-12">
				<!-- Menampilkan pagination -->
				<?php echo $pagination;?>
			</div>
		</div>
	</div>
</body>
</html>