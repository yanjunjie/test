<!DOCTYPE html>
<html>
<body>

<h2>Send data as JSON to a PHP file and Received data as JSON from a PHP file</h2>

<p id="demo"></p>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js" type="text/javascript"></script>
<script>
	var obj, dbParam, xmlhttp, myObj, x, txt = "";
	var xmlhttp = new XMLHttpRequest();

	obj = { "table":"test_table", "limit":5 };
	dbParam = JSON.stringify(obj);

	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			myObj = JSON.parse(this.responseText);
			for (i in myObj) {
				txt += myObj[i].full_name + "<br>";
			}
			document.getElementById("demo").innerHTML = txt;
		}
	};
	/*
	xmlhttp.open("GET", "main.php", true);
	xmlhttp.send();
	*/
	/*
	xmlhttp.open("GET", "main.php?content=" + dbParam, true);
	xmlhttp.send();
	*/
	xmlhttp.open("POST", "main.php", true);
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send("content=" + dbParam);


	//Jquery
	var json = [
		{
			"GROUP_ID":"143",
			"GROUP_TYPE":"2011 Season",
			"EVENTS":[
				{"EVENT_ID":"374","SHORT_DESC":"Wake Forest"},
				{"EVENT_ID":"376","SHORT_DESC":"Yale"},
				{"EVENT_ID":"377","SHORT_DESC":"Michigan State"}
			]
		},
		{
			"GROUP_ID":"142",
			"GROUP_TYPE":"2010 Season",
			"EVENTS":[
				{"EVENT_ID":"370","SHORT_DESC":"Duke"},
				{"EVENT_ID":"371","SHORT_DESC":"Northwestern"},
				{"EVENT_ID":"372","SHORT_DESC":"Brown"}
			]
		}
	];
	//json[1].EVENTS[1] is object selector
	$.each(json[1].EVENTS[0], function(key, value) {
		console.log(value);
	});
</script>

</body>
</html>