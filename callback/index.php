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
		//Javascript Object
		//V.01
		var myCar = new Object(); //making an object 
		myCar.model = 'Mustang';
		myCar.year = 1969;
		//console.log(myCar.year);
		console.log(myCar);
		
		//V.02
		var obj = {}
		obj.foo = 42;
		console.log(obj.foo);

		//V.03  -Arrays are always objects but property is associated with a string value
		var obj = {}
		obj.foo = 423;
		console.log(obj['foo']);
		
		//V.03.01		
		var bar = 'foo';
		console.log(obj[bar]);
		
		
		
	</script>
</body>
</html>