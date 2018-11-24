<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title>Callback</title>
</head>
<body>
	<h1>Callback Test</<h1></h1>
	<script src="https://code.jquery.com/jquery.min.js"></script>
	<script type="text/javascript">
	
		//v.05
		let add = function(a, b){
			return a+b;
		};
		
		let multiply = function(a, b){
			return a*b;
		};
		
		let doWhatever = function(a, b){
			console.log(`Here are your two numbers back ${a}, ${b}`);
		};
		
		let calc = function(num1, num2, callback){ //callback = function(a,b){return a-b;}
			if(typeof callback === "function") //typeof returns type of a variable
			return callback(num1, num2);
		};
		//console.log(calc(2, 3, function(a,b){return a-b;}));
		var result = calc(2, 3, function(a, b){ //this anonimous will assign with a variable and it is a definition
			return a*b;
		});

		console.log(result);
		
	</script>
</body>
</html>