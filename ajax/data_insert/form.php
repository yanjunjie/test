<?php 
	include "config.php";
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Bootstrap 101 Template</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
	<style type="text/css">
		fieldset {
			padding: .35em .625em .75em;
			margin: 0 2px;
			border: 1px solid silver;
			border-radius:5px;
		}
	</style>
	</head>

		<div class="container" style="margin-top:5%;">
			<div class="row">
				<div class="col-md-6 col-md-offset-3">
					<fieldset>
						<h2>Application Form</h2>
						<form id="form" action="insert.php" method="post">
							<div class="form-group">
								<input name="name" type="text" class="form-control" placeholder="Name">
							</div>
							<div class="form-group">
							  <input name="email" type="text" class="form-control" placeholder="E-mail">
							</div>
							<div class="form-group">
							  <input name="password" type="password" class="form-control" placeholder="Password">
							</div>
							<button id="submit" class="btn btn-success" type="submit">submit</button>
							
						</form>
						<div id="success"></div>
					</fieldset>
					
				</div>
			</div>
		</div> 


    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    <script>
    $(document).ready(function(){

    	$("#submit").on("click",function(event){
			event.preventDefault();
    		var data = $("#form").serializeArray(); //this refers current selector
    		
			$.post(
				$("#form").attr("action"), //request url
				data, //data
				function(result){  //response url

					$("#success").html(result);
					$("#success").fadeOut(3000);
					
				}
    		);
    	});

    });
    </script>

  </body>
  
