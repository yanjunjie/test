<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title>JavaScript Form Validation</title>
	<style type="text/css">
		.error{
			border:1px solid red;
		}
		.success{
			border:1px solid green;
		}
	</style>
</head>
<body>
	<form action="index.php" onSubmit="return onSubmitform();" method="post">
		Name: 	<input type="text" name="full_name" id="name1" onkeypress="success1();" />
				<div id="result1"></div>
		E-mail: <input type="text" name="email" id="email1" onkeypress="success2();" />
				<div id="result2"></div>
				<input type="submit" />
	</form>
	
	<script type="text/javascript">
		function onSubmitform(){
			var nameVar = document.getElementById("name1").value;
			var emailVar = document.getElementById("email1").value;
			var msg = "";
			if(nameVar==""){
				name1.className="error";
				msg+="Please fill out this name field";
				document.getElementById("result1").innerHTML=msg;
			}
			if(emailVar==""){
				email1.className="error"; //document.getElementById("email1").className="error";
				msg="Please fill out this email field";
				document.getElementById("result2").innerHTML=msg;
			}
			
			if(msg!=""){
				return false;
			}else{
				return true;
			}
		}
		
		function success1(){
			document.getElementById("name1").className="success";
			document.getElementById("result1").innerHTML="";
		}
		function success2(){
			document.getElementById("email1").className="success";
			document.getElementById("result2").innerHTML="";
		}
	</script>
</body>
</html>