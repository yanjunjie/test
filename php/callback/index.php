<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title>Callback</title>
</head>
<body>
	<h1>Callback Test</<h1></h1>

    <?php

    $myString = "Hello there";

    $myFunc = function() use(&$myString){ //With & is called pass by reference otherwise pass by value/copy
        echo $myString;
    };

    $myString = "Hello here";

    $myFunc();

    ?>


	<script src="https://code.jquery.com/jquery.min.js"></script>
</body>
</html>